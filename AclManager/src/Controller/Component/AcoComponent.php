<?php
namespace AclManager\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

/**
 * Aco component
 */
class AcoComponent extends Component
{

    public $Acos = null;
    public $controller = null;

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->Acos = TableRegistry::get('AclManager.Acos');
        $this->controller = $this->_registry->getController();
    }
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function check($name)
    {
        $aco = $this->Acos->find()->where(['name' => $name])->first();
        if(!empty($aco)){
            return $aco->id;
        }
        return false;
    }

    public function add($acoInfo)
    {
        $acoEntity =$this->Acos->newEntity($acoInfo);
        if($this->Acos->save($acoEntity)){
            return true;
        }
        return false;
    }

    public function remove($aco)
    {

    }

    /**
     * Getting all aco records as tree
     * @return array
     */
    public function getAll()
    {
        $acos = $this->Acos->find()->toArray();
        $acos = Hash::combine($acos, '{n}.name', '{n}');
        ksort($acos);
//        $acos = Hash::expand($acos, '/');
        return $acos;
    }
}
