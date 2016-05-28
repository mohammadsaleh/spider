<?php

namespace Install\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Install\Model\Entity\Install;
use Spider\Model\Table\SpiderTable;
use Cake\Core\Configure; 

class InstallTable extends SpiderTable
{

  
    /** 
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);        
        $this->table('');
    }


    public function addAdminUser($user)
    {
        if (!Plugin::loaded('Users')) {
            Plugin::load('Users');
        }
        $User = ClassRegistry::init('Users.User');
        $Role = ClassRegistry::init('Users.Role');
        $Role->Behaviors->attach('Croogo.Aliasable');
        unset($User->validate['email']);
        $user['User']['name'] = $user['User']['username'];
        $user['User']['email'] = '';
        $user['User']['timezone'] = 0;
        $user['User']['role_id'] = $Role->byAlias('admin');
        $user['User']['status'] = true;
        $user['User']['activation_key'] = md5(uniqid());
        $User->create();
        $saved = $User->save($user);
        if (!$saved) {
            $this->log('Unable to create administrative user. Validation errors:');
            $this->log($User->validationErrors);
        }
        return $saved;
    }

    /**
     * Run Migrations and add data in table
     *
     * @return bool True if migrations have succeeded
     */
    public function setupDatabase()
    {
        $plugins = Configure::read('Core.corePlugins');
        
        $migrationsSucceed = true;
        foreach ($plugins as $plugin) {
            $migrationsSucceed = $this->runMigrations($plugin);
            if (!$migrationsSucceed) {
                $this->log('Migrations failed for ' . $plugin, LOG_CRIT);
                break;
            }
        }
        if ($migrationsSucceed) {
            $DataMigration = new DataMigration();
            $path = App::pluginPath('Install') . DS . 'config' . DS . 'Data' . DS;
            $DataMigration->load($path);
        }
        return $migrationsSucceed;
    }

    public function runMigrations($plugin)
    {
        if (!Plugin::loaded($plugin)) {
            Plugin::load($plugin);
        }
        $CroogoPlugin = $this->_getCroogoPlugin();
        $result = $CroogoPlugin->migrate($plugin);
        if (!$result) {
            $this->log($CroogoPlugin->migrationErrors);
        }
        return $result;
    }

    protected function _getCroogoPlugin()
    {
        if (!($this->_CroogoPlugin instanceof CroogoPlugin)) {
            $this->_setCroogoPlugin(new CroogoPlugin());
        }
        return $this->_CroogoPlugin;
    }

    protected function _setCroogoPlugin($croogoPlugin)
    {
        unset($this->_CroogoPlugin);
        $this->_CroogoPlugin = $croogoPlugin;
    }
}