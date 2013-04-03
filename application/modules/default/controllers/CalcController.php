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