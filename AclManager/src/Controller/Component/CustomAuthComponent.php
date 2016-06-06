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
        $userRoles = Hash::extract($this->user('roles'), '{n}.name');
        if(is_integer($role)){
            $userRoles = Hash::extract($this->user('roles'), '{n}.id');
        }
        return in_array($role, $userRoles);
    }
}