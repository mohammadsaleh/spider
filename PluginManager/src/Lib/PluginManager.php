<?php
/**
 * Created by PhpStorm.
 * User: Davari
 * Date: 9/18/2016
 * Time: 5:13 PM
 */

namespace PluginManager\Lib;

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
        $themeType = strtoupper($themeType);
        return env("{$themeType}_THEME_PLUGIN");
    }
}