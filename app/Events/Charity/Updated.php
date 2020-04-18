<?php

namespace App\Events\Charity;

use App\Models\Charity;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class Updated
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
