<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage; //for setting up brodacating notifications
use App\Download;
use Auth;

class DownloadNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $download;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Download $download)
    {
        $this->download = $download;
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
        $line = Auth::user()->name.' uploaded '.$this->download->download_category->name.' '.$this->download->title;
        $url = route('user.downloads.show', $this->download->id);
        return (new MailMessage)
                    ->subject('Download Notification')
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
        $message = Auth::user()->name.' uploaded '.$this->download->download_category->name.' '.$this->download->title;
        $url = route('user.downloads.show', $this->download->id);
        return [
            'message' => $message,
            'url' => $url
        ];
    }
}
