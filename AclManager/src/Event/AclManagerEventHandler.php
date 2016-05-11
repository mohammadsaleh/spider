<?php
namespace AclManager\Event;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;

class AclManagerEventHandler implements EventListenerInterface
{
	public function implementedEvents()
	{
	    return [
		    'SpiderController.afterInitialize' => 'onAfterSpiderInitialized'
	    ];
	}

	public function onAfterSpiderInitialized(Event $event)
	{
	    $controller = $event->subject();
		$controller->loadComponent('AclManager.Acl');
		$controller->loadComponent('AclManager.Aco');
		$controller->loadComponent('AclManager.Aro');
	}
}