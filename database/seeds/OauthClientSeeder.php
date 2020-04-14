<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;

class OauthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Passport::client()->forceFill([
            'user_id'                => null,
            'name'                   => config('app.name') . ' Personal Access Client',
            'secret'                 => Str::random(40),
            'redirect'               => config('app.url'),
            'personal_access_client' => true,
            'password_client'        => false,
            'revoked'                => false,
        ])->save();

        Passport::client()->forceFill([
            'user_id'                => null,
            'name'                   => config('app.name') . ' Password Access Client',
            'secret'                 => Str::random(40),
            'redirect'               => config('app.url'),
            'personal_access_client' => false,
            'password_client'        => true,
            'revoked'                => false,
        ])->save();
    }
}
