<?php
namespace App\Models\User\Settings;
defined("APPPATH") OR die("Access denied");

use \App\Models\GlobalMethods as GM;

class SettingsCrud{ 

    private $_data;
    private $_table = 'uservic_users_settings';

    public function setData($data, $idUser){
        $this->_data = $data;
        $this->_idUser = $idUser;
    }

    public function validateData(){
        $s = $this->_data;
        $r = false;
        if(isset($s['location'], $s['conexions'], $s['uservic_changes'], $s['budgets']) && is_bool($s['location']) && is_bool($s['conexions']) && is_bool($s['uservic_changes']) && is_bool($s['budgets']) ){
            $r = true;
        }
        return $r;
    }

    private function structData(){
        $this->_data = array(
            'user' => $this->_idUser,
            'location' => $this->_data['location'],
            'conexions' => $this->_data['conexions'],
            'uservic_changes' => $this->_data['uservic_changes'],
            'budgets' => $this->_data['budgets'],
            'date_update' => date("Y-m-d H:i:s")
        );
    }

    public function getData(){
        $this->structData();
        return  $this->_data;
    }

    public function getQuery(){
        return "UPDATE $this->_table SET location=:location, conexions=:conexions, uservic_changes=:uservic_changes, budgets=:budgets, date_update=:date_update WHERE id_pvt_user=:user";
    }
}