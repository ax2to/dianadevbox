<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ProjectModel::class, function (Faker $faker) {
    return [
    	'company_id' => function () {
    		return factory(App\User::class)->create()->id;
    	},
        'name' => $faker->company,
        'description' => $faker->paragraph,
    ];
});