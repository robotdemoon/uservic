<?php
namespace App\Models\User\Settings;
defined("APPPATH") OR die("Access denied");

use \App\Models\CrudHelper\CrudMethods as CRUDMET,
    \App\Models\CrudHelper\Crud as CRUD;

class Settings{ 

    private static $_table = 'uservic_users_settings';
    private $_r;

    public function get(){
        $this->getById();
    }

    public function setId($id){
        $this->_id = $id;
    }

    public function getResponse(){
        return $this->_r;
    }

    public function transformResult(){
        foreach ($this->_r as $k => $v) {
            $this->_r[$k] = ($v == 1) ? true: false;
        }
    }


    private function getById(){
        $s = (CRUD::get("SELECT location, conexions, uservic_changes, budgets FROM ".self::$_table." WHERE id_pvt_user=:id", ['id' => $this->_id]));
        $this->_r =  (!isset($s['e'])) ? $s[0]: $s;
    }


}