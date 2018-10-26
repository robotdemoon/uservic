<?php
namespace App\Models\User\Services;
defined("APPPATH") OR die("Access denied");

use \App\Models\CrudHelper\CrudMethods as CRUDMET,
    \App\Models\CrudHelper\Crud as CRUD;

class Services{ 

    /**
     * [Methods: getAll(my services), getNames, getEdit]
     */

    private $_tm= 'uservic_services';
    private $_fields = '*';
    private $_r;
    private $_coverage = '';
    private $_status = '';

    public function get($type = 'm'){
        $this->getBy($type);
    }

    public function setFields($type){
        switch ($type) {
            case 'all':
                $this->_fields = 'id_pvt_service as id, identity, name_service, image, status, date, date_update';
                break;
            case 'names':
                $this->_fields = 'id_pvt_service as id, name_service';
                break;
            case 'edit':
                $this->_fields = 'id_pvt_service as id, name_service, category, experience, type_service, type_cost, cost, type_money, business_days, open, close, country, state, city, description, image';
                break;
        }

    }

    public function setIds($idUser, $idService = ''){
        $this->_baseConst = (isset($idUser, $idService) && $idUser != '' && $idService != '') ? "$this->_tm.identity=:id1 AND $this->_tm.id_pvt_user=:id2": ((isset($idUser) && $idUser != '') ? "$this->_tm.id_pvt_user=:id":"$this->_tm.identity=:id");
        $this->_data = (isset($idUser, $idService) && $idUser != '' && $idService != '') ? ['id1' => $idService, 'id2' => $idUser]: ((isset($idUser) && $idUser != '') ? ['id' => $idUser]:['id' => $idService]);
    }

    public function getResponse(){
        return $this->_r;
    }

    public function setConvertion($type){
        if(!isset($this->_r['e'])){
            if($type == 'u'){
                $this->_r['id'] = intval($this->_r['id']);
                $this->_r['experience'] = intval($this->_r['experience']);
                $this->_r['cost'] = floatval($this->_r['cost']);
                $this->_r['country'] = intval($this->_r['country']);
                $this->_r['state'] = intval($this->_r['state']);
                $this->_r['city'] = intval($this->_r['city']);
            }else{
                foreach ($this->_r as $k => $v) {
                    $this->_r[$k]['id'] = intval($this->_r[$k]['id']);
                }
            }
        }
    }

    public function structDays(){
        (!isset($this->_r['e']) && isset($this->_r['business_days'])) ? $this->_r['business_days'] = explode(',', $this->_r['business_days']):'';
    }

    public function setStatus($status = ['Active']){
        $s = '';
        foreach ($status as $k => $v) {
            $s .= "$this->_tm.status='$v' OR ";
        }
        $this->_status = "(".substr($s, 0, -3).")";
    }

    private function getBy($type = 'm'){
        $sql = "SELECT $this->_fields $this->_coverage FROM $this->_tm WHERE $this->_baseConst AND $this->_status";
        $s = CRUD::get($sql, $this->_data);
        $this->_r = (($type == 'u' && isset($s[0]) && !isset($s['e'])) ? $s[0]: $s);
    }   
}
