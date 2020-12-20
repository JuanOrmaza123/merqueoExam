<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CashFlow;
use Faker\Generator as Faker;

$factory->define(CashFlow::class, function (Faker $faker) {
    return [
        'denomination' => $faker->randomElement(['coin', 'bill']),
        'value' => $faker->randomNumber(1),
        'count' => $faker->randomNumber(1)
    ];
});
