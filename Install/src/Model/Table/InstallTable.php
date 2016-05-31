<?php

namespace Install\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Install\Model\Entity\Install;
use Spider\Model\Table\SpiderTable;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use PluginManager\Lib\SpiderPlugin;
use Migrations\Migrations;

class InstallTable extends SpiderTable
{
    /**
     *
     * @var C
     */
    protected $_SpiderPlugin = null;
  
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
            $plugin  = explode('/', $plugin);
            $plugin  = $plugin[0];
            $migrationsSucceed = $this->runMigrations($plugin);
            if (!$migrationsSucceed) {
                $this->log('Migrations failed for ' . $plugin, LOG_CRIT);
                break;
            }
        }
//        if ($migrationsSucceed) {
//            $DataMigration = new DataMigration();
//            $path = App::pluginPath('Install') . DS . 'config' . DS . 'Data' . DS;
//            $DataMigration->load($path);
//        }
        return $migrationsSucceed;
    }

    public function runMigrations($plugin)
    {
        if (!Plugin::loaded($plugin)) {
            Plugin::load($plugin);
        }
//        $SpiderPlugin = $this->_getSpiderPlugin();        
//        $result = $SpiderPlugin->migrate($plugin);
//        if (!$result) {
//            $this->log($SpiderPlugin->migrationErrors);
//        }
        
        $migrations = new Migrations();
        $result = $migrations->migrate();
        
        return $result;
    }

    protected function _getSpiderPlugin()
    {
        if (!($this->_SpiderPlugin instanceof SpiderPlugin)) {
            $this->_SpiderPlugin(new SpiderPlugin());
        }
        return $this->_SpiderPlugin;
    }

    protected function _SpiderPlugin($spiderPlugin)
    {
        unset($this->_SpiderPlugin);
        $this->_SpiderPlugin = $spiderPlugin;
    }
    
}