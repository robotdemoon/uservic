<?php
namespace Core\Model;
defined("APPPATH") OR die("Access Denied");

use \Core\Logs;

class CrudBase{

/**
     * [Enviar Mensaje y Crear Log]
     */

    protected function crudMsgLog($msg = ''){
        Logs::instance()->insert($msg, '406', 'Imposible to get Data Server Error');
    }
}