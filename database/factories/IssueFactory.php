<?php

use App\Models\CompanyModel;
use App\Models\ContactModel;
use App\Models\Issue\PriorityModel;
use App\Models\Issue\ResolutionModel;
use App\Models\Issue\StatusModel;
use App\Models\Issue\TypeModel;
use App\Models\ProjectModel;
use App\User;
use Faker\Generator as Faker;

$factory->define(App\Models\IssueModel::class, function (Faker $faker) {
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
        'resolution_id' => ResolutionModel::all()->random()->id,
        'contact_id' => ContactModel::all()->random()->id,
    ];
});