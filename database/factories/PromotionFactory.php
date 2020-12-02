<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Promotion;
use Faker\Generator as Faker;

$factory->define(Promotion::class, function (Faker $faker) {
    return [
        'title' => 'best promotion ever',
        'description' => 'best promotion ever',
        'image' => ''
    ];
});
