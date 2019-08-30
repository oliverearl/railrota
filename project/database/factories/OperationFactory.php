<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Operation;
use Faker\Generator as Faker;

$factory->define(Operation::class, function (Faker $faker) {
    return [
        'date' => $faker->date(),
        'is_running' => $faker->numberBetween(0, 1),
        'notes' => $faker->realText(),
    ];
});
