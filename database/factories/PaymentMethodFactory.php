<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PaymentMethod;
use Faker\Generator as Faker;

$factory->define(PaymentMethod::class, function (Faker $faker) {
    return [
        'type' => 'card',
        'card' => [
            'number' => '4242424242424242',
            'exp_month' => 8,
            'exp_year' => 2023,
            'cvc' => '363'
        ]
    ];
});
