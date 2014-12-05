<?php
require_once("./Tests/DataBase/class.arConnectorPdoDB.php");
require_once("./Tests/Records/class.arUnitTestRecord.php");


/**
 * Class AR_ObjectCache_Test
 *
 * @description PHP Unit-Test for ILIAS ActiveRecord, ObjectCache
 *
 * @author      Fabian Schmid <fs@studer-raimann.ch>
 * @version     2.1.0
 */
class AR_ObjectCache_Test extends PHPUnit_Framework_TestCase {

	/**
	 * @var pdoDB
	 */
	protected $pdo;
	/**
	 * @var string
	 */
	protected $table_name;


	public function setUp() {
		PHPUnit_Framework_Error_Notice::$enabled = false;
		arUnitTestRecord::installDB();
		$arUnitTestRecord = new arUnitTestRecord();
		$this->table_name = $arUnitTestRecord->getConnectorContainerName();
		$this->pdo = arConnectorPdoDB::getConnector();
	}





	/**
	 * @expectedException arException
	 */
	public function testFindOrFail() {
		arUnitTestRecord::findOrFail(9999);
	}



	public static function tearDownAfterClass() {
		$tableName = arUnitTestRecord::returnDbTableName();
		$pbo = new pdoDB();
		$pbo->manipulate("DROP TABLE {$tableName}");
	}

}

?>