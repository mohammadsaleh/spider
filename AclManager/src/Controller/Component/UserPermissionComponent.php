<?php
namespace AclManager\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * UserPermission component
 */
class UserPermissionComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    protected $_controller = null;

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->_controller = $this->_registry->getController();
        $action = $this->_controller->request->getParam('action');
        if(in_array($action, ['edit', 'add'])){
            $this->__setCurrentUserPermissions();
        }
    }

    /**
     * Set allAcos and current user private permission
     */
    private function __setCurrentUserPermissions()
    {
        $passParam = $this->_controller->request->getParam('pass');
        $userId = array_shift($passParam);
        $permissions = [];
        if($userId){
            $permissions = $this->_controller->Aro->getPermissions($this->_controller->Aro->getUser($userId));
            $permissions = array_keys($permissions);
        }
        $allAcos = $this->_controller->Aco->getAll();

        $this->_controller->set(compact('permissions', 'allAcos'));
    }
}
