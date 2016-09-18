<?php
/**
 * Created by PhpStorm.
 * User: Davari
 * Date: 9/18/2016
 * Time: 5:13 PM
 */

namespace PluginManager\Lib;


use Cake\ORM\TableRegistry;

class PluginManager
{

    /**
     * Get default theme in plugins table.
     *
     * @param string $themeType front/admin
     * @return null
     */
    public static function getDefaultTheme($themeType = 'front')
    {
        $themeName = null;
        $Plugins = TableRegistry::get('PluginManager.Plugins');
        $theme = $Plugins->find('all')
            ->where(['theme' => $themeType])
            ->where(['`status`' => 1])
            ->where(['`default`' => 1])
            ->first();
        if(!empty($theme)){
            $themeName = $theme->name;
        }
        return $themeName;
    }
}