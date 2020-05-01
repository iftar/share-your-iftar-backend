<?php

namespace App\Console\Commands\ScheduledEmails;

use App\Models\CollectionPoint;
use Illuminate\Console\Command;
use App\Notifications\SmsMessage;
use App\Services\CollectionPoint\BatchService;
use App\Services\CollectionPoint\OrderService;
use App\Notifications\CollectionPoint\OrdersToday;
use App\Notifications\CollectionPoint\NoOrdersToday;

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
                $collectionPoint->notifyAllUsers(new NoOrdersToday($collectionPoint));
                continue;
            }

            $batch = $this->batchService->createBatchWithOrders($collectionPoint, $orders);

            $csv = $this->batchService->generateCsv($batch);

            $smsMessage = $this->composeSmsMessage($collectionPoint, $orders);

            $collectionPoint->notifyAllUsers(new OrdersToday($batch, $collectionPoint, $csv));
            $collectionPoint->smsAllUsers($smsMessage);
        }
    }

    protected function composeSmsMessage($collectionPoint, $orders)
    {
        $name      = $collectionPoint->name;
        $mealCount = $orders->sum('quantity');

        $numOfMeals = $mealCount == 1
            ? $mealCount . ' meal'
            : $mealCount . ' meals';

        return (new SmsMessage())
            ->line("Salaam $name,")
            ->emptyLine()
            ->line("You have $numOfMeals to prepare today.")
            ->emptyLine()
            ->line("ShareIftar Team");
    }
}
