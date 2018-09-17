<?php

namespace App\Observers;

use App\User;
use Notification;
use App\Notifications\UserCreatedNotification;
use Auth;

class UserObserver
{
    
    

    public function created(User $user)
    {   /*
        Notification::send($user, new UserCreatedNotification($user));

        Auth::logout();
        */
    }
    
   
}