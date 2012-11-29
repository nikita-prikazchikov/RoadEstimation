<?php

class Model_DB_Road_Object extends Model_Abstract_DBObject{

    const CLASS_NAME = 'Model_DB_Road_Object';

    protected $_name;
    protected $_step;

    public function getAssocArray (){

        return array(
            Model_DB_Road_Table::FIELDS_ID => $this->getId(),
            Model_DB_Road_Table::FIELDS_NAME => $this->getName(),
            Model_DB_Road_Table::FIELDS_STEP => $this->getStep()
        );
    }

    public function save () {
        Model_DB_Road_Mapper::get_instance()->save( $this );
    }

    public function setName ( $name ){
        $this->_name = $name;
        return $this;
    }

    public function getName (){
        return $this->_name;
    }

    public function setStep ( $step ){
        $this->_step = (float) $step;
        return $this;
    }

    public function getStep (){
        return $this->_step;
    }

}
