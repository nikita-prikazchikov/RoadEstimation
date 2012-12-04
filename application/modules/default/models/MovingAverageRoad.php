<?php

class Model_MovingAverageRoad{

    /** @var Model_Road */
    protected $_sourceRoad;
    /** @var Model_Road */
    protected $_averageRoad;
    protected $_step;
    protected $_base;

    function __construct ( $_base, $_sourceRoad, $_step ){
        $this->_base = $_base;
        $this->_sourceRoad = $_sourceRoad;
        $this->_step = $_step;
    }

    public function getCoordinate ( $x ){
        return $this->getAverageRoad()->getCoordinate( $x );
    }

    public function setBase ( $base ){
        $this->_base = $base;
        return $this;
    }

    public function getBase (){
        return $this->_base;
    }

    /**
     * @param \Model_Road $averageRoad
     */
    private function setAverageRoad ( $averageRoad ){
        $this->_averageRoad = $averageRoad;
    }

    /**
     * @return \Model_Road
     */
    public function getAverageRoad (){
        if ( is_null( $this->_averageRoad ) ){
            $this->setAverageRoad( $this->calculateAverageRoad() );
        }
        return $this->_averageRoad;
    }

    /**
     * @return Model_Road
     */
    private function calculateAverageRoad (){
        $model = new Model_Road();
        $road = $this->getSourceRoad();

        $start = $road->getStart();
        $end = $road->getEnd();
        $step = $this->getStep();
        $base = $this->getBase();

        $points = ( $this->getBase() / $this->getStep() );

        $negativeOffset = -( $points & 1 ? $points / 2 : $points / 2 - 1 );
        $positiveOffset = $points / 2;

        $negativeOffsetValue = $negativeOffset * $step;
        $positiveOffsetValue = ( $positiveOffset + 1 ) * $step ;

        $sum = 0;
        for ( $i = $negativeOffset; $i <= $positiveOffset; $i++ ){
            $sum += $road->getCoordinate( $start + $i * $this->getStep() );
        }
        for ( $i = 0, $coordinate = $start; $coordinate < $end; $i++, $coordinate += $step ){
            $model->addCoordinate( new Model_Coordinate( $coordinate, $sum / $points ) );
            $sum = $sum - $road->getCoordinate( $coordinate + $negativeOffsetValue ) + $road->getCoordinate( $coordinate + $positiveOffsetValue );
        }

        return $model;
    }

    /**
     * @param \Model_Road $sourceRoad
     * @return \Model_Coordinate
     */
    public function setSourceRoad ( $sourceRoad ){
        $this->_sourceRoad = $sourceRoad;
        return $this;
    }

    /**
     * @return \Model_Road
     */
    public function getSourceRoad (){
        return $this->_sourceRoad;
    }

    public function setStep ( $step ){
        $this->_step = $step;
        return $this;
    }

    public function getStep (){
        return $this->_step;
    }


}
