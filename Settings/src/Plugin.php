<?php

namespace Settings;

use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\PluginApplicationInterface;
use Cake\Datasource\ConnectionManager;
use Settings\Middleware\MaintenanceMiddleware;

/**
 * Plugin for Spider
 */
class Plugin extends BasePlugin
{

    public function bootstrap(PluginApplicationInterface $app)
    {
        parent::bootstrap($app);
        Configure::write('Site.enable', $this->__getSiteStatus());
    }

    public function middleware($middleware)
    {
        $middleware->insertAfter('Cake\Routing\Middleware\AssetMiddleware', new MaintenanceMiddleware);
        return $middleware;
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
