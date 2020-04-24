<?php

namespace App\Services\CollectionPoint;

use App\Models\Batch;
use App\Models\CharityUser;
use App\Models\Order;
use League\Csv\Writer;
use App\Models\BatchOrder;
use App\Models\CollectionPoint;
use League\Csv\CannotInsertRecord;
use Illuminate\Support\Facades\File;

class BatchService
{
    public function create(CollectionPoint $collectionPoint)
    {
        return Batch::create([
            'collection_point_id' => $collectionPoint->id
        ]);
    }

    public function createBatchWithOrders(CollectionPoint $collectionPoint, $orders)
    {
        $batch = $this->create($collectionPoint);

        $this->addOrdersToBatch($batch, $orders);

        return $batch;
    }

    public function addOrdersToBatch(Batch $batch, $orders)
    {
        foreach ($orders as $order) {
            BatchOrder::create([
                'batch_id' => $batch->id,
                'order_id' => $order->id,
            ]);
        }
    }

    public function generateCsv(Batch $batch)
    {
        $csvDirPath = $this->getOrCreateCsvDirectory(storage_path("app/csv/collection-point/" . $batch->collectionPoint->id));
        $csvPath    = $csvDirPath . "/" . now()->format('Y-m-d') . "_batch_" . $batch->id . ".csv";

        $csv = Writer::createFromPath($csvPath, 'w+');

        $this->insertCsvHeader($csv);

        foreach ($batch->batchOrders as $batchOrder) {
            $order = Order::with('collectionPoint', 'collectionPointTimeSlot')
                          ->where('id', $batchOrder->order->id)
                          ->first();

            $pickupUserName = $order->collectionPointTimeSlot->type == 'user_pickup'
                ? $order
                : $order->collectionPoint->charity->first()->charityUsers->first()->user;

            try {
                $csv->insertOne([
                    $order->id,
                    $order->collectionPointTimeSlot->type,
                    $order->required_date->format('d/m/Y'),
                    $order->quantity,
                    $order->notes,
                    $order->collectionPointTimeSlot->start_time . ' - ' . $order->collectionPointTimeSlot->end_time,
                    $pickupUserName->first_name,
                    $pickupUserName->last_name,
                ]);
            } catch (CannotInsertRecord $e) {
                continue;
            }
        }

        $batch->update([
            'csv' => $csvPath
        ]);
    }

    public function getOrCreateCsvDirectory($dirPath)
    {
        if ( ! File::isDirectory($dirPath)) {
            File::makeDirectory($dirPath, 0777, true, true);
        }

        return $dirPath;
    }

    public function insertCsvHeader(Writer $csv)
    {
        try {
            $csv->insertOne([
                'Order ID',
                'Order Type',
                'Order Required Date',
                'Order Quantity',
                'Order Notes',
                'Pickup Time Slot',
                'Pickup User First Name',
                'Pickup User Last Name',
            ]);
        } catch (CannotInsertRecord $e) {
        }
    }
}
