<?php
namespace AclManager\Event;

use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\ORM\Entity;
use Cake\ORM\Locator\TableLocator;
use Cake\ORM\Query;
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
            'Spider.bootstrap.complete' => 'onAfterBootstrap',
        ];
	}

    public function onAfterBootstrap(Event $event)
    {
        $acosConstants = Configure::read('acos');
        if(!empty($acosConstants)){
            foreach($acosConstants as $constant => $value){
                define($constant, $value['name']);
            }
        }
    }

	public function onUserLoginSuccessfully(Event $event)
	{
		$user = $event->getData('user');
		$user['roles'] = [];
		$UsersRoles = (new TableLocator)->get('AclManager.UsersRoles');
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
		$table = $event->getSubject();
		if($table->getRegistryAlias() == 'Users.Users'){
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
		$this->table = $event->getSubject();
		if (($this->table->getRegistryAlias() == 'Users.Users') && isset($data['roles'])) {
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
		$table = $event->getSubject();
		if(($table->getRegistryAlias() == 'Users.Users')){
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
	    $table = $event->getSubject();
		if($table->getRegistryAlias() == 'Users.Users'){
			//Associate AclManager.Roles to Users.Users model
			$table->belongsToMany('AclManager.Roles', [
				'through' => 'AclManager.UsersRoles',
				'foreignKey' => 'user_id',
			]);
		}
	}

	public function onAfterSpiderInitialized(Event $event)
	{
	    $this->controller = $event->getSubject();
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
		$currentUrl = $this->controller->request->getPath();
		$adminScope = trim(SpiderNav::getAdminScope(), '/');
		if(strpos($currentUrl, $adminScope) === 0){
			$this->controller->Auth->setConfig('loginAction', $this->controller->Auth->getConfig('admin.loginAction'));
			$this->controller->Auth->setConfig('loginRedirect', $this->controller->Auth->getConfig('admin.loginRedirect'));
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
            $Users = (new TableLocator)->get('Users.Users');
            $user = $Users->find()->where(['Users.username' => $cookie['username']])->first();
            if(!empty($user) && $user['status'] > 0){
                $currentUrl = $this->controller->request->getUri();
                $adminScope = trim(SpiderNav::getAdminScope(), '/');
                // If url is an admin url
                if(strpos($currentUrl, $adminScope) === 0){
                    //go to unlock page to get password to login
                    Configure::write('unlock', $user);
                    $unlockUrl = SpiderNav::getAdminScope() . '/unlock';
                    if($this->controller->request->getUri() != trim($unlockUrl, '/')){
                        return $this->controller->redirect($unlockUrl);
                    }
                }else{
                    $this->controller->Auth->setUser($cookie);
                }
            }
        }
    }
}