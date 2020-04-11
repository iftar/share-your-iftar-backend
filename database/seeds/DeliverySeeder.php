<?php

use App\Models\Delivery;
use App\Models\Order;
use App\Models\Pickup;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;

class DeliverySeeder extends Seeder
{
    protected $users = 5;

    protected $statuses = [
        'order_delivery_accepted',
        'order_delivery_in_progress',
        'order_delivery_picked_up',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, $this->users)->create()->each(function (User $user, $index) {
            echo "Creating Orders for User " . ($index + 1) . " / $this->users \n";

            foreach ($this->statuses as $newIndex => $status) {
                $order = factory(Order::class)->create([
                    'user_id' => $user->id
                ]);

                $pickup = factory(Pickup::class)->create([
                    'order_id' => $order->id
                ]);

                $delivery = factory(Delivery::class)->create([
                    'user_id'   => factory(User::class)->state('charity')->create()->id,
                    'pickup_id' => $pickup->id,
                ]);

                factory(Status::class)->create([
                    'order_id'    => $order->id,
                    'pickup_id'   => $pickup->id,
                    'delivery_id' => $delivery->id,
                    'status'      => $status
                ]);

                echo ($newIndex + 1) . " / " . count($this->statuses) . "\n";
            }

            echo "---------- \n";
        });
    }
}
