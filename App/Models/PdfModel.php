<?php
namespace App\Models;
defined("APPPATH") OR die("Access denied");
require_once '../App/Lib/Html2Pdf/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf as Pdf,
    Core\App;
    
class PdfModel
{
    public function __construct(){
        $path = App::getPathDocs();
        $html2pdf = new Pdf();
        $html2pdf->writeHTML('<h1>HelloWorld</h1>This is my first test');
        //$h = $html2pdf->output('mipdf.pdf');
        var_dump($h);
        var_dump($html2pdf);
        PDF_save($path.$h);
        //link($h, $path."archiv.pdf");
        //$myfile = fopen($path."archiv.pdf", "w") or die("Unable to open file!");
        //fwrite($myfile, $h);
        //fclose($myfile);
    }
    
    
}