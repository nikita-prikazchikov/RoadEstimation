<?php

class Model_Abstract_Filter {

	protected $_id;
	protected $_idApplication;
	protected $_idSpeciality;
	protected $_id_user;
	protected $_id_year;
	protected $_start_date;
	protected $_end_date;
	protected $_type;
	protected $_active;
	protected $_status;

    protected $_id_road;

	protected $_name;

	protected $_offset;
	protected $_limit;

	public function __construct () {

	}

	// ===============================================================================================================================================

	public function parseJSON ( $value ) {
		try {
			$o = json_decode( $value, true );
			if ( isset( $o[ "active" ] ) ) {
				$this->setActive( $o[ "active" ] );
			}
			if ( isset( $o[ "end_date" ] ) ) {
				$this->setEndDate( $o[ "end_date" ] );
			}
			if ( isset( $o[ "id" ] ) ) {
				$this->setId( $o[ "id" ] );
			}
			if ( isset( $o[ "id_application" ] ) ) {
				$this->setIdApplication( $o[ "id_application" ] );
			}
			if ( isset( $o[ "id_speciality" ] ) ) {
				$this->setIdSpeciality( $o[ "id_speciality" ] );
			}
			if ( isset( $o[ "id_road" ] ) ) {
				$this->setIdRoad( $o[ "id_road" ] );
			}
			if ( isset( $o[ "id_user" ] ) ) {
				$this->setIdUser( $o[ "id_user" ] );
			}
			if ( isset( $o[ "id_year" ] ) ) {
				$this->setIdYear( $o[ "id_year" ] );
			}
			if ( isset( $o[ "limit" ] ) ) {
				$this->setLimit( $o[ "limit" ] );
			}
			if ( isset( $o[ "name" ] ) ) {
				$this->setName( $o[ "name" ] );
			}
			if ( isset( $o[ "offset" ] ) ) {
				$this->setOffset( $o[ "offset" ] );
			}
			if ( isset( $o[ "start_date" ] ) ) {
				$this->setStartDate( $o[ "start_date" ] );
			}
			if ( isset( $o[ "status" ] ) ) {
				$this->setStatus( $o[ "status" ] );
			}
			if ( isset( $o[ "type" ] ) ) {
				$this->setType( $o[ "type" ] );
			}
		}
		catch ( Exception $e ) {
		}
	}

	// ===============================================================================================================================================

    public function getSemesterAll () {
        return array( "" => "Оба" ) + $this->getSemester();
    }

	public function getSemester () {
		return array(
			"I" => "I",
			"II" => "II"
		);
	}

    public function getRateList(){
        return array(
            "0" => "Нет",
            "0.25" => "0.25",
            "0.5" => "0.5",
            "0.75" => "0.75",
            "1" => "1",
            "1.25" => "1.25",
            "1.5" => "1.5",
            "1.75" => "1.75",
            "2" => "2",
        );
    }

	public function getUsers () {
		$mapper = Model_DBMapper_UserMapper::get_instance();
		$users = $mapper->getAssocUsers();
		return $users;
	}

	public function getUsersAll () {
		$users = array( "" => "All" );
		$users += $this->getUsers();
		return $users;
	}

	// ===============================================================================================================================================

	public function setActive ( $active ) {
		$this->_active = $active;
		return $this;
	}

	public function getActive () {
		return $this->_active;
	}

	public function setEndDate ( $end_date ) {
		$this->_end_date = $end_date;
		return $this;
	}

	public function getEndDate () {
		return $this->_end_date;
	}

	public function setId ( $id ) {
		$this->_id = $id;
		return $this;
	}

	public function getId () {
		return $this->_id;
	}

	public function setIdRoad ( $id ) {
		$this->_id_road = $id;
		return $this;
	}

	public function getIdRoad () {
		return $this->_id_road;
	}

	public function setIdUser ( $id_user ) {
		$this->_id_user = $id_user;
		return $this;
	}

	public function setIdApplication ( $idApplication ) {
		$this->_idApplication = $idApplication;
	}

	public function getIdApplication () {
		return $this->_idApplication;
	}

	public function getIdUser () {
		return $this->_id_user;
	}

    public function setIdSpeciality ( $idSpeciality ) {
        $this->_idSpeciality = $idSpeciality;
    }

    public function getIdSpeciality () {
        return $this->_idSpeciality;
    }

    public function setIdYear ( $id_year ) {
        $this->_id_year = $id_year;
    }

    public function getIdYear () {
        return $this->_id_year;
    }




	public function setLimit ( $limit ) {
		$limit = $limit < 1 ? 1 : $limit;
		$this->_limit = $limit;
	}

	public function getLimit () {
		return $this->_limit;
	}

	public function setOffset ( $offset ) {
		$this->_offset = $offset;
	}

	public function getOffset () {
		return $this->_offset;
	}

	public function setStartDate ( $start_date ) {
		$this->_start_date = $start_date;
		return $this;
	}

	public function getStartDate () {
		return $this->_start_date;
	}

	public function setStatus ( $status ) {
		$this->_status = $status;
		return $this;
	}

	public function getStatus () {
		return $this->_status;
	}

	public function setType ( $type ) {
		$this->_type = $type;
		return $this;
	}

	public function getType () {
		return $this->_type;
	}

	public function setName ( $name ) {
		$this->_name = $name;
		return $this;
	}

	public function getName () {
		return $this->_name;
	}

}
