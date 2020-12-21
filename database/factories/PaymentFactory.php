<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Payment;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'total_customer' => $faker->randomElement([100000,50000,20000,10000,5000,1000,500,200,100,50]),
        'total_purchase' => $faker->randomElement([100000,50000,20000,10000,5000,1000,500,200,100,50]),
    ];
});
