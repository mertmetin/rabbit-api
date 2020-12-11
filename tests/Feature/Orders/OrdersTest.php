<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

final class OrdersTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_orders()
    {
        $user = factory(\App\User::class)->create();
        $order = factory(\App\Order::class)
            ->create(['user_id' => $user->id]);
        $response = $this->actingAs($user, 'api')
            ->get("api/orders");
        $content = json_decode($response->getContent());
        $response->assertStatus(200); 
        $this->assertEquals($user->id, $content[0]->user_id);
    }

    public function test_get_order()
    {
        $user = factory(\App\User::class)->create();
        $order = factory(\App\Order::class)
            ->create(['user_id' => $user->id]);
        $orderId = $order->id;
        $response = $this->actingAs($user, 'api')
            ->get("api/orders/$orderId");
        $content = json_decode($response->getContent());
        $response->assertStatus(200); 
        $this->assertEquals($user->id, $content->user_id);
    }

    public function test_add_orders()
    {
        $user = factory(\App\User::class)->create();
        $order = factory(\App\Order::class)
            ->make();
        $order->user_id = $user->id;
        $response = $this->actingAs($user, 'api')
            ->post('api/orders/', $order->toArray());
        $response->assertStatus(201); 
    }

    public function test_update_store_inventory()
    {
        $user = factory(\App\User::class)->create();
        $order = factory(\App\Order::class)
            ->make();
        $order->user_id = $user->id;
        $response = $this->actingAs($user, 'api')
            ->post('api/orders/', $order->toArray());
        $orderId = json_decode($response->getContent());
        $response = $this->actingAs($user, 'api')
            ->put("api/orders/$orderId", ['status' => 'closed']);
        $content = json_decode($response->getContent());
        $response->assertStatus(200); 
        $this->assertEquals($content->status, 'closed');
    }

    public function test_delete_order()
    {
        $user = factory(\App\User::class)->create();
        $order = factory(\App\Order::class)
            ->make();
        $order->user_id = $user->id;
        $response = $this->actingAs($user, 'api')
            ->post('api/orders/', $order->toArray());
        $orderId = json_decode($response->getContent());
        $response = $this->actingAs($user, 'api')
            ->delete("api/orders/$orderId");
        $response->assertStatus(204); 
    }
}