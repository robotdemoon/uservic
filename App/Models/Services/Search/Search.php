<?php
namespace App\Models\Services\Search;
defined("APPPATH") OR die("Access denied");

use \App\Models\CrudHelper\CrudMethods as CRUDMET,
    \App\Models\CrudHelper\Crud as CRUD;

class Search{

    private $_table = 'uservic_services';
    private $_type_search = 'q';
    private $_coverage;
    private $_query = '';
    private $_filter = '';
    private $_fields = [];
    private $_limit = 30;
    
    /**
     * [Propiedades:  Filter, Query]
     */
    public function get(){
        if(($this->_query != '' && $this->_type_search == 'q') || ($this->_filter !='' && $this->_type_search == 'f')){
            $this->getByIds();
        }else{
            $this->_r = ['e' => true, 'm' => 'Invalida data For search'];
        }
    }
    
    /**
     * Filtros[(==) category]
     */

    public function setFilter($filter = []){
        if(is_array($filter) &&$this->validateQuantityFilter($filter)){
            $this->createFilter($this->_filter);
        }
    }

    public function setCoverage(){
        $this->_coverage = CRUDMET::setCoverage($this->_table,['country','state','city']);
    }

    public function setLimit($min, $max = ''){
        $this->_limit = ($max != '') ? "$min, $max " :$min;
    }

    public function getResponse(){
        return $this->_r;
    }

    public function setTypeSearch($type = 'q'){
        $this->_type_search = $type;
    }

    public function setQuery($query){
        if($query != '' && is_string($query)){
            $f = ['name_service', 'description'];
            foreach( explode(' ',$query) as $k => $v){
                $q = '';
                foreach ($f as $kk => $vv) {
                    $q .= $this->_table.'.'.$vv." LIKE '%".$v."%' OR "; 
                }
                $this->_query .= "(".substr($q, 0, -3).") AND ";
            }
            $this->_query = " AND ".substr($this->_query, 0, -4);
        }    
    }

    private function validateQuantityFilter($filter){
        #Revisamos que el filtro tenga algun valor
        $x = $y = 0;
        foreach ($filter as $k => $v) {
            if($v == '' || $v == null || $v === 0){
                $x++;
                unset($filter[$k]);
            }
            $y++;
        }
        if($x != $y && count($filter) > 0){
            $this->_filter = $filter;
            return true;
        }else{
            return false;
        }
    }

    private function createFilter($filter){
        $filterQuery = '';
        foreach ($filter as $k => $v) {
            if($k == 'experience' || $k == 'close'){
                $filterQuery .= $this->_table.'.'.$k.'>=:'.$k.' AND ';
            }else if($k == 'open' || $k == 'cost'){
                $filterQuery .= $this->_table.'.'.$k.'<=:'.$k.' AND ';
            }else if($k == 'business_days'){
                $filterQuery .= "business_days LIKE "."'%".$v."%'"." AND ";
                unset($filter['business_days']);
            }else{
                $filterQuery .= $this->_table.'.'.$k.'=:'.$k.' AND ';
            }
        }
        $this->_fields = $filter;
        $this->_filter = ' AND '.substr($filterQuery ,0, -4);
    }

    private function getByIds(){
        $tm = $this->_table;
        $tU = 'uservic_users';
        $this->_r = (CRUD::get("SELECT $tm.id_pvt_service as id, $tm.identity, $tU.fullname, $tU.username, $tU.image as image_user ,$tm.name_service, $tm.category, $tm.experience, $tm.type_service, $tm.type_cost, $tm.cost, $tm.type_money, $tm.business_days, $tm.open, $tm.close, $tm.description, $tm.image $this->_coverage FROM $tm INNER JOIN $tU WHERE $tm.id_pvt_user=$tU.id_pvt_user AND $tm.status='Active' $this->_query $this->_filter LIMIT $this->_limit", $this->_fields));
    }

} 