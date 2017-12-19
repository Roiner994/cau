<?php
require_once("mantenimientoAdmin.php");
require_once("conexionsql.php");

//	$mantenimiento= new mantenimiento();
		
	if ($_GET[idSitio]==100)
		$_GET[idSitio]="";


	if ((isset($_GET[fechaInicio]) && !empty($_GET[fechaInicio]))) {
		$FechaInicio=substr($_GET[fechaInicio],6,6)."-".substr($_GET[fechaInicio],3,2)."-".substr($_GET[fechaInicio],0,2);
		$FechaFinal=substr($_GET[fechaFinal],6,6)."-".substr($_GET[fechaFinal],3,2)."-".substr($_GET[fechaFinal],0,2);
	}
	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}
//Sentencia sql (sin limit)
$consulta = "Select
			sitio.ID_SITIO,
			sitio.SITIO,
			mantenimiento_preventivo.CONFIGURACION,
			descripcion.DESCRIPCION,
			marca.MARCA,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD,
			inventario.ID_INVENTARIO,
			inventario.SERIAL,
			usuario.FICHA,
			usuario.NOMBRE_USUARIO,
			usuario.APELLIDO_USUARIO,
			usuario.EXTENSION,
			inventario_propiedad.ID_ESTADO,
			inventario_estado.ESTADO,
			inventario_propiedad.FECHA_ASOCIACION,
			inventario_propiedad.STATUS_ACTUAL
			From
			mantenimiento_preventivo
			Inner Join equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Inner Join usuario ON mantenimiento_preventivo.FICHA = usuario.FICHA
			Inner Join inventario_propiedad ON inventario.ID_INVENTARIO = inventario_propiedad.ID_INVENTARIO
			Inner Join inventario_estado ON inventario_propiedad.ID_ESTADO = inventario_estado.ID_ESTADO
			Where
			sitio.ID_SITIO Like '%$_GET[idSitio]' AND
			(mantenimiento_preventivo.HORA_INICIO between '$FechaInicio' and '$FechaFinal') AND inventario_propiedad.status_actual=1 and mantenimiento_preventivo.configuracion not in (Select
			mantenimiento_preventivo.CONFIGURACION
			From
			mantenimiento_preventivo
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Where
			sitio.ID_SITIO Like '%$_GET[idSitio]' AND
			mantenimiento_preventivo.HORA_INICIO > '$FechaFinal'
			Group By
			mantenimiento_preventivo.CONFIGURACION
			)
			Group By
			mantenimiento_preventivo.CONFIGURACION
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