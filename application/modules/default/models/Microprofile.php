<?php

class Model_Microprofile {

    private $_dispersion;
    private $_expectationValue;
    private $_length;
    private $_step;
    /** @var Model_MovingAverageRoad */
    private $averageRoad;
    /** @var array(float) */
    private $correlation;
    /** @var Model_Road */
    private $smoothedRoad;
    /** @var Model_Road */
    private $sourceRoad;

    function __construct (){
    }

    private function calculateCorrelation (){
        $this->correlation = array();
        $road = $this->getSmoothedRoad();
        $length = $road->getCount();
        $step = $this->getStep();
        for ( $k = 0; $k < $length - 1; $k++ ) {
            $sum = 0.0;
            for ( $t = 0; $t < ( $length - $k ); $t++ ) {
                $sum += $road->getCoordinate( $t * $step ) * $road->getCoordinate( ( $t + $k ) * $step );
            }
            $this->correlation[ $k ] = $sum / ( $length - $k );
        }
    }

    private function calculateDispersion (){
        $expectationValue = $this->getExpectationValue();
        $sum = 0.0;
        for ( $x = $this->getSmoothedRoad()->getStart(); $x < $this->getSmoothedRoad()->getEnd(); $x += $this->getStep() ) {
            $sum += pow( $this->getSmoothedRoad()->getCoordinate( $x ) - $expectationValue, 2 );
        }
        $this->setDispersion( $sum / $this->getSmoothedRoad()->getCount() );
    }

    private function calculateExpectationValue (){
        $sum = 0.0;
        for ( $x = $this->getSmoothedRoad()->getStart(); $x < $this->getSmoothedRoad()->getEnd(); $x += $this->getStep() ) {
            $sum += $this->getSmoothedRoad()->getCoordinate( $x );
        }
        $this->setExpectationValue( $sum / $this->getSmoothedRoad()->getCount() );
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
        if ( is_null( $this->averageRoad ) ) {
            $this->setAverageRoad( new Model_MovingAverageRoad( $this->getLength(), $this->getSourceRoad(), $this->getStep() ) );
        }
        return $this->averageRoad;
    }

    /**
     * @return array
     */
    public function getCorrelation (){
        if ( is_null( $this->correlation ) ) {
            $this->calculateCorrelation();
        }
        return $this->correlation;
    }

    public function getDispersion (){
        if ( is_null( $this->_dispersion ) ) {
            $this->calculateDispersion();
        }
        return $this->_dispersion;
    }

    public function getExpectationValue (){
        if ( is_null( $this->_expectationValue ) ) {
            $this->calculateExpectationValue();
        }
        return $this->_expectationValue;
    }

    public function getLength (){
        return $this->_length;
    }

    /**
     * @return \Model_Road
     */
    public function getSmoothedRoad (){
        if ( is_null( $this->smoothedRoad ) ) {
            $r = new Model_Road();
            $x = $this->getSourceRoad()->getStart();
            $step = $this->getStep();
            for ( ; $x < $this->getSourceRoad()->getEnd(); $x += $step ) {
                $r->addCoordinate( new Model_Coordinate( $x, $this->getSourceRoad()->getCoordinate( $x ) - $this->getAverageRoad()->getCoordinate( $x ) ) );
            }
            $this->setSmoothedRoad( $r );
        }
        return $this->smoothedRoad;
    }

    /**
     * @return \Model_Road
     */
    public function getSourceRoad (){
        return $this->sourceRoad;
    }

    public function getStep (){
        return $this->_step;
    }

    public function setDispersion ( $dispersion ){
        $this->_dispersion = $dispersion;
        return $this;
    }

    public function setExpectationValue ( $expectationValue ){
        $this->_expectationValue = $expectationValue;
    }

    public function setLength ( $base ){
        $this->_length = $base;
    }

    /**
     * @param \Model_Road $smoothedRoad
     */
    public function setSmoothedRoad ( $smoothedRoad ){
        $this->smoothedRoad = $smoothedRoad;
    }

    /**
     * @param \Model_Road $sourceRoad
     */
    public function setSourceRoad ( $sourceRoad ){
        $this->sourceRoad = $sourceRoad;
    }

    public function setStep ( $step ){
        $this->_step = $step;
    }
}
