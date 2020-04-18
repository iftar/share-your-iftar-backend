<?php

namespace App\Events\CollectionPoint;

use App\Models\CollectionPoint;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Updated
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
