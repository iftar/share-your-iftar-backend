<?php

use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
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
        // 10 Users with 2 Orders each (no pickups or deliveries)

        factory(User::class, $this->users)->create()->each(function (User $user, $index) {
            echo "Creating Orders for User " . ($index + 1) . " / $this->users \n";

            $order_types = ["collection", "delivery"];

            $orders = factory(Order::class, $this->ordersPerUser)->create([
                'user_id' => $user->id,
                'type' => $order_types[array_rand($order_types)]
            ]);

            echo "---------- \n";
        });
    }
}
