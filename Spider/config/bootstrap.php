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

//Plugin::load('BootstrapUI');

/**
 * List of core plugins
 */
$corePlugins = [
    'Spider/Settings',
    'Spider/Captcha',
    'Spider/AclManager',
    'Spider/PluginManager',
    'Spider/Users',
    'Spider/Search',
];
Configure::write('Core.corePlugins', $corePlugins);

if(!Configure::check('Hook.plugins')){
    Configure::write('Hook.plugins', Configure::read('Core.corePlugins'));
}
Spider::mergeConfig('Hook.plugins', Hash::extract(SpiderPlugin::getPlugins(), '{n}.name'));