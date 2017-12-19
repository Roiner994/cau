<?php
require_once('../Libreria_excel/PHPExcel.php');
require_once('../Libreria_excel/PHPExcel/Reader/Excel2007.php');
require_once('../Libreria_excel/PHPExcel/IOFactory.php');
extract($_POST);
session_start();
$archivo = $_FILES['excel']['name'];
$tipo = $_FILES['excel']['type'];
$destino = "bak_" . $archivo;
$archivo = $_FILES['excel']['name'];
$tipo = $_FILES['excel']['type'];
$destino = "bak_" . $archivo;
if (!(copy($_FILES['excel']['tmp_name'], $destino))){
    echo "Error Al Cargar el Archivo <br></br>";
}
if (!(file_exists("bak_" . $archivo))) {
    echo "Necesitas primero importar el archivo <br></br>";
}
$objReader = new PHPExcel_Reader_Excel2007();

$objPHPExcel = PHPExcel_IOFactory::load("bak_" . $archivo);
        $objFecha = new PHPExcel_Shared_Date();
        $objPHPExcel->setActiveSheetIndex(0);
        $objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true,true,true,true);
        unlink($destino);
        $_SESSION['excel'] = $objHoja;
        header ("Location: index2.php?item=700");

?>
