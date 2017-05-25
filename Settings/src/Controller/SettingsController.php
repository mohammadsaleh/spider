<?php
namespace Settings\Controller;

use Settings\Controller\AppController;

/**
 * Settings Controller
 *
 * @property \Settings\Model\Table\SettingsTable $Settings
 *
 * @method \Settings\Model\Entity\Setting[] paginate($object = null, array $settings = [])
 */
class SettingsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow('maintenance');
    }

    public function maintenance()
    {
        //debug('aaaaaaaa');die;
    }
}
