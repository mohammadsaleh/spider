<?php
\Spider\Lib\SpiderNav::add('sidebar', 'Settings', [
    'title' => __d('settings', 'Settings'),
    'icon' => 'fa fa-wrench',
    'url' => '#',
    'children' => [
        'setting' => [
            'title' => __d('settings', 'Site'),
            'url' => ['plugin' => 'settings', 'controller' => 'settings', 'action' => 'index']
        ]
    ]
]);