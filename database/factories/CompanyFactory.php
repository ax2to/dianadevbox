<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CompanyModel::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->paragraph,
    ];
});