<?php
namespace App\Controllers\Helpers\Search;
defined("APPPATH") OR die("Access denied");


use \App\Controllers\Main\Base as BaseCONT,
    \App\Controllers\Helpers\Contacts\Contacts as ContactsCONT,
    \App\Models\Services\Services as ServicesModel,
    \App\Models\Services\Search\Search as SearchModel,
    \App\Controllers\Helpers\User\Conexions as ConexionsCONT;

class Services extends BaseCONT{   

    public function getPublic(){
        if(isset($this->_data['id']) && $this->_data['id'] != ''){
            $s = new ServicesModel();
            $s -> setIds($this->_data['id']);
            $s -> setTables([['users','id_pvt_user'], ['users_settings', 'id_pvt_user']]);
            $s -> setFields('read');
            $s -> setCoverage();
            $s -> setStatus(['Active']);
            $s -> get('u');
            $service = $s -> getResponse();
            $isConexion = (isset($this->_dTkn['id'],$service['user']) && $this->_dTkn['id'] != $service['user']) ? (new ConexionsCONT($service['user'], ['status' => ['Accepted', 'Pending', 'Ejected']], $this->_dTkn))->find() : false;
            $isOwnService =  (isset($this->_dTkn['id'],$service['user']) && $this->_dTkn['id'] == $service['user'] ) ? true : false;
            $restrictions = ['isConexion' => ((!$isConexion) ? false : true), 'isOWnService' => $isOwnService];
            $contacts = (!isset($service['e'])) ? ContactsCONT::get($service['id'], ((isset($isConexion['status']) && $isConexion['status'] == 'Accepted') ? true : false), 'service'): ['e' => true];
            return  (isset($service['e'], $contacts['e'])) ? ['e' => true, 'm' => 'Register Not Found']: ( isset($this->_dTkn['id']) ? ['service' => $service, 'contacts' => $contacts, 'restrictions' => $restrictions] : ['service' => $service, 'contacts' => $contacts] );
        }
    }

    public function getCategories(){
        $s = new ServicesModel();
        $s -> setStatus(['Active'], false);
        $s -> setGroupBy('category');
        $s -> get();
        return $s -> getResponse();
    }

    public function getTop(){
        $s = new ServicesModel();
        $s -> setFields();
        $s -> setTables([['users_favouriteservices','id_pvt_service'], ['users','id_pvt_user']]);
        $s -> setCoverage();
        $s -> setStatus(['Active']);
        $s -> setGroupBy('', 'users_favouriteservices');
        $s -> setLimit(3);
        $s -> get();
        return $s -> getResponse();
    }

    public function getSearch(){
        return (isset($this->_data['filter'], $this->_data['query']) && is_array($this->_data['filter']) && is_string($this->_data['query'])) ? $this->getServices($this->_data['filter'], $this->_data['query']) : null;
    }

    public function getBy(){
        return (isset($this->_data['filter']) && is_array($this->_data['filter'])) ? $this->getServices($this->_data['filter']) : null;
    }

    private function getServices($filter, $query = ''){
        //Revisar que Filtros vas a permitir
        if(isset($filter)){
            $s = new SearchModel();
            $s -> setFilter($this->_data['filter']);
            (($query != '') ? $s -> setQuery($this->_data['query']) : '');
            $s -> setCoverage();
            (($query == '') ? $s -> setTypeSearch('f') : '');
            (isset($this->_data['min']) && is_int($this->_data['min']) && $this->_data['min'] >= 0 ) ? $s -> setLimit( $this->_data['min'], ((isset($this->_data['max']) && is_int($this->_data['max']) && $this->_data['max'] > 0 && $this->_data['max'] < 100) ? $this->_data['max'] : '')) : '';
            $s -> get();
            return $s -> getResponse();
        }
    }
}
