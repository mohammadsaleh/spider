<?php
namespace AclManager\Event;

use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

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
		    'Model.afterSave' => 'onAfterSave',
		    'SpiderController.afterInitialize' => 'onAfterSpiderInitialized',
		    'SpiderTable.afterConstruct' => 'onAfterSpiderTableConstruct',
		    'Users.Users.add.success' => 'onUserAddSuccessfully',
		    'Users.Users.login.success' => 'onUserLoginSuccessfully'
	    ];
	}

	public function onUserLoginSuccessfully(Event $event)
	{
		$user = &$event->data['user'];
		$user['roles'] = [];
		$UsersRoles = TableRegistry::get('AclManager.UsersRoles');
		$roles = $UsersRoles->find()->where(['user_id' => $user['id']])->contain(['Roles'])->toArray();
		if(!empty($roles)){
			$user['roles'] = Hash::extract($roles, '{n}.role');
		}
	}

	//process roles = 2 or roles = [2, 10] or roles = ['public', 'superadmin'] or roles = 'public'
	//convert all to roles = [ ['id' => 2], ['id' => 10] ] standard
	//then save AclManager.Roles
	//then set access.
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

	public function onAfterSave(Event $event, Entity $entity, $options = [])
	{
		$table = $event->subject();
		if(($table->alias() == 'UsersRoles')){
			$this->controller->Acl->setUserRole($entity['user_id'], $entity['role_id']);
		}
	}
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

	public function onUserAddSuccessfully(Event $event)
	{
		$controller = $event->subject();
		$user = $event->data['user'];
		//set permission for this user base on role id.

		//todo: role_id may has array, then we should save all role_id in users_AclManager.Roles then foreach setUserRole
		$controller->Acl->setUserRole($user['id'], $user['role_id']);
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
		if($this->controller->Acl->checkRole('public', $this->controller->Acl->request())){
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
		if($this->controller->request->prefix == $this->controller->Auth->config('admin.prefix')){
			$this->controller->Auth->config('loginAction', $this->controller->Auth->config('admin.loginAction'));
			$this->controller->Auth->config('loginRedirect', $this->controller->Auth->config('admin.loginRedirect'));
		}
		if(!$this->controller->Auth->user()){
			$this->_tryLoginUserWithCookie();
		}
	}

	/**
	 * Check remember me and if set login user with it's cookie.
	 */
	protected function _tryLoginUserWithCookie()
	{
		if($this->controller->Cookie->check('remember_me')){
			$cookie = $this->controller->Cookie->read('remember_me');
			$this->controller->Auth->setUser($cookie);
		}
	}
}