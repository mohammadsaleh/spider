<?php
use Cake\Routing\Router;

$request = Router::getRequest();

Router::connect('/install', ['plugin'=>'Install','controller'=>'Install','action'=>'index']);
Router::connect('/database', ['plugin'=>'Install','controller'=>'Install','action'=>'database']);
Router::connect('/data', ['plugin'=>'Install','controller'=>'Install','action'=>'data']);
Router::connect('/adminuser', ['plugin'=>'Install','controller'=>'Install','action'=>'adminuser']);
Router::connect('/finish', ['plugin'=>'Install','controller'=>'Install','action'=>'finish']);

