<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;
// use Bezhanov\Faker\Provider\Commerce as Faker;


$factory->define(Product::class, function () {
    // $faker = \Faker\Factory::create();
    // $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));

    return [
        [
            'title' => 'asd',
            'description' => 'asd',
            'price' => 50
        ]
    ];
});
