<?php
namespace PluginManager\Event;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;

class PluginManagerEventHandler implements EventListenerInterface
{
    public function implementedEvents(){
        return [
            'SpiderController.afterConstruct' => 'onAfterSpiderControllerConstruct',
            'View.beforeRender' => 'onBeforeViewRender',
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

    /**
     * Hook admin actions
     * @param Event $event
     */
    public function onBeforeViewRender(Event $event)
    {
        $view = $event->subject();
        $actions = Configure::read('Hook.admin_actions');
        $plugin = $view->request->param('plugin');
        $controller = $view->request->param('controller');
        $action = $view->request->param('action');
        $targetPaths = [
            $action,
            $controller . '/' . $action,
            $plugin . '/' . $controller . '/' . $action
        ];

        $blockType = 'append';
        foreach($actions as $path => $action){
            if(($path == '*') || in_array($path, $targetPaths)){
                if($action['prepend']){
                    $blockType = 'prepend';
                }
                $view->{$blockType}('actions', $view->element($action['element']));
            }
        }
    }

}