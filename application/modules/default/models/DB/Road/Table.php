<?php

class Model_DB_Road_Table extends Model_Abstract_DBTable{

    const CLASS_NAME = 'Model_DB_Year_Table';
    const TABLE_NAME = 'road';

    const FIELDS_ID = 'id_road_pk';
    const FIELDS_NAME = 'name';
    const FIELDS_STEP = 'step';

    protected $_name = self::TABLE_NAME;
}