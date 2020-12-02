<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Store;
use Faker\Generator as Faker;
use Grimzy\LaravelMysqlSpatial\Types\Point;

$factory->define(Store::class, function (Faker $faker) {
    return 
        [
            'name' => "Ottawa Center",
            'coordinates' => new Point(45.3929298, -75.7241912)
        ];
        // [
        //     'name' => "Ottawa East",
        //     'coordinates' => new Point(45.4409817, -75.6310358)
        // ]
    
});
