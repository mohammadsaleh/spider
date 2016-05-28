<?php
namespace Install\Lib;

use Cake\Filesystem\File;
use Cake\Datasource\ConnectionManager;

class InstallManager
{
    /**
     * Default configuration
     *
     * @var array
     * @access public
     */
    public $defaultConfig = [
        'datasource' => 'Cake\Database\Driver\Mysql',
        'persistent' => false,
        'host'       => 'localhost',
        'login'      => 'root',
        'password'   => '',
        'database'   => 'spider',
        'schema'     => null,
        'prefix'     => null,
        'timezone'   => 'UTC',
        'encoding'   => 'UTF8',
        'port'       => null,
    ];

    public function createDatabaseFile($data)
    {
        $config = $this->defaultConfig;
        foreach ($data['Install'] as $key => $value) {
            if (isset($data['Install'][$key])) {
                $config[$key] = $value;
            }
        }
        $result = copy(INSTALL . DS . 'config' . DS . 'database.php.default', INSTALL . DS . 'config' . DS . 'database.php');
        if (!$result) {
            return __d('spider', 'Could not copy database.php file.');
        }
        $file = new File(INSTALL . DS . 'config' . DS . 'database.php', true);
        $content = $file->read();
        foreach ($config as $configKey => $configValue) {
            $content = str_replace('{default_' . $configKey . '}', $configValue, $content);
        }
        if (!$file->write($content)) {
            return __d('spider', 'Could not write database.php file.');
        }
        
        try {            
//            ConnectionManager::config('default',$config);            
            $connection = ConnectionManager::get('default');
            
            
        } catch (MissingConnectionException $e) {
            return __d('spider', 'Could not connect to database: ') . $e->getMessage();
        }        
        if (!$connection->connect()) {
            return __d('spider', 'Could not connect to database.');
        }
        
        return true;
    }

    public function createCroogoFile()
    {
        $croogoConfigFile = APP . 'config' . DS . 'croogo.php';
        $result = copy($croogoConfigFile . '.install', $croogoConfigFile);
        if (!$result) {
            $msg = 'Unable to copy file "croogo.php"';
            Log::critical($msg);
            return $msg;
        }
        $File =& new File($croogoConfigFile);
        $salt = Security::generateAuthKey();
        $seed = mt_rand() . mt_rand();
        $contents = $File->read();
        $contents = preg_replace('/(?<=Configure::write\(\'Security.salt\', \')([^\' ]+)(?=\'\))/', $salt, $contents);
        $contents = preg_replace('/(?<=Configure::write\(\'Security.cipherSeed\', \')(\d+)(?=\'\))/', $seed, $contents);
        if (!$File->write($contents)) {
            $msg = 'Unable to write your Config' . DS . 'spider.php file. Please check the permissions.';
            return $msg;
        }
        Configure::write('Security.salt', $salt);
        Configure::write('Security.cipherSeed', $seed);
        return true;
    }

    /**
     * Create settings.json from default file
     *
     * @return bool true when successful
     */
    public function createSettingsFile()
    {
        return copy(APP . 'config' . DS . 'settings.json.install', APP . 'config' . DS . 'settings.json');
    }

    /**
     * Mark installation as complete
     *
     * @return bool true when successful
     */
    public function installCompleted()
    {
        $Setting = ClassRegistry::init('Settings.Setting');
        $Setting->Behaviors->disable('Cached');
        if (!function_exists('mcrypt_decrypt')) {
            $Setting->write('Access Control.autoLoginDuration', '');
        }
        return $Setting->write('Croogo.installed', 1);
    }
}