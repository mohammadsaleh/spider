<?php
use Cake\Routing\Router;
use Spider\Lib\SpiderNav;

Router::plugin('Settings', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});
Router::scope(SpiderNav::getAdminScope(), ['prefix' => 'admin'], function($routes){
    $routes->plugin('Settings', function ($routes){
        $routes->fallbacks('InflectedRoute');
    });
});

Router::connect('/maintenance.html', ['plugin' => 'Settings', 'controller' => 'Settings', 'action' => 'maintenance']);
