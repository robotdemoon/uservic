<?php
namespace App\Controllers\Helpers\User;
defined("APPPATH") OR die("Access denied");


use \App\Controllers\Main\Base as BaseCONT,
    \App\Models\User\Costumers\Costumers as CostumersModel,
    \App\Models\User\Costumers\CostumersCrud as CostumersCrudModel,
    \App\Models\CrudHelper\CrudA;

class Costumers extends BaseCONT{   

    //Sacar la respuesta en una r ya que saca true o false
    public function find(){
        return (isset($this->_dTkn['id']) && $this->_id != '') ? $this->getCostumers('find', false) : null;
    }

    public function get(){
        return (isset($this->_dTkn['id'])) ? $this->getCostumers() : null;
    }

    private function getCostumers($type = 'get', $coverage = true){
        $s = new CostumersModel();
        ($type == 'get') ? $s -> setIds($this->_dTkn['id']): $s -> setIds($this->_dTkn['id'], $this->_id);
        ($type == 'get') ? $s -> setCoverage() : '';
        ($type == 'get') ? $s ->get(): $s ->find();
        ($type == 'get') ? $s -> setConvertion() : '';
        return $s ->getResponse();
    }

    public function add(){
        $s = null;
        if(isset($this->_dTkn['id'], $this->_data['costumer']) && is_int($this->_data['costumer']) && $this->_dTkn['id'] != $this->_data['costumer']){
            $cst = new CostumersCrudModel();
            $cst -> setData($this->_data, $this->_dTkn['id']);
            $cr = new CrudA();
            $s = $cr -> add($cst ->  getData(), $cst -> getQuery());
            $cr -> end(); 
            return $s;
        }
    }

    public function remove(){
        $s = null;
        if(isset($this->_dTkn['id'], $this->_data['id']) && is_int($this->_data['id'])){
            $cst = new CostumersCrudModel();
            $cst -> setType('remove');
            $cst -> setData($this->_data, $this->_dTkn['id']);
            $cr = new CrudA();
            $s = $cr -> remove($cst ->  getData(), $cst -> getQuery());
            $cr -> end(); 
            return $s;
        }
    }
}