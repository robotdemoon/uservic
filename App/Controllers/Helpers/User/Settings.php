<?php
namespace App\Controllers\Helpers\User;
defined("APPPATH") OR die("Access denied");


use \App\Controllers\Main\Base as BaseCONT,
    \App\Models\User\Settings\Settings as SettingsModel,
    \App\Models\User\Settings\SettingsCrud as SettingsCrudModel,
    \App\Models\CrudHelper\CrudA;

class Settings extends BaseCONT{   

    public function get(){
        if(isset($this->_dTkn['id'])){
            $s = new SettingsModel();
            $s -> setId($this->_dTkn['id']);
            $s -> get();
            $s -> transformResult();
            return $s -> getResponse();
        }
    }

    public function update(){
        $s = null;
        if(isset($this->_dTkn['id'], $this->_data)){
            $p = new SettingsCrudModel();
            $p -> setData($this->_data, $this->_dTkn['id']);
            if($p -> validateData()){
                $cr = new CrudA();
                $s = $cr -> update($p -> getData(), $p -> getQuery());
                $cr -> end();
            }
            return $s;
        }
    }
}