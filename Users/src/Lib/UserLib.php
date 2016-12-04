<?php
namespace Users\Lib;

class UserLib
{
    private static $__Auth = null;

    public function __construct($Auth){
        self::$__Auth = $Auth;
    }

    public static function getAuth()
    {
        return self::$__Auth;
    }
}

