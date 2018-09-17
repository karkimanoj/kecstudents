<?php

namespace App\Observers;

use Illuminate\Support\Collection;
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
         $users = new Collection;
       foreach ($event->event1_members()->withTrashed()->get() as $member) {
           
            $users->push($member->user);
        }

        if(count($users))
            Notification::send($users->unique(), new Event1Notification($event, $type));
        
    }
    
    public function deleted(Event1 $event)
    {
        $type = 'expired';
        if($event->isForceDeleting() === true) {
            $type = 'deleted';
        }
         $users = new Collection;
       foreach ($event->event1_members()->withTrashed()->get() as $member) {
            $users->push($member->user);
        }
       
        $users->push($event->user);

        if(count($users))
            Notification::send($users->unique(), new Event1Notification($event, $type));

    }
}