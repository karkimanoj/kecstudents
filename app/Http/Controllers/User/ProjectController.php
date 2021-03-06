<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Tag;
use App\Project;
use App\Subject;
use App\User;
use App\ProjectMember;
use App\Img;
use Carbon\Carbon;
use Auth;
use Image;
use Validator;
use Session;
use Storage;


class ProjectController extends Controller
{


     public function __construct()
     {
        $this->middleware('role:student', ['except' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $user_rollno=Auth::user()->roll_no;
        $tenant = session('tenant');
         $projects=Project::whereIn('id', function ($query) use($user_rollno, $tenant)
         {
            $query->select('project_id')
                  ->from($tenant.'_project_members')  
                  ->where('roll_no', $user_rollno);
         })->with('project_members')
          ->get();

         //if(Auth::user()->hasRole(['superadministrator', 'administrator']))
            //return view('manage.projects.index', ['projects'=>$projects]);
       
            return view('user.projects.index', ['projects'=>$projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects=Subject::where('project', 1)->get();
        $tags=Tag::all();

        //if(Auth::user()->hasRole(['superadministrator', 'administrator']))
        // return view('manage.projects.create', ['subjects'=>$subjects,
          //                                     'tags'=>$tags ]);
         //else
            return view('user.projects.create', ['subjects'=>$subjects,
                                               'tags'=>$tags ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
    { 
        include(app_path() . '\helpers.php');

       $subject_id=$request->subject;
       $tenant=session('tenant');

        Validator::make($request->all() , [
                'name'=>'required|min:4|max:255',
                'abstract'=>'required|max:4000',
                'link'=>'nullable|url|max:255|unique:'.$tenant.'_projects,url_link',
                'file'=>'required|file|max:31000|mimetypes:application/pdf,application/msword',
                'tags'=>'required|max:60',
                'subject'=>'integer|required',
                'images'=>'sometimes|array|max:4',
                'images.*'=>'nullable|file|image|max:4000',
                'member_rollno'=>'required|array|max:5',
                'member_rollno.*'=>
                    ['sometimes','distinct','string','max:10',
                        Rule::unique($tenant.'_project_members', 'roll_no')
                            ->where( function($query) use( $subject_id, $tenant){
                               return $query->whereIn('project_id', function($query) use($subject_id, $tenant) 
                               {
                                $query->select('id')
                                      ->from($tenant.'_projects')
                                      ->where('subject_id', $subject_id);
                               });
                            })
                    ],
                'member_name'=>'required_with:member_rollno|max:255'
                

        ])->validate();
        

        
        if(Auth::user()->hasRole(['superadministrator', 'administrator']))
            $user_flag=true;
            else
                $user_flag=false;

        $member_rollnos=[];
        $college=strtoupper(session('tenant'));
        //checking if inputed roll no of member is already member of other projects 
        foreach($request->member_rollno as $roll_no)
        {   
           
            if(!Auth::user()->hasRole(['superadministrator', 'administrator']))
            {
                if($college.$roll_no==Auth::user()->roll_no)
                    $user_flag=true;
            }

            //($roll_no==Auth::user()->roll_no) ?  array_push($member_rollnos,  $roll_no) : array_push($member_rollnos,  $college.trim($roll_no));  
            array_push($member_rollnos,  $college.trim($roll_no));  
        }

        if($user_flag==false)
        {
            return back()->withErrors( Auth::user()->roll_no.' is not present in group member in '.$request->name);
            die(1);
        }

         if($request->hasFile('file') && $request->file('file')->isvalid() )
        {
            $file=$request->file('file');
            $ext=$file->extension();
            $original_name=$file->getClientOriginalName();

            //replacing spaces in subject by underscore '_'
            $subject=Subject::find($request->subject);
            $sub_parts=explode(' ',$subject->name);
            $length=count($sub_parts);
            $sub='';
            for($i=0; $i<$length; $i++)
            {
                if($i==($length-1))
                $sub.=$sub_parts[$i];
            else
                $sub.=$sub_parts[$i].'_';
            }

            //replacing spaces in project name by underscore '_'
            $name=$request->name;
            $name_parts=explode(' ',$name);
            $length=count($name_parts);
            $pname='';
            for($i=0; $i<$length; $i++)
            {
                if($i==($length-1))
                $pname.=$name_parts[$i];
            else
                $pname.=$name_parts[$i].'_';
            }

            //creating directory and filename
            $filename=$pname.'_'.time().rand(0, 999).'.'.$ext;

             $upload_dir='/file_uploads/'.$sub.'/projects';
            $dir=Storage::makeDirectory($upload_dir,0775, true);

             //storing file in created directory
             if($path=$file->storeAs($upload_dir, $filename))
             {

                $project=new Project;
                $project->name=$request->name;
                $project->filepath=$path;
                $project->abstract=$request->abstract;
                $project->original_filename=$original_name;
                $project->url_link=$request->link;
                $project->subject_id=$request->subject;
                $project->uploader_id=Auth::user()->id;

                if(Auth::user()->hasRole(['superadministrator', 'administrator']))
                    $project->published_at=Carbon::now();

                if($project->save())
                {
                    //creating array of ProjectMember objects to insert in project_members table in single saveMany command
                   $members=[];
                   
                   $member_names=$request->member_name;

                
                   for ($i=0; $i < count($member_rollnos) ; $i++) 
                   {   
                            
                       $members[$i]=new ProjectMember;
                       $members[$i]->roll_no = $member_rollnos[$i];
                       $members[$i]->name = $member_names[$i] ;

                       if(count(User::where('roll_no', $members[$i]->roll_no)->get()) && 
                        ($member_rollnos[$i] != Auth::user()->roll_no) )
                            $members[$i]->deleted_at = now();

                   }
                   

                    $tag_ids=[]; 
                   //inserting new tags created by user
                    foreach($request->tags as $tag)
                    {   
                        $string=str_split($tag);
                        if($string[0]=='@')
                        {   
                            $string=array_slice($string, 1);
                            $ntag=implode($string);
                            $new_tag=new Tag;
                            $new_tag->name=$ntag;
                            $new_tag->created_by=Auth::user()->id;
                            $new_tag->save();

                            array_push($tag_ids,  $new_tag->id);
                        }
                        else
                            array_push($tag_ids,  $tag);
                    }//end inserting new tags

                   if($project->project_members()->saveMany($members))
                   {
                        //syncing tags to project
                        $project->tags()->sync($tag_ids, false);

                        //insertin screenshots or photos for project
                        $images=[];
                        if($request->hasFile('images'))
                        {   
                            for($i=0; $i < count($request->file('images')) ; $i++)
                            {
                                $img=$request->file('images')[$i];
                                $ext=$img->extension();
                                $img_name=time().rand(0,999).'.'.$ext;
                                $path='images/projects/'.$img_name;

                                if (!file_exists(public_path('images/projects'))) 
                                {
                                    Storage::makeDirectory($dir, 0775, true);
                                }
                                Image::make($img)->resize(720, 720,
                                    function ($constraint) {
                                         $constraint->aspectRatio();
                                        $constraint->upsize();
                                    })->save(public_path($path));

                                $images[$i]=new Img;
                                 $images[$i]->filepath = $path;
                            }

                            $project->imgs()->saveMany($images);
                        }

                        Session::flash('success',$project->name.' has been succesfully uploaded');


                         return redirect()->route('user.projects.show', $project->id);
                   }else
                    return back()->withErrors('error in saving project members');
                   
                } else
                    return back()->withErrors('error occured during saving project');
             }


        }
    }

    public function confirmMember(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        abort_if(!$project, '404');

        $member=$project->project_members()->withTrashed()->where('roll_no', Auth::user()->roll_no)->first();
        
        if($request->confirm == 'no')
        {
            ($member->forceDelete()) ? Session::flash('success', 'successfully confirmed you are not the member of project '.$project->name) :  Session::flash('error', 'error in confirming prject member of '.$project->name);
            
        }
        else
        {
            if($member->trashed())
            {
             $member->restore();
             Session::flash('success', 'successfully confirmed you are the member of project '.$project->name);
            }
        }
        return redirect()->route('user.projects.show', $id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project=Project::findOrFail($id);

        $popular_projects=Project::where('published_at','!=', 'NULL')
                        ->orderBy('view_count', 'desc')
                        ->limit(10)->get();
        return view('user.projects.show', ['project'=>$project, 'popular_projects' => $popular_projects]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $project_member=ProjectMember::where('project_id', $id)->where('roll_no', Auth::user()->roll_no)->get();    
        if(count($project_member))
        {
          $project=Project::findOrFail($id);
          $tags=Tag::all();

         //if(Auth::user()->hasRole(['superadministrator', 'administrator']))
           // return view('manage.projects.edit', ['project'=>$project, 'tags'=>$tags]);
         //else
            return view('user.projects.edit', ['project'=>$project, 'tags'=>$tags]);
        }  
        else
            return back()->withErrors('Access denied. not member of this project');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        include(app_path() . '\helpers.php');
        
        $project_member=ProjectMember::where('project_id', $id)->where('roll_no', Auth::user()->roll_no)->first();    
        if($project_member)
        {   
            $project=Project::findOrFail($id);
             $subject_id=$project->subject_id;
             $tenant=session('tenant');
            Validator::make($request->all() , 
            [
                'name'=>'required|min:4|max:255',
                'abstract'=>'required|max:4000',
                'link'=>'nullable|url|max:255|unique:'.$tenant.'_projects,url_link,'.$id,
                'tags'=>'required|max:60',
                'member_rollno'=>'required|array|max:5',
                'member_rollno.*'=>['sometimes','distinct','string','max:10',
                    Rule::unique($tenant.'_project_members', 'roll_no')
                        ->where( function($query) use( $subject_id, $id ,$tenant)
                        {
                           return $query->where('project_id','!=', $id)
                           ->whereIn('project_id', function($query) use($subject_id, $id, $tenant) 
                           {
                            $query->select('id')
                                  ->from($tenant.'_projects')
                                  ->where('subject_id', $subject_id);
                           });
                        })
                        ],
                'member_name'=>'required_with:member_rollno|max:191',
            ])->validate();
          
                $project->name=$request->name;
                $project->abstract=$request->abstract;
                $project->url_link=$request->link;


                if($project->save())
                {   
                    //creating array of ProjectMember objects to insert in project_members table in single saveMany command
                    $tag_ids=[]; 
                   //inserting new tags created by user
                    foreach($request->tags as $tag)
                    {   
                        $string=str_split($tag);
                        if($string[0]=='@')
                        {   
                            $string=array_slice($string, 1);
                            $ntag=implode($string);
                            $new_tag=new Tag;
                            $new_tag->name=$ntag;
                            $new_tag->created_by=Auth::user()->id;
                            $new_tag->save();

                            array_push($tag_ids,  $new_tag->id);
                        }
                        else
                            array_push($tag_ids,  $tag);
                    }//end inserting new tags

                   //---  $members_changed=0;
                   $members=[];
                   $member_rollnos=$request->member_rollno;
                   $member_names=$request->member_name;
                   $college=strtoupper(session('tenant'));

                   for ($i=0; $i < count($request->member_rollno) ; $i++) 
                   {   
                        $member_rollnos[$i]=$college.trim($member_rollnos[$i]);
                        $member_names[$i]=trim($member_names[$i]);

                    //---if($project->project_members()->count()!=count($request->member_rollno)) 
                    //---$members_changed=1;
                    //---else 
                        $members[$i]=new ProjectMember;
                        $members[$i]->roll_no = $member_rollnos[$i];
                        $members[$i]->name = $member_names[$i] ;

                        $pr = $project->project_members()->withTrashed()
                            ->where('roll_no', $member_rollnos[$i])
                            ->get();

                        if(count($pr) == 0 && User::where('roll_no', $member_rollnos[$i])->count())
                        {
                            //---$members_changed=1;
                            $members[$i]->deleted_at = now();
                        } else
                        if(count($pr))
                        {
                            $members[$i]->deleted_at = $pr->first()->deleted_at;
                        }

                        
                   }

                   //---if($members_changed==1) 
                   //---{
                        ProjectMember::withTrashed()->where('project_id', '=', $project->id)->forceDelete();
                        $inserting_members=$project->project_members()->saveMany($members);
                   //----}

                        $project->tags()->sync($tag_ids, true);

                        $images=[];
                        if($request->hasFile('images'))
                        {       
                            Img::where('imagable_id', $id)->where('imagable_type', 'App\Project')->delete();

                            for($i=0; $i<count($request->file('images')) ;$i++)
                            {
                                $img=$request->file('images')[$i];
                                $ext=$img->extension();
                                $img_name=time().rand(0,999).'.'.$ext;
                                $path='images/projects/'.$img_name;

                                Image::make($img)->resize(720, 720,
                                    function ($constraint) {
                                         $constraint->aspectRatio();
                                        $constraint->upsize();
                                    })->save(public_path($path));

                                $images[$i]=new Img;
                                 $images[$i]->filepath = $path;
                            }

                            $project->imgs()->saveMany($images);
                        }

                        Session::flash('success',$project->name.' has been succesfully edited');
                        return redirect()->route('user.projects.show', $id);
                   
                   
                } else
                return back()->withErrors('error occured in saving project');
        } else
            return back()->withErrors('Access denied. not member of this project');
    }

    /**
     * Remove the specified resource from storage.gff
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
      $project_member=ProjectMember::where('project_id', $id)->where('roll_no', Auth::user()->roll_no)->with('projects')->get(); 

      if(count($project_member))
      {
         $project=Project::findOrFail($id);
      
        if($project->delete())
        {   
             $project->project_members()->forceDelete();
            if( count($project->imgs) )
                {   
                    foreach($project->imgs as $img) 
                    Storage::delete($img->filepath);

                    $project->imgs()->delete();
                }

            if(count($project->tags)) $project->tags()->detach();

            
            Session::flash('success', 'file '.$project->filepath.' was successfully deleted');
            return redirect()->route('user.projects.index');
        } 
      } 
         else
             return back()->withErrors('you dont have access to delete this project');


        return redirect()->route('user.projects.index');
    }


    
}