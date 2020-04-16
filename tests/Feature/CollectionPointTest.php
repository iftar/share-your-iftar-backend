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
}
