<?php
namespace Spider\Lib\Date;

use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use Cake\I18n\Time;

require_once 'jdf.php';

class Persian
{
    public static function date()
    {
        $args = func_get_args();
        if(isset($args[1])){
            $date = $args[1];
            if(($date instanceof FrozenDate) || ($date instanceof Time) || ($date instanceof FrozenTime)|| ($date instanceof \DateTime)){
                $args[1] = (new Time($date, null))->toUnixString();
            }elseif(is_string($date)){
                $args[1] = strtotime($date);
            }
        }
        if(!isset($args[2])){
            $args[2] = '';
        }
        if(!isset($args[3])){
            $args[3] = 'Asia/Tehran';
        }
        if(!isset($args[4])){
            $args[4] = 'en';
        }
        return call_user_func_array('jdate', $args);
    }

    /**
     * @param $date1
     * @param $date2
     * @param string $format : DateInterval::format http://php.net/manual/en/dateinterval.format.php
     * @return string
     */
    public static function diff($date1, $date2, $format = 'a')
    {
        $dStart = new \DateTime($date1);
        $dEnd  = new \DateTime($date2);
        $dDiff = $dStart->diff($dEnd);
        return $dDiff->format('%' . $format); // use for point out relation: smaller/greater
    }

    /**
     * @return \DateTime
     */
    public static function toGregorian()
    {
        $args = func_get_args();
        $gregorianDateTime = call_user_func_array('formated_to_gregorian', $args);
        $asiaTime = new \DateTime($gregorianDateTime, new \DateTimeZone('Asia/Tehran'));
        $utcTime = $asiaTime->setTimezone(new \DateTimeZone('UTC'));
        return $utcTime;
    }
}