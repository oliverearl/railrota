<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\OperationShift;
use Faker\Generator as Faker;

$factory->define(OperationShift::class, function (Faker $faker) {
    return [
        'operation_id' => function() {
            return factory(App\Operation::class)->create()->id;
        },
        'role_type_id' => function() {
            return factory(App\RoleType::class)->create()->id;
        },
        'role_competency_id' => function() {
            return factory(App\RoleCompetency::class)->create()->id;
        },
        'notes' => $faker->realText(),
    ];
});
