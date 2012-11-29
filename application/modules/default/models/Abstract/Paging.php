<?php

abstract class Model_Abstract_Paging {

	/** @var Model_Abstract_Filter */
	protected $_filter;
	protected $_list;
	protected $_mapper;

	private $_pageNumber;
	private $_pageSize;
	private $_pageCount;
	private $_shiftCount = 7;

	public function __construct ( ) {
	}

	// ===============================================================================================================================================

	abstract public function fetch ();
	abstract protected function _getPageCount ();

	// ===============================================================================================================================================

	public function iFirst (){
		return $this->getPageNumber() <= 1;
	}

	public function iLast () {
		return $this->getPageNumber() == $this->getPageCount();
	}

	public function iNeed (){
		return $this->getPageCount() > 1;
	}

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

	public function setPageNumber ( $pageNumber ) {
		$this->_pageNumber = $pageNumber;
	}

	public function getPageNumber () {
		if ( is_null( $this->_pageNumber ) ){
			$this->setPageNumber(
				(int)( $this->getFilter()->getOffset() / $this->getFilter()->getLimit() + 1 )
			);
		}
		return $this->_pageNumber;
	}

	public function setPageSize ( $pageSize ) {
		$this->_pageSize = $pageSize;
	}

	public function getPageSize () {
		if ( is_null( $this->_pageSize ) ){
			$this->setPageSize( $this->getFilter()->getLimit() );
		}
		return $this->_pageSize;
	}

	public function setShiftCount ( $shiftCount ) {
		$this->_shiftCount = $shiftCount;
	}

	public function getShiftCount () {
		return $this->_shiftCount;
	}

	public function getPageCount (){
		if ( is_null ( $this->_pageCount )){
			$this->_pageCount = $this->_getPageCount();
		}
		return $this->_pageCount;
	}


}
