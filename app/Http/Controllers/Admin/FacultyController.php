<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Faculty;
use Session;
use Auth;

class FacultyController extends Controller
{   
  
    /**
     * Display a listin of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faculties=Faculty::paginate(10);
        return view('manage.faculties.index', ['faculties'=>$faculties]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if(Auth::user()->hasPermission(['create-faculties']))
        { 
            $faculties=Faculty::all();
            return view('manage.faculties.create');
        }else
            return back()->withErrors('you dont have permission for this activity');    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if(Auth::user()->hasPermission(['create-faculties']))
        { 
            $this->validate($request, ['name'=>'required|max:100|unique:faculties,name',
                'display_name'=>'required|max:255']);

            $faculty=new Faculty;
            $faculty->name=$request->name;
            $faculty->display_name=$request->display_name;

            if($faculty->save()){
                Session::flash('success', $request->name.' faculty has been created successfully');
                return redirect()->route('faculties.show', $faculty->id);
            }
         }else
            return back()->withErrors('you dont have permission for this activity');    
    }

    public function edit($id){
        if(Auth::user()->hasPermission(['update-faculties']))
        { 
            $faculty=Faculty::findOrFail($id);
            return view('manage.faculties.edit', ['faculty'=>$faculty]);
        }else
            return back()->withErrors('you dont have permission for this activity');    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $faculty=Faculty::findOrFail($id);
        return view('manage.faculties.show', ['faculty'=>$faculty]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {   
        if(Auth::user()->hasPermission(['update-faculties']))
        { 
            $this->validate($request, ['name'=>'required|max:100|unique:faculties,name,'.$id,
                'display_name'=>'required|max:255']);

            $faculty=Faculty::findOrFail($id);
            $faculty->name=$request->name;
            $faculty->display_name=$request->display_name;

            if($faculty->save()){
                Session::flash('success', $request->name.' faculty has been edited successfully');
                return redirect()->route('faculties.show', $faculty->id);
            }
        }else
            return back()->withErrors('you dont have permission for this activity');    
    }
    
    public function destroy($id)
    {   
        if(Auth::user()->hasPermission(['destroy-faculties']))
        {
            $faculty=Faculty::findOrFail($id);
            if($faculty->delete())
                Session::flash('success', $faculty->display_name.' faculty was successfully deleted');

            return redirect()->route('faculties.index');
        }else
            return back()->withErrors('you dont have permission for this activity');    
    }
}
