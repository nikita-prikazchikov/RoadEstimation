<?php

class Model_Data{

    /** @var Model_Road */
    private $sourceRoad;
    /** @var Model_MovingAverageRoad */
    private $averageRoad;

    /** @var Model_Units_Abstract[] */
    private $unitModelList;

    private $_step;
    private $_base;
    private $_type;
    private $_weight;

    private $supportList;

    function __construct (){
    }

    public function getUnitModelListBySupportCount ( $supportCount ){
        $list = $this->getUnitModelList();
        return $list[$supportCount];
    }

    /**
     * @param \Model_MovingAverageRoad $averageRoad
     */
    private function setAverageRoad ( $averageRoad ){
        $this->averageRoad = $averageRoad;
    }

    /**
     * @return \Model_MovingAverageRoad
     */
    public function getAverageRoad (){
        if ( is_null( $this->averageRoad ) ){
            $this->setAverageRoad( new Model_MovingAverageRoad( $this->getBase(), $this->getSourceRoad(), $this->getStep() ) );
        }
        return $this->averageRoad;
    }

    /**
     * @param \Model_Road $sourceRoad
     */
    public function setSourceRoad ( $sourceRoad ){
        $this->sourceRoad = $sourceRoad;
    }

    /**
     * @return \Model_Road
     */
    public function getSourceRoad (){
        return $this->sourceRoad;
    }

    private function setUnitModelList ( $unitModelList ){
        $this->unitModelList = $unitModelList;
    }

    public function getUnitModelList (){
        if ( is_null( $this->unitModelList ) ){
            $list = array();
            foreach ( $this->getSupportList() as $supportCount ){
                switch ( $this->getType() ) {
                    case "1":
                        $model = new Model_Units_Type1();
                        break;
                    default:
                        throw new Exception ( "Неизвестная модель" );

                }
                $model->setBase( $this->getBase() );
                $model->setRoad( $this->getSourceRoad());
                $model->setSupportCount( (int)$supportCount );
                $model->setWeight($this->getWeight());

                $list[ $supportCount ] = $model;
            }
            $this->setUnitModelList( $list );
        }
        return $this->unitModelList;
    }


    public function setBase ( $base ){
        $this->_base = $base;
    }

    public function getBase (){
        return $this->_base;
    }

    public function setStep ( $step ){
        $this->_step = $step;
    }

    public function getStep (){
        return $this->_step;
    }

    public function setType ( $type ){
        $this->_type = $type;
    }

    public function getType (){
        return $this->_type;
    }

    public function setSupportList ( $supportList ){
        $this->supportList = $supportList;
    }

    public function getSupportList (){
        return $this->supportList;
    }

    public function setWeight ( $weight ){
        $this->_weight = $weight;
    }

    public function getWeight (){
        return $this->_weight;
    }

}
