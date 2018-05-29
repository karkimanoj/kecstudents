<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Download;
use App\Subject;
use App\faculty;
use App\DownloadCategory;
use Illuminate\Http\Request;
use DB;

class DownloadController extends Controller
{




    public function Index($category_id)
    {   
        include(app_path() . '\helpers.php');

        $downloads = Download::where('category_id', $category_id)->get();
        $faculties = Faculty::all();
        $categories = DownloadCategory::all();

        $facs=subjects_as_facsem($faculties);
        $fac_sem_sub_arr=json_encode($facs);
        //$active_cat_id=Subject::find($cat_id);
       //dd($projects);
       return view('pages.downloads.index', ['category_id'=>$category_id,
                                         'downloads'=>$downloads,
                                         'categories'=>$categories,
                                         'faculties'=>$faculties,
                                         'fac_sem_sub_arr'=>$fac_sem_sub_arr
                                         ]);
    }

    public function ajaxCall(Request $request)
    {  
     // dd($request);

        
        
        switch ($request->sort_by) 
        {
            case 'date':
                $order='created_at';
                $direction='desc';
                break;
            case 'relevance':
                $order='title';
                $direction='asc';
             break;  
             default:
                $order='created_at';
                $direction='desc';
            break;
        }

        
        $category = DownloadCategory::findOrFail($request->category_id);

        if($category->category_type == 'subject')
          {
            $downloads = Download::where('category_id','=' ,$request->category_id)
                        ->where('subject_id', $request->subject_id)
                        ->whereNotNull('published_at')
                        ->with(['user','download_files'])
                        ->orderBy($order, $direction)
                        ->paginate(1);
            
          
          }  
          else 
            if($category->category_type=='facsem')
          {
          
            //$downloads = Download::all();
            $downloads = Download::where([
                         ['category_id', $request->category_id], 
                         ['faculty_id', $request->faculty_id],
                          ['semester', $request->semester],
                        ])->whereNotNull('published_at')
                        ->with(['user','download_files'])
                        ->orderBy($order, $direction)
                         ->paginate(1);                             
                         /*
             $downloads = Download::where([
                         ['category_id', $request->category_id],
                         ['faculty_id', $request->faculty_id],
                         ['semester_id', $request->semester_id],
                        ])->whereNotNull('published_at')
                        ->orderBy($order, $direction)
                        ->paginate(1);*/
                       
        }
           if($request->ajax())
            return json_encode($downloads);
        
       
     
         

    }



     

  
}
