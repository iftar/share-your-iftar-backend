<?php

namespace App\Providers;

use App\Events\User\Updated as UserUpdated;
use App\Events\Order\Created as OrderCreated;
use App\Events\Order\Updated as OrderUpdated;
use App\Events\User\Registered as UserRegistered;
use App\Listeners\User\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserRegistered::class => [
            SendEmailVerificationNotification::class,
        ],

        UserUpdated::class => [

        ],

        OrderCreated::class => [

        ],

        OrderUpdated::class => [

        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
