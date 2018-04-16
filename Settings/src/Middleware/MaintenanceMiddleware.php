<?php

namespace Settings\Middleware;

use Cake\Core\Configure;
use Cake\Core\InstanceConfigTrait;
use Cake\Routing\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;



/**
 * Middleware responsible of intercepting request to
 * deal with the application being under maintenance
 */
class MaintenanceMiddleware
{
    use InstanceConfigTrait;
    protected $_defaultConfig = [
        'code' => 307,
        'url' => '',
        'headers' => [],
        'config' =>[]
    ];

    public function __construct($config = [])
    {
        $this->setConfig($config);
    }

    public function __invoke($request, $response, $next)
    {
        $response = $next($request, $response);
        if (Configure::read('Site.enable') || $response->getFile()) {
            return $response;
        }
        if($request->getRequestTarget() != trim(MAINTENANCE_URL, '/')){
            $response = $response->withLocation(Router::url(MAINTENANCE_URL));
        }
        return $response;
    }

}
