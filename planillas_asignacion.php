<?php
require_once('reportes_gestion/libreria/fpdf.php');
$url=$_GET['url'];
$pdf = new FPDF(); 
$pdf->AddPage(); //crear documento
$pdf->Image('$url',0, 0, $size[0], $size[4]); //añadir imagen 
$pdf->Output(); //el resto es historia 
?>
