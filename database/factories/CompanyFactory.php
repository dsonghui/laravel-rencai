<?php

use Faker\Generator as Faker;

$factory->define(\App\Company::class, function (Faker $faker) {
    return [
        'user_id'   => 0,
        'name'      => $faker->unique()->name,
        'shortname' => $faker->unique()->name,
    ];
});
