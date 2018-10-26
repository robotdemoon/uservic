<?php
namespace App\Controllers\Helpers\Services;
defined("APPPATH") OR die("Access denied");


use \App\Controllers\Main\Base as BaseCONT,
    \App\Models\Services\Comments\Comments as CommentsModel;

class Comments extends BaseCONT{   

    public function get(){
        if(isset($this->_data['id'])){
            $s = new CommentsModel();
            $s->setId($this->_data['id']);
            $s->get();
            $s->structComments();
            return $s->getResponse();
        }
    }
}