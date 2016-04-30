<?php
namespace PluginManager\Model\Entity;

use Spider\Model\Entity\Spider;

/**
 * Plugin Entity.
 */
class Plugin extends Spider
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
