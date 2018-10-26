<?php
namespace App\Controllers\Main;
defined("APPPATH") OR die("Access denied");

use \App\Controllers\Main\Base as BaseCONT;


class Main extends BaseCONT{

    private $RAIZ = 'App\Controllers\Helpers\\';

    protected function callMethod($a, $allowed, $ruta){
        $nc = $this->RAIZ.$ruta;
        if( $a != '' && in_array($a, $allowed) && method_exists($nc,$a)){
            if(is_int($this->_id) || $this->_id == ''){
                $s = new $nc($this->_id, $this->_data, $this->_dTkn);
                $s = $s -> $a();
                echo json_encode(($s == null) ? $s = ['e' => true, 'm' => 'Invalid Data']: $s);
            }else{
                $this->sendError('Invalid Id');
            }
        }else{
            $this->sendError('Metodo no permitido');
        }
    }


    protected function sendError($m){
        echo json_encode(['e' => true, 'm' => $m]);
    }
}