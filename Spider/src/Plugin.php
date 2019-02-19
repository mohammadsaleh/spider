<?php

namespace Spider;

use Cake\Core\App;
use Cake\Core\BasePlugin;
use Cake\Core\ClassLoader;
use Cake\Core\Configure;
use Cake\Core\PluginApplicationInterface;
use Cake\Core\PluginCollection;
use Cake\Event\EventManager;
use Cake\Log\Log;
use Cake\Utility\Inflector;
use Spider\Event\SpiderEventManager;

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
        parent::bootstrap($app);

        $plugins = Configure::read('Hook.plugins');
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
            $pluginName = str_replace('Spider/', '', $pluginName);
            $configs = [
                'bootstrap' => true,
                'routes' => true,
                'ignoreMissing' => true,
            ];
            $app->addPlugin($pluginName, $configs);
            $this->__autoLoadPlugin($pluginName);
        }
        SpiderEventManager::loadListeners();
        (new EventManager())->dispatch('Spider.bootstrap.complete');
    }

    /**
     * Loading Spider Plugin
     */
    private function __autoLoadPlugin($pluginName)
    {
        $path = (new PluginCollection())->findPath($pluginName);
        $loader = (new ClassLoader());
        $loader->register();
        $loader->addNamespace(
            $pluginName,
            $path . 'src' . DIRECTORY_SEPARATOR
        );
        $loader->addNamespace(
            $pluginName . '\Test',
            $path. 'tests' . DIRECTORY_SEPARATOR
        );
    }
}
