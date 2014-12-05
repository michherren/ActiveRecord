<?php
require_once(dirname(__FILE__) . '/../Statement/class.arStatementCollection.php');
require_once('class.arOrder.php');

/**
 * Class arOrderCollection
 *
 * @author  Fabian Schmid <fs@studer-raimann.ch>
 * @version 2.1.0
 */
class arOrderCollection extends arStatementCollection {

	/**
	 * @return string
	 */
	public function asSQLStatement() {
		$return = '';
		if ($this->hasStatements()) {
			$return .= ' ORDER BY ';
			foreach ($this->getOrders() as $order) {
				$return .= $order->asSQLStatement($this->getAr());
				$orders = $this->getOrders();
				if ($order != end($orders)) {
					$return .= ', ';
				}
			}
		}

		return $return;
	}


	/**
	 * @return arOrder[]
	 */
	public function getOrders() {
		return $this->statements;
	}
}

?>
