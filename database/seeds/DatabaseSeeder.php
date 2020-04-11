<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(PickupSeeder::class);
        $this->call(DeliverySeeder::class);

        // 40 users
        /*
         * 5 Order_delivery_accepted
         * 5 Order_delivery_in_progress
         * 5 Order_delivery_picked_up
         */
    }
}
