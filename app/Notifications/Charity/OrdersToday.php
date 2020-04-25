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
    protected $csv;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Batch $batch, Charity $charity, $csv)
    {
        $this->batch   = $batch;
        $this->charity = $charity;
        $this->csv     = $csv;
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
            ->subject('Orders To Deliver - ' . $this->batch->created_at->format('jS F Y'))
            ->greeting('Hi, ' . $notifiable->full_name)
            ->line('You have ' . $orders . ' to deliver today.')
            ->line('Orders for delivery:');

        $this->addCollectionPointsSummary($message);

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
        return now()->format('Y-m-d') . "_charity_" . $this->batch->charity->id . "_batch_" . $this->batch->id . ".csv";
    }

    protected function addCollectionPointsSummary(MailMessage $message)
    {
        $collectionPoints = [];

        foreach ($this->batch->batchOrders as $batchOrder) {
            $key = $batchOrder->order->collectionPoint->id;

            if (array_key_exists($key, $collectionPoints)) {

                $collectionPoints[$key] = [
                    'orders' => (int) $collectionPoints[$key]['orders'] + 1
                ];

                continue;
            }

            $collectionPoints[$key] = [
                'orders'    => 1,
                'name'      => $batchOrder->order->collectionPoint->name,
                'time_slot' => $batchOrder->order->collectionPointTimeslot->start_time . '-' . $batchOrder->order->collectionPointTimeslot->end_time
            ];
        }

        foreach ($collectionPoints as $collectionPoint) {
            $orders = $collectionPoint['orders'] == 1
                ? $collectionPoint['orders'] . ' order'
                : $collectionPoint['orders'] . ' orders';

            $message->line($collectionPoint['name'] . ' - ' . $collectionPoint['time_slot'] . ' - ' . $orders);
        }
    }
}
