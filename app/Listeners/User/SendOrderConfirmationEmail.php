<?php

namespace App\Listeners\User;

use App\Events\Order\Created;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\User\PickupOrderConfirmation;
use App\Notifications\User\DeliveryOrderConfirmation;

class SendOrderConfirmationEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Handle the event.
     *
     * @param Created $event
     *
     * @return void
     */
    public function handle(Created $event)
    {
        $notification = $event->order->type == 'user_pickup'
            ? new PickupOrderConfirmation($event->order)
            : new DeliveryOrderConfirmation($event->order);

        $event->order->user->notify($notification);
    }
}
