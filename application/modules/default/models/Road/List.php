<?php

class Model_Road_List extends Model_Abstract_List {

    private $_roadViewList;

	public function __construct( $filter = null ){
		if ( null === $filter ){
			$filter = new Model_Road_Filter();
		}
		$this->setFilter( $filter );
		$this->setMapper( Model_DB_Road_Mapper::get_instance() );
	}

    /**
     * @return Model_DB_Road_Mapper
     */
    public function getMapper (){
        return parent::getMapper();
    }


    public function fetch () {
		$list = array();
		foreach ( $this->getMapper()->findByFilter( $this->getFilter() ) as $item ) {
			array_push( $list, $item );
		}
		$this->setList( $list );
	}

	/**
	 * @return Model_Road_Filter
	 */
	public function getFilter () {
		return parent::getFilter();
	}

	/**
	 * @return Model_DB_Road_Object[]
	 */
	public function getList () {
		return parent::getList();
	}

    /**
     * Function to get list of Specialities prepared for display in view
     * @return array
     */
    public function getListView (){
		if ( is_null( $this->_roadViewList )){
        $list = $this->getList();
        $this->_roadViewList = array ();
		foreach ( $list as $item ){
            $this->_roadViewList[ $item->getId()] = $item->getName();
		}
        }
        return $this->_roadViewList;
	}

}
