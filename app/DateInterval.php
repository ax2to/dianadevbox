<?php

namespace App;

use Carbon\CarbonInterval;

class DateInterval extends CarbonInterval
{
    public static function createFromString($string)
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

        $spec = 'P' . implode('', $p) . 'T' . implode('', $t);
        $i = new \DateInterval($spec);
        $ci = self::instance($i);

        return $ci;
    }

    public function __toString()
    {
        $string = parent::__toString();
        $clean = str_replace(' ', '', $string);
        $long = ['days', 'day', 'hours', 'hour', 'minutes', 'minute', 'seconds', 'second'];
        $short = ['D ', 'D ', 'H ', 'H ', 'M ', 'M ', 'S ', 'S '];

        $d = trim(str_replace($long, $short, $clean));

        if ($this->invert) {
            $d = '-' . $d;
        }

        if ($d == '') {
            return '0';
        }

        return $d;
    }

    public function toSeconds()
    {
        $seconds = $this->days * 86400 + $this->h * 3600 + $this->i * 60 + $this->s;
        return $seconds;
    }
}
