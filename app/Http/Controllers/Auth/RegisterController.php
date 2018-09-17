<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {   /*
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'roll_no'=>'required|string|max:12|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);*/
        
        $tenant = session('tenant');
        switch ($data['role']) {
            case 'staff':
                $table = $tenant.'_staffs';
                break;
            case 'teacher':
                $table = $tenant.'_teachers';
                break;
            default:
                $table = $tenant.'_students';
                break;
        }
       
                 return Validator::make($data, [
            'role' => 'required|string|in:student,staff,teacher',
            'roll_no'=>'required|string|max:13|exists:'.$table.',roll_no|unique:users,roll_no',
            'email' => 'required|string|email|max:255|exists:'.$table.',email|unique:users,email',
           
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {   //dd($data);
        $tenant = session('tenant');
        switch ($data['role']) {
            case 'staff':
                $table = $tenant.'_staffs';
                break;
            case 'teacher':
                $table = $tenant.'_teachers';
                break;
            default:
                $table = $tenant.'_students';
                break;
        }
        // = $tenant;
        $user=DB::table($table)->where([ 
            ['roll_no','=',$data['roll_no']] ,
            ['email', '=', $data['email']]
        ])->first();
        /*
        return User::create([
            'name' => $data['name'],
            'roll_no' => $data['roll_no'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'api_token'=>bin2hex(openssl_random_pseudo_bytes(30))
        ]);
        */
        return User::create([
            'name' => $user->name,
            'roll_no' => $user->roll_no,
            'email' => $user->email,
            'password' => bcrypt(str_random(8)),
            'api_token'=>bin2hex(openssl_random_pseudo_bytes(30)),
            'tenant_identifier' => session('tenant')
        ]);
    }
}
