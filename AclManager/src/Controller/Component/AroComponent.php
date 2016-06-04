<?php
namespace AclManager\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

/**
 * Aro component
 */
class AroComponent extends Component
{

    public $Aros = null;
    public $controller = null;

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->Aros = TableRegistry::get('AclManager.Aros');
        $this->controller = $this->_registry->getController();
    }
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * Add an aro
     * @param $aroInfo
     * @return bool
     */
    public function add($aroInfo)
    {
        $aroEntity = $this->Aros->newEntity($aroInfo);
        if($this->Aros->save($aroEntity)){
            return $aroEntity;
        }
        return false;
    }

    public function remove($aro)
    {

    }

    /**
     * Get aro base on userId
     * @param $userId
     * @return mixed
     */
    public function getUser($userId)
    {
        $aroInfo = ['model' => 'users', 'foreign_key' => $userId];
        if(!$this->check($aroInfo)){
            $this->add($aroInfo);
        }
        return $this->_getAros(['user_id' => $userId])->first();
    }

    /**
     * Get aro base on roleId
     * @param $roleId
     * @param bool|true $own : if true return it's own aro too
     * @param bool|false $parents : if true return it's parents aro too
     * @return mixed
     */
    public function getRole($roleId, $own = true, $parents = false)
    {
        $aroInfo = ['model' => 'users', 'foreign_key' => $roleId];
        if(!$this->check($aroInfo)){
            $this->add($aroInfo);
        }
        $roleAro = $this->_getAros(['role_id' => $roleId, 'own' => $own, 'parents' => $parents]);
        if($own && !$parents){
            return $roleAro->first();
        }
        return $roleAro->toArray();
    }

    /**
     * Getting all permission related to given aro entity
     * @param Entity $aro
     * @return array|mixed
     */
    public function getPermissions($aro)
    {
        if(empty($aro)){
            return [];
        }
        if(!is_array($aro)){
            $aro = [$aro];
        }

        $permissions = $this->Aros->find()
            ->contain(['Acos'])
            ->where(['id IN' => Hash::extract($aro, '{n}.id')])->toArray();
        $permissions = Hash::extract($permissions, '{n}.acos');
        $permissions = Hash::combine($permissions, '{n}.{n}.name', '{n}.{n}');
        $permissions = Hash::sort($permissions, '{s}.name');
//        $permissions = Hash::expand($permissions, '/');
        return $permissions;
    }

    /**
     * Getting related aros base on given role_id or user_id
     * @param array $options: set parent=false to not return parents aros.
     * @return mixed
     */
    protected function _getAros($options = [])
    {
        $options = array_merge([
            'parents' => true,
            'own' => true,
            'role_id' => null,
            'user_id' => null
        ], $options);

        $aro = $this->Aros->find();
        if($options['user_id']){
            $aro->where(['model' => 'users']);
            $aro->where(['foreign_key IN' => $options['user_id']]);

        }elseif($options['role_id']){
            $roles = TableRegistry::get('AclManager.Roles');

            if($options['parents']){
                $roleIds = $roles->find('path', ['for' => $options['role_id']])->extract('id')->toArray();
                if(!$options['own']){
                    $key = array_search($options['role_id'], $roleIds);
                    unset($roleIds[$key]);
                }
            }else{
                $roleIds = $roles->find()->where(['id' => $options['role_id']])->extract('id')->toArray();
            }

            $aro->where(['model' => 'roles']);
            $aro->where(['foreign_key IN' => $roleIds]);
        }
        return $aro;
    }

    /**
     * Check if exist aro or not
     * @param array $conditions
     * @return bool
     */
    public function check($conditions = [])
    {
        if(!empty($conditions)){
            $conditions = array_merge([
                'model' => null,
                'foreign_key' => null
            ], $conditions);
        }
        $aro = $this->Aros->find()->where($conditions)->first();
        if(!empty($aro)){
            return $aro->id;
        }
        return false;
    }
}
