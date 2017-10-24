<?php

use App\Models\WorkflowModel;
use Faker\Generator as Faker;

$factory->define(WorkflowModel::class, function (Faker $faker) {
    return [
        'name' => $faker->title
    ];
});
