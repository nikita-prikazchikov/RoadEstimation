<?php

abstract class Model_Abstract_DBObject {

    protected $_id;
    
    public function __construct(array $options = null) {

        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {

        $method = 'set' . $name;
        if (( 'mapper' == $name ) || !method_exists($this, $method)) {
            throw new Exception('Invalid property');
        }
        $this->$method($value);
    }

    public function __get($name) {

        $method = 'get' . $name;
        if (( 'mapper' == $name ) || !method_exists($this, $method)) {
            throw new Exception('Invalid property');
        }
        return $this->$method();
    }

    public function setOptions(array $options) {

        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . preg_replace("/ /", "", ucwords(preg_replace("/(?:_(\w))/", strtoupper(" \\1"), $key)));
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    /**
     * @abstract
     * @return array
     */
	abstract public function getAssocArray ();
    /**
     * @param $id
     * @return Model_Abstract_DBObject
     */
    public function setId ( $id ) {
        $this->_id = (int)$id;
        return $this;
    }

    public function getId () {
        return $this->_id;
    }
}
