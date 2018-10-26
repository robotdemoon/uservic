<?php
namespace App\Models\User\Favs;
defined("APPPATH") OR die("Access denied");

use \App\Models\GlobalMethods as GM;

class FavsCrud{ 

    private $_data;
    private $_table = 'uservic_users_favouriteservices';
    private $_type = 'add';

    public function setData($data, $idUser){
        $this->_data = $data;
        $this->_idUser = $idUser;
    }

    public function setType($type){
        $this->_type = $type;
    }

    private function structData(){
        $this->_data = array(
            'user' => $this->_idUser,
            'service' => $this->_data['service']
        );
    }

    public function getData(){
        $this->structData();
        return  $this->_data;
    }

    public function getQuery(){
        if($this->_type == 'remove'){
            return "DELETE FROM $this->_table WHERE id_pvt_user=:user AND id_pvt_service=:service";
        }else{
            return "INSERT INTO $this->_table (id_pvt_user, id_pvt_service) SELECT :user, :service FROM $this->_table WHERE NOT EXISTS (SELECT id_pvt_service FROM $this->_table WHERE id_pvt_user=:user AND id_pvt_service=:service) LIMIT 1";
        }
    }
}