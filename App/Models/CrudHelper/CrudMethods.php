<?php
namespace App\Models\CrudHelper;
defined("APPPATH") OR die("Access denied");


class CrudMethods{ 

    private static $_coverage_t = ['country' => 'countries', 'state' => 'states', 'city' => 'cities'];

    public function setCoverage($t, $coverage = ['country']){
        $s = '';
        foreach ($coverage as $k) {
            $s .= ', (SELECT name FROM uservic_coverture_'.self::$_coverage_t[$k].' WHERE id='.$t.'.'.$k.') as '.$k.'_name';
        }
        return $s;
    }

    public function setConstraints($constraints, $t = ''){
        $s = '';
        foreach ($constraints as $k => $v) {
            if(is_array($v)){
                $ss = '';
                foreach ($v as $kk => $vv) {
                    $ss .=  (($t != '') ? $t.'.':'').$k.'='.$vv. ' OR ';
                }
            }
            $s .= (is_array($v)) ? " AND (".substr($ss, 0, -3)." )" : " AND ( ".(($t != '') ? $t.'.':'').$k." = '$v')";
        }
        return $s;
    }
}