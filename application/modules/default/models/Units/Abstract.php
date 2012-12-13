<?php

abstract class Model_Units_Abstract{

    protected $_base;
    protected $_weight;
    protected $_supportCount;
    /** @var Model_Road */
    protected $_road;
    /** @var Model_Road */
    protected $_resultRoad;

    protected $x;
    protected $y;

    abstract function getCoordinate( $x );

    protected function calculateCoordinates( $pointX ){
        $start = $pointX - $this->getBase() / 2;
        $step = (float) $this->getBase() / ( $this->getSupportCount() - 1 );
        for ( $i = 0; $i < $this->getSupportCount(); $i ++ ){
            $this->x[ $i ] = $start + $i * $step;
            $this->y[ $i ] = $this->getRoad()->getCoordinate( $this->x[ $i ]);
        }
    }

    function __construct (){
        $this->setResultRoad( new Model_Road());
    }

    public function setBase ( $base ){
        $this->_base = $base;
    }

    public function getBase (){
        return $this->_base;
    }

    /**
     * @param \Model_Road $resultRoad
     */
    protected function setResultRoad ( $resultRoad ){
        $this->_resultRoad = $resultRoad;
    }

    /**
     * @return \Model_Road
     */
    protected function getResultRoad (){
        return $this->_resultRoad;
    }

    /**
     * @param \Model_Road $road
     */
    public function setRoad ( $road ){
        $this->_road = $road;
    }

    /**
     * @return \Model_Road
     */
    public function getRoad (){
        return $this->_road;
    }

    public function setSupportCount ( $supportCount ){
        $this->_supportCount = $supportCount;
    }

    public function getSupportCount (){
        return $this->_supportCount;
    }

    public function setWeight ( $weight ){
        $this->_weight = $weight;
    }

    public function getWeight (){
        return $this->_weight;
    }


}
