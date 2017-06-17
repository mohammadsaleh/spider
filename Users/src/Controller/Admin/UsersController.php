<?php
namespace Users\Controller\Admin;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Auth\PasswordHasherFactory;
use Cake\Core\Configure;
use Cake\Event\Event;
use Spider\Lib\SpiderNav;
use Users\Controller\AppController;

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
        $this->Auth->allow(['login']);
        $this->Auth->allow(['unlock']);
        if($this->Auth->user()){
            $this->Auth->allow(['profile']);
        }
    }

    /**
     * Login admin users
     * @return \Cake\Network\Response|void
     */
    public function login(){
        if(!empty($this->Auth->user()) && ($this->Auth->redirectUrl() !== ('/' . SpiderNav::getAdminScope()))){
            return $this->redirect($this->Auth->redirectUrl());
        }
        $this->viewBuilder()->layout('login');
        if ($this->request->is('post')) {
            if(!$this->Captcha->validate('captcha', $this->request->data('captcha'))){
                $this->Flash->error(__d('users', 'Captcha is incorrect'), ['key' => 'Auth']);
            }else{
                $user = $this->Auth->identify();
                if ($user) {
                    $this->eventManager()->dispatch(new Event('Users.Admin.Users.login.success', $this, ['user' => &$user]));
                    $this->Auth->setUser($user);
                    $this->__setCookie();
                    return $this->redirect($this->Auth->redirectUrl());
                } else {
                    $this->Flash->error(__d('users', 'Username or password is incorrect'), ['key' => 'Auth']);
                    $this->eventManager()->dispatch(new Event('Users.Admin.Users.login.failed', $this));
                }
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
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $query = $this->Users->find('search', $this->Users->filterParams($this->request->query))
            ->where(['Users.id <>' => $this->Auth->user('id')])
            ->matching('Roles', function($q){
                return $q->where(['name <>' => 'superadmin']);
            })
            ->contain(['Roles']);
        $this->set('users', $query->toArray()/*$this->paginate($query)*/);
        $this->set('title', 'Users List');
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Users', 'Cities', 'Roles', 'Banks', 'ActivationKeys', 'UserAccounts', 'UserLogins']
        ]);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            $this->eventManager()->dispatch(new Event('Users.Admin.Users.add.before.save', $this, ['user' => &$user]));
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                $this->eventManager()->dispatch(new Event('Users.Admin.Users.add.after.save.success', $this, ['user' => &$user]));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->eventManager()->dispatch(new Event('Users.Admin.Users.add.after.save.error', $this, ['user' => &$user]));
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user', 'users', 'cities', 'roles', 'banks'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if($id == $this->Auth->user('id')){
            $this->Flash->error(__('The user was not found.'));
            return $this->redirect(['action' => 'index']);
        }
        $user = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            if(!($isResetPassword = $this->request->data('reset_password'))){
                unset($this->request->data['password'], $this->request->data['confirm_password']);
            }elseif($this->Auth->hasAllow(USERS_RESET_PASSWORD)){
                $this->request->data = [
                    'reset_password' => true,
                    'password' => $this->request->data('password'),
                    'confirm_password' => $this->request->data('confirm_password'),
                    'apply' => true
                ];
            }else{
                $isResetPassword = false;
                unset($this->request->data['password'], $this->request->data['confirm_password']);
            }
            $user = $this->Users->patchEntity($user, $this->request->data);
            $this->eventManager()->dispatch(new Event('Users.Admin.Users.edit.before.save', $this, ['user' => &$user]));
            if ($this->Users->save($user)) {
                if($isResetPassword){
                    $this->Flash->success(__('Password Successfully Changed.'), ['key' => 'reset']);
                }else{
                    $this->Flash->success(__('The user has been saved.'));
                }
                $this->eventManager()->dispatch(new Event('Users.Admin.Users.edit.after.save.success', $this, ['user' => &$user]));
                return $this->redirect(['action' => 'index']);
            } else {
                if($isResetPassword){
                    $this->Flash->error(__('Reset Password Failed!'), ['key' => 'reset']);
                }else{
                    $this->Flash->error(__('The user could not be saved. Please, try again.'));
                }
                $this->eventManager()->dispatch(new Event('Users.Admin.Users.edit.after.save.error', $this, ['user' => &$user]));
            }
        }
//        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Edit current admin profile
     */
    public function profile()
    {
        $user = $this->Users->get($this->Auth->user('id'));
        if ($this->request->is(['patch', 'post', 'put'])) {
            if((new DefaultPasswordHasher())->check($this->request->data('old_password'), $user->password)){
                $user = $this->Users->patchEntity($user, $this->request->data);
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('The user has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The user could not be saved. Please, try again.'));
                }
            }else{
                $this->Flash->error(__d('users', 'The old password does not match the current password!'));
            }
        }
        unset($user['password']);
        $this->set(compact('user'));
    }

    public function unlock()
    {
        $this->viewBuilder()->layout('login');
        if($this->request->is('post') && !empty($this->request->data)){
            $cookie = $this->Cookie->read('remember_me');
            $this->request->data['username'] = $cookie['username'];
            $user = $this->Auth->identify();
            if ($user) {
                $this->eventManager()->dispatch(new Event('Users.Admin.Users.unlock.success', $this, ['user' => &$user]));
                $this->Auth->setUser($user);
                $this->__setCookie();
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $user = $this->Users->find()->where(['Users.username' => $cookie['username']])->first();
                $this->Flash->error(__d('users', 'password is incorrect or your account may be disabled'), ['key' => 'Auth']);
                $this->eventManager()->dispatch(new Event('Users.Admin.Users.unlock.failed', $this));
            }
        }else{
            if(Configure::check('unlock')){
                $user = Configure::consume('unlock');
                $user = $this->Users->find()->where(['Users.username' => $user['username']])->first();
            }else{
                $cookie = $this->Cookie->read('remember_me');
                $user = null;
                if(!empty($cookie)){
                    $user = $this->Users->find()->where(['Users.username' => $cookie['username']])->first();
                }
            }
            if(empty($user)){
                return $this->redirect($this->Auth->redirectUrl());
            }
        }
        $this->set(compact('user'));
    }
}
