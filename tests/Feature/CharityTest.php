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
        $response = $this->actingAs($user, "api")->get('/api/charity/profile');
        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => $user->charity()->id,
                'name' => $user->charity()->name,
                'registration_number' => $user->charity()->registration_number,
                'max_delivery_capacity' => $user->charity()->max_delivery_capacity,
              ]);
    }
}
