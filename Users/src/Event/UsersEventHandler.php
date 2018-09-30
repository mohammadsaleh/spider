<?php
namespace Users\Event;

use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Settings\Lib\Settings;
use Users\Lib\UserLib;

class UsersEventHandler implements EventListenerInterface
{
    private $__controller = null;

    public function implementedEvents(){
        return [
            'SpiderController.afterConstruct' => 'onAfterSpiderControllerConstruct',
            'Users.Users.add.success' => [
                'callable' => 'onSuccessRegister', // create and send activation key to user's email
                'priority' => -1
            ],
            'Spider.SpiderAppView.initialize' => 'onSpiderViewInitialize',
            'Users.Users.login.success' => [
                'callable' => 'onSuccessLogin',
                'priority' => -1
            ],
            'Users.Users.active.success' => [
                'callable' => 'onSuccessLogin',
                'priority' => -1
            ],
            'Users.Admin.Users.login.success' => [
                'callable' => 'onSuccessLogin',
                'priority' => -1
            ],
            'Users.Admin.Users.unlock.success' => [
                'callable' => 'onSuccessLogin',
                'priority' => -1
            ]
        ];
    }

    //TODO:: it would be better if using "Auth.afterIdentify" event instead custom,
    //TODO:: but that's not send $user as reference so we can not using that yet
    public function onSuccessLogin(Event $event)
    {
    }

    public function onSpiderViewInitialize(Event $event)
    {
        $view = $event->getSubject();
        if(Plugin::loaded('Users')){
            $view->loadHelper('Users.Users');
        }
    }

    /**
     * Send Auth object to UserLib to accessible anywhere when using UserLib::check($cap, $userId)
     * @param Event $event
     */
    public function onAfterSpiderControllerConstruct(Event $event){
        if(!$this->__controller){
            $this->__controller = $event->getSubject();
        }
        new UserLib($this->__controller->Auth);
        $this->__forceLogout();
        $userAvatar = $this->__controller->request->session()->read('Auth.User.avatar');
        $avatar = Router::url($userAvatar, true);
        if(empty($userAvatar)){
            $avatar = Router::url('/assets/images/default-avatar.jpg', true);
        }
        $this->__controller->set(compact('avatar'));
    }

    private function __forceLogout()
    {
        if($user = $this->__controller->Auth->user()){
            $forceLogoutSetting = Settings::find('users.force_logout', false);
            $forceLogout = false;
            if(!empty($forceLogoutSetting)){
                $forceLogoutSetting = array_shift($forceLogoutSetting);
                $forceLogout = $forceLogoutSetting['value'];
            }
            if($forceLogout){
                $UsersForceLogout = TableRegistry::get('Users.UsersForceLogout');
                $logoutUser = $UsersForceLogout->find()->where(['user_id' => $user['id']])->first();
                $logout = false;
                if(!empty($logoutUser) && ($logoutUser['logout'] == 0)){
                    $logout = true;
                    $logoutUser['logout'] = 1;
                }elseif(empty($logoutUser)){
                    $logout = true;
                    $logoutUser = $UsersForceLogout->newEntity(['user_id' => $user['id'], 'logout' => 1]);
                }
                if($logout && $UsersForceLogout->save($logoutUser)){
                    return $this->__controller->redirect(['plugin' => 'users', 'controller' => 'users', 'action' => 'logout']);
                }
            }
        }
    }

    /**
     * Send an activation link on success registered user
     * @param Event $event
     */
    public function onSuccessRegister(Event $event){
        $controller = $event->getSubject();
        $user = $event->data['user'];
        $controller->_sendActivationEmail($user)
            ->template('Bazibartar.register')
            ->subject('فعال سازی حساب کاربری')
            ->send();
        $controller->Flash->success(__d('users', 'you are success register, and an activation email has been send, check your email'));
    }
}