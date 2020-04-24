<?php

namespace App\Notifications\CollectionPoint;

use App\Models\Batch;
use Illuminate\Bus\Queueable;
use App\Models\CollectionPoint;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrdersToday extends Notification
{
    use Queueable;

    protected $batch;
    protected $collectionPoint;
    protected $collectionPointTimeSlots;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Batch $batch, CollectionPoint $collectionPoint, $collectionPointTimeSlots)
    {
        $this->batch                    = $batch;
        $this->collectionPoint          = $collectionPoint;
        $this->collectionPointTimeSlots = $collectionPointTimeSlots;
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
            ->subject('Orders To Fulfil - ' . $this->batch->created_at->format('jS F Y'))
            ->greeting('Hi, ' . $notifiable->full_name)
            ->line('You have ' . $this->batch->batchOrders->count() . ' orders to fulfil today.')
            ->line('Orders for pickup:');

        foreach ($this->collectionPointTimeSlots as $collectionPointTimeSlot) {
            if ($collectionPointTimeSlot->type == 'user_pickup') {
                $orders = $collectionPointTimeSlot->orders->count() == 1 ? 'order' : 'orders';
                $message->line($collectionPointTimeSlot->start_time . '-' . $collectionPointTimeSlot->end_time . ' - ' . $collectionPointTimeSlot->orders->count() . ' ' . $orders);
            }
        }

        $message->line('Orders for delivery (picked up by charity):');

        foreach ($this->collectionPointTimeSlots as $collectionPointTimeSlot) {
            if ($collectionPointTimeSlot->type == 'charity_pickup') {
                $orders = $collectionPointTimeSlot->orders->count() == 1 ? 'order' : 'orders';
                $message->line($collectionPointTimeSlot->start_time . '-' . $collectionPointTimeSlot->end_time . ' - ' . $collectionPointTimeSlot->orders->count() . ' ' . $orders);
            }
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
