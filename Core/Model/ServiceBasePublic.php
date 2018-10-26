<?php
namespace Core\Model;
defined("APPPATH") OR die("Access Denied");

class ServiceBasePublic{

    protected $_id;
    protected $_query;
    protected $_filter;
    protected $_salida;
    protected $_fields;
    protected $_min;
    protected $_max;

    public function __construct($id = '', $query = '', $filter = '', $min = 0, $max = 30){
        $this->_id = $id;
        $this->_query = $query;
        $this->_filter = $filter;
		$this->_salida = [];
        $this->_table = 'services';
        $this->_idServiceStrg = 'id_pvt_service';
        $this->_idUserStrg = 'id_pvt_user';
        $this->_fields =  array('fullname_user','name_service', 'description');
        $this->_min = $min;
        $this->_max = $max;
    }
}