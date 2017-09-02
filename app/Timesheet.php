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
    private $startDate;
    /**
     * @var Carbon
     */
    private $endDate;
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
     * @var User
     */
    private $user = null;

    /**
     * @var Collection
     */
    private $days = null;

    /**
     * Timesheet constructor.
     * @param Carbon $start
     * @param Carbon $end
     */
    public function __construct(Carbon $start, Carbon $end)
    {
        $this->startDate = $start;
        $this->endDate = $end;
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

        $this->calculateDays();
    }

    /**
     * @return Builder
     */
    private function getWorkLogsBaseQuery()
    {
        $query = WorkLogModel::where('company_id', Auth::user()->company_id)
            ->whereBetween('date', [$this->startDate->tz('UTC'), $this->endDate->tz('UTC')])
            ->where('in_progress', false);

        if (!is_null($this->user)) {
            $query->where('user_id', $this->user->id);
        }

        return $query;
    }

    /**
     *
     */
    private function calculateDays()
    {
        $dates = [];
        $date = clone $this->getStartDate();
        while ($date < $this->getEndDate()) {
            $dates[] = clone $date;
            $date->addDay();
        }
        $this->days = collect($dates);
    }

    /**
     * @return Carbon
     */
    public function getStartDate(): Carbon
    {
        return $this->startDate;
    }

    /**
     * @param Carbon $startDate
     * @return Timesheet
     */
    public function setStartDate(Carbon $startDate): Timesheet
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return Carbon
     */
    public function getEndDate(): Carbon
    {
        return $this->endDate;
    }

    /**
     * @param Carbon $endDate
     * @return Timesheet
     */
    public function setEndDate(Carbon $endDate): Timesheet
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getDays()
    {
        return $this->days;
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
     * @param Carbon $date
     * @return float|int
     */
    public function getHoursByIssueInDate(IssueModel $issue, Carbon $date)
    {
        $workLogs = $this->workLogs->where('issue_id', $issue->id)->filter(function ($workLog) use ($date) {
            return $workLog->date->format('Y-m-d') == $date->format('Y-m-d');
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
     * @param Carbon $date
     * @return float|int
     */
    public function getHoursByDate(Carbon $date)
    {
        $workLogs = $this->workLogs->filter(function ($workLog) use ($date) {
            return $workLog->date->format('Y-m-d') == $date->format('Y-m-d');
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
}
