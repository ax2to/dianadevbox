<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\ContactModel::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'lastname' => $faker->lastName,
        'email1' => $faker->email
    ];
});
