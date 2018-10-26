<?php

namespace Core;
defined("APPPATH") OR die("Access Denied");

use \App\Models\Tkn as Tkn,
    \Core\General\Errors;

class App{
    private $_controller;
    private $_method = "";
    private $_entity = '';
    private $_property = '';

    private $_params = [];
    private $_url = '';
    private $_token = '';
    private $_dTkn = '';
    private $_statusCtrler = 'public';
    private $_data = [];
    private $_id = '';
    private $_logs;

    private $_t_user = 'Guest';

    const NAMESPACE_CONTROLLERS = "\App\Controllers\Main\\";
    const CONTROLLERS_PATH = "../App/controllers/Main/";
    const LOGS_PATH = "../App/Logs/";
    const IMAGES_PATH = "../assets/images/";
    const DOCS_PATH = "../assets/docs/";

    /**
     * [1 Revisar Url]
     * [2 Revisar la Data]
     * [3 Revisar el Token]
     * [4 comprobar el controlador y el metodo]
     * [5 llamar al metodo y enviar información]
     */

    public function __construct(){
        Errors::msg('Metodo Ejecutado', 404, 'Base', false);
        if($this->parseUrl()  && $this->isValidToken() && $this->isCtrlerValid() && $this->_method != '' && $this->_property != ''){
            $fullClass = self::NAMESPACE_CONTROLLERS.$this->_controller;
            if(method_exists( $fullClass, ucfirst($this->_entity).ucfirst($this->_property) ) ){
                $m = ucfirst($this->_entity).ucfirst($this->_property);
                $s = new $fullClass($this->_id, $this->_data, $this->_dTkn);
                $s = $s -> $m($this->_method);
            }else{
                Errors::msg('Invalid Method', 404);
            }
        }
    }

    /**
     * [Se obtiene los valores de la url]
     */

    private function parseUrl(){
        if(isset($_GET["url"])){
            $this->_url =  explode("/", filter_var(rtrim($_GET["url"], "/"), FILTER_SANITIZE_URL));
            return true;
        }else{
            return false;
        }
    }

    /**
     * [Se obtiene la data para obtener el controller]
     */

    private function isValidToken(){
        if(isset($_POST['d'])){
            $this->_params = json_decode($_POST['d'], true);
            if(json_last_error() === 0){
                #revisamos que exista el token 
                if(isset($this->_params['token'], $this->_params['action'])){
                    if(strlen($this->_params['token']) >= 264 && $this->_params['token'] != ''){
                        $this->_token = $this->_params['token'];
                        unset($this->_params['token']);
                        #validamos el Token
                        if($this->validateToken()){
                            $this->_status_ctrls = 'private';
                            if($this->isValidData()){
                                return true;
                            }else{
                                Errors::msg('Invalid Data, Some Variables Undefined.', 404);
                                return false;
                            }
                        }else{
                            return false;
                        }
                    }else{
                        Errors::msg('Invalid Structure Token', 'token');
                        return false;
                    }
                }else{
                    if($this->isValidData('noroot')){
                        return true;
                    }else{
                        Errors::msg('Invalid Data, Some Variables Undefined', 404);
                        return false;
                    }
                }
            }else{
                Errors::msg('Json Error', 404);
                return false;
            }
        }else{
            Errors::msg('There is no data', 404);
            return false;
        }
    }

    /**
     * [Revisar si existe id y/o data]
     */

    private function isValidData($type = 'root'){
        $status = false;
        if(isset($this->_params['action'] ,$this->_params['id'], $this->_params['data'])){
            $this->_id = $this->_params['id'];
            $this->_data = $this->_params['data'];
            $this->_method = $this->_params['action'];
            $status = true;
        }else if((isset($this->_params['id']) || isset($this->_params['data'])) && isset($this->_params['action'])){
            (isset($this->_params['id'])) ? $this->_id = $this->_params['id']: $this->_data = $this->_params['data'];
            $this->_method = $this->_params['action'];
            $status = true;
        }else if(isset($this->_params['action'])){
            $this->_method = $this->_params['action'];
            unset($this->_params['action']);
            if($type == 'root'){ $status = true;}else{$status = false;}
        }else{
            $status = false;
        }
        #revisamos que venga la imagen
        if(isset($_FILES['image'])){
            $this->_data['image'] = array("name"=> $_FILES["image"]["name"],
            "temporalImage"=>$_FILES["image"]["tmp_name"]);
        }
        return $status;
    }

    /**
     * [Validamos que el controlador existe]
     */

    private function isCtrlerValid(){
        $c = $this->_url;
        if(isset($c[0], $c[1])){
            //Cambiamos la ruta del controlador
            if(file_exists(self::CONTROLLERS_PATH.$this->_t_user.'/'.$this->_t_user. ".php")){  
                //nombre del archivo a llamar
                $this->_controller = $this->_t_user.'\\'.$this->_t_user;
                $this->_entity = $c[0];
                $this->_property = $c[1];
                return true;
            }else{
                Errors::msg('Invalid Method', 404);
                return false;
            }
        }else{
            Errors::msg('Not exist url entity and Property', 404);
            return false;
        }
    }
    
    /**
     * [Validar Token]
     */

    private function validateToken(){
        $this->_token = new Tkn($this->_token);
        $this->_token = $this->_token-> validateToken();
        if(!$this->_token['e'] && isset($this->_token['r'], $this->_token['r']['id'])){
            $this->_dTkn = $this->_token['r'];
            $this->_t_user = (isset($this->_dTkn['type_account'])) ? $this->_dTkn['type_account'] : 'Guest';
            return true;
        }else{
            Errors::msg('Invalid Token','token');
            return false;
        }
    }

    public static function getConfig(){
        return parse_ini_file(APPPATH . '/Config/config.ini');
    }

    public static function getLog(){
        return self::LOGS_PATH;
    }

    /**
     * [Regresar Path de Imagenes]
     */
    public static function getPathImages(){
        return self::IMAGES_PATH;
    }
    public static function getPathDocs(){
        return self::DOCS_PATH;
    }
}