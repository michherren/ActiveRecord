<?php
require_once(dirname(__FILE__) . '/../Exception/class.arException.php');
require_once(dirname(__FILE__) . '/../Cache/class.arObjectCache.php');

/**
 * Class arFactory
 *
 * @author  Fabian Schmid <fs@studer-raimann.ch>
 * @version 2.1.0
 */
class arFactory {

	/**
	 * @param       $class_name
	 * @param       $primary_key
	 * @param array $additional_arguments
	 *
	 * @return ActiveRecord
	 * @throws arException
	 */
	public static function getInstance($class_name, $primary_key = 0, $additional_arguments = array()) {
		if (arObjectCache::isCached($class_name, $primary_key)) {
			$obj = arObjectCache::get($class_name, $primary_key);
			if (!$primary_key) { // FSX TODO: Nesting??
				$obj = clone($obj);
			}

			return $obj;
		}
		/**
		 * @var $obj ActiveRecord
		 */
		$ref = new ReflectionClass($class_name);
		if ($ref->isInstantiable()) {
			$obj = $ref->newInstanceArgs(array_merge(array( $primary_key ), $additional_arguments));
			if (!$primary_key) {
				$obj = clone($obj);
			}
		} else {
			throw new arException(arException::PRIVATE_CONTRUCTOR);
		}

		return $obj;
	}
}

?>
