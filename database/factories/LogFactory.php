<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Log::class, function (Faker $faker) {
    return [
        'type' => 'load',
        'value' => 4000
    ];
});
