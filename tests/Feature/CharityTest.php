<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\CharityUser;

class CharityTest extends TestCase
{
    use RefreshDatabase;

    public function testGetCharityProfile()
    {
        $user = factory(CharityUser::class)->create()->user;
        $response = $this->actingAs($user, "api")->get('/api/charity');

        $response
            ->assertStatus(200)
            ->assertJson([
              'status' => 'success',
              'data'   => [ 'charity' => [
                  'id' => $user->charity()->id,
                  'name' => $user->charity()->name,
                  'registration_number' => $user->charity()->registration_number,
                  'max_delivery_capacity' => $user->charity()->max_delivery_capacity,
              ]]]);
    }

    public function testUpdateCharityName()
    {
        $user = factory(CharityUser::class)->create()->user;
        $response = $this->actingAs($user, "api")->postJson('/api/charity', [
          'name' => 'James foundation'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
              'status' => 'success',
              'data'   => [ 'charity' => [
                  'id' => $user->charity()->id,
                  'name' => 'James foundation',
                  'registration_number' => $user->charity()->registration_number,
                  'max_delivery_capacity' => $user->charity()->max_delivery_capacity,
              ]]]);
    }

    public function testUpdateCharityRegistrationNumber()
    {
        $user = factory(CharityUser::class)->create()->user;
        $response = $this->actingAs($user, "api")->postJson('/api/charity', [
          'registration_number' => '1321165464613'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
              'status' => 'success',
              'data'   => [ 'charity' => [
                  'id' => $user->charity()->id,
                  'name' => $user->charity()->name,
                  'registration_number' => '1321165464613',
                  'max_delivery_capacity' => $user->charity()->max_delivery_capacity,
              ]]]);
    }

    public function testUpdateCharityMaxDeliveryCapacity()
    {
        $user = factory(CharityUser::class)->create()->user;
        $response = $this->actingAs($user, "api")->postJson('/api/charity', [
          'max_delivery_capacity' => 132
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
              'status' => 'success',
              'data'   => [ 'charity' => [
                  'id' => $user->charity()->id,
                  'name' => $user->charity()->name,
                  'registration_number' => $user->charity()->registration_number,
                  'max_delivery_capacity' => 132,
              ]]]);
    }

    public function testUpdateCharityAll()
    {
        $user = factory(CharityUser::class)->create()->user;
        $response = $this->actingAs($user, "api")->postJson('/api/charity', [
          'name' => 'James foundation',
          'registration_number' => '1321165464613',
          'max_delivery_capacity' => 132,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
              'status' => 'success',
              'data'   => [ 'charity' => [
                  'id' => $user->charity()->id,
                  'name' => 'James foundation',
                  'registration_number' => '1321165464613',
                  'max_delivery_capacity' => 132,
              ]]]);
    }
}
