<?php

class Model_DB_Road_Object extends Model_Abstract_DBObject{

    const CLASS_NAME = 'Model_DB_Road_Object';

    protected $_name;
    protected $_step;
    /** @var Model_DB_Data_Object[] */
    private $_coordinates;

    public function getAssocArray (){

        return array(
            Model_DB_Road_Table::FIELDS_ID => $this->getId(),
            Model_DB_Road_Table::FIELDS_NAME => $this->getName(),
            Model_DB_Road_Table::FIELDS_STEP => $this->getStep()
        );
    }

    public function save (){
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
        $this->_step = (float)$step;
        return $this;
    }

    public function getStep (){
        return $this->_step;
    }

    public function loadDataFromJSON ( $value ){
        $array = json_decode( $value, true );
        $coordinates = $this->getCoordinates();
        foreach( $coordinates as $item ){
            $item->delete();
        }
        foreach ( $array as $item ){
            $coordinate = new Model_DB_Data_Object();
            $coordinate->setIdRoadFk( $this->getId());
            $coordinate->setValue( $item );
            $coordinate->save();
        }
    }

    public function setCoordinates ( $coordinates ){
        $this->_coordinates = $coordinates;
    }

    public function getCoordinates (){
        if ( is_null( $this->_coordinates ) ){
            $filter = new Model_Data_Filter();
            $filter->setIdRoad( $this->getId() );
            $this->setCoordinates(
                Model_DB_Data_Mapper::get_instance()->findByFilter( $filter )
            );
        }
        return $this->_coordinates;
    }

}
