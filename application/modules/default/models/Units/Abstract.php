<?php

abstract class Model_Units_Abstract{

    private $_base;
    private $_weight;
    private $_supportCount;
    /** @var Model_Road */
    private $_road;
    /** @var Model_Road */
    private $_resultRoad;

    abstract function getCoordinate( $x );

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
