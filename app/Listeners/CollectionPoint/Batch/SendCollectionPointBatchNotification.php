<?php

namespace App\Listeners\CollectionPoint\Batch;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\CollectionPoint\OrdersToday;
use App\Events\CollectionPoint\Batch\Created as CollectionPointBatchCreated;

class SendCollectionPointBatchNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Handle the event.
     *
     * @param CollectionPointBatchCreated $event
     *
     * @return void
     */
    public function handle(CollectionPointBatchCreated $event)
    {
        foreach ($event->collectionPoint->collectionPointUsers as $collectionPointUser) {
            $collectionPointUser->user->notify(new OrdersToday($event->batch, $event->collectionPoint));
        }
    }
}
