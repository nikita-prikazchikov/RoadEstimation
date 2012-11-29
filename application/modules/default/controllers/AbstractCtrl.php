<?php

class AbstractCtrl extends Zend_Controller_Action {

    protected $_acl;
    protected $_redirector;

    const PAGE_TITLE = "";

    protected function setPageTitle ( $value ) {
        $this->view->headTitle( $value );
    }

    /**
     * @return Model_Acl
     */
    protected function getAcl () {
        return $this->_acl;
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

    protected function getRequestId () {
        return $this->getRequest()->getParam( 'id' );
    }

    protected function getRequestIdRoad () {
        return $this->getRequest()->getParam( 'id_road' );
    }

    protected function getRequestName () {
        return $this->getRequest()->getParam( 'name' );
    }

    protected function getRequestStep () {
        return $this->getRequest()->getParam( 'step' );
    }

    protected function getRequestValue () {
        return $this->getRequest()->getParam( 'value' );
    }
}