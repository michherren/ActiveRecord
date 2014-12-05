<?php
require_once('./Customizing/global/plugins/Libraries/ActiveRecord/class.ActiveRecordList.php');
require_once('class.arMessage.php');

/**
 * Class arMessageList
 *
 * @author  Fabian Schmid <fs@studer-raimann.ch>
 * @version 2.1.0
 */
class arMessageList extends ActiveRecordList {

	public function __construct() {
		parent::__construct(new arMessage());
	}
}

?>
