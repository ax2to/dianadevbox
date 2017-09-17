<?php

namespace App;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use DateInterval;

class DateTime extends Carbon
{
    public function dateInterval2String($interval)
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

    public function string2DateInterval($string)
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

        $i = new DateInterval($interval);
        $ci = CarbonInterval::instance($i);

        return $ci;
    }

    public function worked()
    {
        $date = DateTime::now()->setTimestamp(0);
        $interval = $this->diff($date);

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
}
