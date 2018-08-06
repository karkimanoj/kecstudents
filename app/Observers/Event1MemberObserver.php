<?php

namespace App\Observers;

use Illuminate\Support\Collection;
use App\Event1Member;
use Notification;
use Auth;
use App\Notifications\Event1MemberNotification;

class Event1MemberObserver
{

    public function saved(Event1Member $member)
    {  
      
        $member->trashed() ?  $type = 'interested' :  $type = 'joined';

        $users = new Collection();
        foreach ($member->event1->event1_members()->withTrashed()->where('user_id', '!=', Auth::user()->id)->get() as $Emember)
        {
           $users->push($Emember->user);
           
        }

        if( Auth::user()->id != $member->event1->user->id )  $users->push($member->event1->user);
          
        if($users)
            Notification::send($users->unique(), new Event1MemberNotification($member, $type));
        
    }
    
    public function deleted(Event1Member $member)
    { 
       
        $users = new Collection();
        foreach ($member->event1->event1_members()->withTrashed()->where('user_id', '!=', Auth::user()->id)->get() as $Emember)
        {
          $users->push($Emember->user);
           
        }

          if( Auth::user()->id != $member->event1->user->id )  $users->push($member->event1->user);

        if( !($member->trashed()) )
        {   
            if($users)
            {   //dd($users->unique());
                $type = 'unjoined';
                Notification::send($users->unique(), new Event1MemberNotification($member, $type));
            }
            
        }
         
    }

    public function restored(Event1Member $member)
    {       
        $type = 'joined';
        $flag = 1;

         $users = new Collection();
        foreach ($member->event1->event1_members()->withTrashed()->where('user_id', '!=', Auth::user()->id)->get() as $Emember)
        {
           $users->push($Emember->user);
           
        }

          if( Auth::user()->id != $member->event1->user->id )  $users->push($member->event1->user);
          if($users) Notification::send($users->unique(), new Event1MemberNotification($member, $type));
    }
}