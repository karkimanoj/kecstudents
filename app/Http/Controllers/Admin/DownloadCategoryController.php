<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DownloadCategory;
use App\Permission;
use Auth;
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
        if(Auth::user()->hasPermission(['create-download_categories']))
        {    
        	$this->validate($request, ['name'=>'required|unique:'.session('tenant').'_download_categories,name|alpha_dash|max:100',
                                        'max_files' =>'required|integer|between:1,12'
                                        ]);
            $category_type=$request->type;
            if($category_type=='subject' || $category_type=='facsem')
            {
            	$category=new DownloadCategory;
                $category->category_type= $category_type;
            	$category->name= trim($request->name);
                $category->max_no_of_files = $request->max_files;
            	if($category->save())
                {
                    $resource=$category->name;
                    $cruds=['create', 'read', 'update', 'destroy'];
                     
                        foreach($cruds as $crud)
                        {
                            $name=strtolower($crud.'-'.$resource);
                            $display_name=ucwords($crud.' '.$resource);
                            $description='allows user to '.$crud.' '.$resource;

                            $permission=new Permission;
                            $permission->name=$name;
                            $permission->display_name=$display_name;
                            $permission->description=$description;
                            $permission->save();
                        }    
                        Session::flash('success','new category '.$category->name.' and its corresponding permissions created successfully ');
                        return redirect()->route('permissions.index');
                                          
                }return back()->withErrors('failed to create new download category');
            	
            }
        }else
            return back()->withErrors('you dont have permission for this activity');
    }
}
