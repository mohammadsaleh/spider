<?php
namespace Spider\Lib\Date;

require_once 'jdf.php';

class Persian
{
    public static function date()
    {
        return call_user_func_array('jdate', func_get_args());
    }
}