<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
 use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /* original constructer
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }*/

    //__construct and userLogout function are added for  multi auth
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'userLogout']]);
    }

    public function userLogout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }

/* modifying credentials function of AuthenticatesUsers trait for additional login validation with  tenant_identifier. custom code 
*/
    public function credentials(Request $request)
    {   
        $credentials = $request->only($this->username(), 'password');
         $credentials = array_add($credentials, 'tenant_identifier', session('tenant'));
        return $credentials;
    }


}
