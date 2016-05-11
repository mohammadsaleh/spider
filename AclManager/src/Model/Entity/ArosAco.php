<?php
namespace AclManager\Model\Entity;

use Spider\Model\Entity\Spider;

/**
 * ArosAco Entity.
 */
class ArosAco extends Spider
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
