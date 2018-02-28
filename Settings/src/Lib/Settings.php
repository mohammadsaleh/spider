<?php
namespace Settings\Lib;

use Cake\Datasource\ConnectionManager;
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
        $conn = ConnectionManager::get('default');
        $query = $conn->newQuery();
        $query->select('*')->from('spider_settings_settings');
        if($checkUserId){
            $query->where(['created_by' => $userId]);
        }
        $settings = $query->where(['name LIKE' => $key . '%'])
            ->orderDesc('weight')
            ->execute()
            ->fetchAll('assoc');
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
        $conn = ConnectionManager::get('default');
        $query = $conn->newQuery();
        $settings = $query->select('*')
            ->from('spider_settings_settings')
            ->where(['id' => $id])
            ->execute()
            ->fetch('assoc');
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
        $conn = ConnectionManager::get('default');
        $data['created_by'] = $userId ? $userId : ((Router::getRequest() && Router::getRequest()->session()->read('Auth.User.id')) ? Router::getRequest()->session()->read('Auth.User.id') :  null);
        $data['name'] = $key;
        if($exist = self::find($key, $userId)){
            $data = array_merge(array_shift($exist), $data);
            $id = $data['id'];
            unset($data['id']);
            $data['updated'] = date('Y-m-d H:i:s');
            $conn->update('spider_settings_settings', $data, ['id' => $id]);
            return $data;
        }else{
            $data['created'] = date('Y-m-d H:i:s');
        }
        if($conn->insert('spider_settings_settings', $data)){
            return $data;
        }
        return false;
    }
}