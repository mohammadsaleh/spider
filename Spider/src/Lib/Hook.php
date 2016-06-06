<?php
namespace Spider\Lib;

use Cake\Core\Configure;
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
	 * Applies properties set from hooks to an object in __construct()
	 *
	 * @param string $configKey
	 */
	public static function applyHookProperties($configKey, &$object = null) {
		if (empty($object)) {
			$object = self;
		}
		debug(Configure::read($configKey));die;
		$objectName = empty($object->name) ? get_class($object) : $object->name;
		$hookProperties = Configure::read($configKey . '.' . $objectName);
		if (is_array(Configure::read($configKey . '.*'))) {
			$hookProperties = Hash::merge(Configure::read($configKey . '.*'), $hookProperties);
		}
		if (is_array($hookProperties)) {
			foreach ($hookProperties as $property => $value) {
				if (!isset($object->$property)) {
					$object->$property = $value;
				} else {
					if (is_array($object->$property)) {
						if (is_array($value)) {
							$object->$property = Hash::merge($object->$property, $value);
						} else {
							$object->$property = $value;
						}
					} else {
						$object->$property = $value;
					}
				}
			}
		}
	}

	/**
	 * Loads as a normal helper via controller.
	 *
	 * @param string $controllerName
	 * @param mixed $helperName Helper name or array of Helper and settings
	 */
	public static function hookHelper($controllerName, $helperName) {
		if (is_string($helperName)) {
			$helperName = array($helperName);
		}
		self::hookControllerProperty($controllerName, 'helpers', $helperName);
	}
	/**
	 * Hook controller property
	 *
	 * @param string $controllerName Controller name (for e.g., Nodes)
	 * @param string $property       for e.g., components
	 * @param string $value          array or string
	 */
	public static function hookControllerProperty($controllerName, $property, $value) {
		$configKeyPrefix = 'Hook.controller_properties';
		self::_hookProperty($configKeyPrefix, $controllerName, $property, $value);
	}
	/**
	 * Loads as a normal component from controller.
	 *
	 * @param string $controllerName Controller Name
	 * @param mixed $componentName  Component name or array of Component and settings
	 */
	public static function hookComponent($controllerName, $componentName) {
		if (is_string($componentName)) {
			$componentName = array($componentName);
		}
		self::hookControllerProperty($controllerName, '_appComponents', $componentName);
	}
	public static function behavior($modelName, $behaviorName, $config = [])
	{
		self::hookTableMethod($modelName, 'addBehavior', [$behaviorName => $config]);
		debug(Configure::read('Hook.table_methods'));die;
	}
	
	public function component($controllerName, $componentName)
	{
	    
	}
	
	public function helper()
	{
	    
	}
}