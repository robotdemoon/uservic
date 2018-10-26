<?php
namespace App\Models\User\Image;
defined("APPPATH") OR die("Access denied");

use Core\Model\UserBase,
    App\Models\GlobalMethods as GM,
    Core\App;

class Upload{

    public function removeImage($image, $carpeta){
        $path = App::getPathImages();
        if($image != 'nopicture.jpg' && file_exists($path.$carpeta."/".$image)){
            unlink($path.$carpeta."/".$image);
        }
    }    
    /**
     * [Funcion para subir la imagen]
     */

    public function getUrlUploadImage($datosImagen, $carpeta, $nameImage, $image_prev = ''){
        $path = App::getPathImages();
        $datos = $datosImagen;
        $salida = array('e' => true, 'm' => '');

        list($ancho, $alto) = getimagesize($datos["temporalImage"]);
        $imgType = exif_imagetype($datos["temporalImage"]);
        $imgSize = filesize($datos["temporalImage"]);
        #Valores de Resolucion General
        $anchoGeneral = 480; #Ancho General
        $altoGeneral = 270; #Alto General
        $ratioGeneral = $anchoGeneral/$altoGeneral; #Ratio Calculado
        $rangoGeneral = 1.5; #Rango a partir del cual entra en la segunda Condicion


        if($ancho < $anchoGeneral || $alto < $altoGeneral){
            $salida['m'] = 'Imagen muy Pequeña';
            //$salida = array("response"=>'Imagen muy Pequeña', 'status'=>false);
        }else if($imgSize > 1500000){
            $salida['m'] = 'Imagen superior a 1.5 Mb';
            //$salida = array("response"=>'Imagen superior a 1.5 Mb', 'status'=>false);
        }else{

            $n = $nameImage;

            $ratio_ancho = $ancho / $anchoGeneral;
            $ratio = $ancho/$alto;
            $rectangular = false;

            
            if($ratio_ancho < $rangoGeneral){

                $nuevo_ancho = $anchoGeneral;
                $nuevo_alto = $altoGeneral;

            }else{

                $nuevo_ancho = $ancho;
                $nuevo_alto = $ancho / $ratioGeneral;
                if($ratio_ancho > 3 && $ratio == $ratioGeneral){
                    $nuevo_ancho= 3600;
                    $nuevo_alto = $nuevo_ancho / $ratioGeneral;
                    $rectangular = true;
                }
                if($nuevo_alto > $alto){
                    $nuevo_alto = $alto;
                    $nuevo_ancho = $alto * $ratioGeneral;
                }

            }

            if($imgType != IMAGETYPE_JPEG){
                $typeImage = '.png';
                $origen = imagecreatefrompng($datos["temporalImage"]);	
                $url = $path.$carpeta."/".$n.".png";
                $urlUpload = $path.$carpeta."/".$n.".png";
                $thumb = imagecreatetruecolor($ancho, $alto);
                imagealphablending($thumb, false);
                imagesavealpha($thumb, true); 
                imagecopyresampled($thumb, $origen, 0, 0, 0, 0, $ancho, $alto, $ancho, $alto);

                imagecopyresized($thumb, $origen, 0, 0, 0, 0, $ancho, $alto, $ancho,$alto);
                $liminf = ($ancho-$nuevo_ancho)/2;
                $limsup = ($alto-$nuevo_alto)/2;
                $destino =imagecrop($thumb, ["x"=>$liminf,"y"=>$limsup,"width"=>$nuevo_ancho,"height"=>$nuevo_alto]);

                imagepng($destino,$url);

            }else{
                $typeImage = '.jpg';
                $url = $path.$carpeta."/".$n.".jpg";
                $urlUpload = $path.$carpeta."/".$n.".jpg";
                $origen = imagecreatefromjpeg($datos["temporalImage"]);

                if($rectangular == false){
                    $thumb = imagecreatetruecolor($ancho, $alto);
                    imagecopyresized($thumb, $origen, 0, 0, 0, 0, $ancho, $alto, $ancho,$alto);
                    $liminf = ($ancho-$nuevo_ancho)/2;
                    $limsup = ($alto-$nuevo_alto)/2;
                    $destino =imagecrop($thumb, ["x"=>$liminf,"y"=>$limsup,"width"=>$nuevo_ancho,"height"=>$nuevo_alto]);
                    imagejpeg($destino,$url);
                }else{
                    $thumb = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
                    imagecopyresized($thumb, $origen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho,$alto);
                    imagejpeg($thumb,$url);
                }
            }
            /*if($image_prev != '' && file_exists($path.$carpeta."/".$image_prev)){
                unlink($path.$carpeta."/".$image_prev);
            }*/

            $salida = array('e' => false, 'm' => 'Picture Updated', 'image' => $nameImage.$typeImage);
        }
        /*Obtenemos una Respuesta */
        return $salida;
    }

}