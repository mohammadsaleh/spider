<?php
namespace Users\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Utility\Text;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \Users\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Login registered users
     * @return \Cake\Network\Response|void
     */
    public function login(){
        $this->viewBuilder()->layout('login');
        if (!empty($this->request->data)) {
            $user = $this->Auth->identify();
            if ($user && ($user['status'] > 0)) {
                $this->eventManager()->dispatch(new Event('Users.Users.login.success', $this, ['user' => &$user]));
                $this->Auth->setUser($user);
                $this->__setCookie();
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(__d('users', 'Username or password is incorrect'), ['key' => 'Auth']);
                $this->eventManager()->dispatch(new Event('Users.Users.login.failed', $this));
            }
        }
    }

    private function __setCookie()
    {
        if($this->request->data('remember_me')){
            $this->Cookie->write('remember_me', $this->Auth->user());
        }else{
            if($this->Cookie->check('remember_me')){
                $this->Cookie->delete('remember_me');
            }
        }
    }
    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if($this->request->is('ajax')){
            $this->autoRender = false;
            $error = [];
            if (!empty($this->request->data)) {
                $data = array_map(function($value){return trim($value);}, $this->request->data);
                $userData = [];
                $userData['username'] = $data['mailUserRegister'];
                $userData['password'] = $data['passwordRegister'];
                $userData['confirm_password'] = $data['rePasswordRegister'];
                $userData['auth_key'] = Text::uuid();
                if(!$this->Recaptcha->verify()){
                    $error[] = 'عبارت تصویر امنیتی نادرست وارد شده است.';
                }
                //TODO:: dar in marhale bayad unique boodan username barresi shavad .. darhale hazer kar nemikonad
                //TODO:: chon checkRules dar in marhale ettefaq nemiofte, balke dar save ettefaq miofte
                $user = $this->Users->newEntity($userData, ['checkRules' => true]);
                if(!empty($user->errors())){
                    $error = Hash::merge($error, Hash::extract($user->errors(), '{s}.{s}'));
                }
                if(empty($error)) {
                    if(!empty($data['presenterRegister'])){
                        $presenterUser = $this->Users->find()
                            ->select(['id', 'username'])
                            ->where(['username' => $data['presenterRegister']])
                            ->first();
                        if (!empty($presenterUser)) {
                            $userData['presenter_id'] = $presenterUser['id'];
                        }
                    }
                    $this->eventManager()->dispatch(new Event('Users.Users.add.beforeSave', $this, ['user' => &$user]));
                    if ($this->Users->save($user)) {
                        $this->Flash->success(__d('users', 'The user has been saved.'));
                        echo json_encode($this->success());
                        $this->eventManager()->dispatch(new Event('Users.Users.add.success', $this, ['user' => &$user]));
                        return;
                    }else{
                        $error = Hash::merge($error, Hash::extract($user->errors(), '{s}.{s}'));
                    }
                }
            }else{
                $error[] = 'فرمت داده های ورودی معتبر نیست.';
            }
            echo json_encode($this->error($error, 'ERROR'));
            return;

        }
        $this->redirect('/');
    }

    /**
     * Active a new registered user comming from email
     * @param $key
     */
    public function active($key){
        $user = $this->Users->find()->matching('ActivationKeys', function($q) use ($key){
            return $q->where(['activation_key' => $key]);
        })->first();

        if(!empty($user)){
            $user->status = 1;
            if($this->Users->save($user)){
                $this->Users->ActivationKeys->deleteAll(['activation_key' => $key]);
                $this->eventManager()->dispatch(new Event('Users.Users.active.success', $this, ['user' => &$user]));
                //Logged user in
                unset($user->_matchingData);
                $this->Auth->setUser($user->toArray());
                return $this->redirect('/user-panel');
            }
        }
        $this->redirect('/');
    }

    public function editPassword()
    {
        if($this->request->is('ajax')){
            $this->autoRender = false;
            $user = $this->Users->get($this->Auth->user('id'));
            if (!empty($this->request->data)) {
                if(!(new DefaultPasswordHasher)->check($this->request->data('currentPass'), $user->password)){
                    echo json_encode($this->error(['پسورد اشتباه می باشد.']));
                    return;
                }
                $data = [
                    'password' => $this->request->data('newPass'),
                    'confirm_password' => $this->request->data('newRePass'),
                ];
                $user = $this->Users->patchEntity($user, $data);
                if ($this->Users->save($user)) {
                    echo json_encode($this->success());
                    return;
                } else {
                    echo json_encode($this->error(Hash::extract($user->errors(), '{s}.{s}')));
                    return;
                }
            }
        }
        $this->redirect('/');
    }

    public function checkEmail()
    {
        $this->autoRender = false;
        if($this->request->is('post')){
            $data = $this->request->data;
            if(isset($data['mailUserRegister'])){
                $users = TableRegistry::get('Users');
                $query = $users->find();
                $query->select(['id', 'username'])
                    ->where(array(
                        'username' => $data['mailUserRegister'],
                    ));
                $user = $query->first();
                if($user){
                    $output = ['valid' => false];
                    echo json_encode((object)$output);exit;
                }
            }
        }
        $output = ['valid' => true];
        echo json_encode((object)$output);exit;
    }

    public function forgetPass()
    {
        if($this->request->is('post')) {
            $postData = $this->request->data();
            if (!empty($postData['mailUserForgot'])) {
                $user = $this->Users->find()->where(['username' => $postData['mailUserForgot']])->first();
                if ($user) {
                    $this->_sendActivationEmail($user, '/forgetpass?activation=')
                        ->template('Bazibartar.forget_pass')
                        ->subject('بازیابی رمز عبور شما در بازی برتر')
                        ->send();
                    $this->set('successSendActivation', true);
                }
            }elseif (!empty($postData['passwordForgot']) && !empty($postData['rePasswordForgot']) && !empty($postData['activation_key'])) {
                $activationKey = $postData['activation_key'];
                $activation = $this->Users->ActivationKeys->find()->where([
                    'activation_key' => $activationKey
                ])->first();
                if ($activation) {
                    $user = $this->Users->get($activation->user_id);
                    $data = [
                        'password' => $postData['passwordForgot'],
                        'confirm_password' => $postData['rePasswordForgot'],
                    ];
                    $user = $this->Users->patchEntity($user, $data);
                    if ($this->Users->save($user)) {
                        $this->Auth->setUser($user);
                        $this->Users->ActivationKeys->deleteAll(['activation_key' => $activationKey]);
                        $this->set('successChangePassword', true);
                    }else{
                        $this->set('unknownError', true);
                    }
                }else{
                    $this->set('invalidActivation', true);
                }
            }
        }elseif($this->request->query('activation')){
            $activationKey = $this->request->query('activation');
            $activation = $this->Users->ActivationKeys->find()->where([
                'activation_key' => $activationKey
            ])->first();
            if($activation){
                $this->set([
                    'showResetPassForm' => true,
                    'activationKey' => $activationKey,
                ]);
            }
        }else{
            $title = 'بازی برتر - بازیابی رمز عبور';
            $this->set('title', $title);
        }
    }

    /**
     * Logging user out
     * @return \Cake\Network\Response|null
     */
    public function logout() {
        $logoutRedirect = $this->redirect($this->Auth->logout());
        if($this->Cookie->check('remember_me')){
            $this->Cookie->delete('remember_me');
        }
        return $logoutRedirect;
    }
    
    public function uploadAvatar()
    {
        $this->autoRender = false;
        $this->loadComponent('Users.Uploader');
        if(!empty($this->request->data())){
            $destination = DS . 'img' . DS . 'avatars' . DS . $this->Auth->user('id');
            $file = $this->request->data('avatarFile');
            if($file['size'] > (100 * 1024)){
                echo json_encode($this->error(['اندازه فایل بیش از حد مجاز است.']));
                return;
            }
            $fileInfo = $this->Uploader->uploadImage($file, $destination);
            if(!empty($fileInfo)){
                $userEntity = $this->Users->get($this->Auth->user('id'));
                if(!empty($userEntity->avatar)){
                    $imagePath = str_replace('/', DS, $userEntity->avatar);
                    unlink(WWW_ROOT . $imagePath);
                }
                $userEntity->avatar = $fileInfo['path'];
                $this->request->session()->write('Auth.User.avatar', $fileInfo['path']);
                if($this->Users->save($userEntity)){
                    echo json_encode($this->success(['src' => Router::url($fileInfo['path'])]));
                    return;
                }
            }
        }
        echo json_encode($this->error(['خطا در ذخیره سازی تصویر پروفایل']));
        return;
    }



}
