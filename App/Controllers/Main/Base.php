<?php
namespace App\Controllers\Main;
defined("APPPATH") OR die("Access denied");

class Base {
    protected $_id;
    protected $_data;
    protected $_dTkn;

    public function __construct($id = '', $data = [], $dTkn){
        $this->_id = $id;
        $this->_data = $data;
        $this->_dTkn = $dTkn;
    }
}