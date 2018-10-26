<?php
namespace App\Models\User\Conexions;
defined("APPPATH") OR die("Access denied");

use \App\Models\GlobalMethods as GM;

class ConexionsCrud{ 

    private $_data;
    private $_table = 'uservic_users_conexions';
    private $_type = 'add';

    public function setData($data, $idUser){
        $this->_data = $data;
        $this->_idUser = $idUser;
    }

    public function setType($type){
        $this->_type = $type;
    }

    private function structData(){
        if($this->_type == 'remove'){
            $this->_data = array(
                'id' => $this->_data['id'],
                'user' => $this->_idUser
            );
        }else if($this->_type == 'update'){
            $this->_data = array(
                'id' => $this->_data['id'],
                'status' => $this->_data['status'],
                'user' => $this->_idUser
            );
        }else{
            $this->_data = array(
                'user' => $this->_idUser,
                'conexion' => $this->_data['conexion']
            );
        }
    }

    public function getData(){
        $this->structData();
        return  $this->_data;
    }

    public function getQuery(){
        if($this->_type == 'remove'){
            return "DELETE FROM $this->_table WHERE id_conexion=:id AND id_pvt_user=:user";
        }else if($this->_type == 'update'){
            return "UPDATE $this->_table SET status=:status WHERE id_conexion=:id AND (id_pvt_user=:user OR id_user_conexion=:user)";
        }else{
            return "INSERT INTO $this->_table ( id_pvt_user, id_user_conexion ) SELECT :user, :conexion FROM $this->_table WHERE NOT EXISTS (SELECT id_conexion FROM $this->_table WHERE (id_pvt_user=:user AND id_user_conexion=:conexion) OR (id_pvt_user=:conexion AND id_user_conexion=:user)) LIMIT 1";
        }
    }
}