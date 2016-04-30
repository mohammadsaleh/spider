<?php
namespace Users\Controller\Admin;

use Cake\Utility\Hash;
use Users\Controller\AppController;

/**
 * Roles Controller
 *
 * @property \Users\Model\Table\RolesTable $Roles
 */
class RolesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $query = $this->Roles->find('treeList', ['spacer' => '|-']);
        $this->set('roles', $this->paginate($query));
        $this->set('_serialize', ['roles']);
    }

    /**
     * View method
     *
     * @param string|null $id Role id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => ['ParentRoles', 'Capabilities', 'ChildRoles', 'Users']
        ]);
        $this->set('role', $role);
        $this->set('_serialize', ['role']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $role = $this->Roles->newEntity();
        if ($this->request->is('post')) {
            $role = $this->Roles->patchEntity($role, $this->request->data);
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The role could not be saved. Please, try again.'));
            }
        }
        $parentRoles = $this->Roles->ParentRoles->find('list', ['limit' => 200]);
        $capabilities = $this->Roles->Capabilities->find('list', ['limit' => 200]);
        $this->set(compact('role', 'parentRoles', 'capabilities'));
        $this->set('_serialize', ['role']);
    }

    protected function _getAllRoleParentCapabilities($id){
        $parents = $this->Roles->find('path', ['for' => $id])->toArray();
        if(!empty($parents)){
            array_pop($parents);
            $parentsIds = [];
            foreach($parents as $parent){
                $parentsIds[] = $parent->id;
            }

            if(!empty($parentsIds)){
                $parentCapabilities = $this->Roles->Capabilities->find('list', [
                        'limit' => 200,
                        'keyField' => 'id',
                        'valueField' => 'description'
                    ])
                    ->matching('Roles', function($q) use ($parentsIds){
                        return $q->where(['Roles.id IN' => $parentsIds]);
                    });

                return $parentCapabilities->toArray();
            }
        }
        return [];
    }
    /**
     * Edit method
     *
     * @param string|null $id Role id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => ['Capabilities']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $role = $this->Roles->patchEntity($role, $this->request->data);
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The role could not be saved. Please, try again.'));
            }
        }
        $parentRoles = $this->Roles->ParentRoles->find('list', ['limit' => 200]);
        $allCapabilities = $this->Roles->Capabilities->find('list', [
            'limit' => 200,
            'keyField' => 'id',
            'valueField' => 'description'
        ])->toArray();
        $parentCapabilities = $this->_getAllRoleParentCapabilities($id);
        $allCapabilities = array_diff($allCapabilities, $parentCapabilities);
        ksort($parentCapabilities);
        ksort($allCapabilities);

        $this->set(compact('role', 'parentRoles', 'allCapabilities', 'parentCapabilities'));
        $this->set('_serialize', ['role']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Role id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
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
