<?php
namespace App\Controllers\Helpers\User\BudgetRequests\Budgets;
defined("APPPATH") OR die("Access denied");


use \App\Controllers\Main\Base as BaseCONT,
    \App\Controllers\Helpers\User\BudgetRequests\Budgets\BudgetServices as BudgetSCONT,
    \App\Controllers\Helpers\Contacts\Contacts as ContactsCONT,
    \App\Models\User\BudgetRequests\Budgets\Budgets as BudgetsModel,
    \App\Models\User\BudgetRequests\Budgets\BudgetsCrud as BudgetsCrudModel,
    \App\Models\User\BudgetRequests\Budgets\BudgetServicesCrud as BudgetServicesCrudModel,
    \App\Models\User\BudgetRequests\RequestsCrud as RequestsCrudModel,
    \App\Controllers\Helpers\User\Conexions as ConexionsCONT,
    \App\Models\CrudHelper\CrudA;

class Budgets extends BaseCONT{   

    private $_pvt_contacts = false;

    public function get(){
        if(isset($this->_dTkn['id'], $this->_data['t']) && $this->_id != '' &&  ($this->_data['t'] == 'user' || $this->_data['t'] == 'provider') ){
            $s = new BudgetsModel();
            $s -> setIds($this->_dTkn['id'], $this->_id);
            $s -> setCoverage();
            $s -> setType($this->_data['t']);
            $s -> setStatus();
            $s -> get('One');
            $budget = $s ->getResponse();
            if(isset($budget['budget'])){
                $services = BudgetSCONT::get($budget['budget']);
                $contacts =  ContactsCONT::get($budget['service'], (($this->_data['t'] == 'provider') ? true : (new ConexionsCONT($budget['service_provider'], ['status' => 'Accepted'], $this->_dTkn))->find()), 'service' );
                return ['budget' => $budget, 'services' => $services, 'contacts' => $contacts];
            }else{
                return $budget;
            }
        }
    }

    public function add(){
        $s = null;
        if(isset($this->_dTkn['id'], $this->_data['budget'], $this->_data['budget_s'], $this->_data['id_request'])){
            $b = new BudgetsCrudModel();
            $b -> setData($this->_data['budget'], $this->_dTkn['id']);
            $bs = new BudgetServicesCrudModel();
            $bs -> setData($this->_data['budget_s'], $this->_dTkn['id']);
            if($b -> validateData() && $bs -> validateData()){
                $cr = new CrudA();
                $s = $cr -> add($b -> getData(), $b -> getQuery(), true);
                if(!$s['e'] && isset($s['id'])){
                    $idBudget = $s['id'];
                    $bs -> setId($idBudget);
                    $s = $cr -> add($bs -> getData(), $bs -> getQuery());
                    if(!$s['e'] ){
                        $req = new RequestsCrudModel();
                        $req -> setType('updateBudget');
                        $req -> setData(['status' => 'Completed', 'id_request' => $this->_data['id_request']], $this->_dTkn['id']);
                        $req -> setId($idBudget);
                        $s = $cr -> update($req -> getData(), $req -> getQuery());
                    }
                }
                $cr -> end();
            }
            return $s;
        }
    }

    public function update(){
        $s = null;
        if(isset($this->_dTkn['id'], $this->_data)){
            $br = new  BudgetsCrudModel();
            $br -> setType('update');
            $br -> setData($this->_data, $this->_dTkn['id']);
            if($br -> validateData()){
                $cr = new CrudA();
                $s = $cr -> update($br ->  getData(), $br -> getQuery());
                $cr -> end(); 
            }
            return $s;
        }
    }

    public function getAll(){
        if(isset($this->_dTkn['id'])){
            $s = new BudgetsModel();
            $s -> setIds($this->_dTkn['id']);
            $s -> get('All');
            $s -> setConvertion();
            return $s -> getResponse();
        }
    }
}