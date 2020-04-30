<?php

namespace App\Notifications\CollectionPoint;

use Illuminate\Bus\Queueable;
use App\Models\CollectionPoint;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NoOrdersToday extends Notification
{
    use Queueable;

    protected $collectionPoint;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CollectionPoint $collectionPoint)
    {
        $this->collectionPoint = $collectionPoint;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject('No Orders Today')
            ->greeting('Hi, ' . $notifiable->full_name)
            ->line('You have no orders to prepare today.')
            ->line(new HtmlString('If you have any issues please reply to this email or email us at <a href="mailto:shareiftar@gmail.com">shareiftar@gmail.com</a>'))
            ->salutation(new HtmlString('Kind Regards,<br>Share Iftar Team'));

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
