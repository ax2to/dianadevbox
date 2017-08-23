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

use App\Models\CompanyModel;
use App\Models\Issue\PriorityModel;
use App\Models\Issue\ResolutionModel;
use App\Models\Issue\StatusModel;
use App\Models\Issue\TypeModel;
use App\Models\IssueModel;
use App\Models\ProjectModel;
use App\User;
use Carbon\Carbon;

$factory->define(App\Models\CompanyModel::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->paragraph,
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'company_id' => CompanyModel::all()->random()->id,
        'name' => $faker->name,
        'lastName' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'role_id' => 1
    ];
});

$factory->define(App\Models\ProjectModel::class, function (Faker\Generator $faker) {
    return [
        'company_id' => CompanyModel::all()->random()->id,
        'name' => $faker->company,
        'description' => $faker->paragraph
    ];
});

$factory->define(App\Models\IssueModel::class, function (Faker\Generator $faker) {
    return [
        'company_id' => CompanyModel::all()->random()->id,
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

$factory->define(App\Models\WorkLogModel::class, function (Faker\Generator $faker) {
    $dates = collect(['P0Y0M0DT1H0M0S', 'P0Y0M0DT0H40M20S', 'P0Y0M0DT3H0M0S', 'P0Y0M0DT2H30M10S']);
    $date = Carbon::now()->subDay(rand(1, 14));
    return [
        'company_id' => CompanyModel::all()->random()->id,
        'user_id' => User::all()->random()->id,
        'issue_id' => IssueModel::all()->random()->id,
        'worked' => $dates->random(),
        'date' => $date,
        'description' => $faker->paragraph,
        'in_progress' => false,
    ];
});
