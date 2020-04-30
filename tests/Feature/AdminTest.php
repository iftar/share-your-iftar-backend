<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function testGetTodaysOrders()
    {
        $user = factory(User::class)->state('admin')->create();
        $response = $this->actingAs($user, "api")->get('/api/admin/orders/today');

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data'   => [ 'orders' => [] ]]);
    }
}
