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
        $store = factory(\App\Store::class)->create();        
        $order = factory(\App\Order::class)
            ->create(['user_id' => $user->id, 'store_id' => $store->id]);
        $response = $this->actingAs($user, 'api')
            ->get("api/orders");
        $content = json_decode($response->getContent());
        $response->assertStatus(200); 
        $this->assertNotNull($content);
    }

    public function test_get_order()
    {
        $user = factory(\App\User::class)->create();
        $store = factory(\App\Store::class)->create();        
        $order = factory(\App\Order::class)
            ->create(['user_id' => $user->id, 'store_id' => $store->id]);
        $order->store_id = $store->id;
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
        $product = factory(\App\Product::class)->create();       
        $store = factory(\App\Store::class)->create();        
        $order = factory(\App\Order::class)->make();
        $order->store_id = $store->id;
        $order->line_items = [[
            'id' => $product->id,
            'quantity' => 5
        ]];
        $order->user_id = $user->id;
        $response = $this->actingAs($user, 'api')
            ->post('api/orders/', $order->toArray());
        $response->assertStatus(201); 
    }

    public function test_close_order()
    {
        $user = factory(\App\User::class)->create();
        $store = factory(\App\Store::class)->create();    
        $product = factory(\App\Product::class)->create();       
        $order = factory(\App\Order::class)
            ->make();

        $order->user_id = $user->id;
        $order->store_id = $store->id;
        $order->line_items = [[
            'id' => $product->id,
            'quantity' => 5
        ]];
        $response = $this->actingAs($user, 'api')
            ->post('api/orders/', $order->toArray());
        $content = json_decode($response->getContent());
        $orderId = $content->order_id;
        $response = $this->actingAs($user, 'api')
            ->put("api/orders/$orderId/close");
        $content = json_decode($response->getContent());
        $response->assertStatus(200); 
        $this->assertEquals($content->status, 'closed');
    }

    public function test_cancel_order()
    {
        $user = factory(\App\User::class)->create();
        $store = factory(\App\Store::class)->create();        
        $product = factory(\App\Product::class)->create();       
        $order = factory(\App\Order::class)
            ->make();
        $order->user_id = $user->id;
        $order->store_id = $store->id;
        $order->line_items = [[
            'id' => $product->id,
            'quantity' => 5
        ]];
        $response = $this->actingAs($user, 'api')
            ->post('api/orders/', $order->toArray());
        $content = json_decode($response->getContent());
        $orderId = $content->order_id;        
        $response = $this->actingAs($user, 'api')
            ->put("api/orders/$orderId/cancel");
        $content = json_decode($response->getContent());
        $response->assertStatus(200); 
        $this->assertEquals($content->status, 'cancelled');
    }

    public function test_delete_order()
    {
        $user = factory(\App\User::class)->create();
        $store = factory(\App\Store::class)->create();     
        $product = factory(\App\Product::class)->create();       
        $order = factory(\App\Order::class)
            ->make();
        $order->user_id = $user->id;
        $order->store_id = $store->id;
        $order->line_items = [[
            'id' => $product->id,
            'quantity' => 5
        ]];
        $response = $this->actingAs($user, 'api')
            ->post('api/orders/', $order->toArray());
        $content = json_decode($response->getContent());
        $orderId = $content->order_id;        
        $response = $this->actingAs($user, 'api')
            ->delete("api/orders/$orderId");
        $response->assertStatus(204); 
    }
}