<?php
namespace App\Controllers\Helpers\User\BudgetRequests\Budgets;
defined("APPPATH") OR die("Access denied");

use \App\Controllers\Main\Base as BaseCONT,
    \App\Models\User\BudgetRequests\Budgets\BudgetServices as BudgetServicesModel;

class BudgetServices{   

    public function get($id){
        $s = new BudgetServicesModel();
        $s -> setId($id);
        $s -> get();
        return $s ->getResponse();
    }
}