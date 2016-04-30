<?php
use Cake\Core\Plugin;

\Spider\Lib\SpiderNav::add('sidebar', 'Users' , [
    'title' => __d('users', 'Users'),
    'url' => '#',
    'icon' => 'icon-user',
    'weight' => 10,
    'children' => [
        'users_list' => [
            'title' => __d('users', 'Users Management'),
            'url' => ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'index'],
            'weight' => 1
        ],
        'users_roles' => [
            'title' => __d('users', 'Role Management'),
            'url' => ['plugin' => 'Users', 'controller' => 'Roles', 'action' => 'index'],
            'weight' => 2
        ],
        'capabilities_list' => [
            'title' => __d('users', 'Capabilities'),
            'url' => ['plugin' => 'Users', 'controller' => 'Capabilities', 'action' => 'index'],
            'weight' => 3
        ]

    ]
]);