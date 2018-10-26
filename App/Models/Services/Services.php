<?php
namespace App\Models\Services;
defined("APPPATH") OR die("Access denied");

use \App\Models\CrudHelper\CrudMethods as CRUDMET,
    \App\Models\CrudHelper\Crud as CRUD;

class Services{ 

    /**
     * [Methods: getPublic(read), getTop, getByCategory]
     */

    private $_tm= 'uservic_services';
    private $_fields = '';
    private $_r;
    private $_coverage = '';
    private $_status = '';
    private $_limit = '';
    private $_groupBy = '';
    private $_data = [];
    private $_baseConst = '';
    private $_inners = '';
    private $_InnersConst = '';

    public function get($type = 'm'){
        $this->getBy($type);
    }

    public function setFields($type = ''){
        $tm = $this->_tm;
        $tU = 'uservic_users';
        $this->_fields = "$tm.id_pvt_service as id, $tm.identity, $tm.id_pvt_user as user, $tm.name_service, $tm.business_days, $tm.open, $tm.close, $tm.description, $tm.image, $tU.fullname";
        if($type == 'read'){
            $tS = 'uservic_users_settings';
            $this->_fields = "$tm.id_pvt_service as id, $tm.identity, $tm.id_pvt_user as user, $tm.name_service, category, $tm.experience, $tm.type_service, $tm.type_cost, $tm.cost, $tm.type_money, $tm.business_days, $tm.open, $tm.close, $tm.description, $tm.image, $tU.fullname, $tU.username, $tU.image as image_user, $tS.conexions settings_conexions, $tS.budgets as settings_budgets";
        }

    }

    #[['table','field']] 
    public function setTables($tables  = []){
        foreach ($tables as $k => $v) {  
            $this->_inners .= " INNER JOIN  uservic_$v[0]";
            $this->_InnersConst .= $this->_tm.'.'.((isset($v[1])) ? $v[1]: 'id_pvt_service').'=uservic_'.$v[0].'.'.((isset($v[1])) ? $v[1]: 'id_pvt_service').' AND ';
        }
        $this->_InnersConst = substr($this->_InnersConst, 0, -4);
    }

    public function setLimit($min, $max = ''){
        $this->_limit = 'LIMIT ' . $min.(($max != '') ? ','.$max: '');
    }

    public function setIds($idService = ''){
        $this->_baseConst = "$this->_tm.identity=:id ";
        $this->_data = ['id' => $idService];
    }

    public function setCoverage(){
        $this->_coverage = CRUDMET::setCoverage($this->_tm, ['country','state','city']);
    }

    public function getResponse(){
        return $this->_r;
    }

    public function setGroupBy($f, $t = ''){
        $this->_groupBy = " GROUP BY ".(($t != '') ? " $this->_tm.id_pvt_service ": $f);
        $this->_fields = (($t != '') ? $this->_fields: $f).", COUNT(".(($t != '') ? "uservic_$t.id_pvt_service": "*").") as quantity";
    }

    public function setStatus($status = ['Active'], $and = true){
        $s = '';
        foreach ($status as $k => $v) {
            $s .= "$this->_tm.status='$v' OR ";
        }
        $this->_status = (($and) ? " AND ": "")." (".substr($s, 0, -3).")";
    }

    private function getBy($type = 'm'){
        $sql = "SELECT $this->_fields $this->_coverage FROM $this->_tm $this->_inners WHERE ".(($this->_baseConst != '') ? $this->_baseConst.' AND '.$this->_InnersConst: $this->_InnersConst)." $this->_status $this->_groupBy $this->_limit";
        $s = CRUD::get($sql, $this->_data);
        $this->_r = (($type == 'u' && isset($s[0]) && !isset($s['e'])) ? $s[0]: $s);
    }   
}