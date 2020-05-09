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
        $message = (new MailMessage)
            ->subject('Meals To Prepare - ' . $this->batch->created_at->format('jS F Y'))
            ->greeting('Salaam ' . $notifiable->full_name . ",")
            ->line('You have ' . $this->getTotalMeals() . ' to prepare today.');

        $this->addCollectionPointTimeSlotsSummary($message);

        $message->line('Please find a CSV attached with a list of orders and meals per order.')
                ->line(new HtmlString('If you have any issues please reply to this email or email us at <a href="mailto:info@shareiftar.org">info@shareiftar.org</a>'))
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
        return now('Europe/London')->format('Y-m-d') . "_collection-point_" . $this->batch->collectionPoint->id . "_batch_" . $this->batch->id . ".csv";
    }

    protected function getTotalMeals()
    {
        $numOfMeals = 0;

        foreach ($this->batch->batchOrders as $batchOrder) {
            $numOfMeals += $batchOrder->order->quantity;
        }

        return $numOfMeals == 1
            ? '(' . $numOfMeals . ' meal)'
            : '(' . $numOfMeals . ' meals)';
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

                $collectionPointTimeSlots[$type][$key] = (int) $collectionPointTimeSlots[$type][$key] + $batchOrder->order->quantity;
                continue;
            }

            $collectionPointTimeSlots[$type][$key] = $batchOrder->order->quantity;
        }

        if (count($collectionPointTimeSlots['user_pickup']) > 0) {
            $message->line('Meals for collection:');
        }

        foreach ($collectionPointTimeSlots['user_pickup'] as $collectionPointTimeSlot => $numberOfMeals) {
            $meals = $numberOfMeals == 1
                ? $numberOfMeals . ' meal'
                : $numberOfMeals . ' meals';

            $message->line($collectionPointTimeSlot . ' - ' . $meals);
        }

        if (count($collectionPointTimeSlots['charity_pickup']) > 0) {
            $message->line('Meals for delivery:');
        }

        foreach ($collectionPointTimeSlots['charity_pickup'] as $collectionPointTimeSlot => $numberOfMeals) {
            $meals = $numberOfMeals == 1
                ? $numberOfMeals . ' meal'
                : $numberOfMeals . ' meals';

            $message->line($collectionPointTimeSlot . ' - ' . $meals);
        }
    }
}
