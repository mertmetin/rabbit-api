<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

final class StoreProductsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_store_categories()
    {
        $user = factory(\App\User::class)->create();
        $product = factory(\App\StoreProduct::class)->create();
        $storeId = $product->store_id;
        $response = $this->actingAs($user, 'api')
            ->get("api/stores/$storeId/categories");
        $response->assertStatus(200);
    }

    // public function test_get_store_products()
    // {
    //     $user = factory(\App\User::class)->create();
    //     $product = factory(\App\StoreProduct::class)->create();
    //     $storeId = $product->store_id;
    //     $categoryId 
    //     $response = $this->actingAs($user, 'api')
    //         ->get("api/stores/$storeId/products?category");
    //     dd($response);
    //     $response->assertStatus(200);
    // }
}