<?php
namespace Core\General;
defined("APPPATH") OR die("Access denied");

use \Core\Logs;

class Errors{

    /**
     * [Type: user/token/404/DB]
     */

    public function msg($msg, $type = 'user', $carpet = 'Base', $output = true){
        $adInfo = self::backInfoLog();
        Logs::instance()->insert($msg, $type, $carpet, ( (is_string($adInfo) && $adInfo != '') ? $adInfo : 'Any Data' ), self::getURL());
        if($output){
            echo json_encode(['e' => true, 't' => $type, 'm' => ( $type == 'user' || $type == 404) ? 'Invalid Data' : 'Invalid Token']);
        }
    }

    private function backInfoLog(){
        $data ='';$d = '';
        #Se revisa la informacion enviada en caso de error
        if(isset($_POST['d'])){
            $data = json_decode($_POST['d'], true);
            if(is_array($data)){
                foreach ($data as $k => $v) {
                    if(is_array($v) ){
                        $d .= 'Is an Array with size of: '.count($v).' and with name keys of: ('. ( (is_array($k)) ? implode(',',array_keys($k)): $k).'), and with values of: ('.( (is_array($v)) ? implode(',',array_keys($v)): $v).')';
                    }else{
                        $d .= $k.'='.$v.'::';
                    }
                }
                $data = $d;
            }else{
                $data = 'Is not a Valid Array';
            }
        }
        return $data;
    }


    private function getURL(){
        $url = '';
        if(isset($_GET["url"])){
            $url =  explode("/", filter_var(rtrim($_GET["url"], "/"), FILTER_SANITIZE_URL));
            $url = implode("/",$url);
        }
        return $url;
    }

}