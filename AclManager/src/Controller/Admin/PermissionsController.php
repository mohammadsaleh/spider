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
    }
    /**
     * Index method
     *
     */
    public function index($roleId = null)
    {
        $allAcos = $this->Aco->getAll();
        $this->set(compact('allAcos'));
//        debug($allAcos);
        $permissions = [];
        if($this->request->is('post') && !empty($this->request->data)){
            $allowAcos = $this->request->data('permissions');
            $denyAcos = array_diff(array_keys($allAcos), $allowAcos);
            foreach($denyAcos as $acoName){
                $this->Acl->clearRoleAccess($acoName, (int)$roleId);
            }
            foreach($allowAcos as $acoName){
                $this->Acl->setRoleAccess($acoName, (int)$roleId);
            }
            //save permissions
        }else if($this->request->is('ajax') && !empty($roleId)){
            //load permissions related to roleId
            $this->viewBuilder()->layout(false);
            $permissions = $this->Aro->getPermissions($this->Aro->getRole($roleId));
            $this->viewBuilder()->template('ajax_permissions');
            $permissions = array_keys($permissions);
//        debug($permissions);die;
        }
        //load page
        $Roles = TableRegistry::get('AclManager.Roles');
        $roles = $Roles->find('treeList')->toArray();
//            debug($roles);die;
        $this->set(compact('permissions', 'roles', 'roleId'));
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
        foreach(Configure::read('acos') as $aco){
            $resources[$aco['name']] = $aco['name'];
        }
        foreach($resources as $acoPath){
            if(!$this->Aco->check($acoPath)){
                $this->Aco->add(['name' => $acoPath]);
            }
        }
        $this->Flash->success('Sync completed.');
        $this->redirect(['action' => 'index']);
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

}
