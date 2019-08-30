<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SteamLocomotive;
use Faker\Generator as Faker;

$factory->define(SteamLocomotive::class, function (Faker $faker) {
    return [
        'name' => htmlspecialchars($faker->company),
        'description' => $faker->realText(),
    ];
});
