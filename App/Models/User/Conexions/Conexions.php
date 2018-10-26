<?php
namespace App\Models\User\Conexions;
defined("APPPATH") OR die("Access denied");

use \App\Models\CrudHelper\CrudMethods as CRUDMET,
    \App\Models\CrudHelper\Crud as CRUD;

class Conexions{ 

    private $_table = 'uservic_users_conexions';
    private $_fields = '*';
    private $_r;
    private $_coverage = '';
    private $_status;
    private $_ids = [];

    public function get(){
        $this->getById();
    }

    public function setIds($idConexion, $idUser = ''){
        $this->_ids = ($idUser != '') ? ['id1' => $idConexion, 'id2' => $idUser]: $idConexion;
    }

    public function setStatus($status){
        if(is_array($status)){
            $s = '';
            foreach ($status as $k => $v) {
                $s .= " status='".$v."' OR ";
            }
        }
        $this->_status = (is_array($status)) ? " AND (".substr($s, 0, -3).")" : " AND status='".$status."'";
    }

    public function setConvertion(){
        if(!isset($this->_r['e']) && count($this->_r) > 0){
            foreach ($this->_r as $k => $v) {
                $this->_r[$k]['id'] = intval($this->_r[$k]['id']);
            }
        }
    }

    public function setCoverage(){
        $this->_coverage = CRUDMET::setCoverage('uservic_users');
    }

    public function getResponse(){
        return $this->_r;
    }
    //IF($tm.id_pvt_user=:id AND $tm.status !=, $tm.status, 'AcceptedConexion') as status
    private function getById(){
        $tS = 'uservic_users';
        $tm = $this->_table;
        $this->_r = (CRUD::get("SELECT $tm.id_conexion as id, IF($tm.id_pvt_user=:id, 'Own', 'Conexion') as property, $tm.status, $tS.fullname, $tS.username, $tS.email, $tS.sector, $tS.interests, $tS.description, $tS.image $this->_coverage FROM $tm INNER JOIN $tS WHERE ($tm.id_pvt_user=:id AND $tm.id_user_conexion=$tS.id_pvt_user) OR ($tm.id_user_conexion=:id AND $tm.id_pvt_user=$tS.id_pvt_user AND $tm.status != 'Ejected') ORDER BY $tm.date DESC", ['id' => $this->_ids]) );
    }

    public function find(){
        $s = (CRUD::get("SELECT id_conexion as id, status FROM $this->_table WHERE ((id_pvt_user=:id1 AND id_user_conexion=:id2) OR (id_pvt_user=:id2 AND id_user_conexion=:id1))".((isset($this->_status)) ? $this->_status: '')." LIMIT 1", $this->_ids));
        $this->_r = (!isset($s['e']) && count($s) > 0) ? $s[0]: false;
    }
}