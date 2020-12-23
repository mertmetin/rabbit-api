<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

final class OrdersTest extends TestCase
{
    use DatabaseTransactions;

    // public function test_get_orders()
    // {
    //     $user = factory(\App\User::class)->create();
    //     $store = factory(\App\Store::class)->create();        
    //     $order = factory(\App\Order::class)
    //         ->create(['user_id' => $user->id, 'store_id' => $store->id]);
    //     $response = $this->actingAs($user, 'api')
    //         ->get("api/orders");
    //     $content = json_decode($response->getContent());
    //     $response->assertStatus(200); 
    //     $this->assertNotNull($content);
    // }

    // public function test_get_order()
    // {
    //     $user = factory(\App\User::class)->create();
    //     $store = factory(\App\Store::class)->create();        
    //     $order = factory(\App\Order::class)
    //         ->create(['user_id' => $user->id, 'store_id' => $store->id]);
    //     $order->store_id = $store->id;
    //     $orderId = $order->id;
    //     $response = $this->actingAs($user, 'api')
    //         ->get("api/orders/$orderId");
    //     $content = json_decode($response->getContent());
    //     $response->assertStatus(200); 
    //     $this->assertEquals($user->id, $content->user_id);
    // }

    public function test_add_orders()
    {   
        $user = factory(\App\User::class)->create();
        $paymentMethod =  factory(\App\PaymentMethod::class)
            ->make(['user_id' => $user->id]);
        $response = $this->actingAs($user, 'api')->
            post('api/payment/methods', $paymentMethod->toArray());
        $address = factory(\App\UserAddress::class)->create(['user_id' => $user->id, 'address_type' => 1]);
        $product = factory(\App\Product::class)->create(['taxable' => true]);      
        $product2 = factory(\App\Product::class)->create(['taxable' => false]);       
        $store = factory(\App\Store::class)->create();   
        $inventory = factory(\App\Inventory::class)
            ->create(['store_id' => $store->id, 'product_id' => $product->id, 'quantity' => 1]);   
        $inventory = factory(\App\Inventory::class)
            ->create(['store_id' => $store->id, 'product_id' => $product2->id, 'quantity' => 1]);  
        $data = [
            'user_id' => $user->id,
            'store_id' =>  $store->id,
            'user_address_id' => $address->id,
            'payment_method_id' => $response->getContent(),
            'line_items' => [
                [
                    'id' => $product->id,
                    'taxable' => $product->taxable,
                    'quantity' => 1
                ],
                [
                    'id' => $product2->id,
                    'taxable' => $product2->taxable,
                    'quantity' => 1
                ]
            ]
        ];     
        $response = $this->actingAs($user, 'api')
            ->post('api/checkouts/', $data);
        $response->assertStatus(201); 
        $result = json_decode($response->getContent(), true)[0];
        $data['checkout_id'] = $result['id'];
        $response = $this->actingAs($user, 'api')
            ->post('api/orders/', $data);
        $response->assertStatus(201); 
    }

    // public function test_add_orders()
    // {
    //     $user = factory(\App\User::class)->create();
    //     $paymentMethod =  factory(\App\PaymentMethod::class)
    //         ->make(['user_id' => $user->id]);
    //     $response = $this->actingAs($user, 'api')->
    //         post('api/payment/methods', $paymentMethod->toArray());
    //     $product = factory(\App\Product::class)->create();      
    //     $product2 = factory(\App\Product::class)->create();       
    //     $store = factory(\App\Store::class)->create();        
    //     $order = factory(\App\Order::class)->make();
    //     $order->store_id = $store->id;
    //     $order->payment_method_id = $response->getContent();
    //     $order->line_items = [
    //         [
    //             'id' => $product->id,
    //             'quantity' => 5
    //         ],
    //         [
    //             'id' => $product2->id,
    //             'quantity' => 8
    //         ]
    //     ];
    //     $order->user_id = $user->id;
    //     $response = $this->actingAs($user, 'api')
    //         ->post('api/orders/', $order->toArray());
    //     $response->assertStatus(201); 
    // }

    // public function test_close_order()
    // {
    //     $user = factory(\App\User::class)->create();
    //     $store = factory(\App\Store::class)->create();    
    //     $product = factory(\App\Product::class)->create();       
    //     $order = factory(\App\Order::class)
    //         ->make();

    //     $order->user_id = $user->id;
    //     $order->store_id = $store->id;
    //     $order->line_items = [[
    //         'id' => $product->id,
    //         'quantity' => 5
    //     ]];
    //     $response = $this->actingAs($user, 'api')
    //         ->post('api/orders/', $order->toArray());
    //     $content = json_decode($response->getContent());
    //     $orderId = $content->order_id;
    //     $response = $this->actingAs($user, 'api')
    //         ->put("api/orders/$orderId/close");
    //     $content = json_decode($response->getContent());
    //     $response->assertStatus(200); 
    //     $this->assertEquals($content->status, 'closed');
    // }

    // public function test_cancel_order()
    // {
    //     $user = factory(\App\User::class)->create();
    //     $store = factory(\App\Store::class)->create();        
    //     $product = factory(\App\Product::class)->create();       
    //     $order = factory(\App\Order::class)
    //         ->make();
    //     $order->user_id = $user->id;
    //     $order->store_id = $store->id;
    //     $order->line_items = [[
    //         'id' => $product->id,
    //         'quantity' => 5
    //     ]];
    //     $response = $this->actingAs($user, 'api')
    //         ->post('api/orders/', $order->toArray());
    //     $content = json_decode($response->getContent());
    //     $orderId = $content->order_id;        
    //     $response = $this->actingAs($user, 'api')
    //         ->put("api/orders/$orderId/cancel");
    //     $content = json_decode($response->getContent());
    //     $response->assertStatus(200); 
    //     $this->assertEquals($content->status, 'cancelled');
    // }

    // public function test_delete_order()
    // {
    //     $user = factory(\App\User::class)->create();
    //     $store = factory(\App\Store::class)->create();     
    //     $product = factory(\App\Product::class)->create();       
    //     $order = factory(\App\Order::class)
    //         ->make();
    //     $order->user_id = $user->id;
    //     $order->store_id = $store->id;
    //     $order->line_items = [[
    //         'id' => $product->id,
    //         'quantity' => 5
    //     ]];
    //     $response = $this->actingAs($user, 'api')
    //         ->post('api/orders/', $order->toArray());
    //     $content = json_decode($response->getContent());
    //     $orderId = $content->order_id;        
    //     $response = $this->actingAs($user, 'api')
    //         ->delete("api/orders/$orderId");
    //     $response->assertStatus(204); 
    // }
}