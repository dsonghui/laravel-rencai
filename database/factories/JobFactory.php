<?php

use Faker\Generator as Faker;

$factory->define(\App\Job::class, function (Faker $faker) {
    return [
        'company_id'  => 0,
        'title'       => $faker->title,
        'desc'        => $faker->title,
        'position'    => $faker->name,
        'job_address' => $this->faker->address,
        'job_salary'  => '面议',
    ];
});
