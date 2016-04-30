<?php
use Cake\Routing\Router;

Router::plugin('PluginManager', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});

Router::prefix('admin', function ($routes) {
    $routes->plugin('PluginManager', function ($routes){
        $routes->fallbacks('InflectedRoute');
    });
    $routes->fallbacks('InflectedRoute');
});
