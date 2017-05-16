<?php
namespace AclManager\Event;

use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Spider\Lib\SpiderNav;

class AclManagerEventHandler implements EventListenerInterface
{
	/**
	 * @var \Cake\Controller\Controller
	 */
	public $controller = null;
	public $table = null;

	public function implementedEvents()
	{
	    return [
		    'Model.beforeMarshal' => 'onBeforeMarshal',
		    'Model.beforeFind' => 'onBeforeFind',
		    'Model.afterSave' => 'onAfterSave',
		    'SpiderController.afterInitialize' => 'onAfterSpiderInitialized',
		    'SpiderTable.afterConstruct' => 'onAfterSpiderTableConstruct',
		    'Users.Users.login.success' => 'onUserLoginSuccessfully',
			'Users.Admin.Users.login.success' => 'onUserLoginSuccessfully',
	    ];
	}

	public function onUserLoginSuccessfully(Event $event)
	{
		$user = $event->data['user'];
		$user['roles'] = [];
		$UsersRoles = TableRegistry::get('AclManager.UsersRoles');
		$roles = $UsersRoles->find()->where(['user_id' => $user['id']])->contain(['Roles'])->toArray();
		if(!empty($roles)){
			$user['roles'] = Hash::extract($roles, '{n}.role');
		}
		$event->setData('user', $user);
	}

	/**
	 * Before find any users, set contain to get user roles too.
	 *
	 * @param Event $event
	 * @param Query $query
	 * @param \ArrayObject $options
	 * @param $primary
	 */
	public function onBeforeFind(Event $event, /*Query*/ $query, \ArrayObject $options, $primary)
	{
		$table = $event->subject();
		if($table->alias() == 'Users'){
			$query->contain(['Roles']);
		}
	}

	/**
	 * Ready roles to save for user. ( If set $data['roles'] )
	 *
	 * process roles = 2 or roles = [2, 10] or roles = ['public', 'superadmin'] or roles = 'public'
	 * convert all to roles = [ ['id' => 2], ['id' => 10] ] standard
	 * then save AclManager.Roles
	 * then set access.
	 *
	 * @param Event $event
	 * @param \ArrayObject $data
	 * @param \ArrayObject $options
	 */
	public function onBeforeMarshal(Event $event, \ArrayObject $data, \ArrayObject $options)
	{
		$this->table = $event->subject();
		if (($this->table->alias() == 'Users') && isset($data['roles'])) {
			$roles = $data['roles'];
			if(!is_array($roles)){
				$roles = [$roles];
			}
			foreach($roles as &$role){
				if(is_string($role) && (int)$role === 0){
					//find role_id
					$result = $this->table->Roles->find()->where(['name' => $role])->first();
					if(!empty($result)){
						$role = $result['id'];
					}else{
						throw new Exception(__d('acl_manager', 'Role "' . $role . '" Not Found!'));
					}
				}

			}
			$roles = $this->_getInheritedRoles($roles);
			$data['roles'] = $roles;
		}
	}

	/**
	 * After save User entity then set it's private permissions
	 *
	 * @param Event $event
	 * @param Entity $entity
	 * @param array $options
	 */
	public function onAfterSave(Event $event, Entity $entity, $options = [])
	{
		$table = $event->subject();
		if(($table->alias() == 'Users')){
			$userId = $entity['id'];
			if(!isset($entity['permissions'])){
				$entity['permissions'] = [];
			}
			$oldPermissions = $this->controller->Aro->getPermissions($this->controller->Aro->getUser($userId));
			$oldPermissions = array_keys($oldPermissions);
			$willDeletePermissions = array_diff($oldPermissions, $entity['permissions']);
			foreach($willDeletePermissions as $permission){
				$this->controller->Acl->clearUserAccess($permission, $userId);
			}
			foreach($entity['permissions'] as $permission){
				$this->controller->Acl->setUserAccess($permission, $userId);
			}
		}
	}

	/**
	 * Remove parent roles and get the latest children of given roles
	 * So we sure that a powerful role will be selected.
	 * Suppose given roles is: public, registered, admin. so we just return registered as candidate, because has all of public and registered permissions.
	 *
	 * @param $roles
	 * @return array
	 */
	protected function _getInheritedRoles($roles)
	{
		$roleIds = [];
		foreach($roles as $key => $roleId){
			$children = $this->table->Roles->find('children', ['for' => $roleId])->combine('name', 'id')->toArray();
			if(!empty(array_intersect(array_diff($roles, [$roleId]), $children))){
				unset($roles[$key]);
			}else{
				$roleIds[] = ['id' => $roleId];
			}
		}
		return $roleIds;
	}

	public function onAfterSpiderTableConstruct(Event $event)
	{
	    $table = $event->subject();
		if($table->alias() == 'Users'){
			//Associate AclManager.Roles to Users.Users model
			$table->belongsToMany('AclManager.Roles', [
				'through' => 'AclManager.UsersRoles',
				'foreignKey' => 'user_id',
			]);
		}
	}

	public function onAfterSpiderInitialized(Event $event)
	{
	    $this->controller = $event->subject();
		$this->controller->loadComponent('AclManager.Acl');
		$this->controller->loadComponent('AclManager.Aco');
		$this->controller->loadComponent('AclManager.Aro');

		$this->controller->loadComponent('Cookie', [
				'expires' => '+3 days',
				'httpOnly' => true
		]);
		$this->_setupAuthComponent();
		$this->_setupAuthAccess();
		$this->_checkPublicAccess();
	}

	/**
	 * Check access control
	 */
	protected function _checkPublicAccess()
	{
		if($this->controller->Acl->checkRoleAllow('public', $this->controller->Acl->request())){
			$this->controller->Auth->allow();
		}
	}

	/**
	 * Setup Auth component settings
	 */
	protected function _setupAuthComponent(){
		$this->controller->loadComponent('Auth', Configure::read('Auth'));
	}

	/**
	 * Setting up auth access
	 */
	protected function _setupAuthAccess(){
		$this->controller->Auth->deny();
		$currentUrl = $this->controller->request->url;
		$adminScope = trim($this->controller->Auth->config('admin.scope'), '/');
		if(strpos($currentUrl, $adminScope) === 0){
			$this->controller->Auth->config('loginAction', $this->controller->Auth->config('admin.loginAction'));
			$this->controller->Auth->config('loginRedirect', $this->controller->Auth->config('admin.loginRedirect'));
		}
		if(!$this->controller->Auth->user()){
			$this->_tryLoginUserWithCookie();
		}
	}

    /**
     * Check remember me and login user with it's cookie, if set
     */
    protected function _tryLoginUserWithCookie()
    {
        if($this->controller->Cookie->check('remember_me')){
            $cookie = $this->controller->Cookie->read('remember_me');
            $Users = TableRegistry::get('Users.Users');
            $user = $Users->find()->where(['Users.username' => $cookie['username']])->first();
            if(!empty($user) && $user['status'] > 0){
                $currentUrl = $this->controller->request->url;
                $adminScope = trim($this->controller->Auth->config('admin.scope'), '/');
                if(strpos($currentUrl, $adminScope) === 0){
                    //go to unlock page to get password to login
                    Configure::write('unlock', $user);
                    $unlockUrl = SpiderNav::getAdminScope() . '/unlock';
                    if($this->controller->request->url != trim($unlockUrl, '/')){
                        return $this->controller->redirect($unlockUrl);
                    }
                }
                $this->controller->Auth->setUser($cookie);
            }
        }
    }
}