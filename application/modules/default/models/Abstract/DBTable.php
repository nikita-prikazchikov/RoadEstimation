<?php

abstract class Model_Abstract_DBTable extends Zend_Db_Table_Abstract {

	const TABLE_SCHEMA = "road_estimation";

	protected $_schema = self::TABLE_SCHEMA;
}