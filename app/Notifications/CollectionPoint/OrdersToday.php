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
    protected $csv;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Batch $batch, CollectionPoint $collectionPoint, $csv)
    {
        $this->batch           = $batch;
        $this->collectionPoint = $collectionPoint;
        $this->csv             = $csv;
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
        $orders = $this->batch->batchOrders->count() == 1
            ? $this->batch->batchOrders->count() . ' order'
            : $this->batch->batchOrders->count() . ' orders';

        $message = (new MailMessage)
            ->subject('Orders To Fulfil - ' . $this->batch->created_at->format('jS F Y'))
            ->greeting('Hi, ' . $notifiable->full_name)
            ->line('You have ' . $orders . ' to fulfil today.');

        $this->addCollectionPointTimeSlotsSummary($message);

        $message->line('Please find a CSV attached with a list of orders and meals per order.')
                ->line(new HtmlString('If you have any issues please reply to this email or email us at <a href="mailto:shareiftar@gmail.com">shareiftar@gmail.com</a>'))
                ->salutation(new HtmlString('Kind Regards,<br>Share Iftar Team'))
                ->attachData($this->csv, $this->getCsvFileName());

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

    protected function getCsvFileName()
    {
        return now()->format('Y-m-d') . "_collection-point_" . $this->batch->collectionPoint->id . "_batch_" . $this->batch->id . ".csv";
    }

    protected function addCollectionPointTimeSlotsSummary(MailMessage $message)
    {
        $collectionPointTimeSlots = [
            'user_pickup'    => [],
            'charity_pickup' => [],
        ];

        foreach ($this->batch->batchOrders as $batchOrder) {
            $type = $batchOrder->order->collectionPointTimeslot->type;
            $key  = $batchOrder->order->collectionPointTimeslot->start_time . '-' . $batchOrder->order->collectionPointTimeslot->end_time;

            if (array_key_exists($key, $collectionPointTimeSlots[$type])) {

                $collectionPointTimeSlots[$type][$key] = (int) $collectionPointTimeSlots[$type][$key] + 1;
                continue;
            }

            $collectionPointTimeSlots[$type][$key] = 1;
        }

        if (count($collectionPointTimeSlots['user_pickup']) > 0) {
            $message->line('Orders for pickup:');
        }

        foreach ($collectionPointTimeSlots['user_pickup'] as $collectionPointTimeSlot => $numberOfOrders) {
            $orders = $numberOfOrders == 1
                ? $numberOfOrders . ' order'
                : $numberOfOrders . ' orders';

            $message->line($collectionPointTimeSlot . ' - ' . $orders);
        }

        if (count($collectionPointTimeSlots['charity_pickup']) > 0) {
            $message->line('Orders for delivery (picked up by charity):');
        }

        foreach ($collectionPointTimeSlots['charity_pickup'] as $collectionPointTimeSlot => $numberOfOrders) {
            $orders = $numberOfOrders == 1
                ? $numberOfOrders . ' order'
                : $numberOfOrders . ' orders';

            $message->line($collectionPointTimeSlot . ' - ' . $orders);
        }
    }
}
