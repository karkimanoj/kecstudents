<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use Session;
use DB;

class CollegePeopleController extends Controller
{
    public function __construct()
    {
       /* $this->middleware('permission:create-users', [ 'only' => ['create', 'store'] ]);
        $this->middleware('permission:update-users', [ 'only' => ['edit', 'update'] ]);
         $this->middleware('permission:destroy-users', [ 'only' => ['destroy',] ]);*/
        $this->middleware('role:superadministrator');
    }
        
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {   
        switch ($type) 
    	{
    		case 'teacher':
    			$table = session('tenant').'_teachers';
    			break;
    		case 'staff':
    			$table = session('tenant').'_staffs';
    			break;
    		default:
    			$table = session('tenant').'_students';
    			break;
    	}
        $peoples=DB::table($table)->paginate(20);
        //dd($peoples);
        return view('manage.collegePeoples.index', ['peoples'=>$peoples, 'role'=>$type]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {	
    	$roles = ['student', 'teacher', 'staff'] ;
       
        return view('manage.collegePeoples.create', ['roles'=>$roles] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	switch ($request->role) 
    	{
    		case 'teacher':
    			$table = session('tenant').'_teachers';
    			break;
    		case 'staff':
    			$table = session('tenant').'_staffs';
    			break;
    		default:
    			$table = session('tenant').'_students';
    			break;
    	}

        $this->validate($request, [
            'name'=>'required|string|max:191',
            'roll_no'=>'required|string|max:13|unique:'.$table.',roll_no',
            'role' => 'required|in:student,teacher,staff',
            'email'=>'required|email|max:191|unique:'.$table.',email',
           	'gender' => 'required|in:male,female',
           	'dob' => 'required|date|before:today',
        ]);
       // dd($request);

        if(
           DB::table($table)->insert(
			    ['name'=> $request->name, 'roll_no' => $request->roll_no, 'email'=> $request->email, 'gender' => $request->gender, 'dob'=> $request->dob, 'created_at' => now(), 'updated_at' => now()]
			)
        ){
        	Session::flash('success', 'succsfully inserted new '.$request->role);
        	return redirect()->route('collegePeoples.show', [DB::table($table)->where('roll_no', $request->roll_no)->first()->id, $request->role]);
        }   else
        return back()->withErrors('Failed inserting new '.$request->role);

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $type)
    {	
    	switch ($type) 
    	{
    		case 'teacher':
    			$table = session('tenant').'_teachers';
    			break;
    		case 'staff':
    			$table = session('tenant').'_staffs';
    			break;
    		default:
    			$table = session('tenant').'_students';
    			break;
    	}
    	
        $people=DB::table($table)->find($id);
        abort_if(!$people, 404);
        //dd($people);
        return view('manage.collegePeoples.show', ['people'=>$people, 'role' => $type]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $type)
    {	
    	switch ($type) 
    	{
    		case 'teacher':
    			$table = session('tenant').'_teachers';
    			break;
    		case 'staff':
    			$table = session('tenant').'_staffs';
    			break;
    		default:
    			$table = session('tenant').'_students';
    			break;
    	}
        $people=DB::table($table)->find($id);
        abort_if(!$people, 404);
        //dd($people);
        return view('manage.collegePeoples.edit', ['people'=>$people, 'role' => $type]);
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
        switch ($request->role) 
    	{
    		case 'teacher':
    			$table = session('tenant').'_teachers';
    			break;
    		case 'staff':
    			$table = session('tenant').'_staffs';
    			break;
    		default:
    			$table = session('tenant').'_students';
    			break;
    	}

        $this->validate($request, [
        	'role' => 'required|in:student,teacher,staff',
            'name'=>'required|string|max:191',
            'roll_no'=>'required|string|max:13|unique:'.$table.',roll_no,'.$id,
            
            'email'=>'required|email|max:191|unique:'.$table.',email,'.$id,
           	'gender' => 'required|in:male,female',
           	'dob' => 'required|date|before:today',
        ]);

        if(
         DB::table($table)
            ->where('id', $id)
            ->update([
            	'name'=> $request->name, 'roll_no' => $request->roll_no, 'email'=> $request->email, 'gender' => $request->gender, 'dob'=> $request->dob, 'updated_at' => now()
            ])
        )
        {
        	Session::flash('success', 'succsfully updated '.$request->role.' '.$request->name);
        	return redirect()->route('collegePeoples.show', [$id, $request->role]);
        }  else
        	return back()->withErrors('Failed updating new '.$request->role.' '.$request->name);  
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $type)
    {
        switch ($type) 
    	{
    		case 'teacher':
    			$table = session('tenant').'_teachers';
    			break;
    		case 'staff':
    			$table = session('tenant').'_staffs';
    			break;
    		default:
    			$table = session('tenant').'_students';
    			break;
    	}
        $people=DB::table($table)->find($id);
        abort_if(!$people, 404);
        //dd($people);
        if(DB::table($table)->where('id',$id)->delete())
        {
             
             Session::flash('successfully deleted '.$people->name.' ['.$people->roll_no.'] from '.$type.'s' );
            return redirect()->route('collegePeoples.index', $type);
        }
        else            
            return back()->withErrors('sorry user'.$people->name.' ['.$people->roll_no.'] couldnot be deleted due to technical reasons');
    }
}
