<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use DB;

class PostController extends Controller
{


    public function Index()
    {   
	    $taggablest = session('tenant').'_taggables';	
		$popular_tags=DB::table($taggablest)
	                ->join(session('tenant').'_tags', $taggablest.'.tag_id','=', session('tenant').'_tags.id')
	                ->select(DB::raw($taggablest.'.tag_id, '.session('tenant').'_tags.name , count('.$taggablest.'.tag_id) as tagcounts'))
	                ->where($taggablest.'.taggable_type','App\Post')
	                ->groupBy($taggablest.'.tag_id')
	                ->orderBy('tagcounts', 'desc')
	                ->limit(6)
	                ->get();  

//dd($popular_tags);
       return view('pages.posts.index', ['popular_tags'=>$popular_tags,
                                         ]);
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
                $order='content';
                $direction='asc';
             break;  
             case 'view_count':
                $order='view_count';
                $direction='desc';
             break; 
             default:
                $order='created_at';
                $direction='desc';
            break;
        }

        
          if($request->tag_ids)
          {
            //$tags=Tag::where('id', $request->tag_ids)->get();
            $tag_ids = $request->tag_ids;
            $posts = Post::whereExists(function ($query) use($tag_ids){
                $query->select(DB::raw(1))
                      ->from(session('tenant').'_taggables')
                      ->whereIn(session('tenant').'_taggables.tag_id', $tag_ids)
                      ->where(session('tenant').'_taggables.taggable_type' , 'App\Post')
                      ->whereRaw(session('tenant').'_taggables.taggable_id = '.session('tenant').'_posts.id');
            })->with(['user','tags','imgs'])
            ->orderBy($order, $direction)->paginate(1);
            

          }  
          else 
            
          {
	        $posts=Post::with(['user','tags','imgs'])
	         ->orderBy($order, $direction)
	         ->paginate(1);
             
         }

         if ($request->ajax()) //{
            //return view('_includes.projects_load', ['projects' => $projects])->render();  
        //}
            return json_encode($posts);
          
        
       // return view('pages.projects.index', compact('projects'));
    }


}