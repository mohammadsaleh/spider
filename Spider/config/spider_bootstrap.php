<?php
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Event\EventManager;
use Cake\Log\Log;
use Cake\Utility\Inflector;
use Spider\Event\SpiderEventManager;
use Spider\Lib\SpiderPlugin;
use Spider\Lib\Spider;
use Cake\Core\Plugin;

//(new EventManager())->dispatch('Spider.bootstrap.start');
//
//if (!Configure::check('Spider.installed')) {
//    return Plugin::load('Install', ['bootstrap' => true, 'routes' => true, 'autoload' => true]);
//}

/**
 * List of core plugins
 */
$corePlugins = [
    'Spider/Settings',
    'Spider/Captcha',
    'Spider/AclManager',
    'Spider/PluginManager',
    'Spider/Users',
    'Spider/Search',
];
Configure::write('Core.corePlugins', $corePlugins);

if(!Configure::check('Hook.plugins')){
    Configure::write('Hook.plugins', Configure::read('Core.corePlugins'));
}
$plugins = Spider::mergeConfig('Hook.plugins', \Cake\Utility\Hash::extract(SpiderPlugin::getPlugins(), '{n}.name'));
//Configure::read('App.paths.plugins');

foreach ($plugins as $plugin) {
    $pluginName = Inflector::camelize($plugin);
    $pluginPath = APP . 'plugins' . DS . $pluginName;

    if ((!file_exists($pluginPath)) && (strpos($pluginName, 'Spider/') === false)) {
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
        str_replace('Spider/', '', $pluginName) => array(
            'bootstrap' => true,
            'routes' => true,
            'autoload' => true,
            'ignoreMissing' => true,
        )
    );
    SpiderPlugin::load($option);
}
SpiderEventManager::loadListeners();
(new EventManager())->dispatch('Spider.bootstrap.complete');
