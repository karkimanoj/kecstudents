<?php

namespace App\Http\Controllers;
use App\Project;
use App\Subject;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function construct()
    {
         $this->middleware('auth');
    }

    public function projectIndex($category)
    {   
        if($category==0)
            $projects=Project::where('published_at','!=', 'NULL')->paginate(10);
        else
        	$projects=Project::where('published_at','!=', 'NULL')->where('subject_id', $category)->paginate(10);

        	$categories=Subject::where('project', 1)->get();
            $active_category=Subject::find($category);
        return view('pages.projects.index', ['projects'=>$projects,
        									 'categories'=>$categories,
                                                'active_category'=>$active_category]);
    }

    public function projectShow()
    {

    }
}
