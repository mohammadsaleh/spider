<?php
namespace AclManager\Model\Entity;

use Spider\Model\Entity\Spider;

/**
 * Aco Entity.
 */
class Aco extends Spider
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
