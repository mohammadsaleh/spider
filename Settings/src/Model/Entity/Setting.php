<?php
namespace Settings\Model\Entity;

use Spider\Model\Entity\Spider;

/**
 * Setting Entity.
 */
class Setting extends Spider
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
