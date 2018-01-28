<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use Session;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles=Role::all();
        return view('manage.roles.index', ['roles'=>$roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions=Permission::all();
        return view('manage.roles.create', ['permissions'=>$permissions] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //dd($request);
        
        $this->validate($request, [
            'name'=>'required|min:5|max:100|alphadash|unique:roles,name',
            'display_name'=>'required|min:5|max:100',
            'description'=>'required|min:5|max:190'
          ]);

        $role=new Role;
        $role->name=$request->name;
        $role->display_name=$request->display_name;
        $role->description=$request->description;
        $role->save();

        if($request->permission_checks)
            $role->permissions()->sync($request->permission_checks, false);

        Session::flash('success','new role created successfully');
        return redirect()->route('roles.show', $role->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role=Role::findOrFail($id);
        return view('manage.roles.show', ['role'=>$role]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role=Role::findOrFail($id);
        $permissions=Permission::all();
        return view('manage.roles.edit', ['role'=>$role ,
                                          'permissions'=>$permissions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {// dd($request);
        
        $this->validate($request, ['display_name'=>'required|min:5|max:100',
                                    'description'=>'required|min:5|max:190'
                                  ]);
        $role=Role::findOrFail($id);
        $role->display_name=$request->display_name;
        $role->description=$request->description;
        $role->save();

        if($request->permission_checks)
            $role->permissions()->sync($request->permission_checks, true);

        Session::flash('success','permissions succesfully updated for '.$role->display_name);
        return redirect()->route('roles.show', $id);
        
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
