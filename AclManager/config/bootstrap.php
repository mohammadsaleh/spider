<?php
use Spider\Lib\Hook;
use Cake\Core\Configure;
use Spider\Lib\SpiderNav;
Hook::adminForm(['Users/Users/add', 'Users/Users/edit'], 'AclManager.AdminForms/add_edit_user_roles');
Hook::adminBox(['Users/Users/add', 'Users/Users/edit'], 'AclManager.AdminBoxes/add_edit_user_permissions', true);
Hook::adminActions('AclManager/Permissions/index', 'AclManager.AdminActions/permissions_sync');
Hook::helper('AclManager.Permissions', 'AclManager.Tree');
Hook::helper('*', 'AclManager.Acl');
Hook::component('Admin.Users.Users', 'AclManager.UserPermission');

Configure::load('AclManager.auth');

SpiderNav::add('sidebar', 'Users.children.permissions' , [
		'title' => __d('users', 'Permissions'),
		'url' => ['plugin' => 'AclManager', 'controller' => 'Permissions', 'action' => 'index'],
		'weight' => 3
]);
SpiderNav::add('sidebar', 'Users.children.AclManager' , [
		'title' => __d('users', 'Role Management'),
		'url' => ['plugin' => 'AclManager', 'controller' => 'Roles', 'action' => 'index'],
		'weight' => 2
]);