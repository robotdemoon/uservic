<?php
namespace App\Models\Contacts;
defined("APPPATH") OR die("Access denied");

use \App\Models\CrudHelper\CrudMethods as CRUDMET,
    \App\Models\CrudHelper\Crud as CRUD;

class ContactsCrud{ 

    /**
     * [Methods Allowed: Add/Update/Remove]
     */

    private $_type = 'add';

    public function setData($data){
        $this->_data = $data;
    }

    public function setId($id){
        $this->_id = $id;
    }

    public function setType($type){
        $this->_type = $type;
    }

    public function setTable($t){
        $this->_table = 'uservic_'.$t.'s_contacts';
        $this->_field = 'id_pvt_'.$t;
    }

    public function validateData(){
        $s = true;
        foreach($this->_data as $k => $v){
            if(!isset($this->_data[$k]['type'], $this->_data[$k]['status'],$this->_data[$k]['method']) && $this->_type == 'add'){
               $s = false;
               break;
            }else if(!isset($this->_data[$k]['type'], $this->_data[$k]['status'],$this->_data[$k]['method']) && !array_key_exists('id', $this->_data[$k]) && $this->_type == 'update'){
                $s = false;
                break;
            }
        }
        return $s;
    }

    private function structData(){
        if($this->_type == 'add' || $this->_type == 'update'){
            foreach($this->_data as $k => $v){
                $this->_data[$k] = array(
                    'id_contact' => ($this->_type == 'update') ? $v['id']: null,
                    $this->_field => $this->_id,
                    'status' => $v['status'],
                    'type' => $v['type'],
                    'method' => $v['method']
                );
            }
        }else if($this->_type == 'remove'){
            $this->_data = array(
                'id_contact' => $this->_data,
                'id' => $this->_id
            );
        }
    }

    private function setFields($data){
        $d = '';$dd = '';
        foreach ($data as $k => $v) {
            $f = array_keys($v);
            $d .= '(:'.implode($k.',:',$f).$k.'),';
        }
        return substr($d, 0, -1);
    }

    public function getData(){
        $this->structData();
        return $this->_data;
    }

    public function getQuery(){
        if($this->_type == 'add' || $this->_type == 'update'){
            $contacts = $this->setFields($this->_data);
            $s = "INSERT INTO $this->_table (id_contact, $this->_field, status, type, method) VALUES $contacts ON DUPLICATE KEY UPDATE status=IF($this->_field = VALUES($this->_field), VALUES(status), status),type=IF($this->_field = VALUES($this->_field),VALUES(type), type),method=IF($this->_field = VALUES($this->_field),VALUES(method), method)";
        }else if($this->_type == 'remove'){
            $s = "DELETE FROM $this->_table WHERE $this->_field=:id AND id_contact=:id_contact";   
        }
        return $s;
    }
}