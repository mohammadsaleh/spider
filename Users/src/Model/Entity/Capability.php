<?php
namespace Users\Model\Entity;

use Spider\Model\Entity\Spider;

/**
 * Capability Entity.
 */
class Capability extends Spider
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
