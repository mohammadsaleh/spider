<?php
namespace Users\Lib;

class UserLib
{
    private static $__Auth = null;

    public function __construct($Auth){
        self::$__Auth = $Auth;
    }

    /**
     * Check if user has given capability or not.
     * @param $capabilities
     * @param null $userId
     */
    public static function can($capabilities, $userId = null){
        if(!is_array($capabilities)){
            $capabilities = [$capabilities];
        }
        return self::$__Auth->can($capabilities, $userId);
    }

    public static function getAuth()
    {
        return self::$__Auth;
    }
}

