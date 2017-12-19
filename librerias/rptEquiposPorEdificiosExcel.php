<?php
require_once("mantenimientoAdmin.php");
require_once("conexionsql.php");

//	$mantenimiento= new mantenimiento();
	set_time_limit(70);
	
		
	$sitio=isset($_GET['sitio'])&&$_GET['sitio']!=100 ? $_GET['sitio'] : "";
	
		
		
	$query="Select
			equipo_campo.CONFIGURACION,
			equipo_campo.ACTIVO_FIJO,
			equipo_campo.ID_INVENTARIO,
			inventario.SERIAL,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			marca.ID_MARCA,
			marca.MARCA,
			modelo.ID_MODELO,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD,
			sitio.ID_SITIO,
			sitio.SITIO,		
			cantidad_mantenimientos(equipo_campo.configuracion) AS 'CANTIDAD',
			CONCAT(vistainventarioequipos.NOMBRE_USUARIO,' ',vistainventarioequipos.APELLIDO_USUARIO) AS USUARIO,
			vistainventarioequipos.FICHA,
			vistainventarioequipos.GERENCIA,
			vistainventarioequipos.SITIO
			From
			equipo_campo
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
			Inner Join inventario_ubicacion ON inventario_ubicacion.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join sitio ON inventario_ubicacion.ID_SITIO = sitio.ID_SITIO
			INNER JOIN vistainventarioequipos ON equipo_campo.CONFIGURACION=vistainventarioequipos.CONFIGURACION
			Where
			inventario_ubicacion.STATUS_ACTUAL = '1' AND
			sitio.ID_SITIO Like '%$sitio' and descripcion.id_descripcion in ('DES0000001','DES0000008','DES0000042') 
			
			order by descripcion.descripcion, equipo_campo.configuracion";


	
conectarMysql();
$resultado = mysql_query($query);
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
