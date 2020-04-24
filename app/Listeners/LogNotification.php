<?php

namespace App\Listeners;

use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Events\NotificationSent;

class LogNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Handle the event.
     *
     * @param object $event
     *
     * @return void
     */
    public function handle(NotificationSent $event)
    {
        if ( ! config('notifications.log_notifications')) {
            return;
        }

        Notification::create([
            'user_id'    => $event->notifiable->id,
            'user_email' => $event->notifiable->email,
            'channel'    => $event->channel,
            'type'       => get_class($event->notification),
            'contents'   => $event->notification->toMail($event->notifiable)->render()->__toString()
        ]);
    }
}
