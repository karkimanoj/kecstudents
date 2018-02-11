<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Tag;
use Session;

class TagController extends Controller
{
    public function index()
    {
    	$tags=Tag::paginate(40);
    	return view('manage.tags.index', ['tags'=>$tags]);
    }

    public function destroy($id)
    {
    	 $tag=Tag::findOrFail($id);
        if($tag->delete())
            Session::flash('success', $tag->name.' tag was successfully deleted');
        return redirect()->route('tags.index');
    }
}
