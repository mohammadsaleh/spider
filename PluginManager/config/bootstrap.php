<?php
\Spider\Lib\SpiderNav::add('sidebar', 'PluginManager' ,[
    'title' => __d('plugin_manager', 'Extensions'),
    'url' => '#',
    'icon' => 'fa fa-plug',
    'weight' => 10,
    'children' => [
        'plugins' => [
            'title' => __d('plugin_manager', 'Plugins'),
            'icon' => '',
            'url' => ['plugin' => 'PluginManager', 'controller' => 'plugins', 'action' => 'index']
        ],
        'templates' => [
            'title' => __d('plugin_manager', 'Templates'),
            'icon' => '',
            'url' => ['plugin' => 'PluginManager', 'controller' => 'plugins', 'action' => 'index', 'theme']
        ]
    ]
]);