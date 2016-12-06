<?php
use Cake\Routing\Router;
use Spider\Lib\SpiderNav;

Router::plugin('PluginManager', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});

Router::scope(SpiderNav::getAdminScope(), ['prefix' => 'admin'], function($routes){
    $routes->plugin('PluginManager', function ($routes){
        $routes->fallbacks('InflectedRoute');
    });
});
