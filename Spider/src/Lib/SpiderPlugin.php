<?php
namespace Spider\Lib;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;


class SpiderPlugin
{
    /**
     * Get plugin list from database
     */
    public static function getPlugins(){
        $conn = ConnectionManager::get('default');
        $newQuery = $conn->newQuery();
        $plugins = $newQuery
            ->select('*')
            ->from('spider_plugins_plugins')
            ->where(['status' => 1])
            ->order(['weight ASC'])
            ->execute()
            ->fetchAll('assoc');
        return $plugins;
    }
}