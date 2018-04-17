<?php
namespace Settings\Controller\Admin;

use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Settings\Controller\AppController;
use Settings\Lib\Settings;

/**
 * Settings Controller
 *
 * @property \Settings\Model\Table\SettingsTable $Settings
 */
class SettingsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $Settings = TableRegistry::get('Settings.Settings');
        if($settings = $this->getRequest()->getData('settings')){
            foreach(Hash::flatten($settings) as $key => $setting){
                Settings::save($key, ['value' => $setting]);
            }
        }
        $settings = $Settings->find('all')
            ->where(['editable' => 1])
            ->orderDesc('weight')
            ->toArray();
        $this->setRequest($this->getRequest()->withData('settings', Hash::combine($settings, '{n}.name', '{n}.value')));
        $this->set(compact('settings'));
    }

}
