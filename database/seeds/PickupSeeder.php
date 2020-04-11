<?php

use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Pickup;

class PickupSeeder extends Seeder
{
    protected $users = 10;

    protected $ordersPerUser = 2;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 10 Users with 2 Orders each with Pickup for all Orders but no delivery assigned
        // A user is created for each Pickup

        factory(User::class, $this->users)->create()->each(function (User $user, $index) {
            echo "Creating Orders for User " . ($index + 1) . " / $this->users \n";

            $orders = factory(Order::class, $this->ordersPerUser)->create([
                'user_id' => $user->id
            ]);

            foreach ($orders as $newIndex => $order) {
                $pickup = factory(Pickup::class)->create([
                    'order_id' => $order->id
                ]);

                factory(Status::class)->create([
                    'order_id'    => $order->id,
                    'pickup_id'   => $pickup->id,
                    'delivery_id' => null,
                    'status'      => 'order_pickup_accepted'
                ]);

                echo ($newIndex + 1) . " / $this->ordersPerUser \n";
            }

            echo "---------- \n";
        });
    }
}
