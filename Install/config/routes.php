<?php
use Cake\Routing\Router;

$request = Router::getRequest();

Router::connect('/install', ['plugin'=>'Install','controller'=>'Install','action'=>'index']);

