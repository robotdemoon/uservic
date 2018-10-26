<?php
namespace App\Models\User\Comments;
defined("APPPATH") OR die("Access denied");

use \App\Models\GlobalMethods as GM;

class CommentsCrud{ 

    private $_data;
    private $_table = 'uservic_services_comments';

    public function setData($data, $idUser){
        $this->_data = $data;
        $this->_idUser = $idUser;
    }

    public function validateData(){
        $s = $this->_data;
        $r = false;
        if(isset($s['service'], $s['answer'], $s['msg']) && is_int($s['service']) && is_int($s['answer']) && GM::tstStg($s['msg'], 'long')){
            $r = true;
        }
        return $r;
    }

    private function structData(){
        $this->_data = array(
            'service' => $this->_data['service'],
            'answer' => $this->_data['answer'],
            'user' => $this->_idUser,
            'msg' => $this->_data['msg']
        );
    }

    public function getData(){
        $this->structData();
        return  $this->_data;
    }

    public function getQuery(){
        return "INSERT INTO $this->_table (id_pvt_service, answer, id_pvt_user, msg) VALUES (:service, :answer, :user, :msg)";
    }
}