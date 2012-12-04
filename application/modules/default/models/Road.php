<?php

class Model_Road{
    /** @var Model_Coordinate[] */
    private $_coordinates;

    /**
     * @param Model_DB_Road_Object $road
     */
    function __construct ( /*Model_DB_Road_Object*/
        $road = null ){
        if ( !is_null( $road ) ){
            $step = $road->getStep();
            $xCoordinate = 0;
            $coordinateList = $road->getCoordinates();
            foreach ( $coordinateList as $coordinate ){
                $this->addCoordinate( new Model_Coordinate( $xCoordinate, $coordinate->getValue() ) );
                $xCoordinate += $step;
            }
        }
        else{
            $this->_coordinates = array();
        }
    }


    public function addCoordinate ( Model_Coordinate $coordinate ){
        $this->_coordinates[ (string)$coordinate->getX() ] = $coordinate;
    }

    public function getCoordinate ( $x ){
        if ( $this->isCoordinateSet( (string)$x ) ){
            return $this->_coordinates[ (string)$x ]->getY();
        }
        else if ( $x < reset( $this->_coordinates )->getX() ){
            return $this->_coordinates[ key( $this->_coordinates ) ]->getY();
        }
        else if ( $x > end( $this->_coordinates )->getX() ){
            return $this->_coordinates[ key( $this->_coordinates ) ]->getY();
        }
        else{
            return $this->findCoordinate( $x );
        }
    }

    /**
     * @return array|Model_Coordinate[]
     */
    public function getCoordinates (){
        return $this->_coordinates;
    }

    public function isCoordinateSet ( $x ){
        return isset ( $this->_coordinates[ $x ] );
    }

    public function getStart (){
        return reset( $this->_coordinates )->getX();
    }

    public function getEnd (){
        return end( $this->_coordinates )->getX();
    }

    public function getCount (){
        return count( $this->_coordinates );
    }

    private function findCoordinate ( $x ){
        /** @var $points Model_Coordinate[] */
        $points = $this->getIntervalPoints( $x );
        $p1 = $points[ 0 ];
        $p2 = $points[ 1 ];
        $k = ( $p2->getY() - $p1->getY() ) / ( $p2->getX() - $p1->getX() );
        $b = $p2->getY() - $k * $p2->getX();
        return $k * $x + $b;
    }

    private function getIntervalPoints ( $x ){

        $p1 = new Model_Coordinate( 0, 0 );
        $p2 = new Model_Coordinate( 0, 0 );

        foreach ( $this->_coordinates as $item ){
            if ( $x >= $item->getX() ){
                $p1 = $item;
                $p2 = next( $this->_coordinates );
            }
        }
        return array( $p1, $p2 );
    }
}
