<?php
namespace Spider\Lib;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\ORM\Table;
use Cake\Routing\Router;
use Cake\Utility\Hash;

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
		$objectName = ($plugin = Router::getRequest()->param('plugin')) ? ($plugin . '.' . $objectName) : $objectName;
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
				$propertyValue = Hash::merge($propertyValue, $value);
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
		self::hookControllerMethod($controllerName, 'loadHelper', $helperName);
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
	
}