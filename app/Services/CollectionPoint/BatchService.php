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
                    $order->collectionPointTimeSlot->type === 'charity_pickup' ? 'delivery' : 'collection',
                    $order->user_id,
                    $order->first_name,
                    $order->last_name,
                    $order->email,
                    $order->phone,
                    $order->notes,
                    $order->address_line_1,
                    $order->address_line_2,
                    $order->city,
                    $order->county,
                    $order->post_code,
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
                'User ID',
                'User First Name',
                'User Last Name',
                'User Email',
                'User Phone Number',
                'User Notes',
                'Delivery Address Line 1',
                'Delivery Address Line 2',
                'Delivery County',
                'Delivery City',
                'Delivery Post Code',
            ]);
        } catch (CannotInsertRecord $e) {
        }
    }
}
