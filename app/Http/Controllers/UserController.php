<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Session;
use Hash;

class UserController extends Controller
{

    /* required if we used Request::all()

         protected $request;

        public function __construct(Request $request) {
            $this->request = $request;
        }
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::paginate(5);
        return view('manage.users.index', ['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles=Role::all();
        return view('manage.users.create', ['roles'=>$roles] );
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
            'name'=>'required|max:100',
            'email'=>'required|email|max:100|unique:users,email'
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

        $user=new User;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($password);

        if($user->save())
        {
             $user->roles()->sync($request->input('roles'), false);
             Session::flash('error','sorry new user cannot be created');
            return redirect()->route('users.show', $user->id);
        }
        else
        {
            Session::flash('error','sorry new user cannot be created');
            return redirect()->route('users.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=User::where('id', $id)->with('roles')->first();
        return view('manage.users.show', ['user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::where('id', $id)->with('roles')->first();
        $roles=Role::all();
        return view('manage.users.edit', ['user'=>$user, 'roles'=>$roles]);
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
            'name'=>'required|max:100',
            'email'=>'required|max:100|email|unique:users,email,'.$id
        ]);

         $user=User::findOrFail($id);
         $user->name=$request->name;
         $user->email=$request->email;

         if($request->passedit_radio=='manual')
            $user->password=Hash::make($request->password);

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
            $user->password=Hash::make($password);
        }

        if($user->save())
        {   
            $user->roles()->sync($request->input('roles'), true);
            Session::flash('success','updating user credentials for '.$user->name);
            return redirect()->route('users.show', $id);
        } else
        {
            Session::flash('error','Error in updating user credentials');
            return redirect()->route('users.edit',$id);
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
        //
    }
}
