<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Project;
use App\Subject;
use App\Tag;
use Illuminate\Http\Request;
use DB;

class ProjectController extends Controller
{
    public function construct()
    {
         $this->middleware('auth');
    }

    public function Index($category, $cat_id)
    {   
       	$categories=Subject::where('project', 1)->get();

        $popular_tags=DB::table('taggables')
                        ->join('tags', 'taggables.tag_id','=','tags.id')
                        ->select(DB::raw('taggables.tag_id, tags.name , count(taggables.tag_id) as tagcounts'))
                        ->where('taggables.taggable_type','App\Project')
                        ->groupBy('taggables.tag_id')
                        ->orderBy('tagcounts', 'desc')
                        ->limit(6)
                        ->get();  

        $active_cat_id=Subject::find($cat_id);
       // dd($projects);
       return view('pages.projects.index', [
    									 'categories'=>$categories,
                                         'popular_tags'=>$popular_tags,
                                         'cat'=>$category, 'cat_id'=>$cat_id,
                                            'active_cat_id'=>$active_cat_id ]);
    }

    




     public function ajaxIndex(Request $request)
    {   
        switch ($request->sort_by) 
        {
            case 'date':
                $order='created_at';
                $direction='desc';
                break;
            case 'relevance':
                $order='name';
                $direction='asc';
             break;  
             default:
                $order='created_at';
                $direction='desc';
            break;
        }


        if($request->category=='subject')
          {
            if($request->cat_id==0)
               $projects=Project::where('published_at','!=', 'NULL')
                        ->with(['user','subject','tags','project_members'])
                        ->orderBy($order, $direction)
                        ->paginate(2);
            else
                $projects=Project::where('published_at','!=', 'NULL')
                ->where('subject_id', $request->cat_id)               
                ->with(['user','subject','tags','project_members'])
                ->orderBy($order, $direction)
                ->paginate(2);
          }  
          else 
            if($request->category=='tag')
          {
             //Project::where('published_at','!=', 'NULL')
             $projects=Tag::find($request->cat_id)
             ->projects()
             ->where('published_at','!=', 'NULL') 
             ->with(['user','subject','tags','project_members'])
             ->orderBy($order, $direction)
             ->paginate(2);;
         }

         if ($request->ajax()) //{
            //return view('_includes.projects_load', ['projects' => $projects])->render();  
        //}
            return json_encode($projects);
           

       // return view('pages.projects.index', compact('projects'));
    }

   
  
}
