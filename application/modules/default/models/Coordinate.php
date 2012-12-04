<?php

class Model_Coordinate{

    protected $_x;
    protected $_y;


    function __construct ( $x, $y ){
        $this->setX( $x );
        $this->setY( $y );
    }

    public function setX ( $x ){
        $this->_x = $x;
        return $this;
    }

    public function getX (){
        return $this->_x;
    }

    public function setY ( $y ){
        $this->_y = $y;
        return $this;
    }

    public function getY (){
        return $this->_y;
    }



}
