<?php
namespace Spider\Controller;

use Cake\Controller\Component\AuthComponent;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\I18n\I18n;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Spider\Lib\Hook;
use Users\Lib\UserLib;

/**
 * Spider Controller
 *
 */
class SpiderController extends Controller
{

    public function implementedEvents(){
        return parent::implementedEvents()+[
            'SpiderController.afterConstruct' => [
                'callable' => 'onAfterSpiderControllerConstruct'
            ]
        ];
    }

    public function onAfterSpiderControllerConstruct(Event $event){
        $controller = $event->getSubject();
        if($controller->getRequest()->is('ajax')){
            $controller->viewBuilder()->disableAutoLayout();
        }
        if($this->getRequest()->getQuery('debug')){
            Configure::write('debug', true);
        }
    }

    /**
     * Initialization hook method.
     * Use this method to add common initialization code like loading components.
     * @throws \Exception
     */
    public function initialize()
    {
        $this->getEventManager()->dispatch(new Event('SpiderController.beforeInitialize', $this));
        parent::initialize();
        $this->set('title', '');
        $this->loadComponent('Flash');

        /** This below event trigger Before "SpiderController.afterConstruct" event.*/
        $this->getEventManager()->dispatch(new Event('SpiderController.afterInitialize', $this));
    }

    /**
     * Construct running after initialize
     * @param Request|null $request
     * @param Response|null $response
     * @param null $name
     * @param null $eventManager
     */
    public function __construct(Request $request = null, Response $response = null, $name = null, $eventManager = null)
    {
        parent::__construct($request, $response, $name, $eventManager);
        Hook::applyHookMethods('Hook.controller_methods', $this);

        /** This below event trigger After "SpiderController.afterInitialize" event.*/
        $this->getEventManager()->dispatch(new Event('SpiderController.afterConstruct', $this));
    }
    
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        if(!$this->getRequest()->is('post')){
            $this->loadComponent('Search.Prg');
        }
    }

    /**
     * Manage redirect for specific buttons that posted.
     *
     * @param Event $event
     * @param array|string $url
     * @param Response $response
     * @return bool
     */
    public function beforeRedirect(Event $event, $url, Response $response)
    {
        if($this->getRequest()->getParam('prefix') == 'admin'){
            if($this->getRequest()->getData('apply')){
                $response->withLocation(Router::url($this->getRequest()->getRequestTarget(false), true));
            }
        }
        return true;
    }
    
    /**
     * Callback method that will be call ever if user logged in
     * @param null $user
     * @return bool
     */
    public function isAuthorized($user = null)
    {
        return $this->Auth->hasAllow($this->Acl->request());
    }

    /**
     * Alias for loading helpers with hooks.
     *
     * @param $helperName
     * @param array $config
     */
    public function loadHelper($helperName, $config = [])
    {
        $this->viewBuilder()->setHelpers([$helperName => $config]);
    }

    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
        if($this->getRequest()->getQuery('is_dialog')){
            //TODO: convert popup dialog to a plugin
            $this->viewBuilder()->setLayout('admin_popup');
        }
    }

    //todo: these functions should be changed
    public function success($data = [], $message = 'SUCCESS'){
        if(is_object($data)){
            $data = (array)$data;
        }
        $output = new \stdClass();
        $output->result = 1;
        $output->data = $data;
        $output->message = $message;
        return $output;
    }

    public function error($data = [], $message = 'ERROR'){
        if(is_object($data)){
            $data = (array)$data;
        }
        $output = new \stdClass();
        $output->result = 0;
        $output->data = $data;
        $output->message = $message;
        return $output;
    }
}
