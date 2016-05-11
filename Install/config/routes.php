<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin(
    'Install',
    ['path' => '/install'],
    function (RouteBuilder $routes) {
        $routes->fallbacks('DashedRoute');
    }
);
