<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Faculty;
use App\DownloadCategory;
use App\Download;
use App\Subject;
use App\DownloadDetail1;
use App\DownloadDetail2;
use Carbon\Carbon;
use Auth;
use Session;
use Storage;

class DownloadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $downloads=Download::paginate(20);
        return view('manage.downloads.index', ['downloads'=>$downloads]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    
    public function create()
    {   
        $categories=DownloadCategory::all();
        $faculties=Faculty::all();

        $facs=[];
        /*
        array of subjects with corresponding faculty/semester
        */
        foreach ($faculties as $faculty)
         {
            $sems=[];
          for($i=1; $i<=8; $i++)
            {
                $subs=[];
                foreach ( $faculty->subjects()->wherePivot('semester','=',$i)->get() as  $subject)
                 {
                     $subs[$subject->id]=$subject->name;
                 }
                 $sems[$i]=$subs;
            }
            $facs[$faculty->id]=$sems;

         }
            
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
      
        $category=DownloadCategory::where('name','=' ,'tutorial')->first();
      
        if($request->category==$category->id)
        {
                    $this->validate($request, [
            'description'=>'required|max:2000',
            'file1'=>'required|file|max:31000|mimetypes:application/pdf,image/gif,image/jpeg,image/png,image/svg',
            'faculty'=>'required|integer',
            'semester'=>'required|integer',
            'subject'=>'sometimes|integer'
        ]);
                    
        } else {
                    $this->validate($request, [
            'description'=>'required|max:2000',
            'file1'=>'required|file|max:31000|mimetypes:application/pdf,application/vnd.ms-powerpoint',
            'faculty'=>'required|integer',
            'semester'=>'required|integer',
            'subject'=>'sometimes|integer'
        ]);
                                       
        }
        /*
         checking upload type as based on subject or faculty/semester
        */
         //var_dump($request->subject);
         //echo($request->subject);

        $category=DownloadCategory::find($request->category);
        $category_type=$category->category_type;
        


        if($request->hasFile('file1') && $request->file('file1')->isvalid())
        {
            $file=$request->file('file1');
            $ext=$file->extension();
            $original_name=$file->getClientOriginalName();

            /*
            generating filename for acoording to upload type
            */
            if($category_type=='subject')
            {
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
                //echo $sub;
                $filename=$sub.'_'.time().rand(0, 99).'.'.$ext;
            } 
            else
                 $filename=$request->faculty.'_'.$request->semester.'_'.time().rand(0, 999).'.'.$ext;

             $upload_dir='/file_uploads/'.$sub;
             $dir=Storage::makeDirectory($upload_dir,0775, true);
             $path=$file->storeAs($upload_dir, $filename);
            /* saving Downlaod model
            */ 
            $download=new Download;
            $download->original_filename=$original_name;
            $download->filepath=$path;
            $download->category_id=$request->category;
            $download->uploader_id=Auth::user()->id;
            $download->description=$request->description;
          

            $download->save();
            //echo $download->id;
            /*saving DownloadDetail model according to upload type
            */
            
            if($category_type=='subject')
            {
                
                $download_sub=new DownloadDetail1(['subject_id'=>
                    $request->subject]); 
              // var_dump($download.'<br>'.$download_sub->subject_id);

                 $download->download_detail1()->save($download_sub);

            } else
            {
               $download_facsem=new DownloadDetail2([ 
                'faculty_id'=>$request->faculty ,
                'semester'=>$request->semester ]);
               $download->download_detail2()->save($download_facsem);
            }

            Session::flash('success','new file uploaded successfully');

        }
        
        return redirect()->route('downloads.index');


     /*   return redirect()->route('users.index');
       'file1'=>'required|file|mimetypes:application/pdf,application/msword,application/vnd.ms-powerpoint,application/x-rar-compressed, application/octet-stream,application/zip, application/octet-stream,image/gif,image/jpeg,image/png,image/svg'
    */

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $download=Download::findOrFail($id);
        return view('manage.downloads.show', ['download'=>$download]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $download=Download::findOrFail($id);
        return view('manage.downloads.edit', ['download'=>$download]);
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
        $this->validate($request, ['description'=>'required|max:2000']);

        $download=Download::findOrFail($id);
        $download->description=$request->description;

       if($download->save())
        Session::flash('success','upload edited successfully');

        return redirect()->route('downloads.show', $download->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $download=Download::findOrFail($id);
        if($download->delete())
            Session::flash('success', 'file '.$download->filepath.' was successfully deleted');
        return redirect()->route('downloads.index');
    
    
   }
}

