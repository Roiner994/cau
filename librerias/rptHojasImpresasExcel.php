<?php

require_once("conexionsql.php");


    if ($_GET[sitio]==100)
		$_GET[sitio]="";
		
	if ($_GET[gerencia]==100)
		$_GET[gerencia]="";
	
	if ($_GET[idDescripcion]==100)	
		$_GET[idDescripcion]='DES0000008';
		
	if ($_GET[idMarca]==100)	
		$_GET[idMarca]="";
					
	if ($_GET[idModelo]==100)	
		$_GET[idModelo]="";
		
	$rangoFecha="";
	if ((isset($_GET[fechaInicio]) && !empty($_GET[fechaInicio])) && (isset($_GET[fechaFinal]) && !empty($_GET[fechaFinal]))) {
		$FechaInicio=substr($_GET[fechaInicio],6,6)."-".substr($_GET[fechaInicio],3,2)."-".substr($_GET[fechaInicio],0,2);
		$FechaFinal=substr($_GET[fechaFinal],6,6)."-".substr($_GET[fechaFinal],3,2)."-".substr($_GET[fechaFinal],0,2);
		$rangoFecha=" vistamantenimientospreventivos.FECHA_INICIO Between '$FechaInicio' AND '$FechaFinal' AND";
	}
	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}
    if (isset($_GET[txtFicha]) && !empty($_GET[txtFicha])) {
			$conFicha=" AND (vistamantenimientospreventivos.FICHA like '%$_GET[txtFicha]' OR vistamantenimientospreventivos.NOMBRE_USUARIO like '%$_GET[txtFicha]%' OR vistamantenimientospreventivos.APELLIDO_USUARIO like '%$_GET[txtFicha]%')";
		} 
	if (isset($_GET[txtConfiguracion]) && !empty($_GET[txtConfiguracion])) {
		$conConfig=" vistamantenimientospreventivos.CONFIGURACION like '%$_GET[txtConfiguracion]' AND vistamantenimientospreventivos.CONFIGURACION NOT IN (Select equipo_campo.CONFIGURACION From equipo_campo Inner Join inventario_propiedad ON equipo_campo.ID_INVENTARIO = inventario_propiedad.ID_INVENTARIO Where ((inventario_propiedad.ID_ESTADO Not Like 'EST0000001') AND (equipo_campo.CONFIGURACION Like '%VEI%')) Group By equipo_campo.CONFIGURACION) AND ";
	}else
		$conConfig=" vistamantenimientospreventivos.CONFIGURACION like '%$_GET[txtConfiguracion]' AND vistamantenimientospreventivos.CONFIGURACION NOT IN (Select equipo_campo.CONFIGURACION From equipo_campo Inner Join inventario_propiedad ON equipo_campo.ID_INVENTARIO = inventario_propiedad.ID_INVENTARIO Where ((inventario_propiedad.ID_ESTADO Not Like 'EST0000001') AND (equipo_campo.CONFIGURACION Like '%VEI%')) Group By equipo_campo.CONFIGURACION) AND ";

	$consulta="select fecha_inicio,id_mantenimiento,configuracion,marca,modelo,serial,cant_hojas_impresas,gerencia,sitio
	from vistamantenimientospreventivos 
	Where 
	$rangoFecha
	$conConfig
	vistamantenimientospreventivos.ID_Descripcion Like '%$_GET[idDescripcion]' AND
    vistamantenimientospreventivos.ACTIVO_FIJO LIKE '%$_GET[txtActivoFijo]' AND
    vistamantenimientospreventivos.ID_Marca Like '%$_GET[idMarca]' AND
    vistamantenimientospreventivos.ID_Modelo Like '%$_GET[idModelo]' AND       
	vistamantenimientospreventivos.SERIAL LIKE '%$_GET[txtSerial]' AND 
	vistamantenimientospreventivos.ID_SITIO Like '%$_GET[sitio]' AND
    vistamantenimientospreventivos.ID_GERENCIA Like '%$_GET[gerencia]'
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