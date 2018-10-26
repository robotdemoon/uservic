<?php
namespace App\Models\User\Perfil;
defined("APPPATH") OR die("Access denied");

use \App\Models\GlobalMethods as GM;

class PerfilCrud{ 

    private $_data;
    private $_table = 'uservic_users';
    private $_type = 'add';

    public function setData($data){
        $this->_data = $data;
    }

    public function setId($id){
        $this->_id = $id;
    }

    public function setType($type){
        $this->_type = $type;
    }

    public function validateData(){
        $s = $this->_data;
        $r = false;
        if($this->_type == 'add' && isset($s['fullname'], $s['username'], $s['email'], $s['country'], $s['age'], $s['sector'], $s['scholarship'], $s['password']) && GM::tstStg($s['fullname'], 'long') && GM::tstStg($s['username']) && is_int($s['country']) && is_int($s['age']) && GM::tstStg($s['sector'], 'space') && GM::tstStg($s['scholarship'])){
            $r = true;
        }else if($this->_type == 'update' && isset($s['fullname'], $s['country'], $s['age'], $s['sector'], $s['scholarship'], $s['interests'], $s['description']) && GM::tstStg($s['fullname'], 'long')  && is_int($s['country']) && is_int($s['age']) && GM::tstStg($s['sector'], 'space') && GM::tstStg($s['scholarship']) && GM::tstStg($s['interests'], 'list') && GM::tstStg($s['description'], 'long')){
            $r = true;
        }
        return $r;
    }

    private function convertData(){
        if($this->_type == 'add'){
            $this->_data = array(
                'fullname' => $this->_data['fullname'],
                'username' => $this->_data['username'],
                'email' => $this->_data['email'],
                'country' => $this->_data['country'],
                'age' => $this->_data['age'],
                'sector' => $this->_data['sector'],
                'scholarship' => $this->_data['scholarship'],
                'password' => hash('sha256', $this->_data['password'])
            );
        }else{
            $this->_data = array(
                'id' => $this->_id,
                'fullname' => $this->_data['fullname'],
                'country' => $this->_data['country'],
                'age' => $this->_data['age'],
                'sector' => $this->_data['sector'],
                'scholarship' => $this->_data['scholarship'],
                'description' => $this->_data['description'],
                'interests' => $this->_data['interests'],
                'date_update' => date("Y-m-d H:i:s")
            );
        }
    }


    public function getData(){
        $this->convertData();
        return  $this->_data;
    }

    public function getQuery(){
        if($this->_type == 'add'){
            return "INSERT INTO $this->_table (fullname, username, email, age, country, scholarship, sector, password) VALUES (:fullname, :username, :email, :age, :country, :scholarship, :sector, :password)";
        }else{
            return "UPDATE $this->_table SET fullname=:fullname, age=:age, country=:country,scholarship=:scholarship, sector=:sector, interests=:interests, description=:description, date_update=:date_update WHERE id_pvt_user=:id";
        }
    }
}