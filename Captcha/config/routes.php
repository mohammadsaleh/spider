<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin(
    'Captcha',
    ['path' => '/captcha'],
    function (RouteBuilder $routes) {
        $routes->fallbacks('DashedRoute');
    }
);
