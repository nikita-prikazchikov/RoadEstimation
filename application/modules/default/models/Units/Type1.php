
<?php

class Model_Units_Type1 extends Model_Units_Abstract{

    function getCoordinate ( $coordinateX ){
        if ( !$this->_resultRoad->isCoordinateSet( $coordinateX )){
        $this->calculateCoordinates( $coordinateX );

        $xi = 0;
        $yi = 0;
        $xi2 = 0;
        $xyi = 0;
        for ( $i = 0; $i < $this->getSupportCount(); $i++ ){
            $x = $this->x[$i];
            $y = $this->y[$i];
            $xi += $x;
            $xi2 += $x * $x;
            $yi += $y;
            $xyi += $x * $y;
        }
        $z = $this->getSupportCount() * $xi2 - $xi * $xi;
        $b = ( $yi * $xi2 - $xyi * $xi ) / $z;
        $k = ( $this->getSupportCount() * $xyi - $yi * $xi )/ $z;
        $this->_resultRoad->addCoordinate( new Model_Coordinate( $coordinateX, $k * $coordinateX + $b ) );
        }
        return $this->_resultRoad->getCoordinate( $coordinateX );
    }
}
