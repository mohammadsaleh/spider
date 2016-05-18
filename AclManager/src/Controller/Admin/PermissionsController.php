<?php
namespace AclManager\Controller\Admin;

use AclManager\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Permissions Controller
 *
 * @property \AclManager\Model\Table\PermissionsTable $Permissions
 */
class PermissionsController extends AppController
{

    /**
     * Index method
     *
     */
    public function index()
    {
        $Roles = TableRegistry::get('Users.Roles');
        $roles = $Roles->find('treeList', [
            'keyPath' => 'id',
            'valuePath' => 'title',
            'spacer' => '|-'
        ]);
        $this->set(compact('roles'));
    }

    public function acoList($id = null)
    {
        debug($this->Acl->allowRoles('plugin/b2b', ['registered', 'public']));die;
        debug($this->Acl->allowRoles('plugin/b2b/tours/edit', 'registered'));die;
        debug($this->Acl->checkRoles(1, 'plugin/b2b/tours/edit'));die;
        die;
        $Aros = TableRegistry::get('AclManager.Aros');
        $allAcos = $this->Aco->getAll();
        if($id){
            $ownAro = $this->Aro->getAros(['role_id' => $id, 'parents' => false]);
            $parentAro = $this->Aro->getAros(['role_id' => $id, 'parents' => true, 'own' => false]);
            $ownPermissions = $this->Aro->getPermissions($ownAro);
            $parentsPermissions = $this->Aro->getPermissions($parentAro);
        }
//        $acoNames = array_flip(array_merge(array_keys($ownPermissions), array_keys($parentsPermissions)));
//        $allAcos = array_diff_key($allAcos, $acoNames);
        debug($ownPermissions);
        debug($parentsPermissions);
        debug($allAcos);die;
    }
    /**
     * View method
     *
     * @param string|null $id Permission id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $permission = $this->Permissions->get($id, [
            'contain' => []
        ]);

        $this->set('permission', $permission);
        $this->set('_serialize', ['permission']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $permission = $this->Permissions->newEntity();
        if ($this->request->is('post')) {
            $permission = $this->Permissions->patchEntity($permission, $this->request->data);
            if ($this->Permissions->save($permission)) {
                $this->Flash->success(__('The permission has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The permission could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('permission'));
        $this->set('_serialize', ['permission']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Permission id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $permission = $this->Permissions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $permission = $this->Permissions->patchEntity($permission, $this->request->data);
            if ($this->Permissions->save($permission)) {
                $this->Flash->success(__('The permission has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The permission could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('permission'));
        $this->set('_serialize', ['permission']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Permission id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $permission = $this->Permissions->get($id);
        if ($this->Permissions->delete($permission)) {
            $this->Flash->success(__('The permission has been deleted.'));
        } else {
            $this->Flash->error(__('The permission could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
