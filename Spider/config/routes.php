<?php
use Cake\Routing\Router;
use Spider\Lib\SpiderNav;

//todo:: best is that dashboard url would be set on admin settings.
SpiderNav::add('sidebar', 'Dashboard' ,[
    'title' => __d('spider', 'Dashboard'),
    'url' => SpiderNav::getDashboardUrl(),
    'icon' => 'fa fa-home',
    'weight' => -10
]);

Router::plugin('Spider', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});

Router::scope(SpiderNav::getAdminScope(), ['prefix' => 'admin'], function($routes){
    $routes->connect('/', SpiderNav::getDashboardUrl());
    $routes->plugin('Spider', function ($routes) {
        $routes->fallbacks('InflectedRoute');
    });
});