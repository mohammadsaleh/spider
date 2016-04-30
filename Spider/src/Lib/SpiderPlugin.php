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
            ->from('plugins')
            ->where(['status' => 1])
            ->order(['weight ASC'])
            ->execute()
            ->fetchAll('assoc');
        return $plugins;
    }

    /**
     * Loads a plugin and optionally loads bootstrapping and routing files.
     *
     * This method is identical to CakePlugin::load() with extra functionality
     * that loads event configuration when Plugin/Config/events.php is present.
     *
     * @see CakePlugin::load()
     * @param mixed $plugin name of plugin, or array of plugin and its config
     * @return void
     */
    public static function load($plugin, $config = array()) {
        Plugin::load($plugin, $config);
        if (is_string($plugin)) {
            $plugin = array($plugin => $config);
        }
        Cache::delete('EventHandlers', 'default');
        foreach ($plugin as $name => $conf) {
            list($name, $conf) = (is_numeric($name)) ? array($conf, $config) : array($name, $conf);
            $file = Plugin::path($name) . 'config' . DS . 'events.php';
            if (file_exists($file)) {
                Configure::load($name . '.events');
            }
        }
    }
}