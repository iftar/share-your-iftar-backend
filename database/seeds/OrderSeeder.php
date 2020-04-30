<?php

use App\Models\Batch;
use App\Models\Order;
use App\Models\Charity;
use App\Models\BatchOrder;
use App\Models\CharityUser;
use Illuminate\Database\Seeder;
use App\Models\CollectionPointUser;
use App\Models\CollectionPointTimeSlot;
use App\Models\CharityCollectionPoint;

class OrderSeeder extends Seeder
{
    protected $charities      = [];
    protected $numOfCharities = 10;

    protected $charityCollectionPoints      = [];
    protected $numOfCharityCollectionPoints = 1;

    protected $pickupTimeSlots   = [];
    protected $deliveryTimeSlots = [];

    protected $orders            = [];
    protected $ordersPerTimeSlot = 3;

    protected $pickupCollectionPointTimeSlots = [
        ['start' => '18:00', 'end' => '18:15', 'max' => 5],
        ['start' => '18:15', 'end' => '18:30', 'max' => 5],
        ['start' => '18:30', 'end' => '18:45', 'max' => 5],
        ['start' => '18:45', 'end' => '19:00', 'max' => 5],
        ['start' => '19:15', 'end' => '19:30', 'max' => 5],
        ['start' => '19:30', 'end' => '19:45', 'max' => 5],
        ['start' => '19:45', 'end' => '20:00', 'max' => 5],
    ];

    protected $deliveryCollectionPointTimeSlots = [
        ['start' => '19:00', 'end' => '19:15', 'max' => 5],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createCharities();
        $this->createUsersForCharities();

        $this->createCollectionPointsForCharities();
        $this->createUsersForCollectionPoints();

        $this->createCollectionPointTimeSlotsForCollectionPoints();
        $this->createOrdersForCollectionPointTimeSlots();
        // $this->createBatchesForOrders();
    }

    protected function output($message)
    {
        echo "$message\n";
    }

    protected function createCharities()
    {
        $this->output("Creating Charities...");

        factory(Charity::class, $this->numOfCharities)
            ->create()
            ->each(function ($charity) {
                $this->charities[] = $charity;
            });;
    }

    protected function createUsersForCharities()
    {
        $this->output("Creating Users For Charities...");

        foreach ($this->charities as $charity) {
            factory(CharityUser::class)->create([
                'charity_id' => $charity->id
            ]);
        }
    }

    protected function createCollectionPointsForCharities()
    {
        $this->output("Creating CollectionPoints For Charities...");

        foreach ($this->charities as $charity) {
            factory(CharityCollectionPoint::class, $this->numOfCharityCollectionPoints)->create([
                'charity_id' => $charity->id
            ])->each(function ($charityCollectionPoint) {
                $this->charityCollectionPoints[] = $charityCollectionPoint;
            });
        }
    }

    protected function createUsersForCollectionPoints()
    {
        $this->output("Creating Users For CollectionPoints...");

        foreach ($this->charityCollectionPoints as $charityCollectionPoint) {
            factory(CollectionPointUser::class)->create([
                'collection_point_id' => $charityCollectionPoint->collectionPoint->id,
            ]);
        }
    }

    protected function createCollectionPointTimeSlotsForCollectionPoints()
    {
        $this->output("Creating CollectionPointTimeSlots for CollectionPoints...");
        foreach ($this->charityCollectionPoints as $charityCollectionPoint) {
            foreach ($this->pickupCollectionPointTimeSlots as $timeSlot) {
                $this->pickupTimeSlots[] = factory(CollectionPointTimeSlot::class)->create([
                    'collection_point_id' => $charityCollectionPoint->collection_point_id,
                    'start_time'          => $timeSlot['start'],
                    'end_time'            => $timeSlot['end'],
                    'max_capacity'        => $timeSlot['max']
                ]);
            }

            foreach ($this->deliveryCollectionPointTimeSlots as $timeSlot) {
                $this->deliveryTimeSlots[] = factory(CollectionPointTimeSlot::class)->state('charity-pickup')->create([
                    'collection_point_id' => $charityCollectionPoint->collection_point_id,
                    'start_time'          => $timeSlot['start'],
                    'end_time'            => $timeSlot['end'],
                    'max_capacity'        => $timeSlot['max']
                ]);
            }
        }
    }

    protected function createOrdersForCollectionPointTimeSlots()
    {
        $this->output("Creating Orders for CollectionPointTimeSlots...");

        foreach ($this->pickupTimeSlots as $collectionPointTimeSlot) {
            factory(Order::class, $this->ordersPerTimeSlot)->create([
                'collection_point_id'           => $collectionPointTimeSlot->collectionPoint->id,
                'collection_point_time_slot_id' => $collectionPointTimeSlot->id,
            ])->each(function ($order) {
                $this->orders[] = $order;
            });
        }

        foreach ($this->deliveryTimeSlots as $collectionPointTimeSlot) {
            factory(Order::class, $this->ordersPerTimeSlot)->state('charity-pickup')->create([
                'collection_point_id'           => $collectionPointTimeSlot->collectionPoint->id,
                'collection_point_time_slot_id' => $collectionPointTimeSlot->id,
            ])->each(function ($order) {
                $this->orders[] = $order;
            });
        }
    }

    protected function createBatchesForOrders()
    {
        $this->output("Creating Batches for Orders...");

        foreach ($this->orders as $order) {
            $cutOff = $order->required_date->startOfDay()->hour(14);
            $batch  = Batch::where('created_at', $cutOff)->first();

            if ( ! $batch) {
                $batch = factory(Batch::class)->create([
                    'created_at' => $cutOff
                ]);
            }

            factory(BatchOrder::class)->create([
                'batch_id' => $batch->id,
                'order_id' => $order->id,
            ]);
        }
    }
}
