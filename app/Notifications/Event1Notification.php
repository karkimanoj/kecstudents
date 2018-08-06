<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage; //for setting up brodacating notifications
use App\Event1;
use Auth;

class Event1Notification extends Notification implements ShouldQueue
{
    use Queueable;
    public $event;
    public $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Event1 $event, $type)
    {
        $this->event =  $event;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    
    {   
        switch ($this->type) 
        {
            case 'updated':
                $line = Auth::user()->name.' ['.Auth::user()->roll_no.']  updated the event '.$this->event->title.' which you are associated  at '.$this->event->updated_at;
                $url = route('user.events.show', $this->event->id);
                break;
             case 'deleted':
                $line = Auth::user()->name.' ['.Auth::user()->roll_no.']deleted the event '.$this->event->title.' which you are associated  at '.now();
                $url = route('events.index');
                break;
             case 'expired':
                $line = 'Event '.$this->event->title.' which you are associated  has ended ';
                $url = route('user.events.show', $this->event->id);
                break;
            case 'invite':
                $line = Auth::user()->name.' invited you to his Event '.$this->event->title;
                $url = route('user.events.show', $this->event->id);
                break;         
        }
       

        return (new MailMessage)
                    ->subject('Event Notification')
                    ->greeting('Hello '.$notifiable->name)
                    ->line($line)
                    ->action('Go To Page', $url)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {   
        switch ($this->type) 
        {
            case 'updated':
                $message = '<label>'.Auth::user()->name.' ['.Auth::user()->roll_no.'] </label> updated the event <label>'.$this->event->title.'</label>';
                $url = route('user.events.show', $this->event->id);
                break;
            case 'deleted':
                $message = '<label>'.Auth::user()->name.' ['.Auth::user()->roll_no.'] </label> deleted the event <label>'.$this->event->title.'</label>';
                $url = route('events.index');
                break;
            case 'expired':
                $message = '<label>'.$this->event->title.'</label> which you are associated  has ended ';
                $url = route('user.events.show', $this->event->id);
                break;
            case 'invite':
                $message = '<label>'.Auth::user()->name.'</label> invited you to his Event '.$this->event->title;
                $url = route('user.events.show', $this->event->id);
                break;        
        }

        return [
            'message' => $message,
            'url' => $url
        ];
    }
}
