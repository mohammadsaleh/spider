<?php
use Spider\Lib\SpiderNav;
use Cake\Controller\Component\AuthComponent;

return [
    //todo::  this settings should be better to set by setting project ui, not in code.
    'Auth' => [
        'admin' => [
            'className' => 'AclManager.CustomAuth',
            'scope' => SpiderNav::getAdminScope(),
            'loginAction' => SpiderNav::getAdminScope() . '/login',
            'loginRedirect' => SpiderNav::getAdminScope(),
            'logoutRedirect' => SpiderNav::getAdminScope() . '/login',
            'unauthorizedRedirect' => SpiderNav::getAdminScope() . '/login',
            'authenticate' => [
                AuthComponent::ALL => ['userModel' => 'Users.Users'],
                'Form'
            ],
            'authorize' => ['Controller'],
            'storage' => 'Session'
        ],
        'front' => [
            'className' => 'AclManager.CustomAuth',
            'loginAction' => '/login',
            'loginRedirect' => '/tour/search',
            'logoutRedirect' => '/login',
    //        'checkAuthIn' => 'Controller.initialize',
            'authenticate' => [
                AuthComponent::ALL => ['userModel' => 'Users.Users'],
                'Form'
            ],
            'unauthorizedRedirect' => '/login',
            'authorize' => ['Controller'],
            'storage' => 'Session'
        ]
    ]
];