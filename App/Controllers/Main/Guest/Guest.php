<?php
namespace App\Controllers\Main\Guest;
defined("APPPATH") OR die("Access denied");
use \App\Controllers\Main\Main;

class Guest extends Main{

    /**
     * [Variables]
     */

    protected  $_Alwd_Login_Register = ['add'];
    protected  $_Alwd_Login_Login = ['find'];
    protected  $_Allowed_Search_Perfil = ['getPublic'];
    protected  $_Allowed_Search_Services = ['getPublic', 'getBy', 'getSearch', 'getCategories', 'getTop'];
    protected  $_Allowed_Services_Related = ['get', 'getUserRelated'];
    protected  $_Allowed_Search_Coverage = ['getCountries', 'getStates', 'getCities'];
    protected  $_Allowed_Services_Comments = ['get'];


    /**
     * [Usuario]
     */

    public function LoginLogin($a){
        $this->callMethod($a, $this->_Alwd_Login_Login, 'Login\Login');
    }

    public function LoginRegister($a){
        $this->callMethod($a, $this->_Alwd_Login_Register, 'Login\Register');
    }

    /**
     * [Busqueda de Perfil]
     */

    public function SearchPerfil($a){
        $this->callMethod($a, $this->_Allowed_Search_Perfil, 'Search\Perfil');
    }

    /**
     * [Busqueda de Servicios]
     */

    public function SearchServices($a){
        $this->callMethod($a, $this->_Allowed_Search_Services, 'Search\Services');
    }

    public function ServicesRelated($a){
        $this->callMethod($a, $this->_Allowed_Services_Related, 'Services\Related');
    }

    /**
     * [Coverage]
     */

    public function CoverageSearch($a){
        $this->callMethod($a, $this->_Allowed_Search_Coverage, 'Coverage\Coverage');
    }

    /**
     * [Comments]
     */

    public function ServicesComments($a){
        $this->callMethod($a, $this->_Allowed_Services_Comments, 'Services\Comments');
    }
}