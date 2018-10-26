<?php
namespace App\Controllers\Helpers\User\BudgetRequests;
defined("APPPATH") OR die("Access denied");


use \App\Controllers\Main\Base as BaseCONT,
    \App\Models\User\BudgetRequests\Requests as RequestsModel,
    App\Models\User\BudgetRequests\RequestsCrud as RequestsCrudModel,
    App\Models\User\BudgetRequests\Budgets\BudgetsCrud as BudgetsCrudModel,
    \App\Models\CrudHelper\CrudA;

class Requests extends BaseCONT{   

    public function get(){
        if(isset($this->_dTkn['id'], $this->_data['t']) && ($this->_data['t'] == 'user' || $this->_data['t'] == 'provider') ){
            $s = new RequestsModel();
            $s -> setId($this->_dTkn['id']);
            $s -> setType($this->_data['t']);
            ($this->_data['t'] == 'provider') ? $s -> setStatus( ['Pending','Pending Provider', 'Completed'] ) : '';
            $s -> get();
            $s -> setConvertion();
            return $s ->getResponse();
        }
    }

    public function find(){
        if(isset($this->_dTkn['id'], $this->_data['service_provider']) && $this->_data['service'] && is_int($this->_data['service_provider']) && is_int($this->_data['service'])){
            $s = new RequestsModel();
            $s -> setId($this->_dTkn['id'], $this->_data);
            $s -> find();
            return $s ->getResponse();
        }
    }
    
    public function update(){
        $s = null;
        if(isset($this->_dTkn['id'], $this->_data)){
            $br = new RequestsCrudModel();
            $br -> setType('updateStatus');
            $br -> setData($this->_data, $this->_dTkn['id']);
            if($br -> validateData()){
                $cr = new CrudA();
                $s = $cr -> update($br ->  getData(), $br -> getQuery());
                $cr -> end(); 
            }
            return $s;
        }
    }

    public function add(){
        $s = null;
        if(isset($this->_dTkn['id'], $this->_data)){
            $br = new RequestsCrudModel();
            $br -> setData($this->_data, $this->_dTkn['id']);
            if($br -> validateData()){
                $cr = new CrudA();
                $s = $cr -> add($br ->  getData(), $br -> getQuery());
                $cr -> end(); 
            }
            return $s;
        }
    }

    public function remove(){
        $s = null;
        if(isset($this->_dTkn['id'], $this->_data['id_request']) && is_int($this->_data['id_request']) ){
            $req = new RequestsCrudModel();
            $req -> setType('remove');
            $req -> setData($this->_data, $this->_dTkn['id']);
            $cr = new CrudA();
            $s = $cr -> remove($req ->  getData(), $req -> getQuery());
            if(!$s['e'] &&  isset($this->_data['budget']) &&  is_int($this->_data['budget'])){
                $b = new BudgetsCrudModel();
                $b -> setType('remove');
                $b -> setData($this->_data, $this->_dTkn['id']);
                $s = $cr -> remove($b ->  getData(), $b -> getQuery());
            }
            $cr -> end(); 
            return $s;
        }
    }
}