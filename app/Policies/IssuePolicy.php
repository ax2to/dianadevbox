<?php

namespace App\Policies;

use App\Models\IssueModel;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IssuePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the issue.
     *
     * @param User $user
     * @param IssueModel $issue
     * @return mixed
     */
    public function view(User $user, IssueModel $issue)
    {

    }

    public function startProgress(User $user, IssueModel $issue)
    {
        if ($issue->assign_to == $user->id && ($issue->status_id == 1 || $issue->status_id == 2)) {
            return true;
        }

        return false;
    }

    public function stopProgress(User $user, IssueModel $issue)
    {
        if ($issue->assign_to == $user->id && $issue->status_id == 3) {
            return true;
        }

        return false;
    }

    public function resolve(User $user, IssueModel $issue)
    {
        $status = [1, 2, 3];
        return $issue->assign_to == $user->id && in_array($issue->status_id, $status);
    }

    public function reopen(User $user, IssueModel $issue)
    {
        $status = [4, 5];
        return $issue->assign_to == $user->id && in_array($issue->status_id, $status);
    }

    public function close(User $user, IssueModel $issue)
    {
        $status = [1, 2, 3, 4];
        return $issue->assign_to == $user->id && in_array($issue->status_id, $status);
    }
}
