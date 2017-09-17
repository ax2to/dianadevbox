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
    $dates = collect(['1H', '40M', '1H 30M', '2H 15M']);
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
