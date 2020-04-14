<?php

use App\Models\Charity;
use Illuminate\Database\Seeder;

class CharitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Charity::class, 10)->create();
    }
}
