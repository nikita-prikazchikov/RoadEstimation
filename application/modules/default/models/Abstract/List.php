<?php

abstract class Model_Abstract_List {

	protected $_filter;
	protected $_list;
	protected $_mapper;

	public function __construct ( ) {
	}

	// ===============================================================================================================================================

	abstract public function fetch ();

	// ===============================================================================================================================================

	protected function setFilter ( $filter ) {
		$this->_filter = $filter;
	}

	public function getFilter () {
		return $this->_filter;
	}

	protected function setList ( $list ) {
		$this->_list = $list;
	}

	public function getList(){
		if ( null === $this->_list ){
			$this->fetch();
		}
		return $this->_list;
	}

	protected function setMapper ( $mapper ) {
		$this->_mapper = $mapper;
	}

	public function getMapper () {
		return $this->_mapper;
	}

}
