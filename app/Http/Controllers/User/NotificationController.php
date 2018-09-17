<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class NotificationController extends Controller
{   
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(10);
        //dd($notifications->first());
        return view('user.notifications.index', ['notifications' => $notifications]);
    }

    public function markAllAsRead()
    {	
    	if(Auth::user()->unreadNotifications->count())
    		Auth::user()->unreadNotifications->markAsRead();

    	return back();	
    }

    public function markAsRead($id)
    {
    		
    		$notifications = Auth::user()->notifications()->where('id', $id)->get();
    		if(count($notifications) )
    		{	
    			$notification= $notifications->first();
    			if(is_null($notification->read_at))
    			{
    				$notification->markAsRead();
    			}
    			return redirect($notification->data['url']);

    		} else
    			return back();	
    		
    
    }
}
