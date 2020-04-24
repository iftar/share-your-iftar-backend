<?php

namespace App\Console\Commands\ScheduledEmails;

use App\Models\CollectionPoint;
use Illuminate\Console\Command;
use App\Services\CollectionPoint\BatchService;
use App\Services\CollectionPoint\OrderService;
use App\Events\CollectionPoint\Batch\Created as CollectionPointBatchCreated;

class OrdersForCollectionPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:collection-points';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Orders to be made by collection points';

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
        $collectionPoints = CollectionPoint::all();

        foreach ($collectionPoints as $collectionPoint) {
            $collectionPointTimeSlots = $this->orderService->getOrdersToday($collectionPoint);

            $orders = collect();

            foreach ($collectionPointTimeSlots as $collectionPointTimeSlot) {
                $orders = $orders->merge($collectionPointTimeSlot->orders);
            }

            if ($orders->count() == 0) {
                continue;
            }

            $batch = $this->batchService->createBatchWithOrders($collectionPoint, $orders);

            $this->batchService->generateCsv($batch);

            event(new CollectionPointBatchCreated($collectionPoint, $batch, $collectionPointTimeSlots));
        }
    }
}
