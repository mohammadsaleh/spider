<?php
return [
    //todo::  this settings should be better to set by setting project ui, not in code.
    'Auth' => [
        'className' => 'AclManager.CustomAuth',
        'admin' => [
            'prefix' => 'admin',
            'loginAction' => '/admin/login',
            'loginRedirect' => '/admin',
            'logoutRedirect' => '/admin/login',
            'unauthorizedRedirect' => '/admin/login',
        ],
        'loginAction' => '/login',
        'loginRedirect' => '/tour/search',
        'logoutRedirect' => '/login',
//        'checkAuthIn' => 'Controller.startup', // Controller.initialize
        'authenticate' => [
            'Form' => ['userModel' => 'Users.Users'],
            'OAuthServer.OAuth'
        ],
        'unauthorizedRedirect' => '/login',
        'authorize' => ['Controller'],
        'storage' => 'Session'
    ]
];