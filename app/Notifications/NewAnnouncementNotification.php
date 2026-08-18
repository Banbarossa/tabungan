<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class NewAnnouncementNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected string $title, protected string $message, protected ?string $url='/' )
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [WebPushChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toWebPush(object $notifiable,$notification)
    {
        return (new WebPushMessage)
        ->title($this->title)
        ->icon('/images/icons/icon-192x192.png')
        ->body($this->message)
        ->action('View','view_action')
        ->data(['url'=>$this->url])
        ->options(['TTL'=>1000]);
    }

    // /**
    //  * Get the array representation of the notification.
    //  *
    //  * @return array<string, mixed>
    //  */
    // public function toArray(object $notifiable): array
    // {
    //     return [
    //         //
    //     ];
    // }
}
