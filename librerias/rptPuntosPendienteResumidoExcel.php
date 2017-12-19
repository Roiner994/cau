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
	
	
		$tid[]='ENERO';
	$tid[]='FEBRERO';
	$tid[]='MARZO';
	$tid[]='ABRIL';
	$tid[]='MAYO';
	$tid[]='JUNIO';
	$tid[]='JULIO';
	$tid[]='AGOSTO';
	$tid[]='SEPTIEMBRE';	
	$tid[]='OCTUBRE';
	$tid[]='NOVIEMBRE';
	$tid[]='DICIEMBRE';
	
	
	$tif[]=1;
	$tif[]=2;
	$tif[]=3;
	$tif[]=4;
	$tif[]=5;
	$tif[]=6;
	$tif[]=7;
	$tif[]=8;
	$tif[]=9;
	$tif[]=10;
	$tif[]=11;
	$tif[]=12;
	
		
	$tecnicos="";
	$lm=count($tid);
	$total=" ,0";
	
	for($i=0;$i!=$lm;$i++){
		$tecnicos.=" , COUNT(
					CASE (MONTH(punto_pendiente.FECHA_ASOCIACION))
					WHEN '$tif[$i]' THEN 1                           
					END        
					)AS `$tid[$i]` ";
		$total.="+COUNT(
					CASE (MONTH(punto_pendiente.FECHA_ASOCIACION))
					WHEN '$tif[$i]' THEN 1                           
					END        
					)";
	}
	
	
	if(!empty($tecnicos)){
	
	$query="SELECT NOMBRE_PUNTO_PENDIENTE AS DESCRIPCION   ".$tecnicos."".$total."AS TOTAL".

	

"

 FROM punto_pendiente
INNER JOIN detalle_punto_pendiente ON punto_pendiente.ID_PUNTO_PENDIENTE=detalle_punto_pendiente.ID_PUNTO_PENDIENTE
INNER JOIN tipo_punto_pendiente ON tipo_punto_pendiente.ID_TIPO_PENDIENTE=detalle_punto_pendiente.ID_TIPO_PENDIENTE
INNER JOIN usuario_sistema ON detalle_punto_pendiente.ID_USS=usuario_sistema.ID_USS
INNER JOIN vistainventarioequipos ON vistainventarioequipos.CONFIGURACION=punto_pendiente.CONFIGURACION
WHERE TRUE $sitio $mes $anno $gerencia GROUP BY NOMBRE_PUNTO_PENDIENTE";
	
	$resultado = mysql_query($query);
//mysql_close();
$count = mysql_num_fields($resultado);

for ($i = 0; $i < $count; $i++){
    $header .= mysql_field_name($resultado, $i)."\t";
}

while($row = mysql_fetch_row($resultado)){
  $line = '';
    $ba=0;
    
  foreach($row as $value){
	  
	  if($ba!=0){
		$resultados[$ba]+=$row[$ba];
		
	}
	  $ba++;
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

$data.="TOTAL";
	for($i=1;$i!=$count;$i++){
		$data.="\t $resultados[$i] ";
	}
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=excelfile.xls");
header("Pragma: no-cache");
header("Expires: 0");	
if ($data == "") {
	$data = "\nno matching records found\n";
}else
	echo $header."\n".$data; 
	

}
	
?>
