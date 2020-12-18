<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UserAddress;
use Faker\Generator as Faker;

$factory->define(UserAddress::class, function (Faker $faker) {
    return [
        'description' => '8050 Heritage Road, Brampton, ON, Canada', 
        'main_text' => '8050 Heritage Road', 
        'secondary_text' => 'Brampton, ON, Canada', 
        'apt_suite_floor' => 3, 
        'business_or_building_name' => '', 
        'address_type' => 'home', 
        'place_id' => 'ChIJNS1qayJrK4gR3p5kAlXotSE',
        'lng' => '-79.790572',
        'lat' => '43.620396',
        'address_type' => 1
    ];
});
