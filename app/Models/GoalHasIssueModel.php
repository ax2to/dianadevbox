<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GoalHasIssueModel extends Pivot
{
    protected $table = 'goals_has_members';
    protected $foreignKey = 'goal_id';
    protected $relatedKey = 'issue_id';
}
