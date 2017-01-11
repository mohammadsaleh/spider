<?php
use Spider\Lib\SpiderNav;
use Spider\Lib\Hook;

Hook::helper('*', 'Users.Users');
Hook::adminBox('Users/Users/edit', 'Users.Admin/Boxes/edit_user_reset_password', true);
SpiderNav::add('sidebar', 'Users' , [
    'title' => __d('users', 'Users'),
    'url' => '#',
    'icon' => 'fa fa-users',
    'weight' => 10,
    'children' => [
        'users_list' => [
            'title' => __d('users', 'Users Management'),
            'url' => ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'index'],
            'weight' => 1
        ],
    ]
]);