<?php
namespace Users\Lib;

use Cake\ORM\TableRegistry;

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

    public static function getSuperAdmin()
    {
        $superAdminUser = TableRegistry::get('Users.Users')->find()
            ->matching('Roles', function ($q){
                return $q->where(['name' => 'superadmin']);
            })
            ->first();
        return $superAdminUser;
    }
}

