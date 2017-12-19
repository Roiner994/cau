<?php
require_once ("formularios.php");
require_once ("conexionsql.php");
require_once ("inventarioAdmin.php");


	
	
		$Fechainicio=substr($_GET[fechaInicio],6,6)."-".substr($_GET[fechaInicio],3,2)."-".substr($_GET[fechaInicio],0,2);
		if(isset($_GET[fechaInicio]))
			$Fechainicio= " AND FECHA_INICIO >= '$Fechainicio' ";
		
		$Fechafinal=substr($_GET[fechaFinal],6,6)."-".substr($_GET[fechaFinal],3,2)."-".substr($_GET[fechaFinal],0,2);		
		if(isset($_GET[fechaFinal]))
			$Fechafinal= " AND FECHA_INICIO <= '$Fechafinal' ";
	
	
	$analista= isset($_GET['analista'])? $_GET['analista']	: "";
		
	
	if(empty($analista)){
			$query="SELECT 
			CONFIGURACION,
			ACTIVO_FIJO AS 'ACTIVO FIJO',
			SERIAL,
			DESCRIPCION,
			MARCA,
			MODELO,
			CONCAT(NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUARIO,
			EXTENSION,
			SITIO AS EDIFICIO,
			GERENCIA,
			CONCAT(usuario_sistema.NOMBRE,' ',usuario_sistema.APELLIDO) AS ANALISTA,
			FECHA_INICIO AS 'FECHA MANTENIMIENTO'			
			FROM vistamantenimientospreventivos
			INNER JOIN usuario_sistema ON vistamantenimientospreventivos.ID_USS=usuario_sistema.ID_USS
			WHERE TRUE $Fechainicio $Fechafinal AND usuario_sistema.STATUS_ACTIVO=1 AND vistamantenimientospreventivos.STATUS_MANTENIMIENTO = '2'
			
			";
	}else{
			$query="SELECT 
			CONFIGURACION,
			ACTIVO_FIJO AS 'ACTIVO FIJO',
			SERIAL,
			DESCRIPCION,
			MARCA,
			MODELO,
			CONCAT(NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUARIO,
			EXTENSION,
			SITIO AS EDIFICIO,
			GERENCIA,
			CONCAT(usuario_sistema.NOMBRE,' ',usuario_sistema.APELLIDO) AS ANALISTA,
			FECHA_INICIO AS 'FECHA MANTENIMIENTO'			
			FROM vistamantenimientospreventivos
			INNER JOIN usuario_sistema ON vistamantenimientospreventivos.ID_USS=usuario_sistema.ID_USS
			WHERE TRUE $Fechainicio $Fechafinal AND usuario_sistema.STATUS_ACTIVO=1 AND usuario_sistema.ID_USS='$analista' AND vistamantenimientospreventivos.STATUS_MANTENIMIENTO = '2'
			
			";
		
	}
	
		
	
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
//echo $query;
# This line will stream the file to the user rather than spray it across the screen
header("Content-type: application/octet-stream");

# replace excelfile.xls with whatever you want the filename to default to
header("Content-Disposition: attachment; filename=excelfile.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo $header."\n".$data; 
		
		
	
	 
	
?>

