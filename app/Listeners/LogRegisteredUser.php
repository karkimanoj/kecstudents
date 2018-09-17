<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Role;
use Notification;
use App\Notifications\UserCreatedNotification;
use Auth;

class LogRegisteredUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {   $event->user->tenant_identifier = session('tenant');
        $event->user->save();
        //$registered_user = User::where('roll_no', $event->user['roll_no'])->first();
        $role= Role::where('name', $event->role)->first();
        $event->user->roles()->sync($role->id, false);
        Notification::send($event->user, new UserCreatedNotification($event->user));

        Auth::logout();
        
    }
}
