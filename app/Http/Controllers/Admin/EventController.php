<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event1;
use App\Event1Member;
use Auth;
use Validator;
use Session; 
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   //dd(config('laratrust.tables.permissions'));
        $events = Auth::user()->event1s()->withTrashed()->paginate(5);
        
        return view('manage.events.index', ['events' => $events]);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { //dd($request);
        Validator::make($request->all(), [
            'title'=>'required|min:2|max:191',
            'type'=>'required|in:study,entertainment,miscellaneous',
            'venue'=>'required|max:191',
            'start_date'=>'required|date|after:today',
            'end_date'=>'nullable|date|after_or_equal:start_date',
            'start_time'=>'required|date_format:H:i',
            'end_time'=>'required|date_format:H:i',
            'max_members'=>'required|integer|min:1|max:10000',
            'description'=>'required|max:4000'
        ])->validate();

        $start_at=new Carbon($request->start_date.' '.$request->start_time);
        $end_at=new Carbon($request->end_date.' '.$request->end_time);
        
        $event = new Event1;
        $event->title = $request->title;
        $event->type = $request->type;
        $event->venue = $request->venue;
        $event->start_at = $start_at->toDateTimeString();
        $event->end_at = $end_at->toDateTimeString();
        $event->max_members = $request->max_members;
        $event->description = $request->description;
        $event->user_id = Auth::user()->id;
        
        if($event->save())
        {//dd($event);
            Session::flash('success', $event->title.' succesfully created');
            return back(); 
        }else
        return back()->withErrors('New event failed to be created');
        
    }  

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show($id)
    {
        $event = Event1::withTrashed()->where('id', $id)->with('event1_members.user')->first();
        //dd($event);
        $interested_members = Event1Member::onlyTrashed()->where('event1_id','=', $id)->get();
        return view('manage.events.show', ['event' => $event,
                                         'interested_members' => $interested_members]);
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {  
         $event = Event1::where('id', $id)->with('event1_members')->first();
        
        if(Auth::user()->owns($event) && Carbon::now()->diffInHours($event->start_at, false) >= 18)
            return view('manage.events.edit', ['event' => $event]);
        else
            return redirect()->route('events.show', $event->id)->withErrors('updating failed! EITHER YOU ARE NOT THE CREATOR OF THE EVENT OR THE TIME TO EVENT START IS LESS THAN 18 HOURS');
        
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
        $event = Event1::findOrFail($id);

        if(Auth::user()->owns($event) && Carbon::now()->diffInHours($event->start_at, false) >= 18)
        {    
            $min_members = 1;
            ($event->event1_members->count() > $min_members) ? $min_members=$event->event1_members->count() : '';

            Validator::make($request->all(), [
                'title'=>'required|min:4|max:191',
                'type'=>'required|in:study,entertainment,miscellaneous',
                'venue'=>'required|max:191',
                'start_date'=>'required|date|after:today',
                'end_date'=>'nullable|date|after_or_equal:start_date',
                'start_time'=>'required|date_format:H:i', 
                'end_time'=>'required|date_format:H:i',
                'max_members'=>'required|integer|min:'.$min_members.'|max:10000',
                'description'=>'required|max:4000'
            ])->validate();

            $start_at=new Carbon($request->start_date.' '.$request->start_time);
            $end_at=new Carbon($request->get('end_date', $request->start_date).' '.$request->end_time);

            $event->title = $request->title;
            $event->type = $request->type;
            $event->venue = $request->venue;
            $event->start_at = $start_at->toDateTimeString();//$request->start_date.' '.$request->start_time;
            $event->end_at = $end_at->toDateTimeString();//$request->end_date.' '.$request->end_time;
            $event->max_members = $request->max_members;
            $event->description = $request->description;
            
            if($event->save())
            {//dd($event);
                Session::flash('success', $event->title.' succesfully updated');
                return redirect()->route('events.show', $id); 
            }else
            return redirect()->route('events.show', $id)->withErrors($event->title.' faled to be updated');
        } 
        else 
            return redirect()->route('events.show', $id)->withErrors('updating failed! EITHER YOU ARE NOT THE CREATOR OF THE EVENT OR THE TIME TO EVENT START IS LESS THAN 18 HOURS');
        //return redirect()->route('user.events.show', $event->id)->withErrors('updating failed! EITHER YOU ARE NOT THE CREATOR OF THE EVENT OR THE TIME TO EVENT START IS LESS THAN 18 HOURS');
    }

    public function ajaxSoftDelete(Request $request)
    {    $deleted_at='aaaaaa';
    
        $event = Event1::withTrashed()->find($request->id);

        if($request->status == 'activate')
        {   
            $event->restore();
            $deleted_at ='';
        }
        else
        if($request->status == 'deactivate')
        {
            $event->delete();
            $deleted_at = ($event->deleted_at)->toDateTimeString();
        }

        if($request->ajax())
            return json_encode([$deleted_at]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $event = Event1::findOrFail($id);
         //    dd(Carbon::now());
        if(Auth::user()->owns($event) && Carbon::now()->diffInHours($event->start_at, false) >= 18)
        {    
            //$event->event1_members->delete();

            if($event->forceDelete())
            {
                Session::flash('success', $event->title.' succesfully deleted');
                return redirect()->route('user.events.index'); 
            }else
            return back()->withErrors('failed to delete '.$event->title.' due to technical error');

        } 
        else
        return redirect()->route('user.events.show', $event->id)->withErrors('Deleting failed! EITHER YOU ARE NOT THE CREATOR OF THE EVENT OR THE TIME TO EVENT START IS LESS THAN 18 HOURS');   
    }
}