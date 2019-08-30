<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\RoleType;
use Faker\Generator as Faker;

$factory->define(RoleType::class, function (Faker $faker) {
    return [
        'name' => htmlspecialchars($faker->company),
        'description' => $faker->realText(),
    ];
});
