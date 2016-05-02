<?php
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Event\EventManager;
use Cake\Log\Log;
use Cake\Utility\Inflector;
use Spider\Event\SpiderEventManager;
use Spider\Lib\SpiderPlugin;

/**
 * List of core plugins
 */
$corePlugins = [
    'Spider/Settings',
    'Spider/AclManager',
    'Spider/PluginManager',
    'Spider/Users',
];
Configure::write('Core.corePlugins', $corePlugins);

if(!Configure::check('Hook.plugins')){
    Configure::write('Hook.plugins', SpiderPlugin::getPlugins());
}
$plugins = Configure::read('Hook.plugins');

//Configure::read('App.paths.plugins');

foreach ($plugins as $plugin) {
    $pluginName = Inflector::camelize($plugin['name']);
    $pluginPath = APP . 'plugins' . DS . $pluginName;
//    debug(App::path('Plugin'));die;
//    debug($pluginPath);die;
//debug($plugin);die;
    if ((!file_exists($pluginPath))) {
        $pluginFound = false;
        foreach (App::path('Plugin') as $path) {
            if (is_dir($path . $pluginName)) {
                $pluginFound = true;
                break;
            }
        }
        if (!$pluginFound) {
            Log::error('Plugin not found during bootstrap: ' . $pluginName);
            continue;
        }
    }
    $option = array(
        $pluginName => array(
            'bootstrap' => true,
            'routes' => true,
            'autoload' => true,
            'ignoreMissing' => true,
        )
    );
    SpiderPlugin::load($option);
}
SpiderEventManager::loadListeners();
(new EventManager())->dispatch('Spider.bootstrap.Complete');