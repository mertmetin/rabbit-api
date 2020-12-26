<?php
namespace Tests\Feature;

use App\User;
use App\Inventory;
use App\UserAddress;
use App\Product;
use App\Store;
use App\PaymentMethod;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

final class CheckoutsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_add_checkout()
    {
        $user = User::factory()->create();
        $paymentMethod =  PaymentMethod::factory()->make(['user_id' => $user->id]);
        $response = $this->actingAs($user, 'api')->
            post('api/payment/methods', $paymentMethod->toArray());
        $address = UserAddress::factory()->create(['user_id' => $user->id, 'address_type' => 1]);
        $product = Product::factory()->create(['taxable' => true]);      
        $product2 = Product::factory()->create(['taxable' => false]);       
        $store = Store::factory()->create();    
        $inventory = Inventory::factory()
            ->create(['store_id' => $store->id, 'product_id' => $product->id, 'quantity' => 1]);   
        $inventory = Inventory::factory()
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
    }

}