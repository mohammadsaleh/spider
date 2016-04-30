<?php
namespace PluginManager\Lib;

use Cake\Core\App;
use Cake\Core\Exception\Exception;
use Cake\Filesystem\Folder;

class PluginInstaller
{
    public function __construct(){

    }

    /**
     * Installing plugin
     * @param null $zipPath
     * @return array|bool
     * @throws CakeException
     */
    public function install($zipPath = null){
        if (!file_exists($zipPath)) {
            throw new Exception(__d('spider', 'Invalid plugin file path'));
        }
        $pluginInfo = $this->getPluginMeta($zipPath);
        $pluginHomeDir = App::path('Plugin');
        $pluginHomeDir = reset($pluginHomeDir);
        $pluginPath = $pluginHomeDir . $pluginInfo->name . DS;
        if (is_dir($pluginPath)) {
            throw new Exception(__d('spider', 'Plugin already exists'));
        }
        $Zip = new \ZipArchive();
        if ($Zip->open($zipPath) === true) {
            new Folder($pluginPath, true);
            $Zip->extractTo($pluginPath);
            if (!empty($pluginInfo->rootPath)) {
                $old = $pluginPath . $pluginInfo->rootPath;
                $new = $pluginPath;
                $Folder = new Folder($old);
                $Folder->move($new);
            }
            $Zip->close();
            return (array)$pluginInfo;
        } else {
            throw new CakeException(__d('spider', 'Failed to extract plugin'));
        }
        return false;
    }

    /**
     * Retrieve plugin info from meta.json in zip
     * @param $zipPath
     * @return bool|mixed
     * @throws CakeException
     */
    public function getPluginMeta($zipPath){
        $Zip = new \ZipArchive();
        if ($Zip->open($zipPath) === true) {
            $search = 'config/meta.json';
            $indexJson = $Zip->locateName('meta.json', \ZipArchive::FL_NODIR);
            if ($indexJson === false) {
                throw new Exception(__d('spider', 'Invalid meta information in archive'));
            } else {
                $fileName = $Zip->getNameIndex($indexJson);
                $fileJson = json_decode($Zip->getFromIndex($indexJson));
                if (empty($fileJson->name)) {
                    throw new Exception(__d('spider', 'Invalid meta.json or missing plugin name'));
                }else{
                    $pluginRootPath = str_replace($search, '', $fileName);
                    $fileJson->rootPath = $pluginRootPath;
                }
            }
            $Zip->close();
            if(!isset($fileJson) || empty($fileJson)){
                throw new Exception(__d('spider', 'Invali meta.json'));
            }
            return $fileJson;
        } else {
            throw new CakeException(__d('spider', 'Invalid zip archive'));
        }
        return false;
    }
}