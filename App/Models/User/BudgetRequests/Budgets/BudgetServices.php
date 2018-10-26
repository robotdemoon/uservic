<?php
namespace App\Models\User\BudgetRequests\Budgets;
defined("APPPATH") OR die("Access denied");

use \App\Models\CrudHelper\CrudMethods as CRUDMET,
    \App\Models\CrudHelper\Crud as CRUD;

class BudgetServices{ 


    /**
     * [Methods: get]
     */
    private $_table = 'uservic_budget_services';
    private $_r;
    private $_id;


    public function get(){
        $this->getById();
    }

    public function setId($idBudget = ''){
        $this->_id = ['id' => $idBudget];
    }

    public function getResponse(){
        return $this->_r;
    }

    private function getById(){
        $this->_r = (CRUD::get("SELECT name, cost, number, total, description FROM $this->_table WHERE id_pvt_budget=:id", $this->_id) );
    }
}