<?php
namespace App\Models\User\Perfil;
defined("APPPATH") OR die("Access denied");

use \App\Models\CrudHelper\CrudMethods as CRUDMET,
    \App\Models\CrudHelper\Crud as CRUD;

class Perfil{ 

    protected $_id;
    protected $_table = 'uservic_users';

    protected $_fields = '*';
    protected $_coverage = '';
    protected $_type = 'pvt';
    protected $_r;

    public function get(){
        $this->getById();
    }

    public function setFields($type){
        $this->_fields = 'id_pvt_user as id, fullname, age, scholarship, sector, interests,image, description'.(($type == 'read') ? ', username, email': ',country');
    }

    public function setType($type){
        $this->_type = $type;
    }

    public function setId($id){
        $this->_id = $id;
    }

    public function setCoverage(){
        $this->_coverage = CRUDMET::setCoverage($this->_table);
    }

    public function setConvertion(){
        if(!isset($this->_r['e'])){
            $this->_r['age'] = intval($this->_r['age']);
            (isset($this->_r['country'])) ? $this->_r['country'] = intval($this->_r['country']) : '';
            $this->_r['id'] = intval($this->_r['id']);
        }
    }

    public function structInterests(){
        (!isset($this->_r['e']) && isset($this->_r['interests'])) ? $this->_r['interests'] = explode(',', $this->_r['interests']):'';
    }

    private function getById(){
        $s = (CRUD::get("SELECT $this->_fields $this->_coverage FROM $this->_table WHERE ".(($this->_type == 'public') ? "username": "id_pvt_user")."=:id", ['id' => $this->_id]));
        $this->_r =  (!isset($s['e'])) ? $s[0]: $s;
    }

    public function getResponse(){
        return $this->_r;
    }
}