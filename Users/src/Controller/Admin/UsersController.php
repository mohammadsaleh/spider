<?php
namespace Users\Controller\Admin;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Auth\PasswordHasherFactory;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Spider\Lib\Date\Persian;
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
        $this->viewBuilder()->setLayout('login');
        if ($this->getRequest()->is('post')) {
            if(!$this->Captcha->validate('captcha', $this->getRequest()->getData('captcha'))){
                $this->Flash->error(__d('users', 'Captcha is incorrect'), ['key' => 'Auth']);
            }else{
                $user = $this->Auth->identify();
                if ($user) {
                    $this->getEventManager()->dispatch(new Event('Users.Admin.Users.login.success', $this, ['user' => &$user]));
                    $this->Auth->setUser($user);
                    $this->__setCookie();
                    return $this->redirect($this->Auth->redirectUrl());
                } else {
                    $this->Flash->error(__d('users', 'Username or password is incorrect'), ['key' => 'Auth']);
                    $this->getEventManager()->dispatch(new Event('Users.Admin.Users.login.failed', $this));
                }
            }
        }
    }

    private function __setCookie()
    {
        if($this->getRequest()->getData('remember_me')){
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
        $Users = TableRegistry::get('Users.Users');
        $users = $Users->find()
            ->where(['Users.id <>' => $this->Auth->user('id')])
            ->matching('Roles', function($q){
                return $q->where(['Roles.name <>' => 'superadmin']);
            })
            ->contain(['Roles']);
        $users = $this->DataTables->dataTable($users);
        foreach ($users['datatable'] as $key => $user){
            $users['datatable'][$key]['created'] = Persian::date('Y-m-d H:i', $user['created']);
            $users['datatable'][$key]['modified'] = Persian::date('Y-m-d H:i', $user['modified']);
        }
        $this->set(compact('users'));
        $this->set('title', 'Users List');
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
        if ($this->getRequest()->is('post')) {
            $user = $this->Users->patchEntity($user, $this->getRequest()->getData);
            $this->getEventManager()->dispatch(new Event('Users.Admin.Users.add.before.save', $this, ['user' => &$user]));
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                $this->getEventManager()->dispatch(new Event('Users.Admin.Users.add.after.save.success', $this, ['user' => &$user]));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->getEventManager()->dispatch(new Event('Users.Admin.Users.add.after.save.error', $this, ['user' => &$user]));
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
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            if(!($isResetPassword = $this->getRequest()->getData('reset_password'))){
                $this->setRequest($this->getRequest()->withoutData('password'));
                $this->setRequest($this->getRequest()->withoutData('confirm_password'));
            }else{
                $data = [
                    'reset_password' => true,
                    'password' => $this->getRequest()->getData('password'),
                    'confirm_password' => $this->getRequest()->getData('confirm_password'),
                    'apply' => true
                ];
                foreach($data as $index => $value){
                    $this->setRequest($this->getRequest()->withData($index, $value));
                }
            }
            $user = $this->Users->patchEntity($user, $this->getRequest()->getData);
            $this->getEventManager()->dispatch(new Event('Users.Admin.Users.edit.before.save', $this, ['user' => &$user]));
            if ($this->Users->save($user)) {
                if($isResetPassword){
                    $this->Flash->success(__('Password Successfully Changed.'), ['key' => 'reset']);
                }else{
                    $this->Flash->success(__('The user has been saved.'));
                }
                $this->getEventManager()->dispatch(new Event('Users.Admin.Users.edit.after.save.success', $this, ['user' => &$user]));
                return $this->redirect(['action' => 'index']);
            } else {
                if($isResetPassword){
                    $this->Flash->error(__('Reset Password Failed!'), ['key' => 'reset']);
                }else{
                    $this->Flash->error(__('The user could not be saved. Please, try again.'));
                }
                $this->getEventManager()->dispatch(new Event('Users.Admin.Users.edit.after.save.error', $this, ['user' => &$user]));
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
        $this->getRequest()->allowMethod(['post', 'delete']);
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
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            if((new DefaultPasswordHasher())->check($this->getRequest()->getData('old_password'), $user->password)){
                $user = $this->Users->patchEntity($user, $this->getRequest()->getData);
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
        $this->viewBuilder()->setLayout('login');
        if($this->getRequest()->is('post') && !empty($this->getRequest()->getData())){
            $cookie = $this->Cookie->read('remember_me');
            $this->setRequest($this->getRequest()->withData('username', $cookie['username']));
            $user = $this->Auth->identify();
            if ($user) {
                $this->getEventManager()->dispatch(new Event('Users.Admin.Users.unlock.success', $this, ['user' => &$user]));
                $this->Auth->setUser($user);
                $this->__setCookie();
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $user = $this->Users->find()->where(['Users.username' => $cookie['username']])->first();
                $this->Flash->error(__d('users', 'password is incorrect or your account may be disabled'), ['key' => 'Auth']);
                $this->getEventManager()->dispatch(new Event('Users.Admin.Users.unlock.failed', $this));
            }
        }else{
            if(Configure::check('unlock')){
                $user = Configure::read('unlock');
                $user = $this->Users->find()->where(['Users.username' => $user['username']])->first();
            }else{
                $cookie = $this->Cookie->read('remember_me');
                $user = null;
                if(!empty($cookie)){
                    $user = $this->Users->find()->where(['Users.username' => $cookie['username']])->first();
                    $user = Configure::delete('unlock');
                }
            }
            if(empty($user)){
                return $this->redirect($this->Auth->redirectUrl());
            }
        }
        $this->set(compact('user'));
    }
}
