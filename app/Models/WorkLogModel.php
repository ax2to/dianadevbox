<?php

namespace App\Models;

use App\User;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkLogModel
 * @package App\Models
 */
class WorkLogModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'worklogs';
    protected $dates = ['date'];
    protected $fillable = ['issue_id', 'worked', 'date', 'description'];

    public function startLog(IssueModel $issue)
    {
        // create work log
        $workLog = new WorkLogModel();
        $workLog->company_id = Auth::user()->company_id;
        $workLog->issue_id = $issue->id;
        $workLog->user_id = Auth::id();
        $workLog->worked = '0H';
        $workLog->date = Carbon::now();
        $workLog->description = 'issue in progress...';
        $workLog->in_progress = true;
        $workLog->save();

        return $workLog;
    }

    public function stopLog()
    {
        // search in progress work log
        $logs = $this->getWorkLogInProgress();
        $now = Carbon::now();

        foreach ($logs as $log) {
            //$log->worked = WorkLogModel::getIntervalSpec($now, $log->created_at);
            //$log->worked = $now->diff($log->created_at)->format('P%yY%mM%dDT%hH%iM%sS');
            $log->worked = $this->convertDateInterval2String($now->diff($log->created_at));
            $log->in_progress = false;
            $log->save();

            $issue = $log->issue;
            $issue->status_id = 2;
            $issue->save();
        }
    }

    public function getWorkLogInProgress()
    {
        return WorkLogModel::where('in_progress', true)->where('user_id', Auth::id())->get();
    }

    public function convertDateInterval2String($interval)
    {
        $data = [];
        $parts = explode(' ', $interval->format('%yY %mM %dD %hH %iM %sS'));

        foreach ($parts as $part) {
            $type = substr($part, -1);
            $count = str_replace($type, '', $part);
            if ($count > 0) {
                $data[] = $part;
            }
        }

        return implode(' ', $data);
    }

    public function issue()
    {
        return $this->belongsTo(IssueModel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setWorkedAttribute($worked)
    {
        $dateInterval = $this->convertString2DateInterval($worked);
        $date = new Carbon($dateInterval);

        $this->attributes['worked'] = strtoupper($worked);
        $this->attributes['worked_interval'] = $dateInterval->format('P%yY%mM%dDT%hH%iM%sS');
        $this->attributes['worked_timestamp'] = $date->timestamp;

        return $this;
    }

    public function convertString2DateInterval($string)
    {
        $p = [];
        $t = [];
        $parts = explode(' ', strtoupper($string));

        foreach ($parts as $part) {
            $type = substr($part, -1);
            switch ($type) {
                case 'Y':
                case 'W':
                case 'D':
                    $p[] = $part;
                    break;
                case 'H':
                case 'M':
                case 'S':
                    $t[] = $part;
                    break;
            }
        }

        $interval = 'P' . implode('', $p) . 'T' . implode('', $t);

        $i = new \DateInterval($interval);
        $ci = CarbonInterval::instance($i);

        return $ci;
    }
}
