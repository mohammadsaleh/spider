<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Spider\Lib\SpiderNav;

Router::plugin(
    'AclManager',
    ['path' => '/acl-manager'],
    function (RouteBuilder $routes) {
        $routes->fallbacks('DashedRoute');
    }
);

Router::scope(SpiderNav::getAdminScope(), ['prefix' => 'admin'], function($routes){
    $routes->scope('/access', ['plugin' => 'AclManager'], function($routes){
        $routes->connect('/sync',['controller' => 'Permissions', 'action' => 'sync']);
        $routes->connect('/permissions/r-:id/*',['controller' => 'Permissions', 'action' => 'index'], ['pass' => ['id']]);
//        $routes->connect('/permissions/u-:id/*',['controller' => 'Permissions', 'action' => 'index'], ['pass' => ['id']]);
        $routes->connect('/list/*',['controller' => 'Permissions', 'action' => 'acoList']);
    });
    $routes->plugin('AclManager', function ($routes) {
        $routes->fallbacks('InflectedRoute');
    });
});