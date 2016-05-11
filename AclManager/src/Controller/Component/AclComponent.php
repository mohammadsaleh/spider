<?php
namespace AclManager\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

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

    public function __call($name, $args = [])
    {
        if(strpos($name, 'check') === 0){
//            $this->{'check' . }()
        }
    }

    public function check($groupId, $userId, $aco)
    {

    }

    public function allow($aco, $aro)
    {

    }

    public function deny($aco, $aro)
    {

    }

}
