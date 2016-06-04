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
        'AclManager.Roles' => [
            'title' => __d('users', 'Role Management'),
            'url' => ['plugin' => 'Users', 'controller' => 'Roles', 'action' => 'index'],
            'weight' => 2
        ]
    ]
]);