<?php
namespace Spider\Controller;

use Cake\Controller\Component\AuthComponent;
use Cake\Controller\Controller;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Network\Response;
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
        parent::initialize();
        $this->set('title', '');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie', [
            'expires' => '+3 days',
            'httpOnly' => true
        ]);
        $this->_setupAuthComponent();
        $this->_setupAuthAccess();
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
        /** This below event trigger After "SpiderController.afterInitialize" event.*/
        $this->eventManager()->dispatch(new Event('SpiderController.afterConstruct', $this));
    }

    protected function _setupAuthComponent(){
        //todo::  this settings should be better to set by setting project ui, not in code.
        $this->loadComponent('Auth', [
            'className' => 'Users.CustomAuth',
            'loginAction' => '/login',
            'loginRedirect' => '/tour/search',
            'logoutRedirect' => '/login',
            'checkAuthIn' => 'Controller.initialize',
            'authenticate' => [
                AuthComponent::ALL => ['userModel' => 'Users.Users'],
                'Form'
            ],
            'unauthorizedRedirect' => '/login',
            'authorize' => ['Controller'],
            'storage' => 'Session'
        ]);
    }
    protected function _setupAuthAccess(){
        $this->Auth->allow();
        if($this->request->prefix === 'admin'){
            $this->Auth->deny();
            $this->Auth->config('loginAction', '/admin/login');
            $this->Auth->config('loginRedirect', '/admin');
        }
        if(!$this->Auth->user()){
            $this->_tryLoginUserWithCookie();
        }
    }
    
    protected function _tryLoginUserWithCookie()
    {
        if($this->Cookie->check('remember_me')){
            $cookie = $this->Cookie->read('remember_me');
            $this->Auth->setUser($cookie);
        }
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        if(!$this->request->is('post')){
            $this->loadComponent('Search.Prg');
        }
//        if($this->request->prefix === 'admin'){
//            //Search filtering for all admin controllers::index()
//            if($this->request->action === 'index'){
//                $this->loadComponent('Search.Prg');
//            }
//        }
    }

    /**
     * Callback method that will be call ever if user logged in
     * @param null $user
     * @return bool
     */
    public function isAuthorized($user = null)
    {
        // Any registered user can access public functions
        if (empty($this->request->params['prefix'])) {
            return true;
        }

        // Only admins can access admin functions
        if ($this->request->params['prefix'] === 'admin') {
            return true;
            //check this user can access admin section or not
//            return (bool)($user['role'] === 'admin');
        }

        // Default deny
        return false;
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
