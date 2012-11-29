<?php

abstract class Model_Abstract_DBMapper {
	/**
	 * @var Zend_Db_Table_Abstract
	 */
    protected $_dbTable;

    protected $_dbObject_ClassName;
    protected $_dbTable_ClassName;

	private static $instances;

    protected function __construct($_dbObject_ClassName, $_dbTable_ClassName ) {
        $c = get_class($this);
        if(isset(self::$instances[$c])) {
            throw new Exception('You can not create more than one copy of a singleton. [' . $c . ']');
        } else {
	        $this->_dbObject_ClassName = $_dbObject_ClassName;
            $this->_dbTable_ClassName = $_dbTable_ClassName;
            self::$instances[$c] = $this;
        }
    }
	/**
	 * @static
	 * @return Model_Abstract_DBMapper
	 */
	public static function get_instance() {
        $c = get_called_class();
        if (!isset(self::$instances[$c])) {
            $args = func_get_args();
            $reflection_object = new ReflectionClass($c);
            self::$instances[$c] = $reflection_object->newInstanceArgs($args);
        }
        return self::$instances[$c];
    }

    private function __clone() {}
	private function __wakeup() {}

	/**
	 * @param $id
	 * @return null|Zend_Db_Table_Row_Abstract
	 */
    protected function findRow( $id ){
        $result = $this->getDbTable()->find( $id );
        if ( 0 == count( $result ) ) {
            return null;
        }
        return $result->current();
    }
    /**
     * @param null $where
     * @param null $order
     * @param null $offset
     * @return null|Zend_Db_Table_Row_Abstract
     */
    protected function fetchRow( $where = null, $order = null, $offset = null ){
        return $this->getDbTable()->fetchRow( $where, $order, $offset );        
    }
    /**
     * @abstract
     * @param $row
     * @return Model_Abstract_DBObject
     */
    abstract public function parseRow ( $row );
	/**
	 * @param Zend_Db_Table_Rowset_Abstract $rowset
	 * @return Model_Abstract_DBObject[]
	 */
    public function parseRows ( Zend_Db_Table_Rowset_Abstract $rowset ) {
        $entries = array ();
        foreach ( $rowset as $row ) {
            $entry = $this->parseRow( $row );
            $entries[] = $entry;
        }
        return $entries;
    }
	/**
	 * @param $arrays
	 * @return Model_Abstract_DBObject[]
	 */
	public function parseArrays( $arrays ){
        $r = array();
        foreach ($arrays as $arr) {
            $r[] = $this->parseRow($arr);
        }
        return $r;
    }

    public function setDbTable ( $dbTable ) {

        if ( is_string( $dbTable ) ) {
            $dbTable = new $dbTable();
        }
        if ( !$dbTable instanceof Zend_Db_Table_Abstract ) {
            throw new Exception( 'Invalid table data gateway provided' );
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
	/**
	 * @return Zend_Db_Table_Abstract
	 */
    public function getDbTable () {

        if ( null === $this->_dbTable ) {
            $this->setDbTable( $this->_dbTable_ClassName );
        }
        return $this->_dbTable;
    }

    public function getDbTableFieldName_ID () {
        $class = new ReflectionClass( $this->_dbTable_ClassName );
        return $class->getConstant( 'FIELDS_ID' );
    }
	/**
	 * @param Model_Abstract_DBObject $dbObject
	 * @param array $excludeList
	 * @return void|int
	 */
    public function save ( $dbObject, $excludeList = array() ) {

        $data = $dbObject->getAssocArray();

        $excludeList[] = $fieldName_ID = $this->getDbTableFieldName_ID();
        if ( null === ( $id = $dbObject->getId() ) ) {
            foreach ( $excludeList as $key ){
	            unset( $data[$key] );
            }
            $dbObject->setId( $this->getDbTable()->insert( $data ) );
	        return true;
        } else {
            return $this->getDbTable()->update( $data, array ( "$fieldName_ID = ?" => $id ) );
        }
    }
    /**
     * @param $id
     * @param null $db_model
     * @return Model_Abstract_DBObject|null
     */
    public function find ( $id, $db_model = null ) {

        if ( !isset( $db_model ) ) {
            $db_model = new $this->_dbObject_ClassName();
        }

        $row = $this->findRow( $id );
        return ( isset($row) ? $this->parseRow( $row, $db_model ) : null );
    }
   
    public function fetch( $where = null, $order = null, $offset = null ){
        $row = $this->fetchRow( $where, $order, $offset );
        return ( isset($row) ? $this->parseRow( $row ) : null );
    }
    /**
     * @param string|null $where
     * @param string|null $order
     * @param int|null $count
     * @param int|null $offset
     * @return Model_Abstract_DBObject[]
     */
    public function fetchAll ( $where = null, $order = null, $count = null, $offset = null ) {
        
        $resultSet = $this->getDbTable()->fetchAll( $where, $order, $count, $offset );
        return $this->parseRows( $resultSet );
    }
    /**
     * @param Zend_Db_Select $select
     * @return Model_Abstract_DBObject[]
     */
    public function select( Zend_Db_Select $select ){
        $stmt = $select->query();
        $resultSet = $stmt->fetchAll();
        return $this->parseArrays( $resultSet );
    }

	public function delete ( $id ){
		$fieldName_ID = $this->getDbTableFieldName_ID();
		return $this->getDbTable()->delete( array ( "$fieldName_ID = ?" => $id ) );
	}
}
