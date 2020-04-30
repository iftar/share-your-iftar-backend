<?php

namespace App\Console\Commands\ScheduledEmails;

use App\Models\Charity;
use Illuminate\Console\Command;
use App\Services\Charity\BatchService;
use App\Services\Charity\OrderService;
use App\Notifications\Charity\OrdersToday;
use App\Notifications\Charity\NoOrdersToday;

class DeliveryOrdersForCharities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:charities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Orders to be delivered by charities';

    protected $orderService;
    protected $batchService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->orderService = new OrderService();
        $this->batchService = new BatchService();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $charities = Charity::all();

        foreach ($charities as $charity) {
            $collectionPoints = $this->orderService->getOrdersToday($charity);

            $orders = collect();

            foreach ($collectionPoints as $collectionPoint) {
                $orders = $orders->merge($collectionPoint->orders);
            }

            if ($orders->count() == 0) {
                $charity->notifyAllUsers(new NoOrdersToday($charity));
                continue;
            }

            $batch = $this->batchService->createBatchWithOrders($charity, $orders);

            $csv = $this->batchService->generateCsv($batch);

            $charity->notifyAllUsers(new OrdersToday($batch, $charity, $csv));
        }
    }
}
