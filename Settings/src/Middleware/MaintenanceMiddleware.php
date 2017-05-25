<?php

namespace Settings\Middleware;

use Cake\Core\Configure;
use Cake\Core\InstanceConfigTrait;
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

        if (Configure::read('Site.enable')) {
            return $next($request, $response);
        }


        $url = $this->_getUrl($request);
        $headers = $this->getConfig('headers');

        $response = new RedirectResponse($url, $this->getConfig('code'), $headers);
       // debug($response);die;
        if ($response instanceof ResponseInterface) {
            return $response;
        }

        return $next($request, $response);
    }

    protected function _getUrl(ServerRequestInterface $request)
    {
        $url = $this->_config['config']['url'];
        if (empty($url)) {
            $url = $request->getUri()->withPath('/maintenance.html');
        }
        return $url;
    }

}
