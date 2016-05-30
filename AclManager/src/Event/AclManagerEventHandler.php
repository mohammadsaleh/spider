<?php
namespace AclManager\Event;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;

class AclManagerEventHandler implements EventListenerInterface
{
	/**
	 * @var \Cake\Controller\Controller
	 */
	public $controller = null;

	public function implementedEvents()
	{
	    return [
		    'SpiderController.afterInitialize' => 'onAfterSpiderInitialized'
	    ];
	}

	public function onAfterSpiderInitialized(Event $event)
	{
	    $this->controller = $event->subject();
		$this->controller->loadComponent('AclManager.Acl');
		$this->controller->loadComponent('AclManager.Aco');
		$this->controller->loadComponent('AclManager.Aro');

		$this->controller->loadComponent('Cookie', [
				'expires' => '+3 days',
				'httpOnly' => true
		]);
		$this->_setupAuthComponent();
		$this->_setupAuthAccess();
	}

	/**
	 * Setup Auth component settings
	 */
	protected function _setupAuthComponent(){
		$this->controller->loadComponent('Auth', Configure::read('Auth'));
		$this->controller->Auth->deny();
	}

	/**
	 * Setting up auth access
	 */
	protected function _setupAuthAccess(){
		if($this->controller->request->prefix == $this->controller->Auth->config('admin.prefix')){
			$this->controller->Auth->config('loginAction', $this->controller->Auth->config('admin.loginAction'));
			$this->controller->Auth->config('loginRedirect', $this->controller->Auth->config('admin.loginRedirect'));
		}
		if(!$this->controller->Auth->user()){
			$this->_tryLoginUserWithCookie();
		}
	}

	/**
	 * Check remember me and if set login user with it's cookie.
	 */
	protected function _tryLoginUserWithCookie()
	{
		if($this->controller->Cookie->check('remember_me')){
			$cookie = $this->controller->Cookie->read('remember_me');
			$this->controller->Auth->setUser($cookie);
		}
	}
}