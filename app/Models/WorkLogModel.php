<?php

namespace App\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;

class WorkLogModel extends Model
{
    protected $table = 'worklogs';
    protected $dates = ['date'];

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

    public function convertDateInterval2String($interval)
    {
        $i = new \DateInterval($interval);
        $ci = CarbonInterval::instance($i);

        return $ci;
    }

    public function getWorked2StringAttribute()
    {
        return $this->convertDateInterval2String($this->worked);
    }

    public function issue()
    {
        return $this->belongsTo(IssueModel::class);
    }
}
