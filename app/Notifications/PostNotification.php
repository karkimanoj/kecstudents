<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage; //for setting up brodacating notifications
use App\Post;
use Auth;

class PostNotification extends Notification //implements ShouldQueue
{
    use Queueable;
 
    public $post;
    public $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Post $post, $data)
    {
        $this->post = $post;
        $this->data = $data;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {   //dd($this->post);
        return ['database', 'broadcast', 'mail'];  
         //return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {   

        $line = $this->data['owner'].' posted in Discussion and Forum ';
        //$url = route('user.posts.show', $this->post->slug);
        return (new MailMessage)
                    ->subject('Post Notification')
                    ->greeting('Hello '.$notifiable->name)
                    ->line($line)
                    ->action('Go To Page', $this->data['url'])
                    ->line('Thank you for using our application!'); 
/*
        $line = ' posted in Discussion Forum ';

        $url = route('user.posts.show', $this->post->slug);
        return (new MailMessage)
                    ->subject('Post Notification')
                    ->greeting('Hello '.$notifiable->name)
                    ->line($line)
                    ->action('Go To Page', $url)
                    ->line('Thank you for using our application!');

       
*/            
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {   
        $message =$this->data['owner'].' posted in Discussion and Forum ';
        //$url = route('user.posts.show', $this->post->slug);
        return [
            'message' => $message,
            'url' => $this->data['url']
        ];
         //$owner = (Auth::user())->toArray();
         /*
        $message =' posted in Discussion Forum ';
        $url = route('user.posts.show', $this->post->slug);
        return [
            'message' => $message,
            'url' => $url
        ];*/

        
    }
/*
    public function toBroadcast($notifiable)
     {
        $message =$this->data['owner'].' posted in Discussion and Forum ';
        //$url = route('user.posts.show', $this->post->slug);
        return [
            'message' => $message,
            'url' => $this->data['url']
        ];
     }*/
}
