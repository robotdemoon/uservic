<?php
namespace App\Models\Services\Comments;
defined("APPPATH") OR die("Access denied");

use \App\Models\CrudHelper\CrudMethods as CRUDMET,
    \App\Models\CrudHelper\Crud as CRUD;

class Comments{ 

    /**
     * [Methods: get]
     */
    
    private $_table = 'uservic_services_comments';
    private $_r;
    private $_id = [];

    public function get(){
        $this->getById();
    }

    public function setId($idService){
        $this->_id = ['id' => $idService];
    }

    public function structComments(){
        if(!isset($this->_r['e']) && count($this->_r) > 1){
            $x = 0;$s = [];
            foreach ($this->_r as $k => $v) {
                if($v['answer'] != 0 && isset($s[$v['answer']])){
                    (!isset($s[$v['answer']]['elements']) ? $s[$v['answer']]['elements'] = [] : '');
                    array_unshift($s[$v['answer']]['elements'], $v);
                }else{
                    $v['elements'] = [];
                    $s[$v['id']] = $v;
                }
            }
            $this->_r = array_reverse($s);
        }
    }

    public function getResponse(){
        return $this->_r;
    }

    private function getById(){
        $tU = 'uservic_users';
        $tS = 'uservic_services';
        $tm = $this->_table;
        $this->_r = (CRUD::get("SELECT $tm.id_pvt_comment as id, $tm.id_pvt_user as user, $tm.answer, $tm.msg, $tm.date, $tU.fullname, $tU.username, $tU.image FROM $tm INNER JOIN $tU INNER JOIN $tS WHERE $tS.identity=:id AND $tm.id_pvt_user=$tU.id_pvt_user AND $tm.id_pvt_service=$tS.id_pvt_service ORDER BY $tm.date ASC", $this->_id) );
    }
}