<?php
namespace AclManager\Controller\Admin;

use AclManager\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Utility\Text;


/**
 * Permissions Controller
 *
 * @property \AclManager\Model\Table\PermissionsTable $Permissions
 */
class PermissionsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow();
    }
    /**
     * Index method
     *
     */
    public function index()
    {
        $Roles = TableRegistry::get('AclManager.Roles');
        $roles = $Roles->find('treeList', [
            'keyPath' => 'id',
            'valuePath' => 'title',
            'spacer' => '|-'
        ]);
        $this->set(compact('roles'));
    }

    /**
     * Sync controller actions with aco table
     */
    public function sync()
    {
        $resources = $this->Acl->getResources();
        //campare records with table records and diff, if exist in table and not exist in array so remove from table.
        $pluginAcos = $this->Aco->startWith('plugin/');
        $pluginAcos = Hash::combine($pluginAcos, '{n}.id', '{n}.name');

        //Find table actions which deleted from it's controller, so we must delete those from aco table too
        $deleteAcos = array_diff($pluginAcos, array_keys($resources));
        foreach($deleteAcos as $id => $aco){
            $this->Aco->remove($id);
        }

        //Find resources which not exist in aco table so must be add
        $resources = array_diff(array_keys($resources), $pluginAcos);
        foreach($resources as $acoPath){
            if(!$this->Aco->check($acoPath)){
                $this->Aco->add(['name' => $acoPath]);
            }
        }
    }

    public function acoList($id = null)
    {
        $Users = TableRegistry::get('Users.Users');
//        $user = $Users->newEntity([
//            'username' => 'ali_s'.Text::uuid().'@gmail.com',
//            'password' => 123456789,
//            'confirm_password' => 123456789,
//            'roles' => ['public', 'superadmin', 'agency', 'registered']
//        ]);
        $user = $Users->get(36);
        $Users->patchEntity($user, ['roles' => ['superadmin', 'public', 'agency', 'registered']]);
//        debug($user);die;
        $Users->save($user);
        debug($user);
        debug($user->errors());
//        $this->Acl->getResources();
//        $this->Acl->setUserRole(2, 2);
        die;
//        debug($this->Acl->denyRole('plugin/b2b', 'registered'));die;
//        debug($this->Acl->allowUser('plugin/b2b', 1));die;
        debug($this->Acl->allowRole('plugin/b2b', 'registered'));die;
        debug($this->Acl->allowRole('plugin/b2b/tours/edit', 'registered'));die;
        debug($this->Acl->checkRole(1, 'plugin/b2b/tours/edit'));die;
        die;
        $Aros = TableRegistry::get('AclManager.Aros');
        $allAcos = $this->Aco->getAll();
        if($id){
//            $ownAro = $this->Aro->getAros(['role_id' => $id, 'parents' => false]);
//            $parentAro = $this->Aro->getAros(['role_id' => $id, 'parents' => true, 'own' => false]);
//            $ownPermissions = $this->Aro->getPermissions($ownAro);
//            $parentsPermissions = $this->Aro->getPermissions($parentAro);
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
