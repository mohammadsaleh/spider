<?php
use Cake\Routing\Router;

$request = Router::getRequest();

Router::connect('/install', ['plugin'=>'Install','controller'=>'Install','action'=>'index']);
Router::connect('/database', ['plugin'=>'Install','controller'=>'Install','action'=>'database']);

