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
        $pattern = '1234567890AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz_';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
        return $key;
    }

    /**
     * [Generar Ids]
     */
    
    public function generateId($n){
        return self::generateCode($n);
    }

    /**
     * Metodo para Propiedades del usuario
     */

    public function tstStg($stg, $tp = 'short'){
        switch ($tp) {
            case 'short':
                $pattern = '/^[a-zA-Z0-9]+$/';
                break;
            case 'long':
                $pattern = '/^[a-zA-Z0-9- ,.\/\\sáéíóúÁÉÍÓÚñÑ?!]+$/';
                break;
            case 'list':
                $pattern = '/^[a-zA-Z0-9,]+$/';
                break;
            case 'space':
                $pattern = '/^[a-zA-Z0-9 ]+$/';
                break;
            case 'image':
                $pattern = '/^[a-zA-Z0-9.\/\\]+$/';
                break;
            case 'int':
                $pattern = '/[0-9]+$/';
                break;
            case 'float':
                $pattern = '/^[0-9]+[.]+[0-9][0-9]$/';
                break;
            case 'time':
                $pattern = '/^([0-9]{2})[:]([0-9]{2})$/';
                break;
        }
        if(preg_match($pattern, $stg)){
            return true;
        }else {
            return false;
        }
    }

    /**
     * [Testear Email]
     */

    public function tstEmail($stg){
        if(filter_var($stg, FILTER_VALIDATE_EMAIL)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * [Testear Metodos]
     */
    
    public function tstMethods($met){
        if(filter_var($met, FILTER_VALIDATE_EMAIL) || preg_match('/^[a-zA-Z0-9 .+\/\\sáéíóúÁÉÍÓÚñÑ]+$/', $met)){
            return true;
        }else{
            return false;
        }
    }
}