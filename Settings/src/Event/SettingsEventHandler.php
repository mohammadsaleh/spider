<?php
namespace Settings\Event;
/**
 * Created by PhpStorm.
 * User: MohammadSaleh
 * Date: 5/15/2017
 * Time: 11:36 AM
 */

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Routing\Router;
use Settings\Middleware\MaintenanceMiddleware;


class SettingsEventHandler implements EventListenerInterface
{
    public function implementedEvents()
    {
        return [
            'Server.buildMiddleware' => 'onMiddleware'
        ];
    }

    public function onMiddleware(Event $event)
    {
        $status = false;
        Configure::write('Site.enable', $status);
        $middleware = $event->getData('middleware');
        $redirectUrl = Router::url('/maintenance.html', true);
        $hereUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        if($redirectUrl != $hereUrl ){
            $middleware->add(new MaintenanceMiddleware([
                    'config' => [
                        'url' => Router::url('/maintenance.html', true),
                        'code' => 303,
                    ]

            ]));
        }
    }
}