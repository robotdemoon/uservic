<?php
namespace App\Models\User\Costumers;
defined("APPPATH") OR die("Access denied");

use \App\Models\CrudHelper\CrudMethods as CRUDMET,
    \App\Models\CrudHelper\Crud as CRUD;

class Costumers{ 


    /**
     * [Methods: get, find]
     */
    private $_table = 'uservic_users_costumers';
    private $_r;
    private $_coverage = '';
    private $_ids = [];

    public function get(){
        $this->getById();
    }

    public function setIds($idUser, $idCostumer = ''){
        $this->_ids = ($idCostumer != '') ? ['id1' => $idUser, 'id2' => $idCostumer]: $idUser;
    }

    public function setConvertion(){
        if(!isset($this->_r['e']) && count($this->_r) > 0){
            foreach ($this->_r as $k => $v) {
                $this->_r[$k]['id'] = intval($this->_r[$k]['id']);
            }
        }
    }

    public function setCoverage(){
        $this->_coverage = CRUDMET::setCoverage('uservic_users');
    }

    public function getResponse(){
        return $this->_r;
    }

    private function getById(){
        $tS = 'uservic_users';
        $tm = $this->_table;
        $this->_r = (CRUD::get("SELECT $tm.id, $tm.id_pvt_user as costumer, $tS.fullname, $tS.username, $tS.email, $tS.age, $tS.sector, $tS.interests, $tS.image $this->_coverage FROM $tm INNER JOIN $tS WHERE $tm.id_service_provider=:id AND $tm.id_pvt_user=$tS.id_pvt_user ORDER BY $tm.date DESC", [ 'id' => $this->_ids]) );
    }

    public function find(){
        $s = (CRUD::get("SELECT id FROM $this->_table WHERE id_service_provider=:id1 AND id_pvt_user=:id2", $this->_ids));
        $this->_r = (!isset($s['e']) && count($s) > 0) ? true: false;
    }

}