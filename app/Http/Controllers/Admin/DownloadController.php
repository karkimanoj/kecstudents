<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Faculty;
use App\DownloadCategory;
use App\Download;
use App\Subject;
use App\DownloadFile;
use Carbon\Carbon;
use Auth;
use Session;
use Storage;
use App\User;
use Notification;
use App\Notifications\DownloadNotification;

class DownloadController extends Controller
{
  

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $downloads=Download::latest()->paginate(20);
       return view('manage.downloads.index', ['downloads'=>$downloads]);
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    
    public function create()
    {   
        include(app_path() . '\helpers.php');

        $categories=DownloadCategory::all();
        $faculties=Faculty::all();

        $facs=subjects_as_facsem($faculties);

        //throwing to view as json   
         $facs=json_encode($facs);
        return view('manage.downloads.create', ['faculties'=>$faculties,
                                         'categories'=>$categories,
                                         'facs'=>$facs ]);
    }

    /*
      publish the uploads via ajax request  
    */
    public function publish(Request $request)
    {
        if($request->ajax())
        {
            $id=$request->id;
            if($request->status=='publish')
                $date=Carbon::now();
            else if($request->status=='unpublish')
                $date=NULL;

            $download=Download::findOrFail($id);
            $download->published_at=$date;

            if($download->save())
            return $date;
        }
    }


      public function store(Request $request)
    { //  dd($request);
        include(app_path() . '\helpers.php');

        $category=DownloadCategory::where('name','=' ,'note')->first();
        
        if($request->category==$category->id)
        {
            $this->validate($request, [
             'title'=>'required|min:4|max:191',   
            'description'=>'required|min:4|max:2000',
            'files1'=>'required|array|max:12',
            'files1.*.file'=>'required|file|max:10000|mimes:pdf,doc,docx,ppt,pps,txt,pptx',
            'files1.*.dname'=>'required_with:files1.*.file|min:3|max:191',
 
            'faculty'=>'required|integer',
            'semester'=>'required|integer',
            'subject'=>'sometimes|integer',

            'facultyn' => 'sometimes|required|array|max:12',
            'facultyn.*' => 'sometimes|required|string',
            'start_rollno' => 'sometimes|array|max:12',
            'start_rollno.*' =>'sometimes|required_with:facultyn.*|integer|min:0|max:400',
            'end_rollno' => 'sometimes|required_with:start_rollno|array|max:12',
            'end_rollno.*' => 'sometimes|required_with:facultyn.*|integer|min:0|max:400',
            'year' => 'sometimes|required|array|max:12',
            'year.*' => 'sometimes|required_with:facultyn.*|integer',
            'ind_rollno' => 'sometimes|nullable|array|max:40',
            'ind_rollno.*' => 'sometimes|nullable|alpha_num|size:10'
        ]);/*
            'files'=>'required|array|max:12',
            'files.*'=>'required|file|max:31000|mimes:pdf,doc,docx,ppt,pps,txt,pptx',
            'display_fname'=>'required|array|min:1|max:12',
            'display_fname.*'=>'required_with:files.*|min:3|max:191',
            
             'files'=>'required|array|max:1',
            'files.*'=>'required|file|max:31000|mimes:pdf, doc, docx, txt',
            'display_fname'=>'required|array|min:1|max:12',
            'display_fname.*'=>'required_with:files.*|min:3|max:191',

           */
                  
        } else {
                    $this->validate($request, [
            'title'=>'required|min:4|max:191',   
            'description'=>'required|min:4|max:2000',
            'files1'=>'required|array|max:1',
            'files1.*.file'=>'required|file|max:10000|mimes:pdf,doc,docx,txt',
            'files1.*.dname'=>'required_with:files1.*.file|min:3|max:191',
            'faculty'=>'required|integer',
         
            'semester'=>'required|integer',
            'subject'=>'sometimes|integer',

            'facultyn' => 'sometimes|required|array|max:12',
            'facultyn.*' => 'sometimes|required|string',
            'start_rollno' => 'sometimes|array|max:12',
            'start_rollno.*' =>'sometimes|required_with:facultyn.*|integer|min:0|max:400',
            'end_rollno' => 'sometimes|required_with:start_rollno|array|max:12',
            'end_rollno.*' => 'sometimes|required_with:facultyn.*|integer|min:0|max:400',
            'year' => 'sometimes|required|array|max:12',
            'year.*' => 'sometimes|required_with:facultyn.*|integer',
            'ind_rollno' => 'sometimes|nullable|array|max:40',
            'ind_rollno.*' => 'sometimes|nullable|alpha_num|size:10'
        ]);
                                 
        }
       
         $category=DownloadCategory::find($request->category);
         $category_type=$category->category_type;

      
       // if( $request->hasFile('files1[]') )
       // {  
            for ($i=0; $i < count($request->file('files1')) ; $i++) 
            { 
                if ($request->file('files1')[$i]['file']->isValid())
                {


                    $file=$request->file('files1')[$i]['file'];
                    $ext=$file->extension();
                    $original_name=$file->getClientOriginalName();

                    /*
                    generating filename for acoording to upload type
                    */
                    if($category_type=='subject')
                    {
                        $subject=Subject::find($request->subject);

                         $sub=remove_space_in_string( $subject->name );
                        //echo $sub;
                        $filename=$sub.'_'.time().rand(0, 99).'_'.($i+1).'.'.$ext;
                        $upload_dir='/file_uploads/'.$sub;
                    } 
                    else
                    {
                        $fac=Faculty::findOrFail($request->faculty);
                        $filename=$fac->name.'_'.$request->semester.'_'.time().rand(0, 99).'_'.($i+1).'.'.$ext;
                        $upload_dir='/file_uploads/'.$fac->name.'/'.$request->semester;
                    }

                     $dir=Storage::makeDirectory($upload_dir, 0775, true);
                     $path=$file->storeAs($upload_dir, $filename);
                     $display_name=$request->files1[$i]['dname'];
                      
                                               
                    $files[$i]=new DownloadFile;
                    $files[$i]->original_filename= $original_name;
                    $files[$i]->filepath = $path ;
                    $files[$i]->display_name = $display_name ;
                } 

            }       
         
           /* saving Downlaod model
            */ 
            $download=new Download;
           // $download->original_filename=$original_name;
            $download->title=$request->title;
            $download->category_id=$request->category;
            $download->uploader_id=Auth::user()->id;
            $download->description=$request->description;

            if(Auth::user()->hasRole(['superadministrator', 'administrator']))
                    $download->published_at=Carbon::now();

            if($category_type=='subject')
                $download->subject_id=$request->subject;
            else
            {
                $download->faculty_id=$request->faculty;
                $download->semester=$request->semester;
            }

            if( $download->save() && $download->download_files()->saveMany($files) )
            {
                Session::flash('success', $i.' file/s uploaded successfully');

                //Notification Part --start
                if($request->submit == 'Yes' && Auth::user()->hasPermission('create-invites'))
                {
                    $roll_no=[];
                    $college = strtoupper(session('tenant'));
                    for($i=0; $i<count($request->facultyn); $i++)
                    {  
                        if($request->end_rollno[$i] < $request->start_rollno[$i])
                        {
                            $end_rollno = $request->end_rollno;
                            $end_rollno[$i] = $request->start_rollno[$i];
                            $request->end_rollno = $end_rollno;
                        }     
                           
                        $faculties=[]; 
                        if($request->facultyn[$i] == 'All')
                            $faculties = Faculty::pluck('name');
                         else
                         $faculties[] =  Faculty::findOrFail(2)->value('name');
                       
                        for($k=0; $k<count($faculties); $k++)
                        {
                            for($j=$request->start_rollno[$i]; $j<=$request->end_rollno[$i]; $j++ )
                            {   
                                $no = str_pad($j, 3, '0', STR_PAD_LEFT);
                                $roll_no[]=$college.$no.$faculties[$k].$request->year[$i];
                            }
                        }
                    }      

                    $users = User::whereIn('roll_no', $roll_no)->get();
                     
                     if($request->ind_rollno) 
                     {   
                        foreach($request->ind_rollno as $roll) 
                            $i_rollno[] = $college.$roll;

                        if($i_users = User::whereIn('roll_no', $i_rollno)->get())
                        {
                            (count($users)) ? $users->merge($i_users) : $users = $i_users;
                        }
                        /* if (count($i_users)) $users->merge($i_users); 
                         dd($users);  */                  
                     }
                    
                    Notification::send($users->unique(), new DownloadNotification($download));

                }
                //Notification Part --end
                 dd($request);
                return redirect()->route('downloads.index');
            } else
            return back()->withErrors('error in uploading files');
                
            

        //}else
            //return back()->withErrors('error: no file is selected');
        
        
    }
        
    public function show($id)
    {
        $download=Download::findOrFail($id);
        return view('manage.downloads.show', ['download'=>$download]);
    }
    
/*
    public function show($id)
    {   
        include(app_path() . '\helpers.php');
      
        $download=Download::findOrFail($id);
        $faculties=Faculty::all();

        $facs=subjects_as_facsem($faculties);
        $facs=json_encode($facs);

        return view('manage.downloads.show', ['download'=>$download,
                                              'faculties'=>$faculties,
                                              'facs'=>$facs ]);
    }*/

    public function edit($id)
    {
        include(app_path() . '\helpers.php');
      
         $download=Download::findOrFail($id);
        $user=Auth::user();
        //dd($user->roll_no);
        if( $user->owns($download, 'uploader_id') )
        {
            $faculties=Faculty::all();

            $facs=subjects_as_facsem($faculties);

            //throwing to view as json   
             $facs=json_encode($facs);

            return view('manage.downloads.edit', ['download'=>$download,
                                                  'faculties'=>$faculties,
                                                  'facs'=>$facs]);
        }else
            return back()->withErrors('you dont have permission to edit.');

    }

     public function update(Request $request, $id)
    {   //dd($request);
        include(app_path() . '\helpers.php');

        $download=Download::findOrFail($id);
        $user=Auth::user();
        //dd($user->roll_no);
        if( $user->owns($download, 'uploader_id') )
        {
           if($download->download_category->name== 'note')
           {   
            $files_count_remaining=12 - $download->download_files->count();

                    $this->validate($request, [
            'title'=>'required|min:4|max:191',   
            'description'=>'required|min:4|max:2000',
            //'files'=>'nullable|array|max:'.$files_count_remaining,
            //'files.*'=>'nullable|file|max:31000|mimes:pdf,doc,docx,txt,ppt,pps,pptx',

            'files1'=>'nullable|array|max:'.$files_count_remaining,
            'files1.*.file'=>'nullable|file|max:31000|mimes:pdf,doc,docx,ppt,pps,txt,pptx',
            'files1.*.dname'=>'required_with:files1.*.file|min:3|max:191',

            'delDownload'=>'sometimes|array|max:'.$files_count_remaining,
            'delDownload.*'=>'nullable|distinct|max:192',

            'faculty'=>'required|integer',
            'semester'=>'required|integer',
            'subject'=>'sometimes|integer'
            ]);
            /*
               'files1'=>'required|array|max:12',
            'files1.*.file'=>'required|file|max:31000|mimes:pdf,doc,docx,ppt,pps,txt,pptx',
            'files1.*.dname'=>'required_with:files1.*.file|min:3|max:191', 
            */
            for($i=0; $i < count($request->delDownload); $i++ )
            {
                DownloadFile::where('filepath','=', trim($request->delDownload[$i]) )->delete();                
            }

           } 
            else 
            {
                    $this->validate($request, [
            'title'=>'required|min:4|max:191',   
            'description'=>'required|min:4|max:2000',
            'faculty'=>'required|integer',
            'semester'=>'required|integer',
            'subject'=>'sometimes|integer'
            ]);
                           
            }

           

            
            
            if($download->download_category->category_type == 'subject')
            {   
                if($download->subject_id != $request->subject)
                {   
                    foreach ($download->download_files as $file)
                    {   
                        $subject=Subject::find($request->subject);

                        $old_sub=remove_space_in_string( $download->subject->name);
                        $new_sub=remove_space_in_string( $subject->name );

                        $new_filepath=str_replace($old_sub, $new_sub, $file->filepath);
                        Storage::move($file->filepath, $new_filepath);
                        DownloadFile::where('filepath', $file->filepath)
                                    ->update( ['filepath'=>$new_filepath] );
                    }
                   
                    $download->subject_id=$request->subject;
                }
               

            }
            else
            {   
                if($download->faculty_id != $request->faculty || $download->semester != $request->semester)
                 {
                    foreach ($download->download_files as $file)
                    {   
                        
                        $faculty=Faculty::find($request->faculty);

                        $old_faculty= $download->faculty->name;
                        $new_faculty= $faculty->name ;

                        $new_filepath=str_replace('/'.$old_faculty.'_'.$download->semester.'_', '/'.$new_faculty.'_'.$request->semester.'_' , $file->filepath);

                        $filepath_arr=explode('/', $new_filepath);

                        $filepath_arr[1]=$new_faculty; 
                        $filepath_arr[2]=trim($request->semester);
                        $new_filepath=$filepath_arr[0].'/'.$filepath_arr[1].'/'.$filepath_arr[2].'/'.$filepath_arr[3];
                        //dd($new_filepath);
                        Storage::move($file->filepath, $new_filepath);
                        DownloadFile::where('filepath', $file->filepath)
                                    ->update( ['filepath'=>$new_filepath] );
                    }
                
                    $download->faculty_id=$request->faculty;
                    $download->semester=trim($request->semester);
                }   
               
            } 

            $download->title=$request->title;
            $download->description=$request->description;
            $download_updated=$download->save();
              //dd($request);
             $files_added='';
            if($download->download_category->name== 'note')
           {    //dd(count($request->file('files')));
                for ($i=0; $i < count($request->file('files1')) ; $i++) 
                { 
                    if ($request->file('files1')[$i]['file']->isValid())
                    { 
                         $file=$request->file('files1')[$i]['file'];
                        $ext=$file->extension();
                        $original_name=$file->getClientOriginalName();

                        if($download->download_category->category_type =='subject')
                        {
                            $subject=Subject::find($request->subject);

                             $sub=remove_space_in_string( $subject->name );
                           
                            $filename=$sub.'_'.time().rand(0, 99).'_'.($i+1).'.'.$ext;
                            $upload_dir='/file_uploads/'.$sub;
                        } 
                        else
                        {
                            $fac=Faculty::findOrFail($request->faculty);
                            $filename=$fac->name.'_'.$request->semester.'_'.time().rand(0, 99).'_'.($i+1).'.'.$ext;
                            $upload_dir='/file_uploads/'.$fac->name.'/'.$request->semester;
                        }

                    
                         $dir=Storage::makeDirectory($upload_dir, 0775, true);
                         $path=$file->storeAs($upload_dir, $filename);

                         
                        $files[$i]=new DownloadFile;
                        $files[$i]->original_filename= $original_name;
                        $files[$i]->filepath = $path ;
                        $files[$i]->display_name = $request->files1[$i]['dname'] ; 

                    }
                }
                       $files_added=$i.' new files also added .'; 
                       if($download_updated &&  count($request->file('files1')) >=1 )
                          $download->download_files()->saveMany($files);

                    
                         
                

            }

            if($download_updated)
            {
                Session::flash('success','one download model has been succesfully updated. '.$files_added);
                return redirect()->route('downloads.show', $download->id);
            } else
            return back()->withErrors('error editing the download');
                
            
                
        } 
        else
            return back()->withErrors('you dont have permission for this activity');       

        

        
    }

    public function destroy($id)
    {
         $download=Download::findOrFail($id);
        if($download->delete())
        {
           foreach($download->download_files as $file) 
                    Storage::delete($file->filepath);
                
            $download->download_files()->delete();
            Session::flash('success', 'file  was successfully deleted');
             return redirect()->route('downloads.index');
        }
        else
            return back()->withErrors(' delete failed due to unknown error ');            
    }

   
}

