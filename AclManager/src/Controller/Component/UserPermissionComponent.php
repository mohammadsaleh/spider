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
        if($this->_controller->request->param('action') == 'edit'){
            $this->__setCurrentUserPermissions();
        }
    }

    /**
     * Set allAcos and current user private permission
     */
    private function __setCurrentUserPermissions()
    {
        $passParam = $this->_controller->request->param('pass');
        $userId = array_shift($passParam);
        $permissions = $this->_controller->Aro->getPermissions($this->_controller->Aro->getUser($userId));
        $allAcos = $this->_controller->Aco->getAll();

        $permissions = array_keys($permissions);
        $this->_controller->set(compact('permissions', 'allAcos'));
    }
}
