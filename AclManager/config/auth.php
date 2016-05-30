<?php
return [
    //todo::  this settings should be better to set by setting project ui, not in code.
    'Auth' => [
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
        'checkAuthIn' => 'Controller.initialize',
        'authenticate' => [
            \Cake\Controller\Component\AuthComponent::ALL => ['userModel' => 'Users.Users'],
            'Form'
        ],
        'unauthorizedRedirect' => '/login',
        'authorize' => ['Controller'],
        'storage' => 'Session'
    ]
];