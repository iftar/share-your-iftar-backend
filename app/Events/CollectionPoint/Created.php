<?php

namespace App\Events\CollectionPoint;

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
     * Create a new event instance.
     *
     * @param CollectionPoint $collectionPoint
     */
    public function __construct(CollectionPoint $collectionPoint)
    {
        $this->collectionPoint = $collectionPoint;
    }
}
