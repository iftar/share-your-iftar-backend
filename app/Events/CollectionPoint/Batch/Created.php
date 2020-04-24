<?php

namespace App\Events\CollectionPoint\Batch;

use App\Models\Batch;
use App\Models\CollectionPoint;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class Created
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var CollectionPoint $collectionPoint
     */
    public $collectionPoint;

    /**
     * @var Batch $batch
     */
    public $batch;

    public $collectionPointTimeSlots;

    /**
     * Create a new event instance.
     *
     * @param CollectionPoint $collectionPoint
     * @param Batch           $batch
     */
    public function __construct(CollectionPoint $collectionPoint, Batch $batch, $collectionPointTimeSlots)
    {
        $this->collectionPoint          = $collectionPoint;
        $this->batch                    = $batch;
        $this->collectionPointTimeSlots = $collectionPointTimeSlots;
    }
}
