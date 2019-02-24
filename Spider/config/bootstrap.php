<?php
use Cake\Core\Plugin;
use Cake\I18n\I18n;
use Cake\Network\Request;
use Spider\Lib\Hook;
use Spider\Lib\Spider;
use Spider\Lib\SpiderPlugin;
use Cake\Core\Configure;
use Cake\Utility\Hash;

Hook::component('*', 'Spider.Spider');
Hook::helper('*', 'Spider.Spider');
Hook::configFile('*', 'events');

Request::addDetector(
    'chrome',
    ['env' => 'HTTP_USER_AGENT', 'pattern' => '/Chrome/i']
);

/**
 * List of core plugins
 */
$corePlugins = [
    'Spider',
    'Settings',
    'Captcha',
    'AclManager',
    'PluginManager',
    'Users',
    'Search',
];
Configure::write('Spider.corePlugins', $corePlugins);