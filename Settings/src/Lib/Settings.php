<?php
namespace Settings\Lib;

use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Hash;

class Settings
{

    /**
     * Find setting of given key
     * @param $key
     * @param null $userId : null = current user id, false = any user, [integer] = given user id
     * @return array|null
     */
    public static function find($key, $userId = null)
    {
        if(!$userId){
            if(is_null($userId) && !($userId = Router::getRequest()->session()->read('Auth.User.id'))){
                return null;
            }
        }
        $checkUserId = ($userId === false) ? false : true;
        $Settings = TableRegistry::get('Settings.Settings');
        $query = $Settings->find('all');
        if($checkUserId){
            $query->where(['created_by' => $userId]);
        }
        $settings = $query->where(['name LIKE' => $key . '%'])
            ->orderDesc('weight')
            ->toArray();
        if(!empty($settings)){
            $settings = Hash::expand($settings);
        }
        return $settings;
    }

    /**
     * Get value for given setting id
     * @param $id
     * @return array|mixed
     */
    public static function get($id)
    {
        $Settings = TableRegistry::get('Settings.Settings');
        $settings = $Settings->find()->where(['id' => $id])->first();
        if(!empty($settings)){
            $settings = Hash::combine([$settings], '{n}.name', '{n}.value');
            $settings = Hash::expand($settings);
        }
        return $settings;
    }

    /**
     * Save setting data.
     * @param $key
     * @param $data
     * @param $userId: if == false, ignore checking key for the user
     * @return bool|\Cake\Datasource\EntityInterface|\Cake\ORM\Entity
     */
    public static function save($key, $data, $userId = false)
    {
        $Settings = TableRegistry::get('Settings.Settings');
        $data['created_by'] = Router::getRequest()->session()->read('Auth.User.id') ?: null;
        $data['name'] = $key;
        if($exist = self::find($key, $userId)){
            $setting = $Settings->patchEntity(array_shift($exist), $data);
        }else{
            $setting = $Settings->newEntity($data);
        }
//        debug($setting);die;
        if($Settings->save($setting)){
            return $setting;
        }
        return false;
    }
}