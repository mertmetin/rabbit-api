<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

final class CheckoutsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_add_checkout()
    {
        $user = factory(\App\User::class)->create();
        $paymentMethod =  factory(\App\PaymentMethod::class)
            ->make(['user_id' => $user->id]);
        $response = $this->actingAs($user, 'api')->
            post('api/payment/methods', $paymentMethod->toArray());
        $address = factory(\App\UserAddress::class)->create(['user_id' => $user->id]);
        $product = factory(\App\Product::class)->create(['taxable' => true]);      
        $product2 = factory(\App\Product::class)->create(['taxable' => false]);       
        $store = factory(\App\Store::class)->create();    
        $inventory = factory(\App\Inventory::class)
            ->create(['store_id' => $store->id, 'product_id' => $product->id, 'quantity' => 1]);   
        $inventory = factory(\App\Inventory::class)
            ->create(['store_id' => $store->id, 'product_id' => $product2->id, 'quantity' => 1]);  
    //  dd($inventory);
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
    }

}