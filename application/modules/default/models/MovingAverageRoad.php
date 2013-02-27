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
        $sumStep = 0.1;

        $points = ( $base / $sumStep ) + 1;
        $dStep = $step / $sumStep;

        $positiveOffsetValue = $base / 2;
        $negativeOffsetValue = $positiveOffsetValue;

//        $dSum = 0;
//
//        for ( $j = $start - $negativeOffsetValue; $j < $start - $negativeOffsetValue + $step - $sumStep; $j += $sumStep ){
//            $dSum += $road->getCoordinate( $j );
//        }
        $sum = 0;

        for ( $j = $start - $negativeOffsetValue; $j <= $start + $positiveOffsetValue; $j += $sumStep ){
            $sum += $road->getCoordinate( $j );
        }
        for ( $coordinate = $start; $coordinate < $end; $i++, $coordinate += $step ){

            $model->addCoordinate( new Model_Coordinate( $coordinate, $sum / $points ) );
            // Remove first N points from sum
            for ( $i = 0, $j = $coordinate - $negativeOffsetValue; $i < $dStep; $j += $sumStep, $i ++ ){
                $sum -= $road->getCoordinate( $j );
            }
            // Add next N points to the sum
            for ( $i = 0, $j = $coordinate + $positiveOffsetValue + $sumStep; $i < $dStep; $j += $sumStep, $i ++ ){
                $sum += $road->getCoordinate( $j );
            }
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
