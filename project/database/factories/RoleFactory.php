<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'role_type_id' => function() {
            return factory(App\RoleType::class)->create()->id;
        },
        'role_competency_id' => function() {
            return factory(App\RoleCompetency::class)->create()->id;
        }
    ];
});
