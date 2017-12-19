<?php
//require_once('../reportes_gestion/libreria/fpdf.php');
$url=$_GET['url'];
  /*
$pdf = new FPDF(); 
$pdf->AddPage();
$pdf->Image($url,0, 0,200,300);
$pdf->Output(); */
/*
header('Content-disposition: attachment; filename='.$url);
header('Content-type: application/pdf');
readfile($url);*/

$attachment_location=$url;
        if (file_exists($attachment_location)) {
            // attachment exists
           
            // send open/save pdf dialog to user
            header('Cache-Control: public'); // needed for i.e.
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="sample.pdf"');
            readfile($attachment_location);
            die(); // stop execution of further script because we are only outputting the pdf
           
        } else {
            die('Error: File not found.');
        }

?>
