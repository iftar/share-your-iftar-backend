<?php

namespace App\Console\Commands\ScheduledEmails;

use App\Models\Charity;
use Illuminate\Console\Command;
use App\Services\All\SmsService;
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
        $this->smsService   = new SmsService();
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

            $this->sendSmsMessage($charity, $orders);
            $charity->notifyAllUsers(new OrdersToday($batch, $charity, $csv));
        }
    }

    public function sendSmsMessage($charity, $orders)
    {
        $numbers = [];
        foreach ($charity->charityUsers as $charityUser) {
            if (! empty($charityUser->user->phone_number)) {
                $numbers[] = $charityUser->user->phone_number;
            }
        }

        $order_count = $orders->count();
        $name = $charity->name;
        $message = join("\n",[
            "Salaam $name,",
            "",
            "You have $order_count order(s) to collect and deliver today.",
            "",
            "ShareIftar Team"
        ]);

        if (!count($numbers)) return false;
        else return $this->smsService->sendMessage($numbers, $message);
    }
}
