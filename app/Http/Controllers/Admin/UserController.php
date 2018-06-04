<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Session;
use Hash;
use Auth;

class UserController extends Controller
{

    /* required if we used Request::all()

         protected $request;

        public function __construct(Request $request) {
            $this->request = $request;
        }
    */

    public function __construct()
    {
        $this->middleware('permission:create-users', [ 'only' => ['create', 'store'] ]);
        $this->middleware('permission:update-users', [ 'only' => ['edit', 'update'] ]);
         $this->middleware('permission:destroy-users', [ 'only' => ['destroy',] ]);
        
    }
        
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
            'roll_no'=>'required|string|max:12|unique:users',
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
        $user->roll_no=$request->roll_no;
        $user->password=Hash::make($password);
        $user->api_token=bin2hex(openssl_random_pseudo_bytes(30));

        if($user->save())
        {
             $user->roles()->sync($request->input('roles'), false);
             Session::flash('success',' new user created successfully');
            return redirect()->route('users.show', $user->id);
        }
        else
        {
            //Session::flash('error','sorry new user cannot be created');
            return back()->withErrors('sorry new user cannot be created');
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
        //
    }
}
