<?php

namespace App\Events\User;

use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class Registered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The authenticated user.
     *
     * @var Authenticatable | User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param Authenticatable | User $user
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
