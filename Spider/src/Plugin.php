<?php

namespace Spider;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use Settings\Middleware\MaintenanceMiddleware;
use Spider\Middleware\SpiderMiddleware;

/**
 * Plugin for Spider
 */
class Plugin extends BasePlugin
{

    public function bootstrap(PluginApplicationInterface $app)
    {
        parent::bootstrap($app);

        $app->addPlugin('Settings', ['bootstrap' => true, 'routes' => true]);
        $app->addPlugin('Captcha', ['bootstrap' => true, 'routes' => true]);
        $app->addPlugin('AclManager', ['bootstrap' => true, 'routes' => true]);
        $app->addPlugin('PluginManager', ['bootstrap' => true, 'routes' => true]);
        $app->addPlugin('Users', ['bootstrap' => true, 'routes' => true]);
        $app->addPlugin('Search', ['bootstrap' => true, 'routes' => true]);
    }

    public function middleware($middleware)
    {
        $middleware->insertAfter(MaintenanceMiddleware::class, new SpiderMiddleware);
        return $middleware;
    }
}
