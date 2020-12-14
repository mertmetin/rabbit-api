<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Inventory;
use Faker\Generator as Faker;

$factory->define(Inventory::class, function (Faker $faker) {
     return [
        'store_id' => factory(\App\Store::class),
        'product_id' => factory(\App\Product::class),
        'quantity' => 50
    ];
});