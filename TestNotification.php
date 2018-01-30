<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage; //for setting up brodacating notifications
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use Auth;

class TestNotification extends Notification 
{
    use Queueable;

    public $logged_user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $logged_user)
    {
        $this->logged_user=$logged_user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {   
        
        $url=url('/manage/users').'/'.$notifiable->id;
        return (new MailMessage)
                    ->line('Dear '.$notifiiable->name.' profile is changed by administrator. visit wesite to see changes')
                    ->action('Notification Action', $url)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {   
        $url=url('/manage/users').'/'.$notifiable->id;
        return [

            'url'=>$url,
            'message'=>$this->logged_user->name.' changed your user details'

        ];
    }

    public function toBroadcast($notifiable)
     {
        $url=url('/manage/users').'/'.$notifiable->id;
        return new BroadcastMessage([
            'url'=>$url,
            'message'=>$this->logged_user->name.' changed your user details'
        ]);
     }
}
