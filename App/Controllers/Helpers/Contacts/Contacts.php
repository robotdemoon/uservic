<?php
namespace App\Controllers\Helpers\Contacts;
defined("APPPATH") OR die("Access denied");

use \App\Controllers\Main\Base as BaseCONT,
    \App\Models\Contacts\Contacts as ContactsModel,
    \App\Models\Contacts\ContactsCrud as ContactsCrudModel,
    \App\Models\CrudHelper\CrudA;
    

class Contacts extends BaseCONT{  


    public function get($id, $private = false, $table ='user'){
        $s = new ContactsModel();
        $s -> setId($id);
        $s -> setTable($table);
        (!$private) ? $s -> setStatus(): '';
        $s -> get();
        $s -> setConvertion();
        return $s->getResponse(); 
    }

    public function remove(){
        if(isset($this->_data['id_contact'], $this->_dTkn['id']) && is_int($this->_data['id_contact'])){
            $cont = new ContactsCrudModel();
            $cont -> setType( 'remove' );
            $cont -> setTable( (isset($this->_data['id'])) ? 'service' : 'user' );
            $cont -> setId((isset($this->_data['id']) ? $this->_data['id'] : $this->_dTkn['id']));
            $cont -> setData($this->_data['id_contact']);
            $cr = new CrudA();
            $s = $cr -> remove($cont -> getData(), $cont -> getQuery());
            $cr -> end();
            return $s;
        }
    }

}