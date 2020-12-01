<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\StoreProduct;
use Faker\Generator as Faker;

$factory->define(StoreProduct::class, function (Faker $faker) {
    return [
        [
            'quantity' => 50,
        ]
    ];
});