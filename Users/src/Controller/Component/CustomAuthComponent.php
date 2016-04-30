<?php
namespace Users\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Component\AuthComponent;
use Cake\ORM\TableRegistry;

/**
 * CustomAuth component
 */
class CustomAuthComponent extends AuthComponent
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function initialize(array $config)
    {
        parent::initialize($config);
    }

    /**
     * Check given userId have access to compatibility
     * @param String $capabilities
     * @param Integer $userId
     * @return bool
     */
    public function can($capabilities, $userId = null)
    {
        if(!is_array($capabilities)){
            $capabilities = array($capabilities);
        }
        if(empty($userId)){
            $userId = $this->user('id');
        }
        $Users = TableRegistry::get('Users.Users');
        $UserCapabilities = $Users->find()
            ->select(['Capabilities.id', 'Capabilities.title'])
            ->leftJoin(
                ['UsersCapabilities' => 'users_capabilities'],
                ['UsersCapabilities.user_id = Users.id']
            )
            ->leftJoin(
                ['RolesCapabilities' => 'roles_capabilities'],
                ['RolesCapabilities.role_id = Users.role_id']
            )
            ->leftJoin(
                ['Capabilities' => 'capabilities'],
                ['Capabilities.id IN (UsersCapabilities.capability_id, RolesCapabilities.capability_id)']
            )
            ->where(['Users.id' => $userId])->extract('Capabilities.title')->toArray();

        //returning all of given capabilities that is in user capabilities.
        return (count(array_intersect($capabilities, $UserCapabilities)) == count($capabilities));
    }
}
