<?php
require_once "conexionsql.php";
require_once "administracion.php";
require_once "usuarioAdmin.php";
require_once "formularios.php";
conectarMySql();

	
	
	$sitio=isset($_GET['sitio'])&&$_GET['sitio']!=100  ? " AND vistainventarioequipos.ID_SITIO='".$_GET['sitio']."'" : "";	
	$gerencia=isset($_GET['gerencia'])&&$_GET['gerencia']!=100  ? " AND vistainventarioequipos.ID_GERENCIA='".$_GET['gerencia']."'" : "";	
	$mes=isset($_GET['mes'])&&$_GET['mes']!=100 ? " AND MONTH(punto_pendiente.FECHA_ASOCIACION)=".$_GET['mes'] : "";	
	$anno=isset($_GET['anno'])&&$_GET['anno']!=100 ? " AND YEAR(punto_pendiente.FECHA_ASOCIACION)=".$_GET['anno'] : "";		
	
	
	

	$query="SELECT vistainventarioequipos.CONFIGURACION AS CONFIGURACION,
 NOMBRE_PUNTO_PENDIENTE AS 'TIPO PUNTO PENDIENTE',
OBSERVACION,SITIO, GERENCIA,
punto_pendiente.FECHA_ASOCIACION AS 'FECHA GENERACION',
CONCAT(usuario_sistema.NOMBRE,' ',usuario_sistema.APELLIDO) AS 'ANALISTA'



 FROM punto_pendiente
LEFT JOIN detalle_punto_pendiente ON punto_pendiente.ID_PUNTO_PENDIENTE=detalle_punto_pendiente.ID_PUNTO_PENDIENTE
LEFT JOIN tipo_punto_pendiente ON tipo_punto_pendiente.ID_TIPO_PENDIENTE=detalle_punto_pendiente.ID_TIPO_PENDIENTE
LEFT JOIN usuario_sistema ON detalle_punto_pendiente.ID_USS=usuario_sistema.ID_USS
INNER JOIN vistainventarioequipos ON vistainventarioequipos.CONFIGURACION=punto_pendiente.CONFIGURACION
WHERE TRUE $sitio $mes $anno $gerencia ";
	
	$resultado = mysql_query($query);
//mysql_close();
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


header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=excelfile.xls");
header("Pragma: no-cache");
header("Expires: 0");	
if ($data == "") {
	$data = "\nno matching records found\n";
}else
	echo $header."\n".$data; 
	

	
	
?>
