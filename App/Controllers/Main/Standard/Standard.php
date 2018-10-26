<?php
namespace App\Controllers\Main\Standard;
defined("APPPATH") OR die("Access denied");

use \App\Controllers\Main\Guest\Guest;

class Standard extends Guest{

    /**
     * [Variables]
     */

    protected  $_Alwd_Login_Register = [];
    protected  $_Alwd_Login_Login = [];
    protected  $_Alwd_User_Perfil = ['get', 'getEdit', 'update', 'image'];
    protected  $_Alwd_User_Settings = ['get', 'update'];
    protected  $_Alwd_User_Favs = ['get', 'find', 'add', 'remove'];
    protected  $_Alwd_User_Services = ['getEdit','getNames','getAll', 'add', 'update', 'remove', 'image'];
    protected  $_Alwd_User_Conexions = ['get', 'find', 'add', 'remove', 'update'];
    protected  $_Alwd_User_Costumers = ['get', 'find', 'add', 'remove'];
    protected  $_Alwd_User_Requests = ['get', 'find', 'update', 'remove', 'add'];
    protected  $_Alwd_User_Budgets = ['get', 'getAll','add'];
    protected  $_Alwd_User_Comments = ['add'];
    protected  $_Alwd_Contacts = ['remove'];

    /**
     * [User Properties]
     */

    public function UserPerfil($a){
        $this->callMethod($a, $this->_Alwd_User_Perfil, 'User\Perfil');
    }

    public function UserSettings($a){
        $this->callMethod($a, $this->_Alwd_User_Settings, 'User\Settings');
    }

    public function UserFavs($a){
        $this->callMethod($a, $this->_Alwd_User_Favs, 'User\Favs');
    }

    public function UserServices($a){
        $this->callMethod($a, $this->_Alwd_User_Services, 'User\Services');
    }

    public function UserConexions($a){
        $this->callMethod($a, $this->_Alwd_User_Conexions, 'User\Conexions');
    }

    public function UserCostumers($a){
        $this->callMethod($a, $this->_Alwd_User_Costumers, 'User\Costumers');
    }

    public function UserRequests($a){
        $this->callMethod($a, $this->_Alwd_User_Requests, 'User\BudgetRequests\Requests');
    }

    public function UserBudgets($a){
        $this->callMethod($a, $this->_Alwd_User_Budgets, 'User\BudgetRequests\Budgets\Budgets');
    }

    public function UserComments($a){
        $this->callMethod($a, $this->_Alwd_User_Comments, 'User\Comments');
    }

    public function ContactsContacts($a){
        $this->callMethod($a, $this->_Alwd_Contacts, 'Contacts\Contacts');
    }

}