<?php
namespace Spider\Lib;
use Cake\Core\Configure;
use Cake\ORM\Entity;
use Cake\Utility\Hash;

class Spider
{
    /**
     * Generate unique string
     * @param int $length
     * @return string
     */
    public static function uniqueString($length = 32)
    {
        return substr(str_shuffle(md5(microtime())), 0, $length);
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
}