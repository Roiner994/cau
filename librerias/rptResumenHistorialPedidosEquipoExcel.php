<?php

require_once("conexionsql.php");


    if ($_GET[Marca]==100) 	
		$_GET[Marca]="";
		
		
	if ($_GET[Modelo]==100) 	
		$_GET[Modelo]="";
		
		
	if ($_GET[Descripcion]==100)
		$_GET[Descripcion]="";
		
		
	if ($_GET[pedido]==100)
		$_GET[pedido]="";
		
		
	$rangoFecha="";
	if ((isset($_GET[fechaIni]) && !empty($_GET[fechaIni])) && (isset($_GET[fechaFin]) && !empty($_GET[fechaFin]))) {
		$FechaInicio=substr($_GET[fechaIni],6,6)."-".substr($_GET[fechaIni],3,2)."-".substr($_GET[fechaIni],0,2);
		$FechaFinal=substr($_GET[fechaFin],6,6)."-".substr($_GET[fechaFin],3,2)."-".substr($_GET[fechaFin],0,2);
		$rangoFecha=" vistaInventarioEquipos.EQUIPO_FECHA_CREACION Between '$FechaInicio' AND '$FechaFinal' AND ";
	}
	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}
	
	
	//consulto en la base de datos para imprimir en la pantalla de Excel	
	$consulta="SELECT fecha_inicio,fecha_final,configuracion,activo_fijo,serial,marca,modelo,estado,nombre_usuario,apellido_usuario,sitio,id_pedido,proveedor,telefono
	FROM `vistainventarioequipos` 
	WHERE 		
		$rangoFecha		
		CONFIGURACION like '%$_GET[Configuracion]' AND
		SERIAL LIKE '%$_GET[Serial]' AND
	    ID_DESCRIPCION LIKE '%$_GET[Descripcion]' AND
    	ID_Marca Like '%$_GET[Marca]' AND
    	ID_Modelo Like '%$_GET[Modelo]' AND
    	ID_PEDIDO like '%$_GET[pedido]'  AND
    	ACTIVO_FIJO like '%$_GET[ActivoFijo]'			
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