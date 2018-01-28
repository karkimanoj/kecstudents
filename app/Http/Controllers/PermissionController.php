<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use Session;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $permissions=Permission::all();
        return view('manage.permissions.index', ['permissions'=>$permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->permission_type=='basic')
        {
            $this->validate($request, ['display_name'=>'required|min:5|max:100',
                'name'=>'required|min:5|max:100|unique:permissions,name',
                'description'=>'required|min:8|max:150'
                ]);    

            $permission=new Permission;
            $permission->name=$request->name;
            $permission->display_name=$request->display_name;
            $permission->description=$request->description;

            $permission->save();
            Session::flash('success','new permission successfully created');
            return redirect()->route('permissions.index');
        }
        elseif ($request->permission_type=='crud') 
        {
            $this->validate($request, ['resource'=>'required|min:5|max:80|unique:permissions,name']);

            $resource=trim($request->resource);
            $cruds=$request->crud_checks;
            if(count($cruds)>0)
            {   
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
                Session::flash('new permissions created successfully ');
                return redirect()->route('permissions.index');
            }           
        } else
            return redirect()->route('permissions.create');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission=Permission::findOrFail($id);
        return view('manage.permissions.show', ['permission'=>$permission]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $permission=Permission::findOrFail($id);
        return view('manage.permissions.edit', ['permission'=>$permission]);
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
        //dd($request);
        $this->validate($request, ['display_name'=>'required|min:5|max:100',
                'description'=>'required|min:8|max:150'
                ]);    

            $permission=Permission::findOrFail($id);
            $permission->display_name=$request->display_name;
            $permission->description=$request->description;

            $permission->save();
            Session::flash('success',' permission updated successfully');
            return redirect()->route('permissions.show', $permission->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
