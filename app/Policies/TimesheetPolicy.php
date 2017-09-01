<?php

namespace App\Policies;

use App\Timesheet;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimesheetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the timesheet.
     *
     * @param  \App\User $user
     * @param  \App\Timesheet $timesheet
     * @return mixed
     */
    public function view(User $user, Timesheet $timesheet)
    {
        //
    }

    /**
     * Determine whether the user can create timesheets.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the timesheet.
     *
     * @param  \App\User $user
     * @param  \App\Timesheet $timesheet
     * @return mixed
     */
    public function update(User $user, Timesheet $timesheet)
    {
        //
    }

    /**
     * Determine whether the user can delete the timesheet.
     *
     * @param  \App\User $user
     * @param  \App\Timesheet $timesheet
     * @return mixed
     */
    public function delete(User $user, Timesheet $timesheet)
    {
        //
    }

    public function changeUser(User $user)
    {
        return User::ROLE_ADMIN == $user->role_id;
    }
}
