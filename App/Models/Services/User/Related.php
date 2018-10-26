<?php
namespace App\Models\Services\User;
defined("APPPATH") OR die("Access denied");

use \App\Models\CrudHelper\CrudMethods as CRUDMET,
    \App\Models\CrudHelper\Crud as CRUD;

class Related{ 

    protected $_id;
    protected $_table = 'uservic_services';

    protected $_coverage = '';
    protected $_r;

    public function get(){
        $this->getById();
    }

    public function setId($id){
        $this->_id = $id;
    }

    public function setCoverage(){
        $this->_coverage = CRUDMET::setCoverage($this->_table, ['country', 'state', 'city']);
    }

    private function getById(){
        $tm = $this->_table;
        $tU = 'uservic_users';
        $this->_r = (CRUD::get("SELECT $tm.identity, $tm.name_service, $tm.category, $tm.experience, $tm.business_days, $tm.open, $tm.close, $tm.image, $tm.description $this->_coverage FROM $tm INNER JOIN $tU WHERE $tm.id_pvt_user=$tU.id_pvt_user AND $tU.username=:id AND $tm.status = 'Active'", ['id' => $this->_id]));
    }

    public function getResponse(){
        return $this->_r;
    }
}