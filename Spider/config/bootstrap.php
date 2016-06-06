<?php
use Cake\Core\Plugin;
use Cake\I18n\I18n;
use Spider\Lib\SpiderNav;
use Cake\Network\Request;
use Spider\Lib\Hook;

Hook::component('*', 'Spider.Spider');
Hook::helper('*', 'Spider.Spider');
Hook::configFile('*', 'events');

Request::addDetector(
    'chrome',
    ['env' => 'HTTP_USER_AGENT', 'pattern' => '/Chrome/i']
);


SpiderNav::add('sidebar', 'Dashboard' ,[
    'title' => __d('spider', 'Dashboard'),
    'url' => SpiderNav::getDashboardUrl(),
    'icon' => 'fa fa-home',
    'weight' => -10
]);

I18n::locale('fa_IR');
Plugin::load('BootstrapUI');

require_once 'spider_bootstrap.php';
