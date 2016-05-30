<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin(
    'AclManager',
    ['path' => '/acl-manager'],
    function (RouteBuilder $routes) {
        $routes->fallbacks('DashedRoute');
    }
);
Router::prefix('admin', function ($routes) {
    $routes->scope('/access', ['plugin' => 'AclManager'], function($routes){
        $routes->connect('/sync',['controller' => 'Permissions', 'action' => 'sync']);
        $routes->connect('/list/*',['controller' => 'Permissions', 'action' => 'acoList']);
    });
    $routes->plugin('AclManager', function ($routes){
        $routes->fallbacks('InflectedRoute');
    });
    $routes->fallbacks('InflectedRoute');
});