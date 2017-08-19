<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Issue\PriorityModel;
use App\Models\Issue\ResolutionModel;
use App\Models\Issue\StatusModel;
use App\Models\Issue\TypeModel;
use App\Models\ProjectModel;
use App\User;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'company_id' => '0',
        'name' => $faker->name,
        'lastName' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'role_id' => 1
    ];
});

$factory->define(App\Models\IssueModel::class, function (Faker\Generator $faker) {
    return [
        'project_id' => ProjectModel::all()->random()->id,
        'type_id' => TypeModel::all()->random()->id,
        'summary' => $faker->sentence,
        'description' => $faker->paragraph,
        'priority_id' => PriorityModel::all()->random()->id,
        'status_id' => StatusModel::all()->random()->id,
        'assign_to' => User::all()->random()->id,
        'reported_by' => User::all()->random()->id,
        'resolution_id' => ResolutionModel::all()->random()->id
    ];
});
