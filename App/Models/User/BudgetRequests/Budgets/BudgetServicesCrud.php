<?php
namespace App\Models\User\BudgetRequests\Budgets;
defined("APPPATH") OR die("Access denied");

use \App\Models\GlobalMethods as GM;

class BudgetServicesCrud{ 

    private $_data;
    private $_table = 'uservic_budget_services';
    private $_field = 'id_pvt_budget';

    public function setData($data, $idUser){
        $this->_data = $data;
        $this->_idUser = $idUser;
    }

    public function setId($idBudget){
        $this->_idBudget = $idBudget;
    }

    public function validateData(){
        $s = $this->_data;
        $r = true;
        foreach($s as $k => $v){
            if(!isset($s[$k]['name'], $s[$k]['cost'],$s[$k]['number'], $s[$k]['total'], $s[$k]['description'])){
               $r = false;
               break;
            }
        }
        return $r;
    }

    private function structData(){
        foreach($this->_data as $k => $v){
            $this->_data[$k] = array(
                $this->_field => $this->_idBudget,
                'name' => $v['name'],
                'cost' => $v['cost'],
                'number' => $v['number'],
                'total' => $v['total'],
                'description' => $v['description']
            );
        }
    }

    private function setFields($data){
        $d = '';$dd = '';
        foreach ($data as $k => $v) {
            $f = array_keys($v);
            $d .= '(:'.implode($k.',:',$f).$k.'),';
        }
        return substr($d, 0, -1);
    }

    public function getData(){
        $this->structData();
        return  $this->_data;
    }

    public function getQuery(){
        $budgets_s = $this->setFields($this->_data);
        return "INSERT INTO $this->_table (id_pvt_budget, name, cost, number, total, description) VALUES $budgets_s";
    }
}