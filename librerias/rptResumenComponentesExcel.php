<?php
require_once("conexionsql.php");

    if ($_GET[sitio]==100)
		$_GET[sitio]="";
		
	if ($_GET[idGerencia]==100)
		$_GET[idGerencia]="";
	
	if ($_GET[idDescripcion]==100)	
		$_GET[idDescripcion]="";
		
		
	if ($_GET[idMarca]==100)	
		$_GET[idMarca]="";
					
		
	if ($_GET[idModelo]==100)	
		$_GET[idModelo]="";
		
			
	if ($_GET[idTipo]==100)	
		$_GET[idTipo]="";
		
	if ($_GET[idPedido]==100)	
		$_GET[idPedido]="";
		
			
			
	if ($_GET[idEstado]==100)	
		$_GET[idEstado]="";
		
		
	conectarMysql();


	$rangoFecha="";
	if ((isset($_GET[fechaInicio]) && !empty($_GET[fechaInicio])) && (isset($_GET[fechaFinal]) && !empty($_GET[fechaFinal]))) {
		$FechaInicio=substr($_GET[fechaInicio],6,6)."-".substr($_GET[fechaInicio],3,2)."-".substr($_GET[fechaInicio],0,2);
		$FechaFinal=substr($_GET[fechaFinal],6,6)."-".substr($_GET[fechaFinal],3,2)."-".substr($_GET[fechaFinal],0,2);
		$rangoFecha=" vistacomponentes.FECHA_I Between '$FechaInicio' AND '$FechaFinal' AND ";
	}
	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}
	
	if (isset($_GET[sitio]) && !empty($_GET[sitio]) && ($_GET[sitio] == 'SIT0000057') ){
		$consitio=" AND ID_SITIO  Like '%$_GET[sitio]' AND ID_INVENTARIO NOT IN (SELECT ID_INVENTARIO FROM vistacomponentesasociadosequipos)";
	}else
		$consitio=" AND ID_SITIO  Like '%$_GET[sitio]'";
	
    $consulta="SELECT serial, codigo_sap, descripcion, marca, modelo.modelo,tipo.TIPO, modelo.cap_vel, 
modelo.unidad, fru, product_number, spare_number, 
    ct, gerencia, division, departamento,
     sitio, especifico, id_pedido as PEDIDO, proveedor, fecha_inicio as FECHA_INICIO_GARANTIA, 
     fecha_final as FECHA_FINAL_GARANTIA,fecha_asociacion, estado,
     ficha, nombre_usuario, apellido_usuario, cargo, extension
    FROM vistacomponentes INNER JOIN modelo ON vistacomponentes.ID_MODELO=modelo.ID_MODELO INNER JOIN TIPO ON modelo.ID_TIPO=tipo.ID_TIPO
	Where
	$rangoFecha	
	SERIAL LIKE '%$_GET[serial]' AND
    ID_GERENCIA Like '%$_GET[idGerencia]' AND
    modelo.ID_DESCRIPCION LIKE '%$_GET[idDescripcion]' AND
    modelo.ID_Marca Like '%$_GET[idMarca]' AND
    modelo.ID_Modelo Like '%$_GET[idModelo]' AND
    ID_PEDIDO like '%$_GET[idPedido]'  AND
    modelo.ID_TIPO like '%$_GET[idTipo]'  AND
    ID_ESTADO like '%$_GET[idEstado]'    
    $consitio
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

# This line will stream the// file to the user rather than spray it across the screen
header("Content-type: application/octet-stream");

# replace excelfile.xls with whatever you want the filename to default to
header("Content-Disposition: attachment; filename=excelfile.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo $header."\n".$data; 
?> 
		
