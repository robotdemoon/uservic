<?php
namespace App\Controllers\Helpers\User;
defined("APPPATH") OR die("Access denied");


use \App\Controllers\Main\Base as BaseCONT,
    \App\Models\User\Favs\Favs as FavsModel,
    \App\Models\User\Favs\FavsCrud as FavsCrudModel,
    \App\Models\CrudHelper\CrudA;

class Favs extends BaseCONT{   

    public function get(){
        if(isset($this->_dTkn['id'])){
            $s = new FavsModel();
            $s -> setId($this->_dTkn['id']);
            $s -> get();
            $s -> setConvertion();
            return $s -> getResponse();
        }
    }

    public function find(){
        if(isset($this->_dTkn['id'], $this->_id) && is_int($this->_id)){
            $s = new FavsModel();
            $s -> setId($this->_id);
            $s -> find();
            return $s -> getResponse();
        }
    }

    public function add(){
        $s = null;
        if(isset($this->_dTkn['id'], $this->_data['service']) && is_int($this->_data['service'])){
            $fv = new FavsCrudModel();
            $fv -> setData($this->_data, $this->_dTkn['id']);
            $cr = new CrudA();
            $s = $cr -> add($fv ->  getData(), $fv -> getQuery());
            $cr -> end(); 
            return $s;
        }
    }

    public function remove(){
        $s = null;
        if(isset($this->_dTkn['id'], $this->_data['service']) && is_int($this->_data['service'])){
            $fv = new FavsCrudModel();
            $fv -> setType('remove');
            $fv -> setData($this->_data, $this->_dTkn['id']);
            $cr = new CrudA();
            $s = $cr -> remove($fv ->  getData(), $fv -> getQuery());
            $cr -> end(); 
            return $s;
        }
    }
}