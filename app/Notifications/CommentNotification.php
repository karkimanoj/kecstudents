<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage; //for setting up brodacating notifications
use Auth;

class CommentNotification extends Notification //implements ShouldQueue
{
    use Queueable; 

  protected  $m_id;
  protected $type;
  protected $title;
    /**
     * Create a new notification instance.
     *
     * @return void
     */


    public function __construct($m_id, $type, $title)
    {
        $this->m_id =  $m_id;
        $this->type = $type;
        $this->title = $title;
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
       // return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        switch ($this->type) {
            case 'Event':
               $url = route('user.events.show', $this->m_id);
               $line = Auth::user()->name.' commented on the Event '.$this->title;
               break;
            case 'Project':
               $url = route('user.projects.show', $this->m_id);
               $line = Auth::user()->name.' commented on your Project '.$this->title;
               break;
            case 'Download':
               $url = route('user.downloads.show', $this->m_id);
               $line = Auth::user()->name.' commented on your Upload '.$this->title;
               break;   
            case 'Post':
               $url = route('user.posts.show', $this->m_id);
               $line = Auth::user()->name.' commented on your Post '.$this->title;
               break;   
           
        }
        
        return (new MailMessage)
                    ->subject($this->type.' Notification')
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
            case 'Event':
               $url = route('user.events.show', $this->m_id);
               $message = Auth::user()->name.' commented on the Event '.$this->title;
               break;
            case 'Project':
               $url = route('user.projects.show', $this->m_id);
               $message = Auth::user()->name.' commented on your Project '.$this->title;
               break;
            case 'Download':
               $url = route('user.downloads.show', $this->m_id);
               $message = Auth::user()->name.' commented on your Upload '.$this->title;
               break;   
            case 'Post':
               $url = route('user.posts.show', $this->m_id);
               $message = Auth::user()->name.' commented on your Post '.$this->title;
               break;  
        }
        return [
             'message' => $message,
            'url' => $url           
        ];
    }
}
