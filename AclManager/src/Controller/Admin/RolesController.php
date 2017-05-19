<?php
namespace AclManager\Controller\Admin;

use AclManager\Controller\AppController;
use Cake\Utility\Hash;

/**
 * Roles Controller
 *
 * @property \AclManager\Model\Table\RolesTable $Roles
 */
class RolesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $treeRoles = $this->Roles->find('treeList')->toArray();
        $roles = $this->Roles->find('all')->toArray();
        $roles = Hash::combine($roles, '{n}.id', '{n}');

        $this->set(compact('roles', 'treeRoles'));
        $this->set('_serialize', ['roles']);
    }

    /**
     * View method
     *
     * @param string|null $id Role id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => ['ParentRoles', 'Users', 'ChildRoles']
        ]);

        $this->set('role', $role);
        $this->set('_serialize', ['role']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $role = $this->Roles->newEntity();
        if ($this->request->is('post')) {
            $role = $this->Roles->patchEntity($role, $this->request->data);

            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));
                $roleId = $role->id;
                $parentId = $role->parent_id;
                $parentPermissions = $this->Aro->getPermissions($this->Aro->getRole($parentId));
                foreach($parentPermissions as $parentAllowAco){
                    $acoName = $parentAllowAco['name'];
                    $this->Acl->setRoleAccess($acoName, (int)$roleId);
                }
                return $this->redirect(['action' => 'index']);
            }
            else {
                $this->Flash->error(__('The role could not be saved. Please, try again.'));
            }
        }
        $parentRoles = $this->Roles->ParentRoles->find('treeList')->toArray();
        $users = $this->Roles->Users->find('list', ['limit' => 200]);
        $this->set(compact('role', 'parentRoles', 'users'));
        $this->set('_serialize', ['role']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Role id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $role = $this->Roles->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            debug($role);
            $role = $this->Roles->patchEntity($role, $this->request->data);
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The role could not be saved. Please, try again.'));
            }
        }
        $parentRoles = $this->Roles->ParentRoles->find('treeList')->toArray();
        debug($parentRoles);die;
        unset($parentRoles[$id]);
        $users = $this->Roles->Users->find('list', ['limit' => 200]);
        $this->set(compact('role', 'parentRoles', 'users'));
        $this->set('_serialize', ['role']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Role id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $role = $this->Roles->get($id);
        if ($this->Roles->delete($role)) {
            $this->Flash->success(__('The role has been deleted.'));
        } else {
            $this->Flash->error(__('The role could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
