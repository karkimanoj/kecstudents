<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage; //for setting up brodacating notifications
use App\Event1Member;
use Auth;

class Event1MemberNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $member;
    public $type;

    public function __construct(Event1Member $member, $type)
    {
        $this->member = $member;
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
    {   //dd($notifiable);
        switch ($this->type) 
        {
            case 'interested':
                $line =$this->member->user->name.' ['.$this->member->user->roll_no.']  is interested in the event '.($this->member)->event1->title.' which you are associated  at '.$this->member->created_at;
                break;
             case 'joined':
                $line = $this->member->user->name.' ['.$this->member->user->roll_no.'] joined the event '.($this->member)->event1->title.' which you are associated  at '.($this->member)->created_at;
                break;
             case 'unjoined':
                $line =$this->member->user->name.' unjoined the event '.($this->member)->event1->title;
                break;        
        }
       
        $url = route('user.events.show', ($this->member)->event1->id);
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
            case 'interested':
                $message = $this->member->user->name.' ['.$this->member->user->roll_no.']  is interested in the event '.($this->member)->event1->title;
                break;
             case 'joined':
                $message = $this->member->user->name.' ['.$this->member->user->roll_no.'] joined the event '.($this->member)->event1->title;
                break;
             case 'unjoined':
                $message = $this->member->user->name.' unjoined the event '.($this->member)->event1->title;
                break;        
        }

        $url = route('user.events.show', ($this->member)->event1->id);
        return [
            'message' => $message,
            'url' => $url
        ];
    }
}
