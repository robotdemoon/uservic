<?php
namespace App\Models\Coverage;
defined("APPPATH") OR die("Access denied");

use \App\Models\CrudHelper\CrudMethods as CRUDMET,
    \App\Models\CrudHelper\Crud as CRUD;

class Coverage{ 

    private $_table;
    private $_const = '';
    private $_data = [];
    private $_r;

    public function get(){
        $this->getById();
    }

    public function setTable($t = 'countries'){
        $this->_table = 'uservic_coverture_'.$t;
    }

    public function setId($id, $f = 'country'){
        $this->_data = ['id' => $id];
        $this->_const = " WHERE ".$f."_id=:id";
    }

    public function getResponse(){
        return $this->_r;
    }

    private function getById(){
        $this->_r = (CRUD::get("SELECT * FROM $this->_table $this->_const", $this->_data));
    }


}