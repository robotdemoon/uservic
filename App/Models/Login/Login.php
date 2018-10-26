<?php
namespace App\Models\Login;
defined("APPPATH") OR die("Access denied");

use \App\Models\GlobalMethods as GM,
    \App\Models\Tkn,
    \App\Models\CrudHelper\Crud as CRUD;

class Login{ 

    private $_data;
    private $_table = 'uservic_users';
    private $_type = 'find'; 
    private $_hash;

    public function setData($data){
        $this->_data = $data;
    }

    public function validateData(){
        $s = $this->_data;
        $r = false;
        if(isset($s['email'], $s['password']) && GM::tstEmail($s['email'])){
            $r = true;
        }
        return $r;
    }

    private function setType($type){
        $this->_type = $type;
    }

    private function structData(){
        if($this->_type == 'find'){
            $this->_data = array(
                'email' => $this->_data['email'],
                'password' =>  hash('sha256', $this->_data['password'])
            );
        }else{
            $this->_data = array(
                'email' => $this->_data['email'],
                'user' => $this->_r['id_pvt_user'],
                'hash' => $this->_hash
            );
        }
    }

    public function getTkn(){
        $s = new Tkn($this->_r);
        $s = $s -> createToken();
        if(!$s['e']){
            $this->_hash = $s['r'];
            return true;
        }else{
            return false;
        }
    }

    public function getTknResponse(){
        return (isset($this->_hash)) ? ['e' => false, 'tkn' => $this->_hash]: ['e' => true, 'm' => 'Invalid Data'];
    }

    public function getData(){
        $this->_type = 'update';
        $this->structData();
        return  $this->_data;
    }

    public function getQuery(){
        return "UPDATE $this->_table SET hash=:hash WHERE id_pvt_user=:user AND email=:email";
    }

    public function find(){
        $this->structData();
        $s = (CRUD::get("SELECT id_pvt_user, fullname, username, email, age, image FROM $this->_table WHERE email=:email AND password=:password LIMIT 1", $this->_data) );
        $this->_r =  (!isset($s['e'])) ? $s[0]: $s;
        return (!isset($s['e'])) ? true: false;
    }
}