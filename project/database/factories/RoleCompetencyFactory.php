<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\RoleCompetency;
use Faker\Generator as Faker;

$factory->define(RoleCompetency::class, function (Faker $faker) {
    return [
        'name' => htmlspecialchars($faker->name),
        'description' => $faker->realText(),
        'tier' => $faker->numberBetween(1, 10),
        'role_type_id' => function() {
            return factory(App\RoleType::class)->create()->id;
        },
    ];
});
