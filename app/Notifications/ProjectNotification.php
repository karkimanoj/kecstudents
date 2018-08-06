<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage; //for setting up brodacating notifications
use App\Project;
use Auth;

class ProjectNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $project;
    public $type;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Project $project, $type)
    {
        $this->project = $project;
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
         switch ($this->type) 
        {
            case 'updated':
                $line = '<label>'.Auth::user()->name.' ['.Auth::user()->roll_no.'] </label> updated your Project <label>'.$this->project->name.'</label>';
                $url = route('user.projects.show', $this->project->id);
                break;
            case 'deleted':
                $line = '<label>'.Auth::user()->name.' ['.Auth::user()->roll_no.'] </label> deleted your Project <label>'.$this->project->name.'</label>';
                $url = route('projects.index');
                break;
            case 'created':
                $line = '<label>'.Auth::user()->name.' ['.Auth::user()->roll_no.'] </label> added you as member of Project <label>'.$this->project->name.'</label> ';
                $url = route('user.projects.show', $this->project->id);
                break;        
        }
         return (new MailMessage)
                    ->subject('Project Notification')
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
                $message = '<label>'.Auth::user()->name.' ['.Auth::user()->roll_no.'] </label> updated your Project <label>'.$this->project->name.'</label>';
                $url = route('user.projects.show', $this->project->id);
                break;
            case 'deleted':
                $message = '<label>'.Auth::user()->name.' ['.Auth::user()->roll_no.'] </label> deleted your Project <label>'.$this->project->name.'</label>';
                $url = route('projects.index');
                break;
            case 'created':
                $message = '<label>'.Auth::user()->name.' ['.Auth::user()->roll_no.'] </label> added you as member of Project <label>'.$this->project->name.'</label> ';
                $url = route('user.projects.show', $this->project->id);
                break;        
        }

        return [
            'message' => $message,
            'url' => $url
        ];
    }
}
