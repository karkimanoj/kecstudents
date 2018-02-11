<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DownloadCategory;
use Session;

class DownloadCategoryController extends Controller
{
	

    public function index()
    {
    	$categories=DownloadCategory::all();
    	return view('manage.downloads.download_categories', ['categories'=>$categories]);
    }

    public function store(Request $request)
    {
    	$this->validate($request, ['name'=>'required|alpha_dash|max:200']);
        $category_type=$request->type;
        if($category_type=='subject' || $category_type=='facsem')
        {
        	$category=new DownloadCategory;
            $category->category_type= $category_type;
        	$category->name=$request->name;
        	$category->save();

        	Session::flash('success','new category '.$category->name.' successfully added');
        	return redirect()->route('download_categories.index');
        }
    }
}
