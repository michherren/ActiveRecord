<?php
require_once(dirname(__FILE__) . '/../Exception/class.arException.php');

/**
 * Class arObjectCache
 *
 * @version 2.1.0
 *
 * @author  Fabian Schmid <fs@studer-raimann.ch>
 */
class arObjectCache {

	/**
	 * @var array
	 */
	protected static $cache = array();


	/**
	 * @param string $class_name
	 * @param        $id
	 *
	 * @return bool
	 */
	public static function isCached($class_name, $id) {
		if (!isset(self::$cache[$class_name])) {
			return false;
		}
		if (!isset(self::$cache[$class_name][$id]) OR !self::$cache[$class_name][$id] instanceof ActiveRecord) {
			return false;
		}

		return in_array($id, array_keys(self::$cache[$class_name]));
	}


	/**
	 * @param ActiveRecord $object
	 */
	public static function store(ActiveRecord $object) {
		if (!isset($object->is_new)) {
			self::$cache[get_class($object)][$object->getPrimaryFieldValue()] = $object;
		}
	}


	public static function printStats() {
		foreach (self::$cache as $class => $objects) {
			echo $class;
			echo ": ";
			echo count($objects);
			echo " Objects<br>";
		}
	}


	/**
	 * @param string $class_name
	 * @param        $id
	 *
	 * @throws arException
	 * @return ActiveRecord
	 */
	public static function get($class_name, $id) {
		if (!self::isCached($class_name, $id)) {
			throw new arException(arException::GET_UNCACHED_OBJECT, $class_name . ': ' . $id);
		}

		return self::$cache[$class_name][$id];
	}


	/**
	 * @param ActiveRecord $object
	 */
	public static function purge(ActiveRecord $object) {
		unset(self::$cache[get_class($object)][$object->getPrimaryFieldValue()]);
	}
}

?>
