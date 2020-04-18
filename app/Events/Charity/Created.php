<?php

namespace App\Events\Charity;

use App\Models\Charity;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Created
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Charity $charity
     */
    public $charity;

    /**
     * Create a new event instance.
     *
     * @param Charity $charity
     */
    public function __construct(Charity $charity)
    {
        $this->charity = $charity;
    }
}
