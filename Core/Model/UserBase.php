<?php
namespace Core\Model;
defined("APPPATH") OR die("Access Denied");

class UserBase{

    protected $_id;
    protected $_data;
    protected $_salida;
    protected $_tables;
    protected $_gtable;
    protected $_idUserStrg;

    public function __construct($id = '', $data = ''){
        $this->_data = $data;
        $this->_id = $id;
        $this->_idUserStrg = 'id_pvt_user';
        $this->_idBudgetStrg = 'id_pvt_budget';
        $this->_idServiceStrg = 'id_pvt_service';
        $this->_salida = [];
        $this->_gtable = 'users';
        $this->_tables = array(
            'settings' => $this->_gtable.'_settings',
            'conexions' => $this->_gtable.'_conexions',
            'favs' => $this->_gtable.'_favouriteservices',
            'contacts' => $this->_gtable.'_contacts',
            'messages' => $this->_gtable.'_msgs',
            'costumer' => $this->_gtable.'_costumers',
            'budgets' => 'budgets',
            'budget_s' => 'budget_services',
            'budget_r' => 'budget_requests',
            'service' => 'services',
            'comments' => 'services_comments'
        );
    }
}