<?php
\Cake\Core\Configure::load('AclManager.auth');

\Spider\Lib\SpiderNav::add('sidebar', 'Users.children.permissions' , [
		'title' => __d('users', 'Permissions'),
		'url' => ['plugin' => 'AclManager', 'controller' => 'Permissions', 'action' => 'index'],
		'weight' => 3
]);
\Spider\Lib\SpiderNav::add('sidebar', 'Users.children.AclManager' , [
		'title' => __d('users', 'Role Management'),
		'url' => ['plugin' => 'AclManager', 'controller' => 'Roles', 'action' => 'index'],
		'weight' => 2
]);