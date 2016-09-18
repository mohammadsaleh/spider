<?php
namespace PluginManager\Event;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use PluginManager\Lib\PluginManager;

class PluginManagerEventHandler implements EventListenerInterface
{
    /**
     * @var \Cake\View\View
     */
    protected $_View = null;

    public function implementedEvents(){
        return [
            'SpiderController.afterConstruct' => 'onAfterSpiderControllerConstruct',
            'Template.Element.before.admin.structure' => 'onBeforeAdminTemplateStructure',
        ];
    }
    
    public function onAfterSpiderControllerConstruct(Event $event)
    {
        $controller = $event->subject();
        $themeType = ($controller->request->prefix === 'admin') ? 'admin' : 'front';
        $theme = PluginManager::getDefaultTheme($themeType);
        if($theme){
            $controller->viewBuilder()->theme($theme);
        }
    }

    /**
     * Hook admin actions
     * @param Event $event
     */
    public function onBeforeAdminTemplateStructure(Event $event)
    {
        $this->_View = $view = $event->subject();
        $this->__hookAdminActions();
        $this->__hookAdminBoxes();
    }

    /**
     * Hook admin Actions in admin Index/Add/Edit pages
     */
    private function __hookAdminActions()
    {
        $actions = Configure::read('Hook.admin_actions') ?: [];
        $this->_addBlock('actions', $actions);
    }

    /**
     * Hook admin box in admin Add/Edit pages
     */
    private function __hookAdminBoxes()
    {
        $boxes = Configure::read('Hook.admin_box') ?: [];
        $this->_addBlock('box', $boxes);
    }


    /**
     * Adding Hooked element to given target.
     *
     * @param $type
     * @param $blocks : Example:
     * [
     *  'Users/Users/index' => ['prepend' => false, 'element' => 'Bird.Actions/box1']
     *  'Users/index' => ['prepend' => false, 'element' => 'Bird.Actions/box1']
     *  'index' => ['prepend' => false, 'element' => 'Bird.Actions/box1']
     *  '*' => ['prepend' => false, 'element' => 'Bird.Actions/box1']
     * ]
     */
    protected function _addBlock($type, $blocks)
    {
        $plugin = $this->_View->request->param('plugin');
        $controller = $this->_View->request->param('controller');
        $action = $this->_View->request->param('action');
        $target = [
            $action,
            $controller . '/' . $action,
            $plugin . '/' . $controller . '/' . $action
        ];
        $blockType = 'append';
        foreach($blocks as $path => $block){
            if(($path == '*') || in_array($path, $target)){
                if($block['prepend']){
                    $blockType = 'prepend';
                }
                $this->_View->{$blockType}($type, $this->_View->element($block['element']));
            }
        }
    }

}