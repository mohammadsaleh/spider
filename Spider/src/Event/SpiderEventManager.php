<?php
namespace Spider\Event;
use Cake\Cache\Cache;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\EventManager;
use Cake\Log\Log;

/**
 * Created by PhpStorm.
 * User: Mohammad Saleh
 * Date: 9/1/2015
 * Time: 7:08 PM
 */
class SpiderEventManager
{

    public static function loadListeners() {
        Configure::load('Spider.events');
        $eventManager = EventManager::instance();

        $cached = Cache::read('EventHandlers', 'default');
        if ($cached === false) {
            $eventHandlers = Configure::read('EventHandlers');
            $validKeys = array('eventKey' => null, 'options' => array());
            $cached = array();
            if (!empty($eventHandlers) && is_array($eventHandlers)) {
                foreach ($eventHandlers as $eventHandler => $eventOptions) {
                    $eventKey = null;
                    if (is_numeric($eventHandler)) {
                        $eventHandler = $eventOptions;
                        $eventOptions = array();
                    }
                    list($plugin, $class) = pluginSplit($eventHandler);
                    if (!empty($eventOptions)) {
                        extract(array_intersect_key($eventOptions, $validKeys));
                    }
                    if (isset($eventOptions['options']['className'])) {
                        list($plugin, $class) = pluginSplit($eventOptions['options']['className']);
                    }
                    if (class_exists('\\'.$plugin.'\\Event\\'.$class)) {
                        $cached[] = compact('plugin', 'class', 'eventKey', 'eventOptions');
                    } else {
                        Log::error(__d('croogo', 'EventHandler %s not found in plugin %s', $class, $plugin));
                    }
                }
                Cache::write('EventHandlers', $cached, 'default');
            }
        }
        foreach ($cached as $cache) {
            extract($cache);
            if (Plugin::isLoaded($plugin)) {
                $settings = isset($eventOptions['options']) ? $eventOptions['options'] : array();
                $namespace = '\\'.$plugin.'\\Event\\'.$class;
                $listener = new $namespace($settings);
                $eventManager->on($listener, $eventKey, $eventOptions);
            }
        }
    }
}