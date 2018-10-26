<?php
namespace Core;
defined("APPPATH") OR die("Access denied");

use \Core\App;

/**
 * @class Database
 */
class Logs
{
    private static $_instance;

    private function __construct(){
       try {
		   //load from config/config.ini
           $this->_path = App::getLog();
           $this->_filename = 'error';
           $this->_date = date("Y-m-d");
           $this->_ip = $this->getIP();
       }
       catch (\PDOException $e)
       {
           print "Error!: " . $e->getMessage();
           die();
       }
    }


    public static function instance(){
        if (!isset(self::$_instance))
        {
            $class = __CLASS__;
            self::$_instance = new $class;
        }
        return self::$_instance;
    }

    public function insert($msg, $type, $carpet, $adInfo, $url){
        $msg = 'IP: '.$this->_ip.', Error in : '.$carpet.', Description: '.$msg.', info_Received: '.$adInfo.', Url Received: ('.$url.'), date: '.date("Y-m-d H:i:s");
        file_put_contents($this->_path . $carpet.'/'.$this->_filename . $this->_date . ".log", $msg.\PHP_EOL,  \FILE_APPEND);
    }
    
    private function getIP(){   
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

}
