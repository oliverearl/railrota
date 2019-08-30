<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PoweredLocomotive;
use Faker\Generator as Faker;

$factory->define(PoweredLocomotive::class, function (Faker $faker) {
    return [
        'name' => htmlspecialchars($faker->company),
        'description' => $faker->realText(),
    ];
});
