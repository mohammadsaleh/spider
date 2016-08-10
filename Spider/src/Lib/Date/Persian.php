<?php
namespace Spider\Lib\Date;

require_once 'jdf.php';

class Persian
{
    public static function date()
    {
        $args = func_get_args();
        if(isset($args[1])){
            $date = $args[1];
            if($date instanceof FrozenDate){
                $args[1] = (int)$date->toUnixString();
            }elseif(is_string($date)){
                $args[1] = strtotime($date);
            }
        }
        return call_user_func_array('jdate', $args);
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