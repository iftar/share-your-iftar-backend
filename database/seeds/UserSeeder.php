<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    protected $users = 10;

    protected $charityUsers = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 10 Users with no Orders
        factory(User::class, $this->users)->create();

        // 10 Charity Users with no Deliveries
        factory(User::class, $this->charityUsers)->state('charity')->create();
    }
}
