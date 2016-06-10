<?php
namespace Spider\Lib\Date;

require_once 'jdf.php';

class Persian
{
    public static function date()
    {
        return call_user_func_array('jdate', func_get_args());
    }

    /**
     * @param $date1
     * @param $date2
     * @param string $format : DateInterval::format http://php.net/manual/en/dateinterval.format.php
     * @return string
     */
    public static function diff($date1, $date2, $format = 'd')
    {
        $dStart = new \DateTime($date1);
        $dEnd  = new \DateTime($date2);
        $dDiff = $dStart->diff($dEnd);
        return $dDiff->format('%' . $format); // use for point out relation: smaller/greater
    }
}