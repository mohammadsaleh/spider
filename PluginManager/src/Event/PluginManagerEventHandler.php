<?php
namespace PluginManager\Event;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;

class PluginManagerEventHandler implements EventListenerInterface
{
    public function implementedEvents(){
        return [
            'SpiderController.afterConstruct' => 'onAfterSpiderControllerConstruct'
        ];
    }
    
    public function onAfterSpiderControllerConstruct(Event $event)
    {
        $controller = $event->subject();
        $themeType = 'front';
        if($controller->request->prefix === 'admin') {
            $themeType = 'admin';
        }
        $Plugins = TableRegistry::get('PluginManager.Plugins');
        $theme = $Plugins->find('all')
            ->where(['theme' => $themeType])
            ->where(['`status`' => 1])
            ->where(['`default`' => 1])
            ->first();
        if(!empty($theme)){
            $controller->viewBuilder()->theme($theme->name);
        }
    }

}