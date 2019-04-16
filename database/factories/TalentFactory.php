<?php

use Faker\Generator as Faker;

$factory->define(\App\Talent::class, function (Faker $faker) {
    return [
        'user_id' => 0,
        'name'    => $faker->name
    ];
});
