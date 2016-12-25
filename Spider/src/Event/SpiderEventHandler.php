<?php
/**
 * Created by PhpStorm.
 * User: MohammadSaleh
 * Date: 12/25/2016
 * Time: 1:11 PM
 */

namespace Spider\Event;


use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Spider\Lib\Hook;

class SpiderEventHandler implements EventListenerInterface
{
    public function implementedEvents()
    {
        return [
            'Spider.SpiderAppView.initialize' => [
                'callable' => 'onViewInitialize',
                'priority' => -10
            ]
        ];
    }

    public function onViewInitialize(Event $event)
    {
        $View = $event->subject();
        Hook::applyHookHelpers('Hook.helpers', $View);
    }
}