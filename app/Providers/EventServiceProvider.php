<?php

namespace App\Providers;

use App\Events\User\Updated as UserUpdated;
use App\Events\Order\Created as OrderCreated;
use App\Events\Order\Updated as OrderUpdated;
use App\Events\Charity\Created as CharityCreated;
use App\Events\Charity\Updated as CharityUpdated;
use App\Events\User\Registered as UserRegistered;
use App\Listeners\User\SendOrderConfirmationEmail;
use App\Events\User\PasswordReset as UserPasswordReset;
use App\Listeners\User\SendEmailVerificationNotification;
use App\Events\CollectionPoint\Created as CollectionPointCreated;
use App\Events\CollectionPoint\Updated as CollectionPointUpdated;

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

        UserPasswordReset::class => [],

        UserUpdated::class => [],

        CharityCreated::class => [],

        CharityUpdated::class => [],

        CollectionPointCreated::class => [],

        CollectionPointUpdated::class => [],

        OrderCreated::class => [
            SendOrderConfirmationEmail::class
        ],

        OrderUpdated::class => [],
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
