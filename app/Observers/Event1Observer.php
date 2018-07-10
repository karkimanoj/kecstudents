<?php

namespace App\Observers;

use App\Event1;

class Event1Observer
{
    /**
     * Listen to the User created event.
     *
     * @param  \App\User  $user
     * @return void
     */
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

    /**
     * Listen to the User deleting event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleting(Event1 $event)
    {
        //
    }
}