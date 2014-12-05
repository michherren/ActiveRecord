<?php
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once("./Tests/DataBase/class.arConnectorPdoDB.php");
require_once("./Tests/Records/class.arTestUser.php");

/**
 * Class AR_MultiTable_Inheritance_Test
 *
 * @description PHP Unit-Test for ILIAS ActiveRecord, AR_MultiTable_Inheritance_Test
 *
 * @author      Fabian Schmid <fs@studer-raimann.ch>
 * @version     2.1.0
 */
class AR_MultiTable_Inheritance_Test extends PHPUnit_Framework_TestCase {

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
		PHPUnit_Framework_Error_Warning::$enabled = false;
		arTestUser::installDB();
		$this->pdo = arConnectorPdoDB::getConnector();
	}


	public function testTables() {
		$arUser = new arTestUser();
		$this->assertTrue($this->pdo->tableExists($arUser->getConnectorContainerName()));
		foreach ($arUser->getArFieldList()->getParentList()->getParents() as $parent) {
			$this->assertTrue($this->pdo->tableExists($parent->getParent()->getConnectorContainerName()));
		}
	}


	public function testCreateObject() {
		$arUser = new arTestUser();
		$arUser->setFirstname('Fabian');
		$arUser->setLastname('Schmid');
		$arUser->setEmail('fs@studer-raimann.ch');
		$arUser->setBirthday('NOW()');
		$arUser->create();
		$id = $arUser->getUsrId();

		$result = $this->pdo->query('SELECT * FROM ' . $arUser->getConnectorContainerName());
		$record = $this->pdo->fetchObject($result);

		$arUser = new arTestUser();
		$arUser->setFirstname('Oskar');
		$arUser->setLastname('Truffer');
		$arUser->setEmail('ot@studer-raimann.ch');
		$arUser->setBirthday('NOW()');
		$arUser->create();
		$id = $arUser->getUsrId();
	}


	public static function tearDownAfterClass() {
		$tableName = arTestUser::returnDbTableName();
		$pbo = new pdoDB();
		$pbo->manipulate("DROP TABLE {$tableName}");
	}
}

?>