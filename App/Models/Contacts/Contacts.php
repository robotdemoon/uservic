<?php
namespace App\Models\Contacts;
defined("APPPATH") OR die("Access denied");

use \App\Models\CrudHelper\CrudMethods as CRUDMET,
    \App\Models\CrudHelper\Crud as CRUD;

class Contacts{ 

    private $_constraints;
    private $_table;
    private $_field;
    private $_base;
    private $_id;
    private $_r;

    public function get(){
        $this->getById();
    }

    public function setId($id){
        $this->_id = $id;
    }

    public function setTable($t){
        $this->_table = 'uservic_'.$t.'s_contacts';
        $this->_field = 'id_pvt_'.$t;
    }

    public function setConvertion(){
        if(!isset($this->_r['e']) && count($this->_r) > 0){
            foreach ($this->_r as $k => $v) {
                $this->_r[$k]['id'] = intval($this->_r[$k]['id']);
            }
        }
    }

    public function setStatus(){
        $this->_constraints = CRUDMET::setConstraints(['status' => 'Public']);
    }

    private function getById(){
        $this->_r  = (CRUD::get("SELECT id_contact as id, status, type, method FROM $this->_table WHERE $this->_field=:id  $this->_constraints", ['id' => $this->_id]));
    }

    public function getResponse(){
        return $this->_r;
    }
    
}