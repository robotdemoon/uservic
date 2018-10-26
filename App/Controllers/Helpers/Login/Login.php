<?php
namespace App\Controllers\Helpers\Login;
defined("APPPATH") OR die("Access denied");


use \App\Controllers\Main\Base as BaseCONT,
    \App\Models\Login\Login as LoginModel,
    \App\Models\CrudHelper\CrudA;

class Login extends BaseCONT{   

    public function find(){
        $s = null;
        if(isset($this->_data)){
            $u = new LoginModel();
            $u -> setData($this->_data);
            if( $u -> validateData() ){
                if($u -> find() && $u -> getTkn()){
                    $cr = new CrudA();
                    $s = $cr -> update($u -> getData(), $u -> getQuery());
                    if(!$s['e']){
                        $s = $u -> getTknResponse();
                    }
                    $cr -> end();
                }
            }
            return $s;
        }
    }
}

#Password cd0b9452fc376fc4c35a60087b366f70d883fc901524daf1f122fbd319384f6a
#Tkn: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Iml2YW5AaXZhbi5jb20iLCJ0aW1ldXNlciI6IjE1MzAzNDMxZGU5YzIzMDc5ODIwNTc0MjY1MWUxNDZkODJjMGUzYTJhOWI1NzMzNzcyY2MyMDMxZWY5MWY5MTkiLCJpbWFnZSI6IjMuanBnIiwidXNlcm5hbWUiOiJpdmFubWxhciIsImlhdCI6MTUzNTA2NTIwMSwiZXhwIjoxNTM3NjU3MjAxfQ.maGTRZ8Tmjdt5FbJUVmGM_KdP1HlQ_2NBEcgxmo--w0
