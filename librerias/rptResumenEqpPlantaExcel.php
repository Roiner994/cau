<?php

require_once("conexionsql.php");


	if ($_GET[Sitio]==100)
		$_GET[Sitio]="";
		
	if ($_GET[Gerencia]==100)
		$_GET[Gerencia]="";
	
	if ($_GET[Descripcion]==100)	
		$_GET[Descripcion]="";		
		
	if ($_GET[Marca]==100)	
		$_GET[Marca]="";					
		
	if ($_GET[Modelo]==100)	
		$_GET[Modelo]="";
		
	$rangoFecha="";
	if ((isset($_GET[fechaInicio]) && !empty($_GET[fechaInicio])) && (isset($_GET[fechaFinal]) && !empty($_GET[fechaFinal]))) {
		$FechaInicio=substr($_GET[fechaInicio],6,6)."-".substr($_GET[fechaInicio],3,2)."-".substr($_GET[fechaInicio],0,2);
		$FechaFinal=substr($_GET[fechaFinal],6,6)."-".substr($_GET[fechaFinal],3,2)."-".substr($_GET[fechaFinal],0,2);
		$rangoFecha=" vistaInventarioEquipos.EQUIPO_FECHA_CREACION Between '$FechaInicio' AND '$FechaFinal' AND ";
	}
	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}
	if (isset($_GET[Ficha]) && !empty($_GET[Ficha])) {
			$conFicha=" AND (FICHA like '%$_GET[Ficha]' OR NOMBRE_USUARIO like '%$_GET[Ficha]%' OR APELLIDO_USUARIO like '%$_GET[Ficha]%')  ";
		} 
		
	//consulto en la base de datos para imprimir en la pantalla de Excel	
	$consulta="SELECT configuracion,activo_fijo,marca,modelo,serial,gerencia,division,departamento,sitio,cargo,nombre_usuario,apellido_usuario,ficha,cedula,extension
	FROM `vistainventarioequipos` 
	WHERE 
		vistainventarioequipos .SERIAL like '%$_GET[Serial]' and	
		vistainventarioequipos .ID_SITIO like '%$_GET[Sitio]' and
		vistainventarioequipos .ID_GERENCIA like '%$_GET[Gerencia]' and
		vistainventarioequipos .ID_DESCRIPCION like '%$_GET[Descripcion]' and 
		vistainventarioequipos .ACTIVO_FIJO like '%$_GET[activofijo]' AND
		vistainventarioequipos .ID_MARCA like '%$_GET[Marca]' and
		vistainventarioequipos .ID_MODELO like '%$_GET[Modelo]' and		
		vistainventarioequipos .CONFIGURACION like '%$_GET[Configuracion]'	
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