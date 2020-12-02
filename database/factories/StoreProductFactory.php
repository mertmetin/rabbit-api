<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\StoreProduct;
use Faker\Generator as Faker;

$factory->define(StoreProduct::class, function (Faker $faker) {
     return [
        'store_id' => factory(\App\Store::class),
        'product_id' => factory(\App\Product::class),
        'quantity' => 50

        // 'title' => 'asd',
        // 'description' => 'asd',
        // 'price' => 50,
        // 'category' => factory(\App\ProductCategory::class),
        // 'image' => ''
    ];
});