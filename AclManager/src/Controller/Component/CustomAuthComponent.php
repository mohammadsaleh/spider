<?php
namespace AclManager\Controller\Component;

use Cake\Controller\Component\AuthComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Event\Event;
use Cake\Utility\Hash;

class CustomAuthComponent extends AuthComponent
{

    public function __construct(ComponentRegistry $registry, array $config = [])
    {
        $this->components = array_merge($this->components, ['AclManager.Acl']);
        parent::__construct($registry, $config);
    }

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
            $userAllowed = $this->Acl->checkUserAllow($this->user('id'), $acoName);
            return !is_null($userAllowed) ? $userAllowed : $this->Acl->checkRoleAllow(Hash::extract($this->user('roles'), '{n}.id'), $acoName);
        }
        return false;
    }

    /**
     * Overwrite setUser to implement an event after set user.
     *
     * @param array $user
     */
    public function setUser($user)
    {
        parent::setUser($user);
        $this->eventManager()->dispatch(new Event('Auth.after.setUser', $this->_registry->getController(), ['user' => $user]));
    }
}