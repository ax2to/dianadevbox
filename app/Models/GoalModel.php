<?php

namespace App\Models;

use App\DateInterval;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GoalModel
 * @package App\Models
 */
class GoalModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'goals';
    /**
     * @var array
     */
    protected $fillable = ['project_id', 'name', 'description', 'start_at', 'end_at'];
    /**
     * @var array
     */
    protected $dates = ['start_at', 'end_at'];

    public function project()
    {
        return $this->belongsTo(ProjectModel::class);
    }

    public function overallTimeRemaining()
    {
        return $this->overallTimeEstimated() - $this->overallTimeSpent();
    }

    public function overallTimeEstimated()
    {
        $i = new DateInterval(0);
        foreach ($this->issues as $issue) {
            $i->add($issue->estimated);
        }

        $hours = $i->toSeconds() / 60 / 60;
        return round($hours, 1);
    }

    public function overallTimeSpent()
    {
        $i = new DateInterval(0);
        foreach ($this->issues as $issue) {
            $i->add($issue->spent);
        }

        $hours = $i->toSeconds() / 60 / 60;
        return round($hours, 1);
    }

    public function ProgressCompleted()
    {
        // get issues completed
        $issues = $this->issues()->where('resolution_id', [1, 2])->get();
        // count time
        $i = new DateInterval(0);
        foreach ($issues as $issue) {
            $i->add($issue->estimated);
        }
        // calculate progress
        // 100 * TimeSpent / TimeEstimated
        return round(100 * $i->toSeconds() / ($this->overallTimeEstimated() * 60 * 60));
    }

    public function issues()
    {
        return $this->belongsToMany(IssueModel::class, 'goals_has_issues', 'goal_id', 'issue_id')
            ->using(ProjectHasMembersModel::class);
    }
}
