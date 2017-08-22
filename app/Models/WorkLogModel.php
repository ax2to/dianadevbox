<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;

class WorkLogModel extends Model
{
    protected $table = 'worklogs';
    protected $dates = ['date'];

    public static function getIntervalSpec(Carbon $alpha, Carbon $omega)
    {
        $intvl = $alpha->diff($omega);

        $date = NULL;
        if ($intvl->y) $date .= $intvl->y . 'Y';
        if ($intvl->m) $date .= $intvl->m . 'M';
        if ($intvl->d) $date .= $intvl->d . 'D';

        $time = NULL;
        if ($intvl->h) $time .= $intvl->h . 'H';
        if ($intvl->i) $time .= $intvl->i . 'M';
        if ($intvl->s) $time .= $intvl->s . 'S';
        if ($time) $time = 'T' . $time;

        $text = 'P' . $date . $time;
        if ($text == 'P') return 'PT0S';
        return $text;
    }

    public function startLog(IssueModel $issue)
    {
        // create work log
        $workLog = new WorkLogModel();
        $workLog->company_id = Auth::user()->company_id;
        $workLog->issue_id = $issue->id;
        $workLog->user_id = Auth::id();
        $workLog->worked = '';
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
            $log->worked = $now->diff($log->created_at)->format('P%yY%mM%dDT%hH%iM%sS');
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

        return $interval;
    }

    public function getWorked2StringAttribute()
    {
        return $this->convertDateInterval2String($this->worked);
    }

    public function convertDateInterval2String($interval)
    {
        $i = new \DateInterval($interval);
        $ci = CarbonInterval::instance($i);

        return $ci;
    }

    public function issue()
    {
        return $this->belongsTo(IssueModel::class);
    }
}
