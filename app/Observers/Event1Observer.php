<?php

namespace App\Observers;

use App\Event1;
use Notification;
use App\Notifications\Event1Notification;

class Event1Observer
{
    
    public function saving(Event1 $event)
    {   

        $slug = str_slug($event->title);
        $counter = 1;
        while(Event1::where('slug', $slug)->first())
        {
            $slug = $slug.'-'.$counter;
            $counter++;
        }

        $event->slug = $slug;
        //dd('aaaaa');
    }

    public function updated(Event1 $event)
    {
        $type = 'updated';
       foreach ($event->event1_members()->withTrashed()->get() as $member) {
            $users[] = $member->user;
        }

        if($users)
            Notification::send($users, new Event1Notification($event, $type));
        
    }
    
    public function deleted(Event1 $event)
    {
        $type = 'expired';
        if($event->isForceDeleting() === true) {
            $type = 'deleted';
        }

       foreach ($event->event1_members()->withTrashed()->get() as $member) {
            $users[] = $member->user;
        }
        $users[]=$event->user;

        if($users)
            Notification::send($users, new Event1Notification($event, $type));
    }
}