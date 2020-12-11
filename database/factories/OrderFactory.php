<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'total' => '6.37',
        'total_tax' => '5.66',
        'status' => 'open'
    ];
});
