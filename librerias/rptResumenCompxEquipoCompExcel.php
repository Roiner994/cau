<?php

require_once("conexionsql.php");


    if ($_GET[idDescripcion]==100)
		$_GET[idDescripcion]="";


	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}
	
	
	//consulto en la base de datos para imprimir en la pantalla de Excel	
	$consulta="Select DISTINCT equipo_componente_campo.CONFIGURACION,
			inventario.SERIAL,
			descripcion.DESCRIPCION,
			marca.MARCA,
			modelo.MODELO,
			sitio.SITIO,
			inventario_estado.ESTADO
			From
			equipo_componente_campo
			Inner Join inventario ON equipo_componente_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join inventario_propiedad ON inventario.ID_INVENTARIO = inventario_propiedad.ID_INVENTARIO			
			Inner Join inventario_estado ON inventario_propiedad.ID_ESTADO = inventario_estado.ID_ESTADO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON marca.ID_MARCA = modelo.ID_MARCA
			Inner Join pedido ON inventario.ID_PEDIDO = pedido.ID_PEDIDO
			Inner Join proveedor ON proveedor.ID_PROVEEDOR = pedido.ID_PROVEEDOR
			Inner Join sitio ON inventario_propiedad.ID_SITIO = sitio.ID_SITIO
			Where
			inventario_estado.ESTADO='OPERATIVO' AND
			equipo_componente_campo.CONFIGURACION Like '%$_GET[configuracion]' and 
			descripcion.ID_DESCRIPCION Like '%$descripcion' 
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