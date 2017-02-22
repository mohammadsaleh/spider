<?php
use Cake\Routing\Router;
use Spider\Lib\SpiderNav;

Router::plugin('Users', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});

Router::scope(SpiderNav::getAdminScope(), ['prefix' => 'admin'], function($routes){
    $routes->connect('/profile', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'profile']);
    $routes->connect('/unlock', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'unlock']);
    $routes->scope('/login', function($routes){
        $routes->connect('/', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'login']);
    });
    $routes->plugin('Users', function ($routes) {
        $routes->fallbacks('InflectedRoute');
    });
});

Router::scope('/', ['plugin' => 'Users', 'controller' => 'Users'], function($routes){
    $routes->connect('/login', ['action' => 'login']);
    $routes->connect('/logout', ['action' => 'logout']);
    $routes->connect('/forgetpass', ['action' => 'forgetPass']);
    $routes->connect('/upload-avatar', ['action' => 'uploadAvatar']);

    $routes->scope('/profile', function($routes){
        $routes->connect('/', ['action' => 'userProfile']);
    });
    $routes->connect('/user-register', ['action' => 'add']);
    $routes->connect('/checkEmail', ['action' => 'checkEmail']);
    $routes->scope('/register', function($routes){
        $routes->connect('/', ['action' => 'add']);
        $routes->connect('/active/*', ['action' => 'active']);
    });
});