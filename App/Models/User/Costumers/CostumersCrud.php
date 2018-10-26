<?php
namespace App\Models\User\Costumers;
defined("APPPATH") OR die("Access denied");

use \App\Models\GlobalMethods as GM;

class CostumersCrud{ 

    private $_data;
    private $_table = 'uservic_users_costumers';
    private $_type = 'add';

    public function setData($data, $idUser){
        $this->_data = $data;
        $this->_idUser = $idUser;
    }

    public function setType($type){
        $this->_type = $type;
    }

    private function structData(){
        if($this->_type == 'remove')
            $this->_data = array(
                'id' => $this->_data['id'],
                'user' => $this->_idUser
            );
        else
            $this->_data = array(
                'user' => $this->_idUser,
                'costumer' => $this->_data['costumer']
            );
    }

    public function getData(){
        $this->structData();
        return  $this->_data;
    }

    public function getQuery(){
        if($this->_type == 'remove'){
            return "DELETE FROM $this->_table WHERE id=:id AND id_service_provider=:user";
        }else{
            return "INSERT INTO $this->_table ( id_service_provider, id_pvt_user ) SELECT :user, :costumer FROM $this->_table WHERE NOT EXISTS (SELECT id FROM $this->_table WHERE id_service_provider=:user AND id_pvt_user=:costumer) LIMIT 1";
        }
    }
}