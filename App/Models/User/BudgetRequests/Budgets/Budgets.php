<?php
namespace App\Models\User\BudgetRequests\Budgets;
defined("APPPATH") OR die("Access denied");

use \App\Models\CrudHelper\CrudMethods as CRUDMET,
    \App\Models\CrudHelper\Crud as CRUD;

class Budgets{ 

    /**
     * [Methods: get]
     */
    
    private $_table = 'uservic_budgets';
    private $_r;
    private $_coverage = '';
    private $_ids = [];
    private $_type = 'user';
    private $_status = '';

    public function get($type = 'One'){
        $this->getById($type);
    }

    public function setIds($idUser, $idBudget = ''){
        $this->_ids = ($idBudget != '') ? ['id1' => $idBudget, 'id2' => $idUser]: ['id' => $idUser];
    }

    public function setCoverage(){
        $this->_coverage = CRUDMET::setCoverage('uservic_services', ['country','state','city']);
    }

    public function setConvertion(){
        if(!isset($this->_r['e']) && count($this->_r) > 0){
            foreach ($this->_r as $k => $v) {
                $this->_r[$k]['budget'] = intval($this->_r[$k]['budget']);
            }
        }
    }

    public function setType($type = 'user'){
        $this->_type = $type;
    }

    public function setStatus(){
        $this->_status = ($this->_type == 'provider') ? " AND ($this->_table.status='Normal' OR $this->_table.status='Deleted Request')": " AND ($this->_table.status='Normal' OR $this->_table.status='Deleted Provider')";
    }

    public function getResponse(){
        return $this->_r;
    }

    private function getById($type){
        $tU = 'uservic_users';
        $tS = 'uservic_services';
        $tm = $this->_table;
        if($type == 'One'){
            $s = (CRUD::get("SELECT $tm.id_pvt_budget as budget, $tm.id_pvt_service as service, $tm.service_provider, $tm.title, $tm.total, $tm.date, (SELECT fullname FROM $tU WHERE $tU.id_pvt_user=$tm.service_provider) as fullname_provider, (SELECT fullname FROM $tU WHERE $tU.id_pvt_user=$tm.costumer) as fullname_costumer, $tS.identity as service_identity, $tS.name_service, $tS.category, $tS.experience, $tS.type_service, $tS.type_cost, $tS.cost, $tS.type_money, $tS.business_days, $tS.open, $tS.close, $tS.description, $tS.image as image_service $this->_coverage FROM $tm INNER JOIN $tS WHERE $tm.id_pvt_budget=:id1 AND ($tm.service_provider=:id2 OR $tm.costumer=:id2) AND $tm.id_pvt_service=$tS.id_pvt_service $this->_status LIMIT 1", $this->_ids) );
            $this->_r = (!isset($s['e']) && isset($s[0])) ? $s[0] : $s;
        }else{
            $this->_r = (CRUD::get("SELECT $tm.id_pvt_budget as budget, $tm.costumer, $tm.id_pvt_service as service, $tm.title, $tm.total, $tm.date ,$tU.fullname as costumer_name, $tU.username as costumer_username, $tS.name_service, $tS.image as image_service, $tS.identity as service_identity FROM $tm INNER JOIN $tS INNER JOIN $tU WHERE $tm.service_provider=:id AND $tm.id_pvt_service=$tS.id_pvt_service AND $tU.id_pvt_user=$tm.costumer AND ($tm.status='Normal' OR $tm.status='Deleted Request')", $this->_ids) );
        }
    }
}