<?php
namespace AclManager\Controller\Component;

use Cake\Controller\Component\AuthComponent;
use Cake\Utility\Hash;

class CustomAuthComponent extends AuthComponent
{

    /**
     * Check if user has given role or not
     * @param String/Integer $role
     * @return bool
     */
    public function hasRole($role)
    {
        $roles = $this->user('roles');
        if(!empty($roles)){
            $userRoles = Hash::extract($roles, '{n}.name');
            if(is_integer($role)){
                $userRoles = Hash::extract($roles, '{n}.id');
            }
            return in_array($role, $userRoles);
        }
        return false;
    }

    /**
     * Check if current user has allow given acoName or not
     * @param $acoName
     * @return bool
     */
    public function hasAllow($acoName)
    {
        if($this->user('id')){
            return $this->Acl->checkUser($this->user('id'), $acoName);
        }
        return false;
    }
}