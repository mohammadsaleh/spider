<?php

\Spider\Lib\SpiderNav::add('sidebar', 'Users.children.permissions' , [
	'title' => __d('users', 'Permissions'),
	'url' => ['plugin' => 'AclManager', 'controller' => 'Permissions', 'action' => 'index'],
	'weight' => 3
]);