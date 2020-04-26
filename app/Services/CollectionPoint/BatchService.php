<?php

namespace App\Services\CollectionPoint;

use App\Models\Batch;
use App\Models\Order;
use League\Csv\Writer;
use SplTempFileObject;
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
        $csv = Writer::createFromFileObject(new SplTempFileObject());

        $this->insertCsvHeader($csv);

        foreach ($batch->batchOrders as $batchOrder) {
            $order = Order::with('collectionPoint', 'collectionPointTimeSlot')
                          ->where('id', $batchOrder->order->id)
                          ->first();

            try {
                $csv->insertOne([
                    $order->id,
                    $order->required_date->format('d/m/Y'),
                    $order->collectionPointTimeSlot->start_time . ' - ' . $order->collectionPointTimeSlot->end_time,
                    $order->quantity,
                    $order->notes,
                    $order->collectionPointTimeSlot->type,
                    $order->collectionPointTimeSlot->type == 'charity_pickup' ? $order->collectionPoint->charity->first()->name : '',
                    $order->collectionPointTimeSlot->type == 'user_pickup' ? $order->first_name : '',
                    $order->collectionPointTimeSlot->type == 'user_pickup' ? $order->last_name : '',
                ]);
            } catch (CannotInsertRecord $e) {
                continue;
            }
        }

        return $csv;
    }

    public function insertCsvHeader(Writer $csv)
    {
        try {
            $csv->insertOne([
                'Order ID',
                'Order Required Date',
                'Pickup Time Slot',
                'Order Quantity',
                'Order Notes',
                'Order Type',
                'Pickup Charity Name',
                'Pickup User First Name',
                'Pickup User Last Name',
            ]);
        } catch (CannotInsertRecord $e) {
        }
    }
}
