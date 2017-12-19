<?php
require_once("mantenimientoAdmin.php");
require_once("conexionsql.php");

//	$mantenimiento= new mantenimiento();
	if ($_POST[selUsuarioSistema]==100)
		$_POST[selUsuarioSistema]="";
		
	if ($_GET[idGerencia]==100)
		$_GET[idGerencia]="";
		
	if ($_GET[idSitio]==100)
		$_GET[idSitio]="";
		
	if ($_GET[analista]==100)
		$_GET[analista]="";
	
	if ($_GET[idDescripcion]==100)
		$_GET[idDescripcion]="";	

	if ($_GET[idCorrectivo]==100)
		$_GET[idCorrectivo]="";
		
	if ($_GET[idRed]==100)
		$_GET[idRed]="";
		
	if ($_GET[idSistemaOperativo]==100)
		$_GET[idSistemaOperativo]="";

	if ($_GET[idAntivirus]==100)
		$_GET[idAntivirus]="";
		
	if ($_GET[idStatusMantenimiento]==100)
		$_GET[idStatusMantenimiento]="";
				


	$rangoFecha="";
	if ((isset($_GET[fechaInicio]) && !empty($_GET[fechaInicio])) && (isset($_GET[fechaFinal]) && !empty($_GET[fechaFinal]))) {
		$FechaInicio=substr($_GET[fechaInicio],6,6)."-".substr($_GET[fechaInicio],3,2)."-".substr($_GET[fechaInicio],0,2);
		$FechaFinal=substr($_GET[fechaFinal],6,6)."-".substr($_GET[fechaFinal],3,2)."-".substr($_GET[fechaFinal],0,2);
		$rangoFecha=" vistamantenimientospreventivos.fecha_inicio Between '$FechaInicio' AND '$FechaFinal' AND ";
	}
	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}
$consulta="select * from vistamantenimientospreventivos where
		$rangoFecha 
		vistamantenimientospreventivos.STATUS_MANTENIMIENTO like '%$_GET[idStatusMantenimiento]' and
		vistamantenimientospreventivos.id_uss like '%$_GET[analista]' and
		vistamantenimientospreventivos.id_mantenimiento like '%$idMantenimiento' and
		vistamantenimientospreventivos.ID_GERENCIA like '%$_GET[idGerencia]' and
		vistamantenimientospreventivos.ID_SITIO like '%$_GET[idSitio]' and
		vistamantenimientospreventivos.ID_DESCRIPCION like '%$_GET[idDescripcion]' and 
		vistamantenimientospreventivos.CORRECTIVO like '%$_GET[idCorrectivo]' and
		vistamantenimientospreventivos.SISTEMA_OPERATIVO like '%$_GET[idSistemaOperativo]' and
		vistamantenimientospreventivos.ANTIVIRUS like '%$_GET[idAntivirus]' and
		vistamantenimientospreventivos.RED like '%$_GET[idRed]' and
		vistamantenimientospreventivos.CONFIGURACION like '%$_GET[txtConfiguracion]'
		$orden";

conectarMysql();
$resultado = mysql_query($consulta);
mysql_close();
$count = mysql_num_fields($resultado);

for ($i = 0; $i < $count; $i++){
    $header .= mysql_field_name($resultado, $i)."\t";
}

while($row = mysql_fetch_row($resultado)){
  $line = '';
  foreach($row as $value){
    if(!isset($value) || $value == ""){
      $value = "\t";
    }else{
# important to escape any quotes to preserve them in the data.
      $value = str_replace('"', '""', $value);
# needed to encapsulate data in quotes because some data might be multi line.
# the good news is that numbers remain numbers in Excel even though quoted.
      $value = '"' . $value . '"' . "\t";
    }
    $line .= $value;
  }
  $data .= trim($line)."\n";
}
# this line is needed because returns embedded in the data have "\r"
# and this looks like a "box character" in Excel
  $data = str_replace("\r", "", $data);


# Nice to let someone know that the search came up empty.
# Otherwise only the column name headers will be output to Excel.
if ($data == "") {
  $data = "\nno matching records found\n";
}

# This line will stream the file to the user rather than spray it across the screen
header("Content-type: application/octet-stream");

# replace excelfile.xls with whatever you want the filename to default to
header("Content-Disposition: attachment; filename=excelfile.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo $header."\n".$data; 
?> 