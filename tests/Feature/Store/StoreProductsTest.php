<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

final class StoreProductsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_store_categories()
    {
        factory(\App\Store::class)->create();
        // dd($user);


        // $storeProducts = factory(\App\StoreProduct::class, 3)
        //    ->create()
        //    ->each(function ($storeProduct) {
        //         // $storeProduct->products()->save(factory(App\Product::class)->make());
        //     });
    }
}