<?php
namespace App\Models\CrudHelper;
defined("APPPATH") OR die("Access denied");

use \Core\Database,
    \Core\General\Errors;
class Crud{ 
    private static $_stmt;
    private static $_conn;
    private static $_r;

    /***
     * [Get Data]
     */
    
    public function get($sql, $data){
        //echo $sql;
        self::$_r = ['e' => true, 'm' => 'Server Error'];
        try {
            self::$_conn = Database::instance();
            self::$_stmt = self::$_conn->prepare($sql);
            self::fetchData($data);
            if(self::$_stmt->execute() && self::$_stmt->rowCount() > 0){
                self::$_r = self::$_stmt->fetchAll(\PDO::FETCH_ASSOC);
            }else{
                self::$_r['m'] = 'Register not Found';
            }
        }catch(\PDOException $e){
            self::$_r = ['e' => true, 'm' => 'Imposible to get Data'];
            Errors::msg($e, 'DB', 'Crud', false);
        }
        return self::$_r;
    }

    private function fetchData($data){
        foreach ($data as $k => &$v) {
            self::$_stmt->bindParam(':'.$k, $v, \PDO::PARAM_STR);     
        }
    }
    
}