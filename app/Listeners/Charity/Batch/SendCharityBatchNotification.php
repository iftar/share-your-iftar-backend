<?php

namespace App\Listeners\Charity\Batch;

use Illuminate\Bus\Queueable;
use App\Notifications\Charity\OrdersToday;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Charity\Batch\Created as CharityBatchCreated;

class SendCharityBatchNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Handle the event.
     *
     * @param CharityBatchCreated $event
     *
     * @return void
     */
    public function handle(CharityBatchCreated $event)
    {
        foreach ($event->charity->charityUsers as $charityUser) {
            $charityUser->user->notify(new OrdersToday($event->batch, $event->charity, $event->collectionPoints));
        }
    }
}
