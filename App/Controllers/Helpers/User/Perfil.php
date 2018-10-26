<?php
namespace App\Controllers\Helpers\User;
defined("APPPATH") OR die("Access denied");


use \App\Controllers\Main\Base as BaseCONT,
    \App\Controllers\Helpers\Contacts\Contacts as ContactsModel,
    \App\Models\Contacts\ContactsCrud as ContactsCrudModel,
    \App\Models\User\Perfil\Perfil as PerfilModel,
    \App\Models\User\Perfil\PerfilCrud as PerfilCrudModel,
    \App\Models\User\Image\ImageCrud as ImageCrudModel,
    \App\Controllers\Helpers\User\Conexions as ConexionsCONT,
    \App\Models\CrudHelper\CrudA;

class Perfil extends BaseCONT{   

    /**
     * [Funciones Get Principales]
     */

    public function get(){
        return $this->getPerfil();
    }

    public function getEdit(){
        return $this->getPerfil('edit', false);
    }

    public function update(){
        $s = null;
        if(isset($this->_dTkn['id'], $this->_data['perfil'], $this->_data['contacts'])){
            $u = new PerfilCrudModel();
            $u -> setType('update');
            $u -> setData($this->_data['perfil']);
            $c = new ContactsCrudModel();
            $c -> setTable('user');
            $c -> setType('update');
            $c -> setData($this->_data['contacts']);
            if( $u -> validateData() && $c -> validateData() ){
                $u -> setId($this->_dTkn['id']);
                $cr = new CrudA();
                $s = $cr -> update($u -> getData(), $u -> getQuery());
                if(!$s['e']){
                    $c -> setId($this->_dTkn['id']);
                    $s = $cr -> update($c -> getData(), $c -> getQuery());
                }
                $cr -> end();
            }
            return $s;
        }
    }

    public function image(){
        $s = null;
        if(isset($this->_dTkn['id'], $this->_dTkn['email'], $this->_data['image'], $this->_data['nameImage'])){
            $im = new ImageCrudModel();
            $im -> setData(['image' => $this->_data['image'], 'email' => $this->_dTkn['email']], $this->_dTkn['id']);
            $simg = $im -> uploadImage();
            if(!$simg['e']){
                $im -> setName($simg['image']);
                $cr = new CrudA();
                $s = $cr -> update($im -> getData(), $im -> getQuery());
                $cr -> end();
                if($s['e']){
                    $im -> removeImage($simg['image']);
                    $s['image'] = $this->_data['nameImage'];
                }else{
                    $s['image'] = $simg['image'];
                    $im -> removeImage($this->_data['nameImage']);
                }
            }
            return $s;
        }
    }

    /**
     * [Obtnemos el perfil]
     */

    private function getPerfil($type = 'read', $coverage = true){
        if(isset($this->_dTkn['id'])){
            $s = new PerfilModel();
            $s -> setFields($type);
            $s -> setId($this->_dTkn['id']);
            ($coverage) ? $s->setCoverage(): '';
            $s -> get();
            $s -> structInterests();
            $s -> setConvertion();
            $perfil = $s->getResponse();
            $contacts = ContactsModel::get($this->_dTkn['id'], true);
            if(isset($perfil['id'])) unset($perfil['id']);
            return (isset($perfil['e'], $contacts['e'])) ? ['e' => true, 'm' => 'Something went wrong']:['perfil' => $perfil, 'contacts' => $contacts];
        }
    }
}