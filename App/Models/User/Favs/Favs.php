<?php
namespace App\Models\User\Favs;
defined("APPPATH") OR die("Access denied");

use \App\Models\CrudHelper\CrudMethods as CRUDMET,
    \App\Models\CrudHelper\Crud as CRUD;

class Favs{ 

    private $_table = 'uservic_users_favouriteservices';
    private $_r;

    public function get(){
        $this->getById();
    }

    public function setId($id){
        $this->_id = $id;
    }

    public function setConvertion(){
        if(!isset($this->_r['e']) && count($this->_r) > 0){
            foreach ($this->_r as $k => $v) {
                $this->_r[$k]['id'] = intval($this->_r[$k]['id']);
                $this->_r[$k]['service'] = intval($this->_r[$k]['service']);
            }
        }
    }

    public function getResponse(){
        return $this->_r;
    }

    private function getById(){
        $tU = 'uservic_users';
        $tS = 'uservic_services';
        $this->_r = (CRUD::get("SELECT $this->_table.id_favourite_service as id, $this->_table.id_pvt_service as service, $tU.fullname, $tS.identity, $tS.name_service, $tS.business_days, $tS.open, $tS.close, $tS.image FROM $this->_table INNER JOIN $tU INNER JOIN $tS WHERE  $tS.id_pvt_user=$tU.id_pvt_user AND $this->_table.id_pvt_service=$tS.id_pvt_service AND $this->_table.id_pvt_user=:id", ['id' => $this->_id]));
    }

    public function find(){
        $s = (CRUD::get("SELECT id_favourite_service as id FROM $this->_table WHERE id_pvt_service=:id LIMIT 1", ['id' => $this->_id]));
        $this->_r = (!isset($s['e']) && count($s) > 0) ? ['isFavs' => true] : ['isFavs' => false];
    }

}