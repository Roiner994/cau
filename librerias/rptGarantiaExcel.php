<?php
require_once("conexionsql.php");

    if ($_GET[proveedor]==100)
		$_GET[proveedor]="";
		
	if ($_GET[descripcion]==100)
		$_GET[descripcion]="";
	
	if ($_GET[estado]==100)	
		$_GET[estado]="";
		
		
	conectarMysql();


	$rangoFecha="";
	if ((isset($_GET[fechaInicio]) && !empty($_GET[fechaInicio])) && (isset($_GET[fechaFinal]) && !empty($_GET[fechaFinal]))) {
		$FechaInicio=substr($_GET[fechaInicio],6,6)."-".substr($_GET[fechaInicio],3,2)."-".substr($_GET[fechaInicio],0,2);
		$FechaFinal=substr($_GET[fechaFinal],6,6)."-".substr($_GET[fechaFinal],3,2)."-".substr($_GET[fechaFinal],0,2);
		$rangoFecha=" garantia.FECHA_ASOCIACION Between '$FechaInicio 00:00:00' AND '$FechaFinal 23:59:59' AND ";
	}
	
    $consulta="Select
		garantia_estado.GARANTIA_ESTADO,
		detalle_garantia.FECHA_ASOCIACION,
		inventario.SERIAL,
		descripcion.DESCRIPCION,
		marca.MARCA,
		modelo.MODELO,
		pedido.ID_PEDIDO,
		pedido.FECHAI_GARANTIA,
		pedido.FECHAF_GARANTIA,
		proveedor.PROVEEDOR,
		componente_garantia.CONFIGURACION,
		inventario_equipo.SERIAL,
		descripcion_equipo.DESCRIPCION,
		marca_equipo.MARCA,
		modelo_equipo.MODELO,
		modelo_equipo.CAP_VEL,
		modelo_equipo.UNIDAD,
		configuracion_equipo.CONFIGURACION,
		configuracion_equipo.ACTIVO_FIJO
		From
		garantia
		Inner Join detalle_garantia ON garantia.ID_GARANTIA = detalle_garantia.ID_GARANTIA
		Inner Join inventario ON garantia.ID_INVENTARIO = inventario.ID_INVENTARIO
		Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
		Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
		Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
		Inner Join pedido ON inventario.ID_PEDIDO = pedido.ID_PEDIDO
		Inner Join proveedor ON pedido.ID_PROVEEDOR = proveedor.ID_PROVEEDOR
		Left Join componente_garantia ON inventario.ID_INVENTARIO = componente_garantia.ID_INVENTARIO
		Left Join equipo_campo ON componente_garantia.CONFIGURACION = equipo_campo.CONFIGURACION
		Left Join inventario AS inventario_equipo ON equipo_campo.ID_INVENTARIO = inventario_equipo.ID_INVENTARIO
		Left Join modelo AS modelo_equipo ON inventario_equipo.ID_MODELO = modelo_equipo.ID_MODELO
		Left Join descripcion AS descripcion_equipo ON modelo_equipo.ID_DESCRIPCION = descripcion_equipo.ID_DESCRIPCION
		Left Join marca AS marca_equipo ON modelo_equipo.ID_MARCA = marca_equipo.ID_MARCA
		Inner Join garantia_estado ON detalle_garantia.ID_GARANTIA_ESTADO = garantia_estado.ID_GARANTIA_ESTADO
		Left Join equipo_campo AS configuracion_equipo ON configuracion_equipo.ID_INVENTARIO = garantia.ID_INVENTARIO
			Where
			$rangoFecha 
			descripcion.id_descripcion like '%$_GET[descripcion]' and
			detalle_garantia.ID_GARANTIA_ESTADO like '%' AND
			detalle_garantia.STATUS_ACTIVO = '1' AND
			proveedor.ID_PROVEEDOR Like '%$_GET[proveedor]' AND
			inventario.SERIAL Like '%$_GET[serial]' AND
			detalle_garantia.ID_GARANTIA_ESTADO Like '%$_GET[estado]'"; 
    
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
		