<?php
namespace App\Controllers\Helpers\Search;
defined("APPPATH") OR die("Access denied");


use \App\Controllers\Main\Base as BaseCONT,
    \App\Controllers\Helpers\Contacts\Contacts as ContactsModel,
    \App\Models\User\Perfil\Perfil as PerfilModel,
    \App\Controllers\Helpers\User\Conexions as ConexionsCONT;

class Perfil extends BaseCONT{   


    /**
     * [Funciones Get Principales]
     */

    public function getPublic(){
        return $this->getPerfil();
    }

    /**
     * [Obtnemos el perfil]
     */

    private function getPerfil(){
        if(isset($this->_data['id'])){
            $s = new PerfilModel();
            $s->setFields('read');
            $s->setId($this->_data['id']);
            $s->setCoverage();
            $s->setType('public');
            $s->get();
            $s->structInterests();
            $perfil = $s->getResponse();
            (isset($perfil['id'])) ? $contacts = ContactsModel::get($perfil['id'], ( (isset($this->_dTkn['id'])) ? ( ( $this->_dTkn['id'] != $perfil['id']) ? (new ConexionsCONT($perfil['id'], ['status' => 'Accepted'], $this->_dTkn))->find(): true): false) ) : '';
            return  (isset($perfil['e'], $contacts['e'])) ? ['e' => true, 'm' => 'Registers not Found']:['perfil' => $perfil, 'contacts' => $contacts];
        }
    }
}