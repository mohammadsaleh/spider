<?php
namespace Settings\Controller\Admin;

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
        if($settings = $this->request->data('settings')){
            foreach(Hash::flatten($settings) as $key => $setting){
                Settings::save($key, ['value' => $setting]);
            }
        }
        $settings = Settings::find('site', false);
        $this->request->data['settings'] = Hash::combine($settings, '{n}.name', '{n}.value');
        $this->request->data = Hash::expand(Hash::flatten($this->request->data));
        $this->set(compact('settings'));
//        debug($settings);die;
    }

}
