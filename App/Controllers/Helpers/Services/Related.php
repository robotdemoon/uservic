<?php
namespace App\Controllers\Helpers\Services;
defined("APPPATH") OR die("Access denied");


use \App\Controllers\Main\Base as BaseCONT,
    \App\Models\Services\Search\Search as SearchModel,
    \App\Models\Services\User\Related as RelatedServicesModel;

class Related extends BaseCONT{   
    /**
     * [Servicios Relacionados a servicios]
     */
    public function get(){
        if(isset($this->_data['category'], $this->_data['min']) && is_int($this->_data['min'])){
            $s = new SearchModel();
            $s -> setFilter(['category' => $this->_data['category']]);
            $s -> setCoverage();
            $s -> setLimit($this->_data['min'], '');
            $s -> setTypeSearch('f');
            $s -> get();
            return $s -> getResponse();
        }
    }

    /**
     * [Servicios Relacionados a Usuario]
     */

    public function getUserRelated(){
        $r = null;
        if(isset($this->_data['user'])){
            $s = new RelatedServicesModel();
            $s -> setId($this->_data['user']);
            $s -> setCoverage();
            $s -> get();
            $r = $s -> getResponse();
        }
        return $r;
    }
}