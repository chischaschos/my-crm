<?php

class My_Bean_Result {

    private $fields;

    public function __construct() {

        $this->fields = array(
            'message' => null,
            'status' => null,
            'caller' => null
        );
    }

    public function __set($var, $value) {

        if (array_key_exists($var, $this->fields)) {
            $this->fields[$var] = $value;
        }
    }

    public function __get($var) {

        if (array_key_exists($var, $this->fields)) {
            return $this->fields[$var];
        }
    }

    public function toArray() {

        return $this->fields;
    }

    public function __toString() {

        return print_r($this->fields, true);
    }

}
