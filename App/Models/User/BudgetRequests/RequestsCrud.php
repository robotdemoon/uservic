<?php
namespace App\Models\User\BudgetRequests;
defined("APPPATH") OR die("Access denied");

use \App\Models\GlobalMethods as GM;

class RequestsCrud{ 

    private $_data;
    private $_table = 'uservic_budget_requests';
    private $_type = 'add';
    private $_field = 'id_pvt_budget';

    public function setData($data, $idUser){
        $this->_data = $data;
        $this->_idUser = $idUser;
    }

    public function setId($idBudget){
        $this->_idBudget = $idBudget;
    }

    /**
     * [UpdateBudget(interna) / UpdateStatus / Remove / Add]
     */
    public function setType($type){
        $this->_type = $type;
    }

    public function validateData(){
        $s = $this->_data;
        $r = true;
        if( ($this->_type == 'updateStatus') && isset($s['status'], $s['id_request']) && GM::tstStg($s['status']) ){
            $r = true;
        }else if( $this->_type == 'add' && isset($s['service_provider'], $s['service'], $s['description']) && GM::tstStg($s['description'], 'long') && is_int($s['service_provider']) &&  is_int($s['service']) ){
            $r = true;
        }
        return $r;
    }

    private function structData(){
       if($this->_type == 'updateBudget'){
           $this->_data = array(
            'id_request' => $this->_data['id_request'],
            'service_provider' => $this->_idUser,
            'status' => $this->_data['status'],
            'budget' => $this->_idBudget
           );
       }else if($this->_type == 'updateStatus'){
        $this->_data = array(
            'user' => $this->_idUser,
            'id_request' => $this->_data['id_request'],
            'status' => $this->_data['status']
           );
       }else if($this->_type == 'remove'){
        $this->_data = array(
            'user' => $this->_idUser,
            'id_request' => $this->_data['id_request']
           );
       }else{
           $this->_data = array(
            'id_pvt_user' => $this->_idUser,
            'service_provider' => $this->_data['service_provider'],
            'service' => $this->_data['service'],
            'description' => $this->_data['description'],
           );
       }
    }

    public function getData(){
        $this->structData();
        return  $this->_data;
    }

    public function getQuery(){
        if($this->_type == 'updateBudget'){
            return "UPDATE $this->_table SET status=:status, id_pvt_budget=:budget  WHERE id=:id_request AND service_provider=:service_provider";
        }else if($this->_type == 'updateStatus'){
            return "UPDATE $this->_table SET status=:status  WHERE id=:id_request AND service_provider=:user";
        }else if($this->_type == 'remove'){
            return "DELETE FROM $this->_table WHERE id=:id_request AND id_pvt_user=:user";
        }else{
            return "INSERT INTO $this->_table (id_pvt_user, service_provider, id_pvt_service, description) VALUES (:id_pvt_user, :service_provider, :service, :description)";
        }
    }
}