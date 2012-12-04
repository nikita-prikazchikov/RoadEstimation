<?php

class AbstractCtrl extends Zend_Controller_Action {

    protected $_redirector;

    const PAGE_TITLE = "";

    protected function setPageTitle ( $value ) {
        $this->view->headTitle( $value );
    }

    public function init () {

//	    $profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
//      $profiler->setEnabled(true);
//
//      // Attach the profiler to your db adapter
//      Zend_Db_Table::getDefaultAdapter()->setProfiler($profiler);
    }

    public function indexAction () {
        Zend_Layout::getMvcInstance()->setLayout( 'layout' );
    }

    //================================================================================================================================================

    protected function getRequestData () {
        return $this->getRequest()->getParam( 'data' );
    }

    protected function getRequestId () {
        return $this->getRequest()->getParam( 'id' );
    }

    protected function getRequestIdRoad () {
        return $this->getRequest()->getParam( 'id_road' );
    }

    protected function getRequestLength () {
        return $this->getRequest()->getParam( 'length' );
    }

    protected function getRequestModel () {
        return $this->getRequest()->getParam( 'model' );
    }

    protected function getRequestName () {
        return $this->getRequest()->getParam( 'name' );
    }

    protected function getRequestStep () {
        return $this->getRequest()->getParam( 'step' );
    }

    protected function getRequestSupport () {
        return $this->getRequest()->getParam( 'support' );
    }

    protected function getRequestValue () {
        return $this->getRequest()->getParam( 'value' );
    }

    protected function getRequestWeight () {
        return $this->getRequest()->getParam( 'weight' );
    }
}