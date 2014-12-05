<?php
require_once(dirname(__FILE__) . '/../Fields/class.arFieldList.php');

/**
 * Class arFieldCache
 *
 * @version 2.1.0
 *
 * @author  Fabian Schmid <fs@studer-raimann.ch>
 */
class arFieldCache {

	/**
	 * @var array
	 */
	protected static $cache = array();


	/**
	 * @param string $class_name
	 *
	 * @return bool
	 */
	public static function isCached($class_name) {
		return in_array($class_name, array_keys(self::$cache));
	}


	/**
	 * @param ActiveRecord $ar
	 */
	public static function store(ActiveRecord $ar) {
		self::$cache[get_class($ar)] = arFieldList::getInstance($ar);
	}


	/**
	 * @param                                   $storage_class_name
	 * @param \ActiveRecord|\arStorageInterface $foreign_model
	 *
	 * @internal param \ActiveRecord $storage
	 * @internal param $storage_class_name
	 */
	public static function storeFromStorage($storage_class_name, arStorageInterface $foreign_model) {
		self::$cache[$storage_class_name] = arFieldList::getInstanceFromStorage($foreign_model);
	}


	/**
	 * @param ActiveRecord $ar
	 *
	 * @internal param $class
	 * @internal param $id
	 *
	 * @return arFieldList
	 */
	public static function get(ActiveRecord $ar) {
		$class_name = get_class($ar);
		if (!self::isCached($class_name)) {
			self::store($ar);
		}

		return self::$cache[$class_name];
	}


	/**
	 * @param $class_name
	 *
	 * @return arFieldList
	 */
	public static function getByClassName($class_name) {
		if (!self::isCached($class_name)) {
			self::store(new $class_name);
		}

		return self::$cache[$class_name];
	}


	/**
	 * @param ActiveRecord $ar
	 */
	public static function purge(ActiveRecord $ar) {
		unset(self::$cache[get_class($ar)]);
	}


	/**
	 * @param ActiveRecord $ar
	 *
	 * @return string
	 */
	public static function getPrimaryFieldName(ActiveRecord $ar) {
		return self::get($ar)->getPrimaryFieldName();
	}


	/**
	 * @param ActiveRecord $ar
	 *
	 * @return mixed
	 */
	public static function getPrimaryFieldType(ActiveRecord $ar) {
		return self::get($ar)->getPrimaryFieldType();
	}
}

?>
