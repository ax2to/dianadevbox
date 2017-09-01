<?php

namespace App\Providers;

use App\Models\ProjectModel;
use App\Policies\ProjectPolicy;
use App\Policies\TimesheetPolicy;
use App\Policies\UserPolicy;
use App\Timesheet;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        ProjectModel::class => ProjectPolicy::class,
        Timesheet::class => TimesheetPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
