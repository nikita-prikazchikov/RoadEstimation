<?php

include_once "AbstractCtrl.php";

class CalcController extends AbstractCtrl{

    public function init (){
        parent::init();
    }

    public function indexAction (){
        parent::indexAction();
        $this->viewAction();
    }

    public function editAction (){

        $data = array();
        try {
            $roadId = $this->getRequestIdRoad();
            if ( $roadId == 0 ){
                $road = new Model_DB_Road_Object();
            }
            else{
                $road = Model_DB_Road_Mapper::get_instance()->find( $roadId );
            }
            $road->setName( $this->getRequestName() );
            $road->setStep( $this->getRequestStep() );
            $road->save();

            $data[ 'success' ] = true;
        }
        catch ( Exception $e ){
            $data[ 'success' ] = false;
            $data[ 'message' ] = $e->getMessage();
        }

        $this->_helper->json->sendJson( $data );
    }

    public function resultAction (){
        try {
            /** @var $dbRoad Model_DB_Road_Object */
            $dbRoad = Model_DB_Road_Mapper::get_instance()->find( $this->getRequestIdRoad() );
            $data = new Model_Data();
            $data->setBase($this->getRequestLength());
            $data->setStep( $dbRoad->getStep() );
            $data->setSourceRoad( new Model_Road( $dbRoad ));
            $data->setType($this->getRequestModel());
            $data->setSupportList( $this->getRequestSupport() );

            $this->view->assign( "data", $data );
        }
        catch ( Exception $e ){
            echo $e->getMessage();
        }
    }

    public function processmicroprofileAction (){
        try {
            /** @var $dbRoad Model_DB_Road_Object */
            $dbRoad = Model_DB_Road_Mapper::get_instance()->find( $this->getRequestIdRoad() );

            $data = new Model_Microprofile();
            $data->setLength($this->getRequestLength());
            $data->setStep( $dbRoad->getStep() );
            $data->setSourceRoad( new Model_Road( $dbRoad ));

            $data->approximate();

            $this->view->assign( "data", $data );
        }
        catch ( Exception $e ){
            echo $e->getMessage();
        }
    }

    public function approximateAction (){
        try {
            /** @var $dbRoad Model_DB_Road_Object */
            $dbRoad = Model_DB_Road_Mapper::get_instance()->find( $this->getRequestIdRoad() );


            $length = array(1.11, 1.38, 1.66, 1.85, 2.08, 2.22, 2.77, 2.78, 3.46, 3.7, 4.62, 5.53, 5.55, 7.4, 8.3, 9.23, 11.1, 13.85, 16.6, 22.2, 27.7);
            $road = new Model_Road( $dbRoad );
            $data = array();
            for( $i = 0; $i < count($length); $i ++ ){
                $profile = new Model_Microprofile();
                $profile->setLength($length[$i]);
                $profile->setStep( $dbRoad->getStep() );
                $profile->setSourceRoad( $road );
                $data[] = $profile;
            }
            $this->view->assign( "data", $data );
        }
        catch ( Exception $e ){
            echo $e->getMessage();
        }
    }

    public function viewAction (){
        try {
            $roadList = new Model_Road_List();
            $this->view->assign( "roadList", $roadList );
            $this->view->assign( "modelList", array(
                                                   "1" => "Модель 1"
                                              ) );
        }
        catch ( Exception $e ){
            echo $e->getMessage();
        }
    }
}