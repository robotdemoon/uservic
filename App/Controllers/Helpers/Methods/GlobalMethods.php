<?php
namespace App\Models;
defined("APPPATH") OR die("Access denied");

class GlobalMethods
{

    /**
     * [Generador de codigo]
     */
    
    private function generateCode($longitud) {
        $key = '';
        $pattern = '1234567890AaBbCcDdFfGgHhIiKkLlMmNnQqRrSsTtUuVvWwXxZz';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
        return $key;
    }

    /**
     * [Generar Ids]
     */
    
    public function generateId($i, $n){
        return self::getPrefix($i, 'first').self::generateCode($n);
    }

    /**
     * [Regresa los prefijos de inserccion]
     */

    /*public function getPrefix($n, $p = 'last'){
        if($p == 'first'){
            switch ($n) {
                case 'user':
                    return 'US';
                    break;
                case 'service':
                    return 'SER';
                    break;
                case 'budget':
                    return 'BUD';
                    break;
            }
        }else{
            switch ($n) {
                case 'user':
                    return 'ER';
                    break;
                case 'service':
                    return 'VIC';
                    break;
                case 'budget':
                    return 'GET';
                    break;
            }
        }
    }
*/
    /**
     * [Agregamos los prefijos y sufijos del Id]
     */

    public function addStringtoId($val, $type = 'user'){
        if($type == 'user'){
            $r = 'US'.$val.'ER';
        }else if($type == 'service'){
            $r = 'SER'.$val.'VIC';
        }else if($type == 'budget'){
            $r = 'BUD'.$val.'GET';
        }
        return $r;
    }

    /**
     * [Eliminar los prefijos y sufijos del Id]
     */

    public function removeStringtoId($val, $type){
        if($type == 'user'){
            $r = substr(substr($val, 2),0 , -2);
        }else if($type == 'service' || $type == 'budget'){
            $r = substr(substr($val, 3),0 , -3);
        }
        return $r;
    }
}