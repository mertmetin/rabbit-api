<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PaymentMethodTypes;
use Faker\Generator as Faker;

$factory->define(PaymentMethodTypes::class, function (Faker $faker) {
    return [
        'type' => 'card'
    ];
});
