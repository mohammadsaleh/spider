<?php
use Cake\Routing\Router;
use Spider\Lib\SpiderNav;

Router::plugin('Spider', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});

Router::prefix('admin', function ($routes) {
    $routes->connect('/', SpiderNav::getDashboardUrl());

    $routes->plugin('Spider', function ($routes) {
        $routes->fallbacks('InflectedRoute');
    });
    $routes->fallbacks('InflectedRoute');
});