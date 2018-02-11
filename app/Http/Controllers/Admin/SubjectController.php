<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Subject;
use App\Faculty;
use Session;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects=Subject::with('faculties')->get();
       // $facultys=$subjects->faculties->name;
        return view('manage.subjects.index', ['subjects'=>$subjects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $faculties=Faculty::all();
        return view('manage.subjects.create', ['faculties'=>$faculties]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name'=>'required|max:255|unique:subjects,name',
                                    'faculty'=>'required']);

        $subject=new Subject;
        $subject->name=$request->name;
        $subject->project=$request->project_check;

        /*syncing with inserting additional values  in additional column of pivot table
        */
        $semester_array=[];
        $faculty_array=[];
        foreach ($request->faculty as $faculty) {
            array_push($faculty_array, $faculty);
           array_push($semester_array, array('semester'=>$request->get('semester'.'_'.$faculty)) );

        }

        $syncData=array_combine($faculty_array, $semester_array);

        $subject->save();

        if($subject->faculties()->sync($syncData, false))
        {
            Session::flash('success','new subject added successfully');
            return redirect()->route('subjects.index');
        }

/*
        foreach ($request->faculty as $faculty) {
            array_push($pivot_array,
                $faculty=>['semester'=>$request->semester.'_'.$faculty] );
        }

        */
        //$count=count($request->faculty);
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subject=Subject::findOrFail($id);
        return view('manage.subjects.show', ['subject'=>$subject]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subject=Subject::findOrFail($id);
        $faculties=Faculty::all();
        return view('manage.subjects.edit', ['subject'=>$subject,
                                      'faculties'=>$faculties]);
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
        $this->validate($request, ['name'=>'required|max:255|unique:subjects,name,'.$id,
                                    'faculty'=>'required']);

        $subject=Subject::findOrFail($id);
        $subject->name=$request->name;
        $subject->project=$request->project_check;

        /*syncing with inserting additional values  in additional column of pivot table
        */
        $semester_array=[];
        $faculty_array=[];
        foreach ($request->faculty as $faculty) {
            array_push($faculty_array, $faculty);
           array_push($semester_array, array('semester'=>$request->get('semester'.'_'.$faculty)) );

        }

        $syncData=array_combine($faculty_array, $semester_array);

        $subject->save();

        if($subject->faculties()->sync($syncData, true))
        {
            Session::flash('success', $subject->name.' subject was updated successfully');
            return redirect()->route('subjects.show', $subject->id);
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
        $subject=Subject::findOrFail($id);
        if($subject->delete())
            Session::flash('success', $subject->display_name.' subject was successfully deleted');
        return redirect()->route('subjects.index');
    }
}
