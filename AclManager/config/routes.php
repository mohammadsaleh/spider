<?php
use Cake\Routing\Router;

Router::plugin('AclManager', function ($routes) {
    $routes->fallbacks('DashedRoute');
});
Router::prefix('admin', function($routes){
    $routes->plugin('AclManager', function($routes){
        $routes->fallbacks('InflectedRoute');
    });
    $routes->fallbacks('InflectedRoute');
});