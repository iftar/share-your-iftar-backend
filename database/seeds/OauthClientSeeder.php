<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class OauthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name     = config('app.name');
        $redirect = config('app.url');

        Artisan::call('passport:keys --force');

        Artisan::call('passport:client --personal --name="' . $name . ' Personal Access Client" --redirect_uri="' . $redirect . '"');

        Artisan::call('passport:client --password --name="' . $name . ' Password Access Client" --redirect_uri="' . $redirect . '"');
    }
}
