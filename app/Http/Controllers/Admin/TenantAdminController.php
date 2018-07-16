<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TenantAdmin;
use Session;
use Auth;
use Hash;

class TenantAdminController extends Controller
{
    public function __construct()
    {   
       
        $this->middleware('auth:tenant_admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $tenant_admins=TenantAdmin::all();
        return view('manage.tenant_admins.index', ['tenant_admins' => $tenant_admins]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('manage.tenant_admins.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tenant_admins,email',
            'password' => 'sometimes|string|min:6|confirmed'
        ]);


        if($request->has('password') && !empty($request->password)){
                $password=trim($request->password);
        } else
        {
            $length=10;
            $keys='123456789abcdefghJkLmnpQRSTuVWXYz';
            $str='';
            $keylength=mb_strlen($keys,'8bit')-1;
            for($i=0; $i<$length; $i++)
                $str.=$keys[random_int(0,$keylength)];

            $password=$str;
        }

        $tenantAdmin=new TenantAdmin;
        $tenantAdmin->name=$request->name;
        $tenantAdmin->email=$request->email;
        $tenantAdmin->password=Hash::make($password);
        $tenantAdmin->api_token=bin2hex(openssl_random_pseudo_bytes(30));

        if($tenantAdmin->save())
        {
             
             Session::flash('success',' new tenant admin created successfully');
            return redirect()->route('tenantAdmin.show', $tenantAdmin->id);
        }
        else            
            return back()->withErrors('sorry new tenant admin cannot be created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tenant_admin=TenantAdmin::findOrFail($id);
        return view('manage.tenant_admins.show', ['tenant_admin'=>$tenant_admin]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        if($id == Auth::guard('tenant_admin')->user()->id)
         return view('manage.tenant_admins.edit', ['tenant_admin'=> Auth::guard('tenant_admin')->user()]);
         else
             return back()->withErrors('you dont have permission to edit this user');
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
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:tenant_admins,email,'.$id,
            'password' => 'sometimes|string|min:6'
        ]);


         $tenantAdmin=TenantAdmin::findOrFail($id);
         $tenantAdmin->name=$request->name;
         $tenantAdmin->email=$request->email;

         if($request->passedit_radio=='manual')
            $tenantAdmin->password=Hash::make($request->password);

        else if($request->passedit_radio=='auto')
        { 
            /*
              auto generating random password of 8 characters  
            */

            $length=10;
            $keys='123456789abcdefghJkLmnpQRSTuVWXYz';
            $str='';
            $keylength=mb_strlen($keys, '8bit')-1;
            for($i=0; $i<$length; $i++)
                $str.=$keys[random_int(0,$keylength)];

            $password=$str;
            $tenantAdmin->password=Hash::make($password);
        }

        if($tenantAdmin->save())
        {   
            
            Session::flash('success','updating user credentials for '.$tenantAdmin->name);
            return redirect()->route('tenantAdmin.show', $id);
        } else
        {
            return back()->withErrors('Error ocurred in updating user credentials. Try again');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tenant_admin = TenantAdmin::findOrFail($id);
        
        if($tenant_admin->delete())
        {
             
             Session::flash('success',$tenant_admin->email.' a tenant admin deleted successfully');
            return redirect()->route('tenantAdmin.index');
        }
        else            
            return back()->withErrors('sorry '.$tenant_admin->email.' tenant admin cannot be deletd');
    }
}
