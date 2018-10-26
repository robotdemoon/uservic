<?php
namespace App\Models\User\BudgetRequests\Budgets;
defined("APPPATH") OR die("Access denied");

use \App\Models\GlobalMethods as GM;

class BudgetsCrud{ 

    private $_data;
    private $_table = 'uservic_budgets';
    private $_type = 'add';

    public function setData($data, $idUser = ''){
        $this->_data = $data;
        $this->_idUser = $idUser;
    }

    /**
     * [ Add / Remove]
     */

    public function setType($type){
        $this->_type = $type;
    }

    public function validateData(){
        $s = $this->_data;
        $r = false;
        if( $this->_type == 'add' && isset($s['title'], $s['total'], $s['costumer'], $s['service']) && GM::tstStg($s['title'], 'long') && (is_int($s['total']) || is_float($s['total'])) && is_int($s['costumer']) && is_int($s['service']) ){
            $r = true;
        }
        return $r;
    }

    private function structData(){
        if($this->_type == 'remove'){
            $this->_data = array(
                'user' => $this->_idUser,
                'budget' => $this->_data['budget']
            );
        }else{
            $this->_data = array(
                'service_provider' => $this->_idUser,
                'costumer' => $this->_data['costumer'],
                'service' => $this->_data['service'],
                'title' => $this->_data['title'],
                'total' => $this->_data['total']
            );
        } 
    }

    public function getData(){
        $this->structData();
        return  $this->_data;
    }

    public function getQuery(){
        if($this->_type == 'remove'){
            return  "DELETE FROM $this->_table WHERE id_pvt_budget=:budget AND costumer=:user AND NOT EXISTS(SELECT service_provider FROM uservic_budget_requests WHERE id_pvt_budget=:budget)";
        }else{
            return "INSERT INTO $this->_table (service_provider, costumer, id_pvt_service, title, total) VALUES (:service_provider, :costumer, :service, :title, :total)";
        }
    }
}