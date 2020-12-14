<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;
// use Bezhanov\Faker\Provider\Commerce as Faker;


$factory->define(Product::class, function () {
    return [
        'title' => 'Perrier',
        'description' => 'Perrier',
        'price' => 50,
        'category' => factory(\App\ProductCategory::class),
        'image' => ''
    ];
});
