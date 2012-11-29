<?php

class Model_DB_Data_Object extends Model_Abstract_DBObject{

    const CLASS_NAME = 'Model_DB_Data_Object';

    protected $_id_road_fk;
    protected $_value;

    public function getAssocArray (){

        return array(
            Model_DB_Data_Table::FIELDS_ID => $this->getId(),
            Model_DB_Data_Table::FIELDS_ID_ROAD_FK => $this->getIdRoadFk(),
            Model_DB_Data_Table::FIELDS_VALUE => $this->getValue()
        );
    }

    public function setIdRoadFk ( $id_road_fk ){
        $this->_id_road_fk = $id_road_fk;
        return $this;
    }

    public function getIdRoadFk (){
        return $this->_id_road_fk;
    }

    public function setValue ( $value ){
        $this->_value = (float)$value;
        return $this;
    }

    public function getValue (){
        return $this->_value;
    }

}
