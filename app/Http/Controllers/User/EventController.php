<?php

namespace App\Http\Controllers\User;

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

    public function __construct()
    {
        $this->middleware('permission:create-events', ['only' => ['create', 'store'] ]);
        $this->middleware('permission:update-events', [ 'only' => ['edit', 'update'] ]);
        $this->middleware('permission:destroy-events', [ 'only' => ['destroy',] ]);

         $this->middleware(function ($request, $next) 
         {  
            $value = $request->session()->get('tenant');

           
            Event1::where('end_at', '<', now())->delete();
            return $next($request);
        });
        //

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Responsey
     */
    public function index()
    {   

         
        
        $events = Auth::user()->event1s;
        
        return view('user.events.index', ['events' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  
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

        $interested_members = Event1Member::onlyTrashed()->where('event1_id','=', $id)->get();
        return view('user.events.show', ['event' => $event,
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
            return view('user.events.edit', ['event' => $event]);
        else
            return redirect()->route('user.events.show', $event->id)->withErrors('updating failed! EITHER YOU ARE NOT THE CREATOR OF THE EVENT OR THE TIME TO EVENT START IS LESS THAN 18 HOURS');
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
                return redirect()->route('user.events.index'); 
            }else
            return redirect()->route('user.events.index')->withErrors($event->title.' faled to be updated');
        } 
        else 
            return redirect()->route('user.events.index')->withErrors('updating failed! EITHER YOU ARE NOT THE CREATOR OF THE EVENT OR THE TIME TO EVENT START IS LESS THAN 18 HOURS');
        //return redirect()->route('user.events.show', $event->id)->withErrors('updating failed! EITHER YOU ARE NOT THE CREATOR OF THE EVENT OR THE TIME TO EVENT START IS LESS THAN 18 HOURS');
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

    public function eventFeed(Request $request)
    {   
        
     if($request->personId == 'my')  
            $events = Auth()->user()->event1s()->withTrashed()->get();
      else
            $events = Event1::withTrashed()->get();
        

        $data=[];
        foreach ($events as $event) 
        {   

            switch ($event->type) 
            {
                case 'study':
                   $color = '#7F0180';
                    break;
                case 'entertainment':
                   
                   $color = '#007F00';
                    break;
                case 'miscellaneous':
                   $color = '#d50000';
                    break;       
            }
            if($event->trashed())  $color='#707070';   

            $status = NULL;
            if( $member = $event->event1_members()->withTrashed()->where('user_id', Auth::user()->id)->first()){
                if($member->trashed())  $status = 'interested'; else $status = 'joined';
            }
            

           array_push($data, [
                'id' => $event->id,
                'title' => $event->title,
                'type'=> $event->type,
                'start' => ($event->start_at)->toDateTimeString(),
                'end' => ($event->end_at)->toDateTimeString(),
                'venue' => $event->venue,
                'description' => $event->description,
                'color' =>  $color,
                'owner' => $event->user->name,
                'members_joined' => $event->event1_members->count().'/'.$event->max_members,
                'textColor' => '#ffffff',
                'editable' => ($event->user_id == Auth::user()->id),  
                'user_status' => $status,
                'deleted_at' => $event->deleted_at
            ]);
        }

       return json_encode($data);

    }

    public function interest_and_join(Request $request)
    {   
        $event = Event1::findOrFail($request->id);
     
        if($request->ajax())
        {   

            if(trim($request->action)  == 'unjoin')
            {
                $event->event1_members()->where('user_id', Auth::user()->id)->forceDelete();
                 $respnse_text = 'unjoin';
            }
            else if($request->action == 'uninterested')
            {
                $event->event1_members()->withTrashed()->where('user_id', Auth::user()->id)->forceDelete();
                 $respnse_text = 'uninterested';
            }
            else
                {
                    $member=$event->event1_members()->withTrashed()->where('user_id', (Auth::user()->id))->first();
                    //return json_encode( $member);
                        if($member)
                        {
                            $member->restore();
                             $respnse_text = 'uninterested';
                        }
                        else
                        {
                            $member = new Event1Member;
                            if($request->action == 'interested') $member->deleted_at = now() ;
  
                            
                            $member->event1()->associate($event);
                            $member->user()->associate(Auth::user());
                            $member->save();
                               // 2nd method
                            // $member = new Event1Member;
                            //$event->event1_members()->save($member);
                            //$member->user_id = Auth::user()->id;
                            //$member->save() --end of 2nd method
                        }
                }

        }
     
    }
    /*
    public function eventList(Request $request)
    { 
        //$events = Event1::where('start_at','>=',$request->start)->orWhere('end_at','<=',$request->end)->get();
        $events = Event1::whereBetween('start_at', [$request->start, $request->end])->withCount('event1_members')->with('user')->get();
        if($request->ajax())
        return json_encode($events);
       
    }   */

}
