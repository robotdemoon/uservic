<?php

/*header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");
header("Content-Type: application/json");*/
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Cache-Control, Pragma, Origin, Authorization, Content-Type, X-Requested-With');
header('Access-Control-Allow-Methods: GET, PUT, POST');

//error_reporting(E_ALL);
//ini_set('display_errors', 0);

//directorio del proyecto
define("PROJECTPATH", dirname(__DIR__));

//directorio app
define("APPPATH", PROJECTPATH . '/App');


function autoload_classes($class_name)
{
    $filename = PROJECTPATH . '/' . str_replace('\\', '/', $class_name) .'.php';
    if(is_file($filename))
    {
        include_once $filename;
    }
}

//registramos el autoload autoload_classes
spl_autoload_register('autoload_classes');

//instanciamos la app
$app = new \Core\App;
 
