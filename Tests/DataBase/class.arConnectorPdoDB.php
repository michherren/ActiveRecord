<?php
require_once('./Connector/class.arConnectorDB.php');
require_once('./Exception/class.arException.php');
require_once('class.pdoDB.php');

/**
 * Class arConnectorDB
 *
 * @author  Fabian Schmid <fs@studer-raimann.ch>
 * @author  Timon Amstutz <timon.amstutz@ilub.unibe.ch>
 * @version 2.1.0
 */
class arConnectorPdoDB extends arConnectorDB {

	protected static $pbo_connect;
	protected $pdo_connect;


	/**
	 * @return pdoDB
	 */
	protected function returnDB() {
		if (!self::$pbo_connect) {
			self::$pbo_connect = new pdoDB();
		}

		return self::$pbo_connect;
	}


	/**
	 * @return mixed
	 */
	public static function getConnector() {
		return self::$pbo_connect;
	}


	/**
	 * @param ActiveRecord $ar
	 *
	 * @return null|void
	 */
	public function updateIndices(ActiveRecord $ar) {
		return NULL;
	}


	/**
	 * @param ActiveRecord $ar
	 *
	 * @return int|mixed
	 */
	public function nextID(ActiveRecord $ar) {
		$sequence_field_name = '';
		foreach ($ar->getArFieldList()->getFields() as $field) {
			if ($field->getSequence()) {
				$sequence_field_name = $field->getName();
			}
		}
		if (!$sequence_field_name) {
			return NULL;
		}

		return $this->returnDB()->nextId($ar->getConnectorContainerName(), $sequence_field_name);
	}
}
