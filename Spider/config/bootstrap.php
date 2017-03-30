<?php
use Cake\Core\Plugin;
use Cake\I18n\I18n;
use Cake\Network\Request;
use Spider\Lib\Hook;

Hook::component('*', 'Spider.Spider');
Hook::helper('*', 'Spider.Spider');
Hook::configFile('*', 'events');

Request::addDetector(
    'chrome',
    ['env' => 'HTTP_USER_AGENT', 'pattern' => '/Chrome/i']
);

Plugin::load('BootstrapUI');

require_once 'spider_bootstrap.php';
