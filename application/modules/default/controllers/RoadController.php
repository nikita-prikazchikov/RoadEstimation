<?php

include_once "AbstractCtrl.php";

class RoadController extends AbstractCtrl {

	public function init () {
		parent::init();
	}

	public function indexAction () {
		parent::indexAction();
		$this->listAction();
	}

    public function editAction () {

        $data = array();
        try {
            $roadId = $this->getRequestIdRoad();
            if ( $roadId == 0 ) {
                $road = new Model_DB_Road_Object();
            }
            else {
                $road = Model_DB_Road_Mapper::get_instance()->find( $roadId );
            }
            $road->setName( $this->getRequestName());
            $road->setStep( $this->getRequestStep());
            $road->save();

            $data[ 'success' ] = true;
        }
        catch ( Exception $e ) {
            $data[ 'success' ] = false;
            $data[ 'message' ] = $e->getMessage();
        }

        $this->_helper->json->sendJson( $data );
    }

    public function dialogAction () {
        try {
            $roadId = $this->getRequestIdRoad();
            if ( $roadId == 0 ) {
                $road = new Model_DB_Road_Object();
            }
            else {
                $road = Model_DB_Road_Mapper::get_instance()->find( $roadId );
            }
            $this->view->assign( "road", $road );
        }
        catch ( Exception $e ) {
            echo $e->getMessage();
        }
    }

	public function listAction () {
		try {
            $roadList = new Model_Road_List();
			$this->view->assign( "roadList", $roadList );
		}
		catch ( Exception $e ) {
			echo $e->getMessage();
		}
	}

    public function uploadAction () {

        $data = array();
        try {
            $roadId = $this->getRequestIdRoad();
            if ( $roadId == 0 ) {
                throw new Exception ("Incorrect Road ID");
            }
            else {
                /** @var $road Model_DB_Road_Object */
                $road = Model_DB_Road_Mapper::get_instance()->find( $roadId );
            }
            $road->loadDataFromJSON( $this->getRequestData());

            $data[ 'success' ] = true;
        }
        catch ( Exception $e ) {
            $data[ 'success' ] = false;
            $data[ 'message' ] = $e->getMessage();
        }

        $this->_helper->json->sendJson( $data );
    }

	public function viewAction () {
		$this->listAction();
	}
}