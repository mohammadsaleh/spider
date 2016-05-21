<?php
namespace Spider\Lib;

use Cake\I18n\Time;

class SpiderTime
{
    public static function getTimeAgo($givenTime)
    {
//        if(!is_integer($givenTime)){
//            $givenTime = strtotime($givenTime);
//        }
        $diffTime = time() - $givenTime;

        if ($diffTime < 60)
        {
            return 'چند لحظه';
        }

        $times = [
            365 * 24 * 60 * 60  =>  'year',
            30 * 24 * 60 * 60  =>  'month',
            24 * 60 * 60  =>  'day',
            60 * 60  =>  'hour',
            60  =>  'minute',
            1  =>  'second'
        ];
        $persian = [
            'year'   => 'سال',
            'month'  => 'ماه',
            'day'    => 'روز',
            'hour'   => 'ساعت',
            'minute' => 'دقیقه',
            'second' => 'ثانیه'
        ];
//        $english = [
//            'year'   => 'years',
//            'month'  => 'months',
//            'day'    => 'days',
//            'hour'   => 'hours',
//            'minute' => 'minutes',
//            'second' => 'seconds'
//        ];

        foreach ($times as $secs => $str)
        {
            $d = $diffTime / $secs;
            if ($d >= 1)
            {
                $r = round($d);
                return $r . ' ' . $persian[$str] . ' قبل';
            }
        }
    }

    public static function jalaliAsiaTehranToGregorianUTC($date, $format = 'Y-m-d H:i:s')
    {
        $defaultTimezone = date_default_timezone_get();
        date_default_timezone_set('Asia/Tehran');
        $gregorianDate = formated_to_gregorian($date);
        $time = new Time($gregorianDate);
        date_default_timezone_set($defaultTimezone);
        return $time->setTimezone('UTC')->format($format);
    }
}