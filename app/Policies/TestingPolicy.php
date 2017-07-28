<?php

namespace App\Policies;

use App\User;
use App\IssueModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the issueModel.
     *
     * @param  \App\User  $user
     * @param  \App\IssueModel  $issueModel
     * @return mixed
     */
    public function view(User $user, IssueModel $issueModel)
    {
        //
    }

    /**
     * Determine whether the user can create issueModels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the issueModel.
     *
     * @param  \App\User  $user
     * @param  \App\IssueModel  $issueModel
     * @return mixed
     */
    public function update(User $user, IssueModel $issueModel)
    {
        //
    }

    /**
     * Determine whether the user can delete the issueModel.
     *
     * @param  \App\User  $user
     * @param  \App\IssueModel  $issueModel
     * @return mixed
     */
    public function delete(User $user, IssueModel $issueModel)
    {
        //
    }
}
