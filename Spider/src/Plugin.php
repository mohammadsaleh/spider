<?php

namespace Spider\Spider;

use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\PluginApplicationInterface;

/**
 * Plugin for Spider
 */
class Plugin extends BasePlugin
{
    /**
     * Plugin name.
     *
     * @var string
     */
    protected $name = 'Spider';

    public function bootstrap(PluginApplicationInterface $app)
    {
        debug('aaaaaaa');die;
        parent::bootstrap($app);

        $plugins = Configure::read('App.paths.plugins');
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
    }
}
