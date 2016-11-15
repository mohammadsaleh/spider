<?php
namespace Spider\Controller;

use Cake\Controller\Component\AuthComponent;
use Cake\Controller\Controller;
use Cake\Core\Plugin;
use Cake\Event\Event;
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
        $controller = $event->subject();
        if($controller->request->is('ajax')){
            $controller->viewBuilder()->autoLayout(false);
        }
        if($this->request->query('debug')){
            Configure::write('debug', true);
        }
    }

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize()
    {
        $this->eventManager()->dispatch(new Event('SpiderController.beforeInitialize', $this));
        parent::initialize();
        $this->set('title', '');
        $this->loadComponent('Flash');

        /** This below event trigger Before "SpiderController.afterConstruct" event.*/
        $this->eventManager()->dispatch(new Event('SpiderController.afterInitialize', $this));
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
        $this->eventManager()->dispatch(new Event('SpiderController.afterConstruct', $this));
    }
    
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        if(!$this->request->is('post')){
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
        if($this->request->param('prefix') == 'admin'){
            if(isset($this->request->data['apply'])){
                $response->location(Router::url($this->request->here(false), true));
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
        if($this->Auth->hasRole('superadmin')){
            return true;
        }
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
        $this->viewBuilder()->helpers([$helperName => $config]);
    }

    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
        if($this->request->query('is_dialog')){
            //TODO: convert popup dialog to a plugin
            $this->viewBuilder()->layout('admin_popup');
        }
    }

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
