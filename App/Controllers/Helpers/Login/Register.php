<?php
namespace App\Controllers\Helpers\Login;
defined("APPPATH") OR die("Access denied");


use \App\Controllers\Main\Base as BaseCONT,
    \App\Models\User\Perfil\PerfilCrud as PerfilCrudModel,
    \App\Models\CrudHelper\CrudA;

class Register extends BaseCONT{   

    public function add(){
        if(isset($this->_data['perfil'])){
            $u = new PerfilCrudModel();
            $u -> setData($this->_data['perfil']);
            if( $u -> validateData() ){
                $cr = new CrudA();
                $s = $cr -> add($u -> getData(), $u -> getQuery());
                $cr -> end();
            }
            return $s;
        }
    }

}