<?php
namespace Spider\Lib;
use Cake\Core\Configure;
use Cake\ORM\Entity;
use Cake\Utility\Hash;

require_once 'Date/jdf.php';
class Spider
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

    /**
     * Generate unique string
     * @param int $length
     * @param bool $letter todo:: 32 length is not enough for letter = false, because just return 19 characters.
     * @return string
     */
    public static function uniqueString($length = 32, $letter = true)
    {
        if($letter){
            return substr(str_shuffle(md5(microtime())), 0, $length);
        }
        return substr(str_replace(['.', ' '], '', str_shuffle(microtime())), 0, $length);
    }

    /**
     * Merge Configuration
     *
     * @param string $key Configure key
     * @param array $config New configuration to merge
     * @param return array Array of merged configurations
     */
    public static function mergeConfig($key, $config) {
        $values = Configure::read($key);
        $values = Hash::merge((array)$values, $config);
        Configure::write($key, $values);
        return $values;
    }

    /**
     * Extract array values starting with given prefix.
     * @param $collections
     * @param string $prefix
     * @param bool|false $originalKeys
     * @return array
     */
    public static function extractByPrefix($collections, $prefix = '', $originalKeys = false)
    {
        $items = [];
        if(empty($prefix)){
            return $collections;
        }
        if(!is_array($collections)){
            if($collections instanceof Entity){
                $collections = $collections->toArray();
            }else{
                $collections = (array)$collections;
            }
        }
        foreach($collections as $key => $value){
            if(preg_match("/^$prefix(.*?)$/is", $key, $match)){
                $key = $originalKeys ? $key : $match[1];
                $items[$key] = $value;
            }
        }
        return $items;
    }


    public static function convertTimesToTwoDigits($timeString = '00:00:00')
    {
        $timeString = array_map(function($val) {
            return sprintf('%02d', $val);
        }, explode(':', $timeString));
        $timeString = implode(':', $timeString);
        return $timeString;
    }

    public static function purgeAmount($amount)
    {
        return preg_replace('/[,?]/', '', $amount);
    }

    /**
     * Get [count] word from string
     * @param $sentence
     * @param int $count
     * @return mixed
     */
    public static function getWords($sentence, $count = 10) {
        $string = preg_replace('/\s+/', ' ', trim($sentence));
        $words = explode(" ", $string); // an array
        // if number of words you want to get is greater than number of words in the string
        if ($count > count($words)) {
            // then use number of words in the string
            $count = count($words);
        }
        $new_string = "";
        for ($i = 0; $i < $count; $i++) {
            $new_string .= $words[$i] . " ";
        }
        return trim($new_string);
    }
}