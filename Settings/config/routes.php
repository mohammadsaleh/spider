<?php
use Cake\Routing\Router;

Router::plugin('Settings', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});
Router::prefix('admin', function ($routes) {
    $routes->plugin('Settings', function ($routes){
        $routes->fallbacks('InflectedRoute');
    });
    $routes->fallbacks('InflectedRoute');
});
