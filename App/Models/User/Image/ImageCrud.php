<?php
namespace App\Models\User\Image;
defined("APPPATH") OR die("Access denied");

use \App\Models\CrudHelper\CrudMethods as CRUDMET,
    \App\Models\CrudHelper\Crud as CRUD,
    \App\Models\User\Image\Upload as UploadModel;

class ImageCrud{ 

    protected $_id;
    protected $_table;

    protected $_type = 'user';
    protected $_r;

    private function setFields(){
        $this->_fields = ($this->_type == 'user') ? " id_pvt_user=:user" : " id_pvt_service=:service AND id_pvt_user=:user";
    }

    public function setName($nameImage){
        $this->_nameImage = $nameImage;
    }

    public function setData($data, $idUser){
        $this->_data = $data;
        $this->_idUser = $idUser;
        $this->_id = MD5($this->_data['email'].( ($this->_type == 'service') ? $this->_data['id'] : $this->_idUser ).rand(1000 , 1000000) );
    }

    public function structData(){
        $s = $this->_data; 
        $this->_data = array (
            'image' => $this->_nameImage,
            'user' => $this->_idUser,
            'date' => date("Y-m-d H:i:s")
        );
        ($this->_type == 'service') ? $this->_data['service'] = $s['id'] : '';
    }

    public function setType($type){
        $this->_type = $type;
    }

    public function uploadImage(){
        return UploadModel::getUrlUploadImage($this->_data['image'], $this->_type.'s', $this->_id);
    }

    public function removeImage($image){
        UploadModel::removeImage($image, $this->_type.'s');
    }

    public function getData(){
        $this->structData();
        return $this->_data;
    }

    public function getQuery(){
        $this->setFields();
        $s = "UPDATE ".( ($this->_type == 'user') ? "uservic_users" : "uservic_services")." SET image=:image, date_update=:date WHERE $this->_fields";
        return $s;
    }
}