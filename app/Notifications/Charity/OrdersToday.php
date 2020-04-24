<?php

namespace App\Notifications\Charity;

use App\Models\Batch;
use App\Models\Charity;
use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrdersToday extends Notification
{
    use Queueable;

    protected $batch;
    protected $charity;
    protected $collectionPoints;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Batch $batch, Charity $charity, $collectionPoints)
    {
        $this->batch            = $batch;
        $this->charity          = $charity;
        $this->collectionPoints = $collectionPoints;
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
            ->subject('Orders To Deliver - ' . $this->batch->created_at->format('jS F Y'))
            ->greeting('Hi, ' . $notifiable->full_name)
            ->line('You have ' . $this->batch->batchOrders->count() . ' orders to deliver today.')
            ->line('Orders for delivery:');

        foreach ($this->collectionPoints as $collectionPoint) {
            $orders = $collectionPoint->orders->count() == 1 ? 'order' : 'orders';
            $message->line($collectionPoint->name . ' - ' . $collectionPoint->orders->count() . ' ' . $orders);
        }

        $message->line('Please find a CSV attached with a list of orders and meals per order.')
                ->line(new HtmlString('If you have any issues please reply to this email or email us at <a href="mailto:shareiftar@gmail.com">shareiftar@gmail.com</a>'))
                ->salutation(new HtmlString('Kind Regards,<br>Share Iftar Team'))
                ->attach($this->batch->csv);

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
