<?php
use Cake\Routing\Router;

$request = Router::getRequest();
if (strpos($request->url, 'install') === false) {
    $url = ['plugin' => 'install', 'controller' => 'install'];    
    Router::connect('/', $url);
    Router::connect('/database', ['plugin' => 'install', 'controller' => 'install','action'=>'database']);
}