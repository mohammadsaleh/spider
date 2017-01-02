<?php
namespace Spider\Lib;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\ORM\Table;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;

class Hook
{
    /**
     * Hook model property
     *
     * Useful when models need to be associated to another one, setting Behaviors, disabling cache, etc.
     *
     * @param string $modelName Model name (for e.g., Node)
     * @param string $method  for e.g., addBehavior
     * @param string $value     array or string
     */
    public static function hookTableMethod($modelName, $method, $value)
    {
        $configKeyPrefix = 'Hook.table_methods';
        self::_hookMethod($configKeyPrefix, $modelName, $method, $value);
    }

    /**
     * Hook method
     *
     * @param string $configKeyPrefix
     * @param string $modelName
     * @param string $method
     * @param string $value
     */
    protected static function _hookMethod($configKeyPrefix, $modelName, $method, $value) {
        $propertyValue = Configure::read($configKeyPrefix . '.' . $modelName . '.' . $method);
        if (!is_array($propertyValue)) {
            $propertyValue = null;
        }
        if (is_array($value)) {
            if (is_array($propertyValue)) {
                $propertyValue = Hash::merge($propertyValue, $value);
            } else {
                $propertyValue = $value;
            }
        } else {
            $propertyValue = $value;
        }
        Configure::write($configKeyPrefix . '.' . $modelName . '.' . $method, $propertyValue);
    }

    /**
     * Applies methods set from hooks to an object in __construct()
     *
     * @param string $configKey
     */
    public static function applyHookMethods($configKey, &$object = null) {
        if (empty($object)) {
            $object = self;
        }
        if($object instanceof Table){
            $objectName = $object->alias();
        }else{
            $objectName = $object->name;
        }
        if(php_sapi_name() !== 'cli'){
            $prefix = ($prefix = Router::getRequest()->param('prefix')) ? (Inflector::camelize($prefix) . '.') : '';
            $plugin = ($plugin = Router::getRequest()->param('plugin')) ? ($plugin . '.') : '';
            $objectName = $prefix . $plugin . $objectName;
            $hookMethods = Configure::read($configKey . '.' . $objectName);
            if (is_array(Configure::read($configKey . '.*'))) {
                $hookMethods = Hash::merge(Configure::read($configKey . '.*'), $hookMethods);
            }
            if (is_array($hookMethods)) {
                foreach ($hookMethods as $method => $values) {
                    if(is_callable([$object, $method])){
                        foreach($values as $name => $config){
                            $object->$method($name, $config);
                        }
                    }
                }
            }
        }
    }

    /**
     * Load Hook helpers as a normal load.
     *
     * @param $configKey
     * @param $View
     */
    public static function applyHookHelpers($configKey, $View)
    {
        $prefix = ($prefix = $View->request->param('prefix')) ? (Inflector::camelize($prefix) . '.') : '';
        $plugin = ($plugin = $View->request->param('plugin')) ? ($plugin . '.') : '';
        $controller = $View->request->param('controller');
        $objectName = $prefix . $plugin . $controller;
        $hookHelpers = Configure::read($configKey . '.' . $objectName);
        if (is_array(Configure::read($configKey . '.*'))) {
            $hookHelpers = Hash::merge(Configure::read($configKey . '.*'), $hookHelpers);
        }
        if (is_array($hookHelpers)) {
            foreach ($hookHelpers as $name => $config) {
                $View->loadHelper($name, $config);
            }
        }
    }
    /**
     * Apply load config files for * / particular Plugin
     * @param $configKey
     * @param $pluginName
     */
    public static function applyHookConfigFiles($configKey, $pluginName)
    {
        $hookConfigs = Configure::read($configKey . '.' . $pluginName);
        if (is_array(Configure::read($configKey . '.*'))) {
            $hookConfigs = Hash::merge(Configure::read($configKey . '.*'), $hookConfigs);
        }
        if(!empty($hookConfigs)){
            $hookConfigs = array_unique($hookConfigs);
            foreach($hookConfigs as $configName){
                $file = Plugin::path($pluginName) . 'config' . DS . $configName . '.php';
                if (file_exists($file)) {
                    Configure::load($pluginName . '.' . $configName);
                }
            }
        }
    }

    /**
     * Hook config
     *
     * @param string $configKeyPrefix
     * @param string $value
     */
    protected static function _hookConfig($configKeyPrefix, $value) {
        $propertyValue = Configure::read($configKeyPrefix);
        if (!is_array($propertyValue)) {
            $propertyValue = null;
        }
        if (is_array($value)) {
            if (is_array($propertyValue)) {
                $propertyValue = array_merge_recursive($propertyValue, $value);
            } else {
                $propertyValue = $value;
            }
        } else {
            $propertyValue = $value;
        }
        Configure::write($configKeyPrefix, $propertyValue);
    }

    /**
     * Load as a normal Configure::load() config file for given plugin or *
     * @param $pluginName
     * @param $configName
     */
    public static function configFile($pluginName, $configName)
    {
        if(!is_array($configName)){
            $configName = [$configName];
        }
        self::_hookConfig('Hook.config_files', [$pluginName => $configName]);
    }

    /**
     * Loads as a normal helper via controller.
     *
     * @param string $controllerName
     * @param mixed $helperName Helper name or array of Helper and settings
     */
    public static function helper($controllerName, $helperName) {
        if (is_string($helperName)) {
            $helperName =[$helperName => []];
        }
        self::_hookConfig('Hook.helpers', [$controllerName => $helperName]);
    }

    /**
     * Hook controller method
     *
     * @param string $controllerName Controller name (for e.g., Nodes)
     * @param string $method       for e.g., components
     * @param string $value          array or string
     */
    public static function hookControllerMethod($controllerName, $method, $value) {
        $configKeyPrefix = 'Hook.controller_methods';
        self::_hookMethod($configKeyPrefix, $controllerName, $method, $value);
    }

    /**
     * Loads as a normal component from controller.
     *
     * @param string $controllerName Controller Name
     * @param mixed $componentName  Component name or array of Component and settings
     */
    public static function component($controllerName, $componentName) {
        if (is_string($componentName)) {
            $componentName = [$componentName => []];
        }
        self::hookControllerMethod($controllerName, 'loadComponent', $componentName);
    }

    /**
     * Loads as a normal behavior from table.
     *
     * @param $modelName Model name
     * @param $behaviorName Behavior name
     * @param array $config array of Behavior settings
     */
    public static function behavior($modelName, $behaviorName, $config = [])
    {
        self::hookTableMethod($modelName, 'addBehavior', [$behaviorName => $config]);
    }

    /**
     * Hook admin actions
     *
     * @param $viewPath
     * @param $element
     * @param bool $prepend : not working good still. it's because beforeRender run soon and it means always append.
     */
    public static function adminActions($viewPath, $element, $prepend = false)
    {
        $configKeyPrefix = 'Hook.admin_actions';
        if(!is_array($viewPath)){
            $viewPath = [$viewPath];
        }
        foreach ($viewPath as $path) {
            self::_hookConfig($configKeyPrefix, [$path => ['element' => $element, 'prepend' => $prepend]]);
        }
    }

    /**
     * Hook admin actions
     *
     * @param $viewPath
     * @param $element
     * @param bool $prepend : not working good still. it's because beforeRender run soon and it means always append.
     */
    public static function adminBox($viewPath, $element, $prepend = false)
    {
        $configKeyPrefix = 'Hook.admin_box';
        if(!is_array($viewPath)){
            $viewPath = [$viewPath];
        }
        foreach ($viewPath as $path) {
            self::_hookConfig($configKeyPrefix, [$path => ['element' => $element, 'prepend' => $prepend]]);
        }
    }

    /**
     * Hook admin form
     *
     * @param $viewPath
     * @param $element
     * @param bool $prepend : not working good still. it's because beforeRender run soon and it means always append.
     */
    public static function adminForm($viewPath, $element, $prepend = false)
    {
        $configKeyPrefix = 'Hook.admin_form';
        if(!is_array($viewPath)){
            $viewPath = [$viewPath];
        }
        foreach ($viewPath as $path) {
            self::_hookConfig($configKeyPrefix, [$path => [['element' => $element, 'prepend' => $prepend]]]);
        }
    }

    /**
     * Hook admin navbar
     *
     * @param $viewPath
     * @param $element
     * @param bool $prepend
     */
    public static function adminNavbar($viewPath, $element, $prepend = false)
    {
        $configKeyPrefix = 'Hook.admin_navbar';
        if(!is_array($viewPath)){
            $viewPath = [$viewPath];
        }
        foreach ($viewPath as $path) {
            self::_hookConfig($configKeyPrefix, [$path => [['element' => $element, 'prepend' => $prepend]]]);
        }
    }

}