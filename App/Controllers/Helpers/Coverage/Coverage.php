<?php
namespace App\Controllers\Helpers\Coverage;
defined("APPPATH") OR die("Access denied");


use \App\Controllers\Main\Base as BaseCONT,
    \App\Models\Coverage\Coverage as CoverageModel;

class Coverage extends BaseCONT{   

    public function getCountries(){
        return $this->getCoverage('countries');
    }

    public function getStates(){
        return (($this->_id > 0 && $this->_id != '') ? $this->getCoverage('states', 'country',$this->_id): null);
    }

    public function getCities(){
        return  (($this->_id > 0 && $this->_id != '') ? $this->getCoverage('cities', 'state', $this->_id): null);
    }

    private function getCoverage($t, $i = '', $id = ''){
        $s = new CoverageModel();
        $s -> setTable($t);
        (($id != '') ? $s -> setId($id, $i) : '');
        $s -> get();
        return $s ->getResponse();
    }

    
}