<?php
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Event\EventManager;
use Cake\Log\Log;
use Cake\Utility\Inflector;
use Spider\Event\SpiderEventManager;
use Spider\Lib\SpiderPlugin;

/**
 * Plugins
 */
Configure::write('Core.plugins', [
    'Settings','PluginManager','Metronic','Users','Messages'
]);

if(!Configure::check('Hook.plugins')){
    Configure::write('Hook.plugins', SpiderPlugin::getPlugins());
}
$plugins = Configure::read('Hook.plugins');

foreach ($plugins as $plugin) {
    $pluginName = Inflector::camelize($plugin['name']);
    $pluginPath = ROOT . 'plugins' . DS . $pluginName;
//    if (!file_exists($pluginPath)) {
//        $pluginFound = false;
//        foreach (App::path('Plugin') as $path) {
//            if (is_dir($path . $pluginName)) {
//                $pluginFound = true;
//                break;
//            }
//        }
//        if (!$pluginFound) {
//            Log::error('Plugin not found during bootstrap: ' . $pluginName);
//            continue;
//        }
//    }
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