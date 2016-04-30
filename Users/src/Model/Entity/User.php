<?php
namespace Users\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Spider\Model\Entity\Spider;

/**
 * User Entity.
 */
class User extends Spider
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
        'confirm_password' => true
    ];

    protected function _getFullName(){
        return $this->_properties['firstname'] . ' ' . $this->_properties['lastname'];
    }

    protected function _setPassword($password){
        return (new DefaultPasswordHasher())->hash($password);
    }
}
