<?php
namespace App\Http\Controllers\User;

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

class DownloadController extends Controller
{   

    public function __construct()
    {
        $this->middleware('role:teacher', ['except' => ['show']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        $user_rollno=Auth::user()->roll_no;
        $user=Auth::user();
       // $downloads=Download::where('uploader_id', $user->id)->get();
     
        //$user->downloads;
        
        return view('user.downloads.index', ['downloads'=>$user->downloads]);
        
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
        return view('user.downloads.create', ['faculties'=>$faculties,
                                         'categories'=>$categories,
                                         'facs'=>$facs ]);
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
            'files1.*.file'=>'required|file|max:31000|mimes:pdf,doc,docx,ppt,pps,txt,pptx',
            'files1.*.dname'=>'required_with:files1.*.file|min:3|max:191',
            
            'faculty'=>'required|integer',
            'semester'=>'required|integer',
            'subject'=>'sometimes|integer'
        ]);
                   
        } else {
                    $this->validate($request, [
            'title'=>'required|min:4|max:191',   
            'description'=>'required|min:4|max:2000',
            'files1'=>'required|array|max:1',
            'files1.*.file'=>'required|file|max:31000|mimes:pdf,doc,docx,txt',
            'files1.*.dname'=>'required_with:files1.*.file|min:3|max:191',

            'faculty'=>'required|integer',
            'semester'=>'required|integer',
            'subject'=>'sometimes|integer'
        ]);
                                 
        }
  
         $category=DownloadCategory::find($request->category);
         $category_type=$category->category_type;
        


        for ($i=0; $i < count($request->file('files1')) ; $i++) 
            { 
              if ($request->file('files1')[$i]['file']->isValid())
              {
                //$request->file('files')->isvalid();
                $file=$request->file('files1')[$i];
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

                 $files[$i]=new DownloadFile([ 'original_filename' => $original_name, 
                                               'filepath' => $path   
                                             ]);
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
                return redirect()->route('user.downloads.index');
            } else
            return back()->withErrors('error in uploading files');
                
            

       // }else
         //   return back()->withErrors('error: no file is selected');
        
        
    }
        
    public function show($id)
    {  
        $download=Download::findOrFail($id);
        return view('user.downloads.show', ['download'=>$download]);
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
       $download=Download::findOrFail($id);
        $user=Auth::user();
        //dd($user->roll_no);
        if( $user->owns($download, 'uploader_id') )
        {
            include(app_path() . '\helpers.php');
          
            $faculties=Faculty::all();

            $facs=subjects_as_facsem($faculties);

            //throwing to view as json   
             $facs=json_encode($facs);

            return view('user.downloads.edit', ['download'=>$download,
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
            'files1'=>'nullable|array|max:'.$files_count_remaining,
            'files1.*.file'=>'nullable|file|max:31000|mimes:pdf,doc,docx,ppt,pps,txt,pptx',
            'files1.*.dname'=>'required_with:files1.*.file|min:3|max:191',

            'delDownload'=>'sometimes|array|max:'.$files_count_remaining,
            'delDownload.*'=>'nullable|distinct|max:191',

            'faculty'=>'required|integer',
            'semester'=>'required|integer',
            'subject'=>'sometimes|integer'
            ]);
            //dd(count($request->file('files')));
            for($i=0; $i < count($request->delDownload); $i++ )
            {
                DownloadFile::where('filepath','=', trim($request->delDownload[$i]) )->delete();                
            }

            } 
              else 
            {
                    $this->validate($request, [
            'title'=>'required|min:4|max:255',   
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

                         $files[$i]=new DownloadFile([ 'original_filename' => $original_name, 
                                                        'display_name'=>$request->files1[$i]['dname'],
                                                       'filepath' => $path   
                                                     ]);
                     }
                    }
                       $files_added=$i.' new files also added .'; 
                       if($download_updated &&  count($request->file('files1')) >=1 )
                          $download->download_files()->saveMany($files);
             
            }

            if($download_updated)
            {
                Session::flash('success','one download model has been succesfully updated. '.$files_added);
                return redirect()->route('user.downloads.show', $download->id);
            } else
            return back()->withErrors('error editing the download');
                
            
                
        } 
        else
            return back()->withErrors('you dont have permission for this activity');       

        

        
    }

    public function destroy($id)
    {  
        $download=Download::findOrFail($id);
        if(Auth::user()->owns($download, 'uploader_id'))
        {
           if($download->delete())
            {
                Session::flash('success', 'file  +was successfully deleted');
                return redirect()->route('downloads.index');
            }
            else
                return back()->withErrors(' delete failed due to database error ');  
        } else
        return back()->withErrors('you dont have permission for this activity');           
    }


   
}

