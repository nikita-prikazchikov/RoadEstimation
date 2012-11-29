<?php

class Model_DB_Data_Table extends Model_Abstract_DBTable{

    const CLASS_NAME = 'Model_DB_Data_Table';
    const TABLE_NAME = 'data';

    const FIELDS_ID = 'id_data_pk';
    const FIELDS_ID_ROAD_FK = 'id_road_fk';
    const FIELDS_VALUE = 'value';

    protected $_name = self::TABLE_NAME;

}