<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Kreait\Firebase\Messaging\Notification ;
use Kreait\Laravel\Firebase\Facades\FirebaseMessaging;

class PushNotification 
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function toFcm($notifiable)
    {
        return (new Notification())
            ->title('New Notification')
            ->body('Hello, this is a test notification from Laravel and Firebase!')
            ->image('https://example.com/image.jpg');
    }

    /**
     * Get the mail representation of the notification.
     */
}
