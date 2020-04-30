<?php

namespace App\Notifications\Charity;

use App\Models\Charity;
use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NoOrdersToday extends Notification
{
    use Queueable;

    protected $charity;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Charity $charity)
    {
        $this->charity = $charity;
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
            ->line('You have no meals to deliver today.')
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
