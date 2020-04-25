<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ScheduledEmails\OrdersForCollectionPoints::class,
        Commands\ScheduledEmails\DeliveryOrdersForCharities::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $timezone = 'Europe/London';

        $schedule->command('orders:collection-points')
                 ->dailyAt('14:05')
                 ->timezone($timezone);

        $schedule->command('orders:charities')
                 ->dailyAt('14:05')
                 ->timezone($timezone);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
