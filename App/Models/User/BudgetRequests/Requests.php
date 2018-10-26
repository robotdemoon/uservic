<?php
namespace App\Models\User\BudgetRequests;
defined("APPPATH") OR die("Access denied");

use \App\Models\CrudHelper\CrudMethods as CRUDMET,
    \App\Models\CrudHelper\Crud as CRUD;

class Requests{ 


    /**
     * [Methods: get, find]
     */
    private $_table = 'uservic_budget_requests';
    private $_r;
    private $_coverage = '';
    private $_ids = [];
    private $_type = 'user';
    private $_status = '';

    public function get(){
        $this->getById();
    }

    public function setId($idUser, $data = []){
        $this->_id = $idUser;
        $this->_data = $data;
    }

    public function setType($type = 'user'){
        $this->_type = $type;
    }

    public function setConvertion(){
        if(!isset($this->_r['e']) && count($this->_r) > 0){
            foreach ($this->_r as $k => $v) {
                $this->_r[$k]['id'] = intval($this->_r[$k]['id']);
            }
        }
    }

    public function setStatus($status){
        if(is_array($status)){
            $s = '';
            foreach ($status as $k => $v) {
                $s .= " $this->_table.status='".$v."' OR ";
            }
        }
        $this->_status = (is_array($status)) ? " AND (".substr($s, 0, -3).")" : " AND $this->_table.status='".$status."'";
    }

    public function getResponse(){
        return $this->_r;
    }

    private function getById(){
        $tU = 'uservic_users';
        $tS = 'uservic_services';
        $tC = 'uservic_users_costumers';
        $tm = $this->_table;
        $this->_r = (CRUD::get("SELECT $tm.id, ".(($this->_type == 'provider') ? "$tm.id_pvt_user as user," : "$tm.service_provider,")." $tm.id_pvt_service as service_id, $tm.description, $tm.status, $tm.id_pvt_budget as budget, $tm.date, $tU.fullname, $tU.username, $tU.image as image_user, $tU.email, $tS.identity as service_identity, $tS.name_service, $tS.image as image_service ". (($this->_type == 'provider') ? ", IF((SELECT $tC.id_pvt_user FROM $tC WHERE $tC.id_pvt_user=$tm.id_pvt_user LIMIT 1) > 0, true, false) as isCostumer": "")." FROM $tm INNER JOIN $tS INNER JOIN $tU WHERE ".(($this->_type == 'provider') ? "$tm.service_provider=:id AND $tm.id_pvt_user=$tU.id_pvt_user": "$tm.id_pvt_user=:id AND $tm.service_provider=$tU.id_pvt_user")." AND $tm.id_pvt_service=$tS.id_pvt_service $this->_status ORDER BY $tm.date_update DESC", [ 'id' => $this->_id]) );
    }

    public function find(){
        $s = (CRUD::get("SELECT id FROM $this->_table WHERE id_pvt_user=:id AND service_provider=:service_provider AND id_pvt_service=:service AND (status='Pending' OR status='Pending Provider' OR status='Ejected') ORDER BY date DESC LIMIT 1", [ 'id' => $this->_id, 'service_provider' => $this->_data['service_provider'], 'service' => $this->_data['service']]) );
        $this->_r = (!isset($s['e']) && count($s) > 0) ? ['isRequest' => true] : ['isRequest' => false];
    }
}