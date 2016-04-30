<?php
namespace Users\Model\Entity;

use Spider\Model\Entity\Spider;

/**
 * Role Entity.
 */
class Role extends Spider
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'lft' => false,
        'rght' => false,
        'id' => false,
    ];
}
