<?php

namespace App\Services\Charity;

use App\Models\Batch;
use App\Models\Order;
use SplTempFileObject;
use League\Csv\Writer;
use App\Models\Charity;
use App\Models\BatchOrder;
use League\Csv\CannotInsertRecord;

class BatchService
{
    public function create(Charity $charity)
    {
        return Batch::create([
            'charity_id' => $charity->id
        ]);
    }

    public function createBatchWithOrders(Charity $charity, $orders)
    {
        $batch = $this->create($charity);

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
                    $order->quantity,
                    $order->collectionPointTimeSlot->start_time . ' - ' . $order->collectionPointTimeSlot->end_time,
                    $order->collectionPoint->name,
                    $order->collectionPoint->address_line_1,
                    $order->collectionPoint->address_line_2,
                    $order->collectionPoint->county,
                    $order->collectionPoint->city,
                    $order->collectionPoint->post_code,
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

            try {
                $csv->insertOne([]);
            } catch (CannotInsertRecord $e) {
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
                'Order Quantity',
                'Pickup Time Slot',
                'Pickup Name',
                'Pickup Address Line 1',
                'Pickup Address Line 2',
                'Pickup County',
                'Pickup City',
                'Pickup Post Code',
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
