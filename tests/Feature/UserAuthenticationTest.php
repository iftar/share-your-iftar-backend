<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Passport\Passport;
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

    public function testRegisterCharityUser()
    {
        $password = $this->faker->password;
        $postData = [
            'email'             => $this->faker->email,
            'password'          => $password,
            'confirm'           => $password,
            'first_name'        => $this->faker->firstName,
            'last_name'         => $this->faker->firstName,
            'type'              => 'charity',
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

    public function testRegisterThenLoginWithoutVerifying()
    {
        // register
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

        // login
        $loginData = [
            "email" => $postData["email"],
            "password" => $postData["password"],
        ];
        $response = $this->postJson('/api/login', $loginData);

        $response
            ->assertStatus(401)
            ->assertJson([
                "status" => "error",
                "message" => "User has not verified email"
            ]);
    }

    public function testRegisterThenLoginAfterVerifying()
    {
        // register
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

        // user object
        $user = User::find($response["data"]["user"]["id"]);

        // verify
        $verified = $user->markEmailAsVerified();
        $this->assertTrue($verified);

        // create personal token
        // https://laravel.com/docs/7.x/passport#testing
        Passport::actingAs(
            $user, ["blahblah"]
        );

        // login
        $loginData = [
            "email" => $postData["email"],
            "password" => $postData["password"],
        ];
        $response = $this->postJson('/api/login', $loginData);


        $response
            ->assertStatus(200)
            ->assertJson([
                "status" => "success",
                "data" => []
            ]);
    }
}
