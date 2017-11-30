<?php
namespace Settings\Event;
/**
 * Created by PhpStorm.
 * User: MohammadSaleh
 * Date: 5/15/2017
 * Time: 11:36 AM
 */

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Http\ServerRequestFactory;
use Cake\Routing\Router;
use Settings\Lib\Settings;
use Settings\Middleware\MaintenanceMiddleware;
use Spider\Lib\SpiderNav;


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
        $request = ServerRequestFactory::fromGlobals();
        $currentUrl = $request->url;
        $adminScope = trim(SpiderNav::getAdminScope(), '/');
        if(strpos($currentUrl, $adminScope) === 0){
            return true;
        }

        Configure::write('Site.enable', $this->__getSiteStatus());
        $middleware = $event->getData('middleware');
        $redirectUrl = Router::url(MAINTENANCE_URL);

        if($redirectUrl != Router::url($request->getRequestTarget())){
            $middleware->add(new MaintenanceMiddleware([
                    'config' => [
                        'url' => MAINTENANCE_URL,
                        'code' => 303,
                    ]

            ]));
        }
    }

    private function __getSiteStatus()
    {
        $conn = ConnectionManager::get('default');
        $newQuery = $conn->newQuery();
        $siteStatus = $newQuery
            ->select('value')
            ->from('spider_settings_settings')
            ->where(['name' => 'site.status'])
            ->execute()
            ->fetch('assoc');
        return (!empty($siteStatus) && ($siteStatus['value'] == 'offline')) ? false : true;
    }
}