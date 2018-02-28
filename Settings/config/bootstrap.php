<?php
define('MAINTENANCE_URL', '/maintenance.html');

\Cake\Event\EventManager::instance()->on(
    'Server.buildMiddleware',
    function ($event, $middlewareQueue) {
        $middlewareQueue->insertAfter(
            'Cake\Routing\Middleware\AssetMiddleware',
            new \Settings\Middleware\MaintenanceMiddleware
        );
    }
);

\Spider\Lib\SpiderNav::add('sidebar', 'Settings', [
    'title' => __d('settings', 'Settings'),
    'icon' => 'fa fa-wrench',
    'url' => '#',
    'children' => [
        'setting' => [
            'title' => __d('settings', 'Site'),
            'url' => ['plugin' => 'settings', 'controller' => 'settings', 'action' => 'index']
        ]
    ]
]);