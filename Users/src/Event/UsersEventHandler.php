<?php
namespace Users\Event;

use Cake\Collection\Collection;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Users\Lib\UserLib;

class UsersEventHandler implements EventListenerInterface
{
    public function implementedEvents(){
        return [
            'SpiderController.afterInitialize' => 'onAfterSpiderControllerInitialize',
            'Users.Users.add.success' => [
                'callable' => 'onSuccessRegister', // create and send activation key to user's email
                'priority' => -1
            ],
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
            ]
        ];
    }

//TODO:: it would be better if using "Auth.afterIdentify" event instead custom,
//TODO:: but that's not send $user as reference so we can not using that yet
    public function onSuccessLogin(Event $event)
    {
        $controller = $event->subject();
        $userInfo = &$event->data['user'];
        $userInfo['Capabilities'] = $this->__getUserCapabilities($userInfo);
        return $userInfo;
    }

    /**
     * Get given/auth user capabilities
     * @param null $userInfo
     * @return array
     */
    private function __getUserCapabilities($userInfo){
        $userId = $userInfo['id'];
        $UserCapabilities = TableRegistry::get('Users.UsersCapabilities');
        $query = $UserCapabilities->find('all')
            ->select(['Capabilities.title'])
            ->contain(['Capabilities'])
            ->where(['user_id' => $userId]);
        $capabilities = (new Collection($query))->extract('Capabilities.title')->filter()->toArray();
        if(empty($capabilities)){
            $Roles = TableRegistry::get('Users.Roles');
            $capabilities = $Roles->getAllParentCapabilities($userInfo['role_id'], ['valueField' => 'title']);
        }
        return $capabilities;
    }

    /**
     * Send Auth object to UserLib to accessible anywhere when using UserLib::check($cap, $userId)
     * @param Event $event
     */
    public function onAfterSpiderControllerInitialize(Event $event){
        $controller = $event->subject();
        new UserLib($event->subject()->Auth);
        $avatar = Router::url($controller->request->session()->read('Auth.User.avatar'), true);
        if(empty($avatar)){
            $avatar = Router::url('/assets/images/default-avatar.jpg', true);
        }
        $controller->set(compact('avatar'));
    }

    /**
     * Send an activation link on success registered user
     * @param Event $event
     */
    public function onSuccessRegister(Event $event){
        $controller = $event->subject();
        $user = $event->data['user'];
        $controller->_sendActivationEmail($user)
            ->template('Bazibartar.register')
            ->subject('فعال سازی حساب کاربری')
            ->send();
        $controller->Flash->success(__d('users', 'you are success register, and an activation email has been send, check your email'));
    }
}