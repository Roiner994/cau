<?php

require_once("conexionsql.php");


    if ($_GET[sitio]==100)
		$_GET[sitio]="";
		
	if ($_GET[idGerencia]==100)
		$_GET[idGerencia]="";
	
	if ($_GET[idDescripcion]==100)	
		$_GET[idDescripcion]="";

	if ($_GET[despachadoPor]==100)	
		$_GET[despachadoPor]="";

	if ($_GET[despachadoA]==100)	
		$_GET[despachadoA]="";

	if ($_GET[statusDespacho]==100)	
		$_GET[statusDespacho]="";
		
		
	
		
	$rangoFecha="";
	if ((isset($_GET[fechaInicio]) && !empty($_GET[fechaInicio])) && (isset($_GET[fechaFinal]) && !empty($_GET[fechaFinal]))) {
		$FechaInicio=substr($_GET[fechaInicio],6,6)."-".substr($_GET[fechaInicio],3,2)."-".substr($_GET[fechaInicio],0,2);
		$FechaFinal=substr($_GET[fechaFinal],6,6)."-".substr($_GET[fechaFinal],3,2)."-".substr($_GET[fechaFinal],0,2);
		$rangoFecha=" vistadespachocomponentes.FECHA_ASOCIACION Between '$FechaInicio' AND '$FechaFinal' AND ";
	}
	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}
	
	if (isset($_GET[ficha]) && !empty($_GET[ficha])) {
		$conFicha=" and (ficha like '%$_GET[ficha]' or NOMBRE_USUARIO like '%$_GET[ficha]%' OR APELLIDO_USUARIO like '%$_GET[ficha]%')  ";
	}	
	
	$consulta="SELECT * FROM vistadespachocomponentes 

        where
		$rangoFecha
		vistadespachocomponentes.CONFIGURACION like '%$_GET[txtConfiguracion]' and
		vistadespachocomponentes.SERIAL like '%$_GET[txtSerial]' and	
		detalle_id_uss like '%$_GET[despachadoA]' and
		id_uss like '%$_GET[despachadoPor]' and						
		id_despacho_estado like '%$_GET[statusDespacho]' and						
		vistadespachocomponentes.ID_SITIO like '%$_GET[sitio]' and
		vistadespachocomponentes.ID_GERENCIA like '%$_GET[idGerencia]' and
		vistadespachocomponentes.ID_DESCRIPCION like '%$_GET[idDescripcion]'  
		
		$conFicha
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