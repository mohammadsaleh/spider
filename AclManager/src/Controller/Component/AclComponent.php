<?php
namespace AclManager\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

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


    public function checkUser($userId, $acoName)
    {
        $aros = $this->controller->Aro->getAros(['user_id' => $userId]);
        return $this->__check($aros, $acoName);
    }

    public function checkRoles($roleId, $acoName)
    {
        $aros = $this->controller->Aro->getAros(['role_id' => $roleId]);
        return $this->__check($aros, $acoName);
    }

    private function __check($aros, $acoName)
    {
        if(!empty($aros)){
            $ArosAcos = TableRegistry::get('AclManager.ArosAcos');
            $permissions = $ArosAcos->find()
                ->matching('Acos', function($q) use($acoName) {
                    return $q->where(['Acos.name' => $acoName]);
                })
                ->where(['aro_id IN' => Hash::extract($aros, '{n}.id')])->toArray();
//            $permissions = Hash::extract($permissions, '{n}._matchingData.Acos');
//            $permissions = Hash::combine($permissions, '{n}.name', '{n}');
//            $permissions = Hash::sort($permissions, '{s}.name');
//            debug($permissions);die;
            if(!empty($permissions)){
                return true;
            }
            return false;
        }
        return null;
    }

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
        $aco = $this->controller->Aco->Acos->find()
            ->where(['name' => $acoName])->first();
        if(!empty($aco)){
            return $this->__allow($aro, $aco);
        }
        return false;
    }

    public function allowRoles($acoName, $roleNames = [])
    {
        if(!is_array($roleNames)){
            $roleNames = [$roleNames];
        }
        if(!$this->controller->Aco->check($acoName)){
            $this->controller->Aco->add(['name' => $acoName]);
        }
        $Roles = TableRegistry::get('Users.Roles');
        $roles = $Roles->find()->where(['name IN' => $roleNames])->extract('id')->toArray();
        if(!empty($roles)){
            foreach($roles as $key => $roleId){
                $conditions = ['model' => 'roles', 'foreign_key' => $roleId];
                if(!$this->controller->Aro->check($conditions)){
                    $this->controller->Aro->add($conditions);
                }
                if($this->checkRoles($roleId, $acoName)){
                    unset($roles[$key]);
                }
            }
            if(!empty($roles)){
                $aros = $this->controller->Aro->Aros->find()
                    ->where(['model' => 'roles'])
                    ->where(['foreign_key IN' => $roles])->toArray();
                $acos = $this->controller->Aco->Acos->find()
                    ->where(['name LIKE' => $acoName . '%'])->toArray();
                if(!empty($acos) && !empty($aros)){
                    if($this->__allow($aros, $acos)){
                        //find all users with this roles and allow thairs
                        $UsersRoles = TableRegistry::get('Users.UsersRoles');
                        $Roles = TableRegistry::get('Users.Roles');
                        $rolesWithParents = [];
                        foreach($roles as $roleId){
                            //get all parent roles
                            $rolesWithParents[] = Hash::extract(
                                $Roles->find('path', ['for' => $roleId])->toArray(),
                                '{n}.id'
                            );
                        }
                        $rolesWithParents = Hash::extract($rolesWithParents, '{n}.{n}');
                        $roles = array_unique(array_filter($rolesWithParents));
                        //find all users having this roles
                        $users = $UsersRoles->find()->where(['role_id IN' => $roles])->toArray();
                        //allow all users
                        foreach($users as $user){
                            $this->allowUser($acoName, $user->user_id);
                        }
                    }
                }
            }
            return true; //was already added.
        }
        return null;
    }

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
                $data = [
                    'aro_id' => $aro->id,
                    'aco_id' => $aco->id
                ];
                $arosAcosEntity = $ArosAcos->newEntity($data);
                $ArosAcos->save($arosAcosEntity);
            }
        }
        return true;
    }

    public function deny($aco, $userId)
    {

        //select all aro from aros
        //select relatd aco id
        //remove from join table
    }

}
