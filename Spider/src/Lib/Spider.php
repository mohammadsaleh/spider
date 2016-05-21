<?php
namespace Spider\Lib;
use Cake\Core\Configure;
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
}