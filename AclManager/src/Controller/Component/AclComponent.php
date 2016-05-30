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

    public function request()
    {
        $request = $this->controller->request;
        $prefix = $request->param('prefix') ? $request->param('prefix') . '/' : '';
        $plugin = $request->param('plugin') ? 'plugin/' . $request->param('plugin') . '/' : '';
        $controller = $request->param('controller') . '/';
        $action = $request->param('action');
        return $plugin . $prefix . $controller . $action;
    }

    /**
     * Checking if userId has access to given aco name or not
     * @param $userId
     * @param $acoName
     * @return bool|null
     */
    public function checkUser($userId, $acoName)
    {
        $aro = $this->controller->Aro->Aros->find()
            ->where(['model' => 'users'])
            ->where(['foreign_key' => $userId])->first();
        if(!empty($aro)){
            $aco = $this->controller->Aco->Acos->find()->where(['name' => $acoName])->first();
            if(!empty($aco)){
                return $this->__check($aro, $aco);
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
    public function checkRole($role, $acoName, $inParentToo = true)
    {
        $roleId = &$role;
        if(!is_integer($role)){
            //get it's id.
            $Roles = TableRegistry::get('Users.Roles');
            $role = $Roles->find()->where(['name' => $role])->extract('id')->first();
        }
        if(!empty($role)){
            $roles = [$roleId];
            if($inParentToo){
                $Roles = TableRegistry::get('Users.Roles');
                $parentRoles = Hash::extract($Roles->find('path', ['for' => $roleId])->toArray(),'{n}.id');
                $roles = array_unique(array_filter($parentRoles));
            }
            $aros = $this->controller->Aro->Aros->find()
                ->where(['model' => 'roles'])
                ->where(['foreign_key IN' => $roles])->toArray();
            if(!empty($aros)){
                $aco = $this->controller->Aco->Acos->find()->where(['name' => $acoName])->first();
                if(!empty($aco)){
                    return $this->__check($aros, $aco);
                }
            }
        }
        return false;
    }

    /**
     * Check if aros has access to an aco or not
     * @param $aros
     * @param $aco
     * @return bool|null
     */
    private function __check($aros, $aco)
    {
        if(!is_array($aros)){
            $aros = [$aros];
        }
        $ArosAcos = TableRegistry::get('AclManager.ArosAcos');
        $permissions = $ArosAcos->find()
            ->where(['aco_id' => $aco->id])
            ->where(['aro_id IN' => Hash::extract($aros, '{n}.id')])
            ->toArray();
//            $permissions = Hash::extract($permissions, '{n}._matchingData.Acos');
//            $permissions = Hash::combine($permissions, '{n}.name', '{n}');
//            $permissions = Hash::sort($permissions, '{s}.name');
//            debug($permissions);die;
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
    public function allowUser($acoName, $userId)
    {
        $conditions = ['model' => 'users', 'foreign_key' => $userId];
        if(!$this->controller->Aro->check($conditions)){
            $this->controller->Aro->add($conditions);
        }
        if(!$this->controller->Aco->check($acoName)){
            $this->controller->Aco->add(['name' => $acoName]);
        }

        if($this->checkUser($userId, $acoName)){
            return true;
        }
        $aro = $this->controller->Aro->Aros->find()
            ->where(['model' => 'users'])
            ->where(['foreign_key' => $userId])->first();
        $acos = $this->controller->Aco->Acos->find()
            ->where(['name LIKE' => $acoName . '%'])->toArray();
        if(!empty($acos)){
            return $this->__allow($aro, $acos);
        }
        return false;
    }

    /**
     * Allow acoName to given role
     * @param $acoName
     * @param $roleName
     * @return bool|null
     */
    public function allowRole($acoName, $roleName)
    {
        if(!$this->controller->Aco->check($acoName)){
            $this->controller->Aco->add(['name' => $acoName]);
        }
        $Roles = TableRegistry::get('Users.Roles');
        $roleId = $Roles->find()->where(['name' => $roleName])->extract('id')->first();
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
                    if($this->checkRole($roleId, $aco->name, true)){
                        unset($acos[$index]);
                    }
                }
                if(!empty($acos) && $this->__allow($aro, $acos)){
                    //find all users with this roles and allow thairs
                    $UsersRoles = TableRegistry::get('Users.UsersRoles');
                    //get all child roles
                    $childrenRoles = Hash::extract(
                        $Roles->find('children', ['for' => $roleId])->toArray(),
                        '{n}.id'
                    );
                    $roles = array_unique(array_filter($childrenRoles));
                    foreach($roles as $roleId){
                        $conditions = ['model' => 'roles', 'foreign_key' => $roleId];
                        if(!$this->controller->Aro->check($conditions)){
                            $this->controller->Aro->add($conditions);
                        }
                        foreach($acos as $aco){
                            if($this->checkRole($roleId, $aco->name, false)){
                                $this->denyRole($aco->name, $roleId);
                            }
                        }
                    }

                    array_push($roles, $roleId);
                    //find all users having this roles
                    $users = $UsersRoles->find()->where(['role_id IN' => $roles])->toArray();
                    //allow all users
                    foreach($users as $user){
                        $this->allowUser($acoName, $user->user_id);
                    }
                }
                return true;
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
    private function __allow($aros, $acos)
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
                if(!$this->__check($aro, $aco)){
                    $data = [
                        'aro_id' => $aro->id,
                        'aco_id' => $aco->id
                    ];
                    $arosAcosEntity = $ArosAcos->newEntity($data);
                    $ArosAcos->save($arosAcosEntity);
                }
            }
        }
        return true;
    }

    /**
     * Deny acoName from given user id
     * @param $acoName
     * @param $userId
     * @return bool
     */
    public function denyUser($acoName, $userId)
    {
        $aro = $this->controller->Aro->Aros->find()
            ->where(['model' => 'users'])
            ->where(['foreign_key' => $userId])->first();
        $acos = $this->controller->Aco->startWith($acoName);
        if(!empty($acos) && !empty($aro)){
            return $this->__deny($aro, $acos);
        }
    }

    /**
     * Deny acoName from given role name
     * @param $acoName
     * @param $roleName
     * @return bool
     */
    public function denyRole($acoName, $roleName)
    {
        $Roles = TableRegistry::get('Users.Roles');
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
                if($this->__deny($aros, $acos)){
                    $UsersRoles = TableRegistry::get('Users.UsersRoles');
                    //get all parent roles
                    $childrenRoles = Hash::extract(
                        $Roles->find('children', ['for' => $roleId])->toArray(),
                        '{n}.id'
                    );
                    $roles = array_unique(array_filter($childrenRoles));
                    array_push($roles, $roleId);
                    //find all users having this roles
                    $users = $UsersRoles->find()->where(['role_id IN' => $roles])->toArray();
                    //allow all users
                    foreach($users as $user){
                        $this->denyUser($acoName, $user->user_id);
                    }
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Deny aros from acos
     * @param $aros
     * @param $acos
     * @return bool
     */
    private function __deny($aros, $acos)
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
                    'aro_id' => $aro->id,
                    'aco_id' => $aco->id
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
            'Controller\AppController.php',
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
        $ignoreList = ['beforeFilter', 'afterFilter', 'initialize'];
        foreach($actions as $action){
            if($action->class == $className && !in_array($action->name, $ignoreList)){
                $results[$action->name] = $action->name;
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
                $className = 'App\\' . $controller;
                $cname = str_replace(['Controller\\', 'Controller', DS], ['','','/'], $controller);
                $actions = $this->getActions($className);
                $resources[$cname]= $actions;
            }else{
                foreach($controller as $controllerName){
                    $cname = str_replace(['Controller\\', 'Controller', DS], ['','','/'], $controllerName);
                    $pName = $pluginName;
                    $className = $pluginName . '\\' . $controllerName;
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
