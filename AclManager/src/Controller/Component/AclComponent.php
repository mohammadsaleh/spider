<?php
namespace AclManager\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use ReflectionClass;
use ReflectionMethod;
use Cake\Core\Plugin;
use Cake\Filesystem\Folder;
use Cake\Core\App;


/**
 * Acl component
 */
class AclComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    public $controller = null;


    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->controller = $this->_registry->getController();
    }

    /**
     * Set role/roles to a user
     * @param $userId
     * @param $roleIds
     */
    public function setUserRole($userId, $roleIds)
    {
        if(empty($roleIds)){
            return;
        }
        $UserRoles = TableRegistry::get('AclManager.UsersRoles');
        if(!is_array($roleIds)){
            $roleIds = [$roleIds];
        }
        $currentRoles = $UserRoles->find()->where(['user_id' => $userId])->extract('role_id')->toArray();
        if(!empty($currentRoles)){
            $diffRoles = array_diff($currentRoles, $roleIds);
            if(!empty($diffRoles)){
                $UserRoles->deleteAll(['user_id' => $userId, 'role_id IN' => $diffRoles]);
            }
        }
        foreach($roleIds as $roleId){
            $UserRoles->save($UserRoles->newEntity(['user_id' => $userId, 'role_id' => $roleId]));
        }
    }

    /**
     * Get request as AcoName
     * @return string
     */
    public function request()
    {
        $request = $this->controller->request;
        $prefix = $request->param('prefix') ? $request->param('prefix') . '/' : '';
        $plugin = $request->param('plugin') ? 'plugin/' . $request->param('plugin') . '/' : '';
        $controller = $request->param('controller') . '/';
        $action = $request->param('action');
        return $plugin . $prefix . $controller . $action . '/';
    }

    /**
     * Check given user has allow to do acoName.
     * @param $userId
     * @param $acoName
     * @return bool
     */
    public function checkUserAllow($userId, $acoName)
    {
        //if deny user return false
        //else if access user return true
        if($this->checkUserDeny($userId, $acoName)){
            return false;
        }
        if($this->checkUserAccess($userId, $acoName)){
            return true;
        }
        return null;
    }

    /**
     * Check given user has allow to do acoName.
     * @param $roles
     * @param $acoName
     * @return bool
     */
    public function checkRoleAllow($roles, $acoName)
    {
        //else if deny role return false
        //else if access role return true
        if(!is_array($roles)){
            $roles = [$roles];
        }
        foreach($roles as $role){
            if($this->checkRoleDeny($role, $acoName)){
                return false;
            }
        }
        foreach($roles as $role){
            if($this->checkRoleAccess($role, $acoName)){
                return true;
            }
        }
        return false;
    }

    /**
     * Check userId is denied to do acoName
     *
     * @param $role
     * @param $acoName
     * @return bool
     */
    public function checkRoleDeny($role, $acoName)
    {
        $roleId = &$role;
        if(!is_integer($role)){
            //get it's id.
            $Roles = TableRegistry::get('AclManager.Roles');
            $role = $Roles->find()->where(['name' => $role])->extract('id')->first();
        }
        if(!empty($role)){
            $aro = $this->controller->Aro->Aros->find()
                ->where(['model' => 'roles'])
                ->where(['foreign_key' => $roleId])->first();
            if(!empty($aro)){
                $aco = $this->controller->Aco->Acos->find()->where(['name' => $acoName])->first();
                if(!empty($aco)){
                    return $this->__checkDeny($aro, $aco);
                }
            }
        }
        return false;
    }
    /**
     * Check userId is denied to do acoName
     *
     * @param $userId
     * @param $acoName
     * @return bool
     */
    public function checkUserDeny($userId, $acoName)
    {
        $aro = $this->controller->Aro->Aros->find()
            ->where(['model' => 'users'])
            ->where(['foreign_key' => $userId])->first();
        if(!empty($aro)){
            $aco = $this->controller->Aco->Acos->find()->where(['name' => $acoName])->first();
            if(!empty($aco)){
                return $this->__checkDeny($aro, $aco);
            }
        }
        return false;
    }

    /**
     * Check deny for aro , aco
     * @param $aro
     * @param $aco
     * @return bool
     */
    public function __checkDeny($aro, $aco)
    {
        $ArosAcos = TableRegistry::get('AclManager.ArosAcos');
        $exist = $ArosAcos->find()
            ->where(['aco_id' => $aco['id']])
            ->where(['aro_id' => $aro['id']])
            ->where(['deny' => 1])
            ->first();

        if(!empty($exist)){
            return true;
        }
        return false;
    }

    /**
     * Checking if userId has access to given aco name or not
     * @param $userId
     * @param $acoName
     * @return bool|null
     */
    public function checkUserAccess($userId, $acoName)
    {
        $aro = $this->controller->Aro->Aros->find()
            ->where(['model' => 'users'])
            ->where(['foreign_key' => $userId])->first();
        if(!empty($aro)){
            $aco = $this->controller->Aco->Acos->find()->where(['name' => $acoName])->first();
            if(!empty($aco)){
                return $this->__checkAccess($aro, $aco);
            }
        }
        return false;
    }

    /**
     * Checking if role name has access to given aco name or not
     * @param $role
     * @param $acoName
     * @param $inParentToo
     * @return bool|null
     */
    public function checkRoleAccess($role, $acoName)
    {
        $roleId = &$role;
        if(!is_integer($role)){
            //get it's id.
            $Roles = TableRegistry::get('AclManager.Roles');
            $role = $Roles->find()->where(['name' => $role])->extract('id')->first();
        }
        if(!empty($role)){
            $aro = $this->controller->Aro->Aros->find()
                ->where(['model' => 'roles'])
                ->where(['foreign_key' => $roleId])->first();
            if(!empty($aro)){
                $aco = $this->controller->Aco->Acos->find()->where(['name' => $acoName])->first();
                if(!empty($aco)){
                    return $this->__checkAccess($aro, $aco);
                }
            }
        }
        return false;
    }

    /**
     * Check if aro has access to an aco or not
     * @param $aro
     * @param $aco
     * @return bool|null
     */
    private function __checkAccess($aro, $aco)
    {
        $ArosAcos = TableRegistry::get('AclManager.ArosAcos');
        $permissions = $ArosAcos->find()
            ->where(['aco_id' => $aco['id']])
            ->where(['aro_id IN' => $aro['id']])
            ->toArray();

        if(!empty($permissions)){
            return true;
        }
        return false;
    }

    /**
     * Allow acoName to an userId
     * @param $acoName
     * @param $userId
     * @return bool
     */
    public function setUserAccess($acoName, $userId)
    {
        $conditions = ['model' => 'users', 'foreign_key' => $userId];
        if(!$this->controller->Aro->check($conditions)){
            $this->controller->Aro->add($conditions);
        }
        if(!$this->controller->Aco->check($acoName)){
            $this->controller->Aco->add(['name' => $acoName]);
        }

        if($this->checkUserAccess($userId, $acoName)){
            return true;
        }
        $aro = $this->controller->Aro->Aros->find()
            ->where(['model' => 'users'])
            ->where(['foreign_key' => $userId])->first();
        $acos = $this->controller->Aco->Acos->find()
            ->where(['name LIKE' => $acoName . '%'])->toArray();
        if(!empty($acos)){
            return $this->__setAccess($aro, $acos);
        }
        return false;
    }

    /**
     * Allow acoName to given role
     * @param $acoName
     * @param $roleName
     * @return bool|null
     */
    public function setRoleAccess($acoName, $roleName)
    {
        $Roles = TableRegistry::get('AclManager.Roles');
        if(!$this->controller->Aco->check($acoName)){
            $this->controller->Aco->add(['name' => $acoName]);
        }
        if(is_integer($roleName)){
            $roleId = $roleName;
        }else{
            $roleId = $Roles->find()->where(['name' => $roleName])->extract('id')->first();
        }
        if(!empty($roleId)){
            $conditions = ['model' => 'roles', 'foreign_key' => $roleId];
            if(!$this->controller->Aro->check($conditions)){
                $this->controller->Aro->add($conditions);
            }
            $aro = $this->controller->Aro->Aros->find()
                ->where(['model' => 'roles'])
                ->where(['foreign_key' => $roleId])->toArray();
            $acos = $this->controller->Aco->startWith($acoName);
            if(!empty($acos) && !empty($aro)){
                foreach($acos as $index => $aco){
                    if($this->checkRoleAccess($roleId, $aco->name)){
                        unset($acos[$index]);
                    }
                }
                if(!empty($acos) && $this->__setAccess($aro, $acos)){
                    return true;
                }
            }
        }
        return null;
    }

    /**
     * Allow aros to acos
     * @param $aros
     * @param $acos
     * @return bool
     */
    private function __setAccess($aros, $acos)
    {
        if(!is_array($aros)){
            $aros = [$aros];
        }
        if(!is_array($acos)){
            $acos = [$acos];
        }
        $ArosAcos = TableRegistry::get('AclManager.ArosAcos');
        foreach($aros as $aro){
            foreach($acos as $aco){
                if(!$this->__checkAccess($aro, $aco)){
                    $data = [
                        'aro_id' => $aro['id'],
                        'aco_id' => $aco['id']
                    ];
                    $arosAcosEntity = $ArosAcos->newEntity($data);
                    $ArosAcos->save($arosAcosEntity);
                }
            }
        }
        return true;
    }

    /**
     * Deny acoName to given role
     * @param $acoName
     * @param $roleName|$roleId
     * @return bool|null
     */
    public function setRoleDeny($acoName, $roleName)
    {
        $Roles = TableRegistry::get('AclManager.Roles');
        if(!$this->controller->Aco->check($acoName)){
            $this->controller->Aco->add(['name' => $acoName]);
        }
        if(is_integer($roleName)){
            $roleId = $roleName;
        }else{
            $roleId = $Roles->find()->where(['name' => $roleName])->extract('id')->first();
        }
        if(!empty($roleId)){
            $conditions = ['model' => 'roles', 'foreign_key' => $roleId];
            if(!$this->controller->Aro->check($conditions)){
                $this->controller->Aro->add($conditions);
            }
            $aro = $this->controller->Aro->Aros->find()
                ->where(['model' => 'roles'])
                ->where(['foreign_key' => $roleId])->first();
            $acos = $this->controller->Aco->startWith($acoName);
            if(!empty($acos) && !empty($aro)){
                foreach($acos as $index => $aco){
                    if(!$this->checkRoleAccess($roleId, $aco->name)){
                        unset($acos[$index]);
                    }
                }
                if(!empty($acos) && $this->__setDeny($aro, $acos)){
                    return true;
                }
            }
        }
        return null;
    }

    /**
     * Deny acoName from given user id
     * @param $acoName
     * @param $userId
     * @return bool
     */
    public function setUserDeny($acoName, $userId)
    {
        $aro = $this->controller->Aro->Aros->find()
            ->where(['model' => 'users'])
            ->where(['foreign_key' => $userId])->first();
        $acos = $this->controller->Aco->startWith($acoName);
        if(!empty($acos) && !empty($aro)){
            return $this->__setDeny($aro, $acos);
        }
    }

    /**
     * Deny aros to acos
     * @param $aros
     * @param $acos
     * @return bool
     */
    private function __setDeny($aros, $acos)
    {
        if(!is_array($aros)){
            $aros = [$aros];
        }
        if(!is_array($acos)){
            $acos = [$acos];
        }
        $ArosAcos = TableRegistry::get('AclManager.ArosAcos');
        foreach($aros as $aro){
            foreach($acos as $aco){
                $ArosAcos->updateAll(['deny' => 1], [
                    'aro_id' => $aro['id'],
                    'aco_id' => $aco['id']
                ]);
            }
        }
        return true;
    }

    /**
     * Clear Role Deny acoName from given role name
     * @param $acoName
     * @param $roleName
     * @return bool
     */
    public function clearRoleDeny($acoName, $roleName)
    {
        $Roles = TableRegistry::get('AclManager.Roles');
        $roleId = $roleName;
        if(!is_integer($roleName)){
            $roleId = $Roles->find()->where(['name' => $roleName])->extract('id')->first();
        }
        if(!empty($roleId)){
            $aros = $this->controller->Aro->Aros->find()
                ->where(['model' => 'roles'])
                ->where(['foreign_key' => $roleId])->toArray();
            $acos = $this->controller->Aco->startWith($acoName);
            if(!empty($acos) && !empty($aros)){
                if($this->__clearDeny($aros, $acos)){
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Clear User Deny acoName from given user id
     *
     * @param $acoName
     * @param $userId
     * @return bool
     */
    public function clearUserDeny($acoName, $userId)
    {
        if(!empty($userId)){
            $aro = $this->controller->Aro->Aros->find()
                ->where(['model' => 'users'])
                ->where(['foreign_key' => $userId])->toArray();
            $acos = $this->controller->Aco->startWith($acoName);
            if(!empty($acos) && !empty($aro)){
                if($this->__clearDeny($aro, $acos)){
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Clear Deny aros from acos
     * @param $aros
     * @param $acos
     * @return bool
     */
    private function __clearDeny($aros, $acos)
    {

        if(!is_array($aros)){
            $aros = [$aros];
        }
        if(!is_array($acos)){
            $acos = [$acos];
        }
        $ArosAcos = TableRegistry::get('AclManager.ArosAcos');
        foreach($aros as $aro){
            foreach($acos as $aco){
                $ArosAcos->updateAll(['deny' => 0], [
                    'aro_id' => $aro['id'],
                    'aco_id' => $aco['id']
                ]);
            }
        }
        return true;
    }

    /**
     * Clear Role Access acoName from given role name
     * @param $acoName
     * @param $roleName
     * @return bool
     */
    public function clearRoleAccess($acoName, $roleName)
    {
        $Roles = TableRegistry::get('AclManager.Roles');
        $roleId = $roleName;
        if(!is_integer($roleName)){
            $roleId = $Roles->find()->where(['name' => $roleName])->extract('id')->first();
        }
        if(!empty($roleId)){
            $aros = $this->controller->Aro->Aros->find()
                ->where(['model' => 'roles'])
                ->where(['foreign_key' => $roleId])->toArray();
            $acos = $this->controller->Aco->startWith($acoName);
            if(!empty($acos) && !empty($aros)){
                if($this->__clearAccess($aros, $acos)){
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Clear User Access acoName from given user id
     *
     * @param $acoName
     * @param $roleName
     * @return bool
     */
    public function clearUserAccess($acoName, $userId)
    {
        if(!empty($userId)){
            $aros = $this->controller->Aro->Aros->find()
                ->where(['model' => 'users'])
                ->where(['foreign_key' => $userId])->toArray();
            $acos = $this->controller->Aco->startWith($acoName);
            if(!empty($acos) && !empty($aros)){
                if($this->__clearAccess($aros, $acos)){
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Clear Access aros from acos
     * @param $aros
     * @param $acos
     * @return bool
     */
    private function __clearAccess($aros, $acos)
    {

        if(!is_array($aros)){
            $aros = [$aros];
        }
        if(!is_array($acos)){
            $acos = [$acos];
        }
        $ArosAcos = TableRegistry::get('AclManager.ArosAcos');
        foreach($aros as $aro){
            foreach($acos as $aco){
                $condition = [
                    'aro_id' => $aro['id'],
                    'aco_id' => $aco['id']
                ];
                $ArosAcos->deleteAll($condition);
            }
        }
        return true;
    }


    public function findControllers($controllerDir = APP) {
        $results = [];
        $dir = new Folder($controllerDir . 'Controller');
        $files = $dir->findRecursive('^.*Controller\.php$', true);
        $ignoreList = [
            'Controller' . DS . 'AppController.php',
        ];
        foreach($files as &$file){
            $file = str_replace($controllerDir, '', $file);
            if(!in_array($file, $ignoreList)) {
                $controller = explode('.', $file)[0];
                array_push($results, $controller);
            }
        }
        return $results;
    }

    public function getActions($className) {
        $class = new ReflectionClass($className);
        $actions = $class->getMethods(ReflectionMethod::IS_PUBLIC);
        $results = [];
        $ignoreList = ['beforeFilter', 'afterFilter', 'initialize', 'beforeRender'];
        foreach($actions as $action){
            if($action->class == $className && !in_array($action->name, $ignoreList)){
                $results[$action->name . '/'] = $action->name;
            }
        }
        return $results;
    }

    /**
     * @param string $type: flaten or array
     * @return array
     */
    public function getResources($type = 'flatten'){
        $controllers = $this->findControllers();
        foreach(Configure::read('Hook.plugins') as $plugin){
            $pluginName = Inflector::camelize($plugin);
            foreach (App::path('Plugin') as $pluginPath) {
                $pluginName = str_replace('Spider/', '', $pluginName);
                if(Plugin::loaded($pluginName)){
                    if (is_dir($pluginPath . $pluginName)) {
                        $findedControllers = $this->findControllers($pluginPath . $pluginName . DS . 'src' . DS);
                        if(!empty($findedControllers)){
                            $controllers[$pluginName] = $findedControllers;
                        }
                        break;
                    }
                }
            }
        }
        $resources = [];
        foreach($controllers as $pluginName => $controller){
            if(is_integer($pluginName)){
                $className = 'App' . DS . $controller;
                $cname = str_replace(['Controller' . DS, 'Controller', DS], ['','','/'], $controller);
                $className = str_replace('/', '\\', $className);
                $actions = $this->getActions($className);
                $resources[$cname]= $actions;
            }else{
                foreach($controller as $controllerName){
                    $cname = str_replace(['Controller' . DS, 'Controller', DS], ['','','/'], $controllerName);
                    $pName = $pluginName;
                    $className = $pluginName . DS . $controllerName;
                    $className = str_replace('/', '\\', $className);
                    $actions = $this->getActions($className);
                    $resources['plugin'][$pName][$cname] = $actions;
                }
            }
        }
        if($type == 'flatten'){
            return Hash::flatten($resources, '/');
        }
        return $resources;
    }
}
