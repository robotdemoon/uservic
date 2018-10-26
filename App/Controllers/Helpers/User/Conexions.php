<?php
namespace App\Controllers\Helpers\User;
defined("APPPATH") OR die("Access denied");


use \App\Controllers\Main\Base as BaseCONT,
    \App\Models\User\Conexions\Conexions as ConexionsModel,
    \App\Models\User\Conexions\ConexionsCrud as ConexionsCrudModel,
    \App\Models\CrudHelper\CrudA;

class Conexions extends BaseCONT{   

    public function find(){
        $s = new ConexionsModel();
        $s -> setIds($this->_id, $this->_dTkn['id']);
        $s -> setStatus($this->_data['status']);
        $s -> find();
        return $s ->getResponse();
    }

    public function get(){
        if(isset($this->_dTkn['id'])){
            $s = new ConexionsModel();
            $s -> setIds($this->_dTkn['id']);
            $s -> setCoverage();
            $s -> get();
            $s -> setConvertion();
            return $s ->getResponse();
        }
    }

    public function add(){
        $s = null;
        if(isset($this->_dTkn['id'], $this->_data['conexion']) && is_int($this->_data['conexion']) && $this->_dTkn['id'] != $this->_data['conexion']){
            $cst = new ConexionsCrudModel();
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
            $cst = new ConexionsCrudModel();
            $cst -> setType('remove');
            $cst -> setData($this->_data, $this->_dTkn['id']);
            $cr = new CrudA();
            $s = $cr -> remove($cst ->  getData(), $cst -> getQuery());
            $cr -> end(); 
            return $s;
        }
    }

    public function update(){
        $s = null;
        if(isset($this->_dTkn['id'], $this->_data['id'], $this->_data['status']) && is_int($this->_data['id']) && ($this->_data['status'] == 'Accepted' OR $this->_data['status'] == 'Ejected')){
            $cst = new ConexionsCrudModel();
            $cst -> setType('update');
            $cst -> setData($this->_data, $this->_dTkn['id']);
            $cr = new CrudA();
            $s = $cr -> update($cst ->  getData(), $cst -> getQuery());
            $cr -> end(); 
            return $s;
        }
    }
}