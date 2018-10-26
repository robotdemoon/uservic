<?php
namespace App\Models\CrudHelper;
defined("APPPATH") OR die("Access denied");

use \Core\Database,
    \Core\General\Errors;

class CrudA{
    private $_stmt;
    private $_conn;
    private $_r;
    private $_msg;

    public function __construct(){
        $this->_r = ['e' => true, 'm' => 'Server Error'];
        try{
            $this->_conn = Database::instance();
            $this->_conn->beginTransaction();
        }catch(\PDOException $e){
            $this->_r = ['e' => true, 'm' => 'Imposible to Connect with the server'];
        }
    }

    /**
     * [Metodos Publicos]
     */

    public function add($data, $sql, $lastId = false){
        $this->_msg = "Register(s) Added";
        return $this->implementCrud( $sql, $data, $lastId);
    }

    public function update($data, $sql, $lastId = false){
        $this->_msg = "Register(s) Updated";
        return $this->implementCrud( $sql, $data, $lastId);
    }

    public function remove($data, $sql){
        $this->_msg = "Register(s) Removed";
        return $this->implementCrud( $sql, $data);
    }

    /***
     * [Add Data]
     */
    
    private function implementCrud($sql, $data, $lastId = false){
        try {
            $this->_stmt = $this->_conn->prepare($sql);
            self::setData($data, $lastId);
        }catch(\PDOException $e){
            $this->_conn->rollback();
            $this->_r = ['e' => true, 'm' => 'Imposible to Add Data'];
            Errors::msg($e, 'DB', 'Crud', false);
        }
        return $this->_r;
    }

    private function setData($data, $lastId){
        (isset($data[0])) ? self::fetchData($data, 2) : self::fetchData($data);
        if($this->_stmt->execute()){
            $this->_r['e'] = false;
            if($this->_stmt -> rowCount() > 0){
                $this->_r['m'] = $this->_msg;
                if($lastId){
                    $this->_r['id'] = $this->_conn->lastId();
                }
            }else{
                $this->_r['m'] =  'Register(s) not have changed';# Si es update es por que no hubo cambios en el registro / Si es add es que no se pudo agregar
            }
        }else{
            $this->_r = ['e' => true, 'm' => 'Invalid Data'];
        }
    }

    private function fetchData($data, $type = 1){
        $x = 0;
        foreach ($data as $k => &$v) {
            if($type == 1){
                $this->_stmt->bindParam(':'.$k, $v, \PDO::PARAM_STR);  
            }else{
                foreach ($v as $kk => &$vv) {
                    $this->_stmt->bindParam(':'.$kk.$x, $vv, \PDO::PARAM_STR);  
                }
                $x++;
            }
        }
    }

    public function end(){
        try{
            $this->_conn->commit();
            $this->_conn = null;
        }catch(\PDOException $e){
            $this->_r = ['e' => true, 'm' => 'Imposible to Add Data while Final'];
        }
    }
} 