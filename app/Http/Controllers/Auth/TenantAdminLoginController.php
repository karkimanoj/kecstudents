<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class TenantAdminLoginController extends Controller
{	
	use AuthenticatesUsers;

    public function __consruct()
    {
    	$this->middleware('guest:tenant_admin')->except('tenantAdminLogout');
    }

    public function showLoginForm()
    {
    	return view('auth.tenant_admin_login');
    }

    public function login(Request $request)
    {
    	$this->validate($request, [
    		'email' => 'required|email',
    		'password' => 'required|min:8'
    	]);

    	if( Auth::guard('tenant_admin')->attempt([ 'email' => $request->email, 'password' => $request->password]) )
    		return redirect()->intended(route('tenants.index'));
    	else 
    	  	return redirect()->back()->withInput($request->only('email', 'remember'));	
    }

    public function tenantAdminLogout()
    {
    	Auth::guard('tenant_admin')->logout();
    	return redirect()->route('tenantadmin.login');
    }
}
