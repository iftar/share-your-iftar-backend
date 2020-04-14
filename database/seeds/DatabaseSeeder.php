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
        $this->call(OauthClientSeeder::class);
    }
}
