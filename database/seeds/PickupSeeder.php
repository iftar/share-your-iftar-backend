<?php

use Illuminate\Database\Seeder;
use App\Models\Pickup;

class PickupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Pickup::class, 50)->create();
    }
}
