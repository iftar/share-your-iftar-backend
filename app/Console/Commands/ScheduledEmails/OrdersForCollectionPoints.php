<?php

namespace App\Console\Commands\ScheduledEmails;

use App\Models\CollectionPoint;
use Illuminate\Console\Command;
use App\Services\All\SmsService;
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
        $this->smsService   = new SmsService();
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

            $this->sendSmsMessage($collectionPoint, $orders);
            $collectionPoint->notifyAllUsers(new OrdersToday($batch, $collectionPoint, $csv));
        }
    }

    public function sendSmsMessage($collectionPoint, $orders)
    {
        $numbers = [];
        foreach ($collectionPoint->collectionPointUsers as $collectionPointUser) {
            if (! empty($collectionPointUser->user->phone_number)) {
                $numbers[] = $collectionPointUser->user->phone_number;
            }
        }

        $meal_count = $orders->sum('quantity');
        $name = $collectionPoint->name;
        $message = join("\n",[
            "Salaam $name,",
            "",
            "You have $meal_count meals that will be collected today.",
            "",
            "Please check your inbox for further information regarding specific orders.",
            "",
            "If you have any issues please email us on info@shareiftar.org.",
            "",
            "ShareIftar Team"
        ]);

        if (!count($numbers)) return false;
        else return $this->smsService->sendMessage($numbers, $message);
    }
}
