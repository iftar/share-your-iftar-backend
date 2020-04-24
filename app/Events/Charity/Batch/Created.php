<?php

namespace App\Events\Charity\Batch;

use App\Models\Batch;
use App\Models\Charity;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class Created
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Charity $charity
     */
    public $charity;

    /**
     * @var Batch $batch
     */
    public $batch;

    public $collectionPoints;

    /**
     * Create a new event instance.
     *
     * @param Charity $charity
     * @param Batch   $batch
     */
    public function __construct(Charity $charity, Batch $batch, $collectionPoints)
    {
        $this->charity          = $charity;
        $this->batch            = $batch;
        $this->collectionPoints = $collectionPoints;
    }
}
