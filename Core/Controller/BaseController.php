<?php
namespace Core\Controller;
defined("APPPATH") OR die("Access denied");

use \App\Models\User\{Contacts as ContactsModel, Settings as SettingsModel};
use \App\Models\User\Services\Comments as CommentsModel;

class BaseController
{

    protected $_dTkn;
    protected $_id;
    protected $_data;
    protected $_salida;

    public function __construct($dTkn = '', $id = '', $data = ''){
        $this->_dTkn = $dTkn;
        $this->_data = $data;
        $this->_id = $id;
        $this->_salida = array();
    }

    /**
     * [Funciones Adicionales]
     */
    
    protected function errorUser($msg){
        $this->_salida = array('e' => true, 'm' => $msg);
    }

    /**
     * [Obtener Contacts]
     */

    protected function getContacts($id, $table){
        $sContacts = new ContactsModel($id, '', $table);
        $sContacts = $sContacts->getContacts();
        if(!$sContacts['e']){
            return $sContacts['r'];
        }else{
            return array('e' => true, 'm' => $sContacts['m']);
        }
    }

    /**
     * [Obtener los Settings]
     */

    protected function getSettings($id){
        $sSettings = new SettingsModel($id);
        $sSettings = $sSettings->getSettings();
        if(!$sSettings['e']){
            return $sSettings['r'];
        }else{
            return array('e' => true, 'm' => $sSettings['m']);
        }
    }

    /**
     * [Obtener Comentarios]
     */

    protected function getComments($id = '', $table = 'service'){
        $sComments = new CommentsModel($id,'' ,$table);
        $sComments  = $sComments->getComments();
        if(!$sComments['e']){
            return $sComments['r'];
        }else{
            return array('e' => true, 'm' => $sComments['m']);
        }
    }
}