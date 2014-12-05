<?php
require_once('./Tests/DataBase/class.arConnectorPdoDB.php');
require_once('./_Examples/Object/User/class.arUser.php');

/**
 * Class arTestUser
 *
 * @author  Fabian Schmid <fs@studer-raimann.ch>
 * @version 1.0.0
 */
class arTestUser extends arUser {

	/**
	 * @param int $primary_key
	 */
	public function __construct($primary_key = 0) {
		parent::__construct($primary_key, new arConnectorPdoDB());
	}



}

?>
