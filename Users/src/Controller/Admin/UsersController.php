<?php
namespace Users\Controller\Admin;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Auth\PasswordHasherFactory;
use Cake\Event\Event;
use Users\Controller\AppController;

/**
 * Users Controller
 *
 * @property \Users\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    /**
     * Login admin users
     * @return \Cake\Network\Response|void
     */
    public function login(){
        $this->viewBuilder()->layout('login');
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->eventManager()->dispatch(new Event('Users.Admin.Users.login.success', $this, ['user' => &$user]));
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(
                    __d('users', 'Username or password is incorrect'), ['key' => 'Auth']
                );
                $this->eventManager()->dispatch(new Event('Users.Admin.Users.login.failed', $this));
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
//        debug($this->Auth->user());die;
//        $this->Auth->check($capabilities, $userId);
        $query = $this->Users->find('search', $this->Users->filterParams($this->request->query))
            ->contain(['Roles']);
        $this->set('users', $this->paginate($query));
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
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $users = $this->Users->Presenters->find('list', ['limit' => 200]);
        $cities = $this->Users->Cities->find('list', ['limit' => 200]);
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $banks = $this->Users->Banks->find('list', ['limit' => 200]);
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
        $user = $this->Users->get($id, [
            'contain' => ['Banks']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $users = $this->Users->Users->find('list', ['limit' => 200]);
        $cities = $this->Users->Cities->find('list', ['limit' => 200]);
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $banks = $this->Users->Banks->find('list', ['limit' => 200]);
        $this->set(compact('user', 'users', 'cities', 'roles', 'banks'));
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
}
