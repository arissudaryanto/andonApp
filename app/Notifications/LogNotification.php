<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LogNotification extends Notification
{
    use Queueable;
    private $lineData;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($lineData)
    {
        $this->lineData = $lineData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'device_id' => $this->lineData['device_id'],
            'body' => $this->lineData['body'],
            'url'  => $this->lineData['url'],
        ];
    }
}
