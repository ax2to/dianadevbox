<?php

namespace App\Policies;

use App\Models\ProjectModel;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the projectModel.
     *
     * @param  \App\User $user
     * @param  \App\Models\ProjectModel $projectModel
     * @return mixed
     */
    public function view(User $user, ProjectModel $project)
    {
        if ($user->role_id == User::ROLE_ADMIN) {
            return true;
        }
        $rs = $project->members()->where('user_id', $user->id)->get();
        return $rs->count();
    }

    /**
     * Determine whether the user can create projectModels.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the projectModel.
     *
     * @param  \App\User $user
     * @param  \App\Models\ProjectModel $projectModel
     * @return mixed
     */
    public function update(User $user, ProjectModel $projectModel)
    {
        return $user->role_id == 1 ? true : false;
    }

    /**
     * Determine whether the user can delete the projectModel.
     *
     * @param  \App\User $user
     * @param  \App\Models\ProjectModel $projectModel
     * @return mixed
     */
    public function delete(User $user, ProjectModel $projectModel)
    {
        //
    }

    public function addMember(User $user, ProjectModel $project)
    {
        return $user->role_id == 1 ? true : false;
    }

    public function removeMember(User $user, ProjectModel $project)
    {
        return $user->role_id == 1 ? true : false;
    }
}
