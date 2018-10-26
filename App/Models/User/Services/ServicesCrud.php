<?php
namespace App\Models\User\Services;
defined("APPPATH") OR die("Access denied");

use \App\Models\GlobalMethods as GM;

class ServicesCrud{

    /**
     * [Methods: add, update, remove(update status)]
     */
    private $_data;
    private $_table = 'uservic_services';
    private $_type = 'add';

    public function setData($data, $idUser){
        $this->_data = $data;
        $this->_idUser = $idUser;
    }

    public function setType($type){
        $this->_type = $type;
    }

    public function validateData(){
        $s = $this->_data;
        $r = false;
        if(isset($s['name_service'], $s['category'], $s['experience'], $s['type_service'], $s['type_cost'], $s['cost'], $s['type_money'], $s['business_days'], $s['open'], $s['close'], $s['country'], $s['state'], $s['city'], $s['description']) && GM::tstStg($s['name_service'], 'long') && GM::tstStg($s['category'], 'long') && is_int($s['experience']) && GM::tstStg($s['type_service'], 'long') && GM::tstStg($s['type_cost'], 'long') && (is_int($s['cost']) || is_float($s['cost'])) && GM::tstStg($s['type_money']) && GM::tstStg($s['business_days'], 'list') && GM::tstStg($s['open'], 'time') && GM::tstStg($s['close'], 'time') && is_int($s['country']) && (is_int($s['state']) ) && (is_int($s['city'])) && GM::tstStg($s['description'], 'long') ){
            $r = true;
        }
        if($this->_type == 'update' && !isset($s['id']) && !is_int($s['id'])){
            $r = false;
        }
        return $r;
    }

    private function convertData(){
        if($this->_type == 'update' || $this->_type == 'add'){
            $array = array(
                'user' => $this->_idUser,
                'name_service' => $this->_data['name_service'],
                'category' => $this->_data['category'],
                'experience' => $this->_data['experience'],
                'type_service' => $this->_data['type_service'],
                'type_cost' => $this->_data['type_cost'],
                'cost' => $this->_data['cost'],
                'type_money' => $this->_data['type_money'],
                'business_days' => $this->_data['business_days'],
                'open' => $this->_data['open'],
                'close' => $this->_data['close'],
                'country' => $this->_data['country'],
                'state' => ($this->_data['state'] == 0) ? null : $this->_data['state'],
                'city' => ($this->_data['city'] == 0) ? null : $this->_data['city'],
                'description' => $this->_data['description']
            );
            if($this->_type == 'update'){
                $id = $this->_data['id'];
                $this->_data = $array;
                $this->_data['date_update'] =  date("Y-m-d H:i:s");
                $this->_data['id'] = $id;
            }else{
                $this->_data = $array;
                $this->_data['identity'] = GM::generateId(16);
            }
        }else if($this->_type == 'remove'){
            $this->_data = array(
                'user' => $this->_idUser,
                'service' => $this->_data['service']
            );
        }
    }

    public function getData(){
        $this->convertData();
        return  $this->_data;
    }

    public function getId($id = 'id'){
        return $this->_data[$id];
    }

    public function getQuery(){
        if($this->_type == 'update'){
            return "UPDATE $this->_table SET name_service=:name_service, category=:category, experience=:experience, type_service=:type_service, type_cost=:type_cost, cost=:cost, type_money=:type_money, business_days=:business_days, open=:open, close=:close, country=:country, state=:state, city=:city, description=:description, date_update=:date_update WHERE id_pvt_user=:user AND id_pvt_service=:id AND (status='Active' or status='Inactive')";
        }else if($this->_type == 'remove'){
            return "UPDATE $this->_table SET status='Deleted' WHERE id_pvt_user=:user AND id_pvt_service=:service LIMIT 1";
        }else{
            return "INSERT INTO $this->_table (id_pvt_user, name_service, identity, category, experience, type_service, type_cost, cost, type_money, business_days, open, close, country, state, city, description) VALUES (:user, :name_service, :identity, :category, :experience, :type_service, :type_cost, :cost, :type_money, :business_days, :open, :close, :country, :state, :city, :description)";
        }
    }
} 
