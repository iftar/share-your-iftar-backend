<?php

namespace App\Providers;

use App\Events\User\Updated as UserUpdated;
use App\Events\Order\Created as OrderCreated;
use App\Events\Order\Updated as OrderUpdated;
use App\Events\Charity\Created as CharityCreated;
use App\Events\Charity\Updated as CharityUpdated;
use App\Events\User\Registered as UserRegistered;
use App\Listeners\LogNotification;
use Illuminate\Notifications\Events\NotificationSent;
use App\Events\User\PasswordReset as UserPasswordReset;
use App\Listeners\User\SendEmailVerificationNotification;
use App\Listeners\Charity\Batch\SendCharityBatchNotification;
use App\Events\Charity\Batch\Created as CharityBatchCreated;
use App\Events\CollectionPoint\Created as CollectionPointCreated;
use App\Events\CollectionPoint\Updated as CollectionPointUpdated;
use App\Events\CollectionPoint\Batch\Created as CollectionPointBatchCreated;
use App\Listeners\CollectionPoint\Batch\SendCollectionPointBatchNotification;
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

        OrderCreated::class => [],

        OrderUpdated::class => [],

        CharityBatchCreated::class => [
            SendCharityBatchNotification::class
        ],

        CollectionPointBatchCreated::class => [
            SendCollectionPointBatchNotification::class
        ],

        NotificationSent::class => [
            LogNotification::class
        ]
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
