<?php

namespace Spider\Middleware;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Core\PluginApplicationInterface;
use Cake\Event\EventManager;
use Cake\Utility\Hash;
use Spider\Event\SpiderEventManager;
use Spider\Lib\Hook;


/**
 * Middleware responsible of intercepting request to
 * deal with the application being under maintenance
 */
class SpiderMiddleware
{

    public function __invoke($request, $response, $next)
    {
        $corePlugins = Configure::read('Spider.corePlugins');
        $nonCorePlugins = [];
        foreach (Plugin::getCollection() as $plugin){
            if(!in_array($plugin->getName(), $corePlugins)){
                array_push($nonCorePlugins, $plugin->getName());
            }
        }
        $plugins = array_merge($corePlugins, $nonCorePlugins);
        $requestedPlugin = $request->getParam('plugin');

        //Remove Spider Plugin from list
        array_shift($plugins);
        foreach($plugins as $pluginName){
            if(Plugin::loaded($pluginName)){
                Cache::delete('EventHandlers', 'default');
                Hook::applyHookConfigFiles('Hook.config_files', $pluginName);
            }
        }

        SpiderEventManager::loadListeners();
        (new EventManager())->dispatch('Spider.bootstrap.complete');

        $response = $next($request, $response);
        return $response;
    }

}
