<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	protected function _initSession () {
		Zend_Session::start();
	}

	protected function _initConfiguration () {

		$options = $this->getApplication()->getOptions();

		set_include_path( implode( PATH_SEPARATOR, array(
		                                                realpath( APPLICATION_PATH . '/modules/' . $this->_moduleName . '/models' ),
		                                                get_include_path(),
		                                           ) ) );

		return $options;
	}

	protected function _initConfig () {

		$settings = $this->getOption( 'settings' );
		Zend_Registry::set( 'settings', $settings );
	}

	protected function _initAutoload () {
		new Zend_Application_Module_Autoloader( array(
		                                             'namespace' => '',
		                                             'basePath' => APPLICATION_PATH . '/modules/default' )

		);
	}

	protected function _initDoctype () {
		$this->bootstrap( 'view' );

		$view = $this->getResource( 'view' );
		$view->navigation = array();
		$view->subnavigation = array();
		$view->headTitle( 'Расчет дорог' )
				->setSeparator( ' :: ' );

		$view->doctype( 'HTML5' );

		$this->view->headScript()->appendFile( '/jquery/js/jquery-1.8.2.min.js' );

		$this->view->headLink()->appendStylesheet( '/twitter_bootstrap/css/bootstrap.css' );
		$this->view->headLink()->appendStylesheet( '/twitter_bootstrap/css/bootstrap-responsive.css' );
		$this->view->headLink()->appendStylesheet( '/css/main.css' );

        $this->view->headScript()->appendFile( '/twitter_bootstrap/js/bootstrap.min.js' );

        $this->view->headScript()->appendFile( '/js/main.js' );
	}

	protected function _initView () {
		// initialize smarty view
		$view = new Ext_View_Smarty( $this->getOption( 'smarty' ) );
		// setup viewRenderer with suffix and view
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper( 'ViewRenderer' );
		$viewRenderer->setViewSuffix( 'tpl' );
		$viewRenderer->setView( $view );

		// ensure we have layout bootstraped
		$this->bootstrap( 'layout' );
		// set the tpl suffix to layout also
		$layout = Zend_Layout::getMvcInstance();
		$layout->setViewSuffix( 'tpl' );

		return $view;
	}

	protected function _initCache () {
		// First, set up the Cache
		$frontendOptions = array(
			'automatic_serialization' => true
		);

		$backendOptions = array(
			'cache_dir' => APPLICATION_PATH . '/tmp/dbCache/'
		);

		$cache = Zend_Cache::factory( 'Core',
			'File',
			$frontendOptions,
			$backendOptions );

		Zend_Db_Table_Abstract::setDefaultMetadataCache( $cache );
	}

	protected function _initDB () {
		Zend_Db_Table::setDefaultAdapter( $this->getPluginResource('db')->getDbAdapter() );
	}
}

