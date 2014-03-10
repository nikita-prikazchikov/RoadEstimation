<?php

class Model_Microprofile {

    private $_dispersion;
    private $_expectationValue;
    private $_length;
    private $_step;

    private $_alpha;
    private $_beta;
    private $_tau;

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
        $average = $this->getExpectationValue();
        for ( $k = 0; $k < $length - 1; $k++ ) {
            $sum = 0.0;
            for ( $t = 0; $t < ( $length - $k ); $t++ ) {
                $sum += ( $road->getCoordinate( $t * $step ) - $average ) * ( $road->getCoordinate( ( $t + $k ) * $step ) - $average );
            }
            $cor = ( $sum / ( $length - $k ) ) / $this->getDispersion();
            $this->correlation[ $k ] = $cor;
            if ( $cor < 0 ){
                break;
            }
        }
    }

    private function calculateDispersion (){
        $expectationValue = $this->getExpectationValue();
        $sum = 0.0;
        for ( $x = $this->getSmoothedRoad()->getStart(); $x < $this->getSmoothedRoad()->getEnd(); $x += $this->getStep() ) {
            $sum += pow( $this->getSmoothedRoad()->getCoordinate( $x ) - $expectationValue, 2 );
        }
        $this->setDispersion( $sum / ( $this->getSmoothedRoad()->getCount() - 1 ) );
    }

    private function calculateExpectationValue (){
        $sum = 0.0;
        for ( $x = $this->getSmoothedRoad()->getStart(); $x < $this->getSmoothedRoad()->getEnd(); $x += $this->getStep() ) {
            $sum += $this->getSmoothedRoad()->getCoordinate( $x );
        }
        $this->setExpectationValue( $sum / ( $this->getSmoothedRoad()->getCount() ) );
    }

    public function approximate(){
        $correlation = $this->getCorrelation();
        $step = $this->getStep();

        $this->_tau = 0;
        for ( $i = 0; $i < count( $correlation ); $i++ ) {
            if ( $correlation[ $i ] < 0 ){
                $p1 = new Model_Coordinate( $step * ( $i - 1 ), $correlation[ $i - 1 ]  );
                $p2 = new Model_Coordinate( $step * ( $i ), $correlation[ $i ]  );
                $k = ( $p2->getY() - $p1->getY() ) / ( $p2->getX() - $p1->getX() );
                $b = $p2->getY() - $k * $p2->getX();
                $this->_tau = - $b / $k;
                break;
            }
        }

        $this->_beta = pi() / ( 2 * $this->_tau );

        $s1 = 0;
        $s2 = 0;
        for ( $i = 0; $i * $step < $this->_tau; $i++ ){
            $tau = $i * $step;
            $ro_tau = $correlation[ $i ];
            $s1 += abs( $tau * (log( $ro_tau / cos( $this->_beta * $tau ))));
            $s2 += $tau * $tau;
        }
        if ( $this->_tau < $step ){
            $this->_alpha = 1;
        }
        else {
            $this->_alpha = $s1 / $s2;
        }
    }

    public function getResultTable(){
        $res = array();
        $correlation = $this->getCorrelation();
        $step = $this->getStep();
        for ( $i = 0; $i * $step < $this->_tau; $i++ ){
            $tau = $i * $step;
            array_push($res, array(
                "tau" => $tau,
                "ro_tau" => $correlation[ $i ],
                "ro_tau_calc" => exp( - $this->getAlpha() * $tau ) * cos( $this->getBeta() * $tau )
            ));
        }
        return $res;
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

    public function getAlpha(){
        if ( is_null( $this->_alpha )){
            $this->approximate();
        }
        return $this->_alpha;
    }

    public function getBeta(){
        if ( is_null( $this->_beta )){
            $this->approximate();
        }
        return $this->_beta;
    }

    public function getTau(){
        if ( is_null( $this->_tau )){
            $this->approximate();
        }
        return $this->_tau;
    }



}
