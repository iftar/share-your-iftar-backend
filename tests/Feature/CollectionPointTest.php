<?php

namespace Tests\Feature;

use App\Models\CollectionPointUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CollectionPointTest extends TestCase
{
    use RefreshDatabase;

    public function testGetCollectionPointProfile()
    {
        $user = factory(CollectionPointUser::class)->create()->user;
        $response = $this->actingAs($user, "api")->get('/api/collection-point/profile');

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data'   => [ 'collection_point' => [
                    'id' => $user->collectionPoint()->id,
                    'name' => $user->collectionPoint()->name,
                    'address_line_1' => $user->collectionPoint()->address_line_1,
                    'address_line_2' => $user->collectionPoint()->address_line_2,
                    'city' => $user->collectionPoint()->city,
                    'county' => $user->collectionPoint()->county,
                    'post_code' => $user->collectionPoint()->post_code,
                    'max_daily_capacity' => $user->collectionPoint()->max_daily_capacity,
                ]]]);
    }

    public function testUpdateCollectionPointName()
    {
        $user = factory(CollectionPointUser::class)->create()->user;
        $response = $this->actingAs($user, "api")->postJson('/api/collection-point/profile', [
          'name' => 'ELM'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data'   => [ 'collection_point' => [
                    'id' => $user->collectionPoint()->id,
                    'name' => 'ELM',
                    'address_line_1' => $user->collectionPoint()->address_line_1,
                    'address_line_2' => $user->collectionPoint()->address_line_2,
                    'city' => $user->collectionPoint()->city,
                    'county' => $user->collectionPoint()->county,
                    'post_code' => $user->collectionPoint()->post_code,
                    'max_daily_capacity' => $user->collectionPoint()->max_daily_capacity,
                ]]]);
    }

    public function testUpdateCollectionPointAddress()
    {
        $user = factory(CollectionPointUser::class)->create()->user;
        $response = $this->actingAs($user, "api")->postJson('/api/collection-point/profile', [
            'address_line_1'    => 'Fake house',
            'address_line_2'    => '123 Fake Street',
            'city'              => 'Fake city',
            'county'            => 'Fake county',
            'post_code'         => 'F4 K3E',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data'   => [ 'collection_point' => [
                    'id' => $user->collectionPoint()->id,
                    'name' => $user->collectionPoint()->name,
                    'address_line_1'    => 'Fake house',
                    'address_line_2'    => '123 Fake Street',
                    'city'              => 'Fake city',
                    'county'            => 'Fake county',
                    'post_code'         => 'F4 K3E',
                    'max_daily_capacity' => $user->collectionPoint()->max_daily_capacity,
                ]]]);
    }

    public function testUpdateCollectionPointMaxDailyCapacity()
    {
        $user = factory(CollectionPointUser::class)->create()->user;
        $response = $this->actingAs($user, "api")->postJson('/api/collection-point/profile', [
          'max_daily_capacity' => 130
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data'   => [ 'collection_point' => [
                    'id' => $user->collectionPoint()->id,
                    'name' => $user->collectionPoint()->name,
                    'address_line_1' => $user->collectionPoint()->address_line_1,
                    'address_line_2' => $user->collectionPoint()->address_line_2,
                    'city' => $user->collectionPoint()->city,
                    'county' => $user->collectionPoint()->county,
                    'post_code' => $user->collectionPoint()->post_code,
                    'max_daily_capacity' => 130,
                ]]]);
    }

    public function testUpdateCollectionPointAll()
    {
        $user = factory(CollectionPointUser::class)->create()->user;
        $response = $this->actingAs($user, "api")->postJson('/api/collection-point/profile', [
            'name'              => 'Fake Collection point',
            'address_line_1'    => 'Fake house',
            'address_line_2'    => '123 Fake Street',
            'city'              => 'Fake city',
            'county'            => 'Fake county',
            'post_code'         => 'F4 K3E',
            'max_daily_capacity'=> 1310
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data'   => [ 'collection_point' => [
                    'id' => $user->collectionPoint()->id,
                    'name'              => 'Fake Collection point',
                    'address_line_1'    => 'Fake house',
                    'address_line_2'    => '123 Fake Street',
                    'city'              => 'Fake city',
                    'county'            => 'Fake county',
                    'post_code'         => 'F4 K3E',
                    'max_daily_capacity'=> 1310
                ]]]);
    }
}
