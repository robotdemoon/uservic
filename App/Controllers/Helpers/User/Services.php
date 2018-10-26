<?php
namespace App\Controllers\Helpers\User;
defined("APPPATH") OR die("Access denied");


use \App\Controllers\Main\Base as BaseCONT,
    \App\Controllers\Helpers\Contacts\Contacts as ContactsCONT,
    \App\Models\User\Services\Services as ServicesModel,
    \App\Models\Contacts\ContactsCrud as ContactsCrudModel,
    \App\Models\User\Services\ServicesCrud as ServicesCrudModel,
    \App\Models\User\Image\ImageCrud as ImageCrudModel,
    \App\Models\CrudHelper\CrudA;

class Services extends BaseCONT{   

    public function getEdit(){
        $service =  ((isset($this->_data['id'])) ? $this->getService('edit', true,'u', true): ['e' => true, 'm' => 'Invalid Data']);
        $contacts = (!isset($service['e'])) ? ContactsCONT::get($service['id'], true, 'service'): ['e' => true];
        return (isset($service['e'], $contacts['e'])) ? ['e' => true, 'm' => 'Register Not Found']: ['service' => $service, 'contacts' => $contacts];
    }

    public function getNames(){
        return $this->getService('names', true);
    }
    
    public function getAll(){
        return $this->getService('all');
    }

    public function add(){
        $s = null;
        if(isset($this->_dTkn['id'],$this->_data['service'], $this->_data['contacts'])){
            $u = new ServicesCrudModel();
            $u -> setData($this->_data['service'], $this->_dTkn['id'], $this->_dTkn['email']);
            $c = new ContactsCrudModel();
            $c -> setTable('service');
            $c -> setData($this->_data['contacts']);
            if( $u -> validateData() && $c -> validateData() ){
                $cr = new CrudA();
                $sSer = $cr -> add($u -> getData(), $u -> getQuery(), true);
                if(!$sSer['e'] && isset($sSer['id'])){
                    $c -> setId($sSer['id']);
                    $s = $cr -> add($c -> getData(), $c -> getQuery());
                    if(isset($this->_data['image'], $sSer['id']) && !$s['e']){
                        $this->imageUpload($sSer['id']);
                    }
                }
                if(isset($s['id'])){ $s['id'] = $u->getId('identity');}
                $cr -> end();
            }
            return $s;
        }
    }

    public function update(){
        $s = null;
        if(isset($this->_dTkn['id'], $this->_data['service'],$this->_data['contacts'])){
            $u = new ServicesCrudModel();
            $u -> setType('update');
            $u -> setData($this->_data['service'], $this->_dTkn['id']);
            $c = new ContactsCrudModel();
            $c -> setTable('service');
            $c -> setType('update');
            $c -> setData($this->_data['contacts']);
            if( $u -> validateData() && $c -> validateData() ){
                $cr = new CrudA();
                $s = $cr -> update($u -> getData(), $u -> getQuery());
                if(!$s['e']){
                    $c -> setId($u -> getId());
                    $s = $cr -> update($c -> getData(), $c -> getQuery());
                }
                $cr -> end();
            }
            return $s;
        }
    }

    public function remove(){
        $s = null;
        if(isset($this->_dTkn['id'], $this->_data['service']) && is_int($this->_data['service'])){
            $u = new ServicesCrudModel();
            $u -> setType('remove');
            $u -> setData($this->_data, $this->_dTkn['id']);
            $cr = new CrudA();
            $s = $cr -> remove($u -> getData(), $u -> getQuery());
            $cr -> end();
            return $s;
        }
    }

    public function image(){
        if(isset($this->_data['service'])){
            return $this->imageUpload($this->_data['service']);
        }
    }
    
    private function imageUpload($id){
        $s = null;
        if(isset($this->_dTkn['id'], $this->_dTkn['email'], $this->_data['image'])){
            $im = new ImageCrudModel();
            $im -> setType('service');
            $im -> setData(['image' => $this->_data['image'], 'email' => $this->_dTkn['email'], 'id' => $id], $this->_dTkn['id']);
            $simg = $im -> uploadImage();
            if(!$simg['e']){
                $im -> setName($simg['image']);
                $cr = new CrudA();
                $s = $cr -> update($im -> getData(), $im -> getQuery());
                $cr -> end();
                if($s['e']){
                    $im -> removeImage($simg['image']);
                }else{
                    $s['image'] = $simg['image'];
                    if(isset($this->_data['nameImage']) && $this->_data['nameImage'] != '' && $this->_data['nameImage']  != 'nopicture.jpg'){
                        $im -> removeImage($this->_data['nameImage']);
                    }
                }
            }
            return $s;
        }
    }

    private function getService($f, $convertion = false, $type = 'm', $days = false){
        $r = ['e' => true, 'm' => 'Invalid Data'];
        if(isset($this->_dTkn['id'])){
            $s = new ServicesModel();
            $s -> setIds($this->_dTkn['id'], (($f == 'edit') ? $this->_data['id'] : '') );
            $s -> setFields($f);
            $s -> setStatus((($f == 'edit')  ? ['Active', 'Inactive'] : ['Active']));
            $s -> get($type);
            ($days) ? $s -> structDays(): '';
            ($convertion) ? $s -> setConvertion($type) : '';
            $r = $s -> getResponse();
        }
        return $r;
    }
}