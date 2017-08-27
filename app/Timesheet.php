<?php

namespace App;

use App\Models\IssueModel;
use App\Models\ProjectModel;
use App\Models\WorkLogModel;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Timesheet
 * @package App
 */
class Timesheet
{
    /**
     * @var Carbon
     */
    private $start;
    /**
     * @var Carbon
     */
    private $end;
    /**
     * @var Collection
     */
    private $projects;
    /**
     * @var Collection
     */
    private $issues;
    /**
     * @var Collection
     */
    private $workLogs;
    /**
     * @var null
     */
    private $user = null;

    /**
     * Timesheet constructor.
     * @param Carbon $start
     * @param Carbon $end
     */
    public function __construct(Carbon $start, Carbon $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Timesheet
     */
    public function setUser(User $user): Timesheet
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return integer
     */
    public function getDays()
    {
        return $this->end->diff($this->start)->days;
    }

    /**
     * @return Carbon
     */
    public function getEnd(): Carbon
    {
        return $this->end;
    }

    /**
     * @param Carbon $end
     * @return Timesheet
     */
    public function setEnd(Carbon $end): Timesheet
    {
        $this->end = $end;
        return $this;
    }

    /**
     *
     */
    public function build()
    {
        $this->workLogs = $this->getWorkLogsBaseQuery()->get();

        $this->issues = IssueModel::whereIn('id', $this->workLogs->pluck('issue_id'))
            ->get();

        $this->projects = ProjectModel::whereIn('id', $this->issues->pluck('project_id'))
            ->orderBy('name')
            ->get();
    }

    /**
     * @return Builder
     */
    private function getWorkLogsBaseQuery()
    {
        $query = WorkLogModel::where('company_id', Auth::user()->company_id)
            ->whereBetween('date', [$this->start->tz('UTC'), $this->end->tz('UTC')])
            ->where('in_progress', false);

        if (!is_null($this->user)) {
            $query->where('user_id', $this->user->id);
        }

        return $query;
    }

    /**
     * @return mixed
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * @param ProjectModel $project
     * @return mixed
     */
    public function getIssuesByProject(ProjectModel $project)
    {
        return $this->issues->where('project_id', $project->id);
    }

    /**
     * @param IssueModel $issue
     * @return float|int
     */
    public function getHoursByIssue(IssueModel $issue)
    {
        $workLogs = $this->workLogs->where('issue_id', $issue->id);
        if ($workLogs->count() > 0) {
            $dateTime = (new \DateTime())->setTimestamp(0);
            foreach ($workLogs as $workLog) {
                $interval = new \DateInterval($workLog->worked_interval);
                $dateTime->add($interval);
            }
            $hours = $dateTime->getTimestamp() / 60 / 60;
            return round($hours, 1);
        }
        return 0;
    }

    /**
     * @param IssueModel $issue
     * @param string $date
     * @return float|int
     */
    public function getHoursByIssueInDate(IssueModel $issue, $date)
    {
        $workLogs = $this->workLogs->where('issue_id', $issue->id)->filter(function ($workLog) use ($date) {
            return $workLog->date->format('Y-m-d') == $date;
        });
        if ($workLogs->count() > 0) {
            $dateTime = (new \DateTime())->setTimestamp(0);
            foreach ($workLogs as $workLog) {
                $interval = new \DateInterval($workLog->worked_interval);
                $dateTime->add($interval);
            }
            $hours = $dateTime->getTimestamp() / 60 / 60;
            return round($hours, 1);
        }
        return 0;
    }

    /**
     * @param string $date
     * @return float|int
     */
    public function getHoursByDate($date)
    {
        $workLogs = $this->workLogs->filter(function ($workLog) use ($date) {
            return $workLog->date->format('Y-m-d') == $date;
        });
        if ($workLogs->count() > 0) {
            $dateTime = (new \DateTime())->setTimestamp(0);
            foreach ($workLogs as $workLog) {
                $interval = new \DateInterval($workLog->worked_interval);
                $dateTime->add($interval);
            }
            $hours = $dateTime->getTimestamp() / 60 / 60;
            return round($hours, 1);
        }
        return 0;
    }

    /**
     * @param integer $position
     * @return false|string
     */
    public function getDateByPosition($position)
    {
        return date('Y-m-' . ($this->getStart()->day + $position));
    }

    /**
     * @return Carbon
     */
    public function getStart(): Carbon
    {
        return $this->start;
    }

    /**
     * @param Carbon $start
     * @return Timesheet
     */
    public function setStart(Carbon $start): Timesheet
    {
        $this->start = $start;
        return $this;
    }
}
