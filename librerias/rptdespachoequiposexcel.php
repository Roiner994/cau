<?php
require_once("conexionsql.php");


    if ($_GET[idSitio]==100)
		$_GET[idSitio]="";
		
	if ($_GET[idGerencia]==100)
		$_GET[idGerencia]="";
	
	if ($_GET[idDescripcion]==100)	
		$_GET[idDescripcion]="";

	if ($_GET[tipoDespacho]==100)	
		$_GET[tipoDespacho]="";
		
	if ($_GET[statusDespacho]==100)	
		$_GET[statusDespacho]="";
		
	if ($_GET[analista]==100)	
		$_GET[analista]="";		
					
	if ($_GET[despachadoPor]==100)	
		$_GET[despachadoPor]="";		
		
	
     conectarMysql();


		$rangoFecha="";
		if ((isset($_GET[fechaInicio]) && !empty($_GET[fechaInicio])) || (isset($_GET[fechaFinal]) && !empty($_GET[fechaFinal]))) {
			$FechaInicio=substr($_GET[fechaInicio],6,6)."-".substr($_GET[fechaInicio],3,2)."-".substr($_GET[fechaInicio],0,2);
			$FechaFinal=substr($_GET[fechaFinal],6,6)."-".substr($_GET[fechaFinal],3,2)."-".substr($_GET[fechaFinal],0,2);
			$rangoFecha=" vistadespachoequipos.fecha_asociacion Between '$FechaInicio' AND '$FechaFinal' AND ";
		}
	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}
	if (isset($_GET[ficha]) && !empty($_GET[ficha])) {
		$conFicha=" and (ficha like '%$_GET[ficha]' or NOMBRE_USUARIO like '%$_GET[ficha]%' OR APELLIDO_USUARIO like '%$_GET[ficha]%')  ";
	}
	
	
		$consulta="select * 
		from 
		vistadespachoequipos 
		where $rangoFecha 
		id_despacho like '%' and 
		id_uss_detalle like '%' and
		help_desk like '%' and
		id_uss_detalle like '%$_GET[analista]' and
		id_uss like '%$_GET[despachadoPor]' and
		configuracion_nueva like '%$_GET[configuracion]' and
		configuracion_anterior like '%' and
		id_sitio like '%$_GET[idSitio]' and 
		id_gerencia like '%$_GET[idGerencia]' and 
		id_descripcion like '%$_GET[idDescripcion]' and
		id_despacho_estado like '%$_GET[tipoDespacho]' and 
		status_despacho like '%$_GET[statusDespacho]' $conFicha 
		$orden";
	
conectarMysql();
$result = mysql_query($consulta);
mysql_close();
$count = mysql_num_fields($result);

for ($i = 0; $i < $count; $i++){
    $header .= mysql_field_name($result, $i)."\t";
}

while($row = mysql_fetch_row($result)){
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