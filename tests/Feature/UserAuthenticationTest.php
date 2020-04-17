<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserAuthenticationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testRegisterUser()
    {
        $password = $this->faker->password;
        $postData = [
            'email'             => $this->faker->email,
            'password'          => $password,
            'confirm'           => $password,
            'first_name'        => $this->faker->firstName,
            'last_name'         => $this->faker->firstName,
            'type'              => 'user',
        ];
        $response = $this->postJson('/api/register', $postData);

        $response
            ->assertStatus(200)
            ->assertJson([
                "status" => "success",
                "data" => [ "user" => [
                    'email'             => $postData['email'],
                    'first_name'        => $postData['first_name'],
                    'last_name'         => $postData['last_name'],
                    'type'              => $postData['type'],
                    'status'            => 'approved',
                ]]]);
    }
}
