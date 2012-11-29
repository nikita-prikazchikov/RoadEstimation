<?php

class Model_DB_Road_Mapper extends Model_Abstract_DBMapper{

    const CLASS_NAME = 'Model_DB_Road_Mapper';

    /**
     * @param $row
     * @param \Model_DB_Road_Object $db_model
     * @return Model_DB_Road_Object
     */
    public function parseRow ( $row, Model_DB_Road_Object $db_model = null ){

        if ( null === $db_model ){
            $db_model = new Model_DB_Road_Object();
        }

        return $db_model
            ->setName( $row[ Model_DB_Road_Table::FIELDS_NAME ] )
            ->setStep( $row[ Model_DB_Road_Table::FIELDS_STEP ] )
            ->setId( $row[ Model_DB_Road_Table::FIELDS_ID ] );
    }

    public function __construct (){
        parent::__construct( 'Model_DB_Road_Object', 'Model_DB_Road_Table' );
    }

    /**
     * @return Model_DB_Road_Mapper
     */
    public static function get_instance (){
        return parent::get_instance();
    }

    public function getName ( $id ){
        /** @var $year Model_DB_Road_Object */
        $year = $this->find( $id );
        if ( !is_null( $year ) ) {
            return $year->getName();
        }
        return null;
    }

    public function findByFilter( Model_Road_Filter $filter ){

   		$where = $this->getWhereClauseByFilter( $filter );
   		$order = null;
   		return $this->fetchAll( $where, $order, $filter->getLimit(), $filter->getOffset() );
   	}

   	public function getCountByFilter( Model_Road_Filter $filter ){
   		return false;
   	}

   	protected function getWhereClauseByFilter ( Model_Road_Filter $filter ){
   		$where = "1=1 ";
   		$and = " AND ";

   		$adapter = $this->getDbTable()->getAdapter();
   		if ( $filter->getId() ){
   			$where = $adapter->quoteInto( Model_DB_Road_Table::FIELDS_ID." = ?", $filter->getId() );
   		}
   		else {
   			$value = $filter->getName();
   			if ( !empty( $value ) ){
   				$where .= $and . $adapter->quoteInto( Model_DB_Road_Table::FIELDS_NAME." LIKE ?", "%$value%" );
   			}
   		}
   		return $where;
   	}
}
