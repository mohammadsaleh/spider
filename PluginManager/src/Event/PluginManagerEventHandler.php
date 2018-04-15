<?php
namespace PluginManager\Event;
use Cake\Controller\ErrorController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Routing\Router;
use PluginManager\Lib\PluginManager;
use Spider\Lib\SpiderNav;

class PluginManagerEventHandler implements EventListenerInterface
{
    /**
     * @var \Cake\View\View
     */
    protected $_View = null;
    private $__controller = null;

    public function implementedEvents(){
        return [
            'SpiderController.afterConstruct' => 'onAfterSpiderControllerConstruct',
            'Template.Element.before.admin.structure' => 'onBeforeAdminTemplateStructure',
            'Controller.initialize' => 'beforeFilter',
            'Spider.SpiderAppView.initialize' => 'onSpiderAppView'
        ];
    }

    public function onSpiderAppView(Event $event)
    {
        if(!$this->_View){
            $this->_View = $event->getSubject();
            if(($this->__controller->request->prefix === 'admin')){
                $this->__hookAdminNavbar();
                if($this->_View->request->here() == (Router::url(SpiderNav::getDashboardUrl()))){
                    $this->__hookAdminDashboard();
                }
            }
        }
    }

    private function __setDefaultTheme()
    {
        $themeType = ($this->__controller->request->prefix === 'admin') ? 'admin' : 'front';
        $theme = PluginManager::getDefaultTheme($themeType);
        if($theme) {
            $this->__controller->viewBuilder()->theme($theme);
            if($this->__controller->Flash){
                $this->__controller->Flash->setConfig('plugin', $theme);
            }
        }
    }

    public function beforeFilter(Event $event)
    {
        $this->__controller = $event->getSubject();
        if($this->__controller instanceof ErrorController){
            $this->__setDefaultTheme();
        }
    }

    public function onAfterSpiderControllerConstruct(Event $event)
    {
        $this->__controller = $event->getSubject();
        $this->__setDefaultTheme();
    }

    /**
     * Hook admin actions
     * @param Event $event
     */
    public function onBeforeAdminTemplateStructure(Event $event)
    {
        $this->_View = $view = $event->getSubject();
        $this->__hookAdminActions();
        $this->__hookAdminBoxes();
        $this->__hookAdminForms();
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
     * Hook admin Actions in admin Index/Add/Edit pages
     */
    private function __hookAdminForms()
    {
        $actions = Configure::read('Hook.admin_form') ?: [];
        $this->_addBlock('form', $actions);
    }


    /**
     * Hook admin boxes in dashboard page
     */
    private function __hookAdminDashboard()
    {
        $dashboardBoxes = Configure::read('Hook.admin_dashboard') ?: [];
        $target = SpiderNav::getDashboardUrl();
        $plugin = $target['plugin'];
        $controller = $target['controller'];
        $action = $target['action'];
        $target = $plugin . '/' . $controller . '/' . $action;

        $dashboardBoxes = [$target => $dashboardBoxes];
        $this->_addBlock('dashboard', $dashboardBoxes);
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
     * Hook admin navbar in admin head navbar
     */
    private function __hookAdminNavbar()
    {
        $navbars = Configure::consume('Hook.admin_navbar') ?: [];
        $this->_addBlock('navbar', $navbars);
    }


    /**
     * Adding Hooked element to given target.
     *
     * @param $type: box, actions, form
     * @param $blocksArr : Example:
     * [
     *  'Users/Users/index' => ['prepend' => false, 'element' => 'Bird.Actions/box1']
     *  'Users/index' => ['prepend' => false, 'element' => 'Bird.Actions/box1']
     *  'index' => ['prepend' => false, 'element' => 'Bird.Actions/box1']
     *  '*' => ['prepend' => false, 'element' => 'Bird.Actions/box1']
     * ]
     */
    protected function _addBlock($type, $blocksArr)
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
        foreach($blocksArr as $path => $blocks){
            if(empty($blocks)){
                continue;
            }
            if(!array_key_exists(0, $blocks)){
                $blocks = [$blocks];
            }
            foreach($blocks as $block){
                if(($path == '*') || in_array($path, $target)){
                    if($block['prepend']){
                        $blockType = 'prepend';
                    }
                    if(is_array($block['element'])){
                        foreach($block['element'] as $element){
                            $this->_View->{$blockType}($type, $this->_View->element($element));
                        }
                    }else{
                        $this->_View->{$blockType}($type, $this->_View->element($block['element']));
                    }
                }
            }
        }
    }

}