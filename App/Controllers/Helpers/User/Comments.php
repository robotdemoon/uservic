<?php
namespace App\Controllers\Helpers\User;
defined("APPPATH") OR die("Access denied");


use \App\Controllers\Main\Base as BaseCONT,
    \App\Models\User\Comments\CommentsCrud as CommentsCrudModel,
    \App\Models\CrudHelper\CrudA;

class Comments extends BaseCONT{   

    public function add(){
        $s = null;
        if(isset($this->_dTkn['id'], $this->_data)){
            $comm = new CommentsCrudModel();
            $comm -> setData($this->_data, $this->_dTkn['id']);
            if($comm -> validateData()){
                $cr = new CrudA();
                $s = $cr -> add($comm ->  getData(), $comm -> getQuery(), true);
                $cr -> end();
            } 
            return $s;
        }
    }
}