<?php
namespace App\Models;
defined("APPPATH") OR die("Access denied");
require_once '../App/Lib/Jwt/vendor/autoload.php';

use Firebase\JWT\JWT as JWT,
    App\Models\CrudHelper\Crud as CRUD;
    
class Tkn
{

    private $data;

    public function __construct($data = ''){
        $this->key = 'uservic8246592/¨*??$$&/(tokenuser27634lakjfafjals';
        $this->data = $data;
    }

    /**
     * [Crear Token]
     */

    public function createToken(){
        $s = array('e' => true, 'm' => '', 'r' => '');
        $token = array(
            'email' => $this->data['email'],
            'timeuser' => hash('sha256', ($this->data['email'].$this->data['fullname'].$this->data['username'].$this->data['age'])),
            'image' => $this->data['image'],
            'username' => $this->data['username'],
            "iat" => time(),
            "exp" => time() + (60 * 60 * 24 * 30)
        );
        try{
            $JWT = JWT::encode($token, $this->key, 'HS256');
            $s['e'] = false;
            $s['r'] = $JWT;
        }catch (\Exception $e){
            $s['m'] = 'Error While Creating Token';
        }
        return $s;
    }

    /**
     * [Verificar Token]
     */
    
    public function validateToken(){
        $s = array('e' => true, 'm' => 'Invalid Token');
        try{
            $JWT = JWT::decode($this->data, $this->key, array('HS256'));
            if($JWT->email !=''){
                $array = array('email' => $JWT->email, 'hash' => $this->data);
                //Obtener esta información desde la entidad o propiedad
                $r = (CRUD::get("SELECT * FROM uservic_users WHERE email=:email AND hash=:hash", $array));
                if(!isset($r['e'])){
                    $r = $r[0];
                    $r['id'] = $r['id_pvt_user'];  
                    unset($r['hash'], $r['password'], $r['date'], $r['date_update'], $r['id_pvt_user']);
                    $s['e'] = false;
                    $s['r'] = $r;
                    $s['m'] = 'Valid Token';
                }
            }
        }catch (\Exception $e){
            $s['e'] = true;
            $s['m'] = 'Invalid Token';
        }
        return $s;
    }
    
}
