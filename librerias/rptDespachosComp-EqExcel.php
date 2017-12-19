<?php
require_once "conexionsql.php";
require_once "administracion.php";
require_once "usuarioAdmin.php";
require_once "formularios.php";
conectarMySql();

	
	
	$sitio=isset($_GET['sitio'])&&$_GET['sitio']!=100  ? " AND vistadespachoequipos.ID_SITIO='".$_GET['sitio']."'" : "";	
	$gerencia=isset($_GET['gerencia'])&&$_GET['gerencia']!=100  ? " AND vistadespachoequipos.ID_GERENCIA='".$_GET['gerencia']."'" : "";	
	$mes=isset($_GET['mes'])&&$_GET['mes']!=100 ? " AND MONTH(vistadespachoequipos.FECHA_ASOCIACION)=".$_GET['mes'] : "";	
	$anno=isset($_GET['anno'])&&$_GET['anno']!=100 ? " AND YEAR(vistadespachoequipos.FECHA_ASOCIACION)=".$_GET['anno'] : "";		
	
	
	
$query="SELECT DISTINCT DESPACHO_ESTADO FROM vistadespachoequipos WHERE TRUE $sitio  $gerencia $mes $anno";

$rs=mysql_query($query);
	
	if($rs&&mysql_num_rows($rs)>0){
		$nt=mysql_num_rows($rs);
		
		while($row=mysql_fetch_array($rs)){			
			$tid[]=$row[0];					
								
		}
	}
	$tecnicos="";
	$lm=count($tid);
	$total=" ,0";
	
	for($i=0;$i!=$lm;$i++){
		$tecnicos.=" , COUNT(
					CASE (vistadespachoequipos.DESPACHO_ESTADO)
					WHEN '$tid[$i]' THEN 1                           
					END        
					)AS `$tid[$i]` ";
		$total.="+COUNT(
					CASE (vistadespachoequipos.DESPACHO_ESTADO)
					WHEN '$tid[$i]' THEN 1                           
					END        
					)";
	}
	if(!empty($tecnicos)){
	$query="SELECT  DESCRIPCION ".$tecnicos."".$total."AS TOTAL".  
	"
	FROM vistadespachoequipos WHERE TRUE $sitio  $gerencia $mes $anno
	
	 
	GROUP BY DESCRIPCION";	
	
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
	}
	
	
	
	$sitio=isset($_GET['sitio'])&&$_GET['sitio']!=100  ? " AND vistadespachocomponentes.ID_SITIO='".$_GET['sitio']."'" : "";	
	$gerencia=isset($_GET['gerencia'])&&$_GET['gerencia']!=100  ? " AND vistadespachocomponentes.ID_GERENCIA='".$_GET['gerencia']."'" : "";	
	$mes=isset($_GET['mes'])&&$_GET['mes']!=100 ? " AND MONTH(vistadespachocomponentes.FECHA_ASOCIACION)=".$_GET['mes'] : "";	
	$anno=isset($_GET['anno'])&&$_GET['anno']!=100 ? " AND YEAR(vistadespachocomponentes.FECHA_ASOCIACION)=".$_GET['anno'] : "";		
	
	
	
$query1="SELECT DISTINCT DESPACHO_ESTADO FROM vistadespachocomponentes WHERE TRUE $sitio  $gerencia $mes $anno";

$rs1=mysql_query($query1);
	
	if($rs1&&mysql_num_rows($rs1)>0){
		$nt1=mysql_num_rows($rs1);
		
		while($row1=mysql_fetch_array($rs1)){			
			$tid1[]=$row1[0];					
								
		}
	}
	$tecnicos1="";
	$lm1=count($tid1);
	$total1=" ,0";
	
	for($i1=0;$i1!=$lm1;$i1++){
		$tecnicos1.=" , COUNT(
					CASE (vistadespachocomponentes.DESPACHO_ESTADO)
					WHEN '$tid1[$i1]' THEN 1                           
					END        
					)AS `$tid1[$i1]` ";
		$total1.="+COUNT(
					CASE (vistadespachocomponentes.DESPACHO_ESTADO)
					WHEN '$tid1[$i1]' THEN 1                           
					END        
					)";
	}
	if(!empty($tecnicos1)){
		
	$query1="SELECT  DESCRIPCION ".$tecnicos1."".$total1."AS TOTAL".  
	"
	FROM vistadespachocomponentes WHERE TRUE $sitio  $gerencia $mes $anno
	
	 
	GROUP BY DESCRIPCION";	
	
			$resultado1 = mysql_query($query1);
//mysql_close();
$count1 = mysql_num_fields($resultado1);

for ($i1 = 0; $i1 < $count1; $i1++){
    $header1 .= mysql_field_name($resultado1, $i1)."\t";
}

while($row1 = mysql_fetch_row($resultado1)){
  $line1 = '';
  foreach($row1 as $value1){
    if(!isset($value1) || $value1 == ""){
      $value1 = "\t";
    }else{
# important to escape any quotes to preserve them in the data.
      $value1 = str_replace('"', '""', $value1);
# needed to encapsulate data in quotes because some data might be multi line.
# the good news is that numbers remain numbers in Excel even though quoted.
      $value1 = '"' . $value1 . '"' . "\t";
    }
    $line1 .= $value1;
  }
  $data1 .= trim($line1)."\n";
}
# this line is needed because returns embedded in the data have "\r"
# and this looks like a "box character" in Excel
  $data1 = str_replace("\r", "", $data1);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	


header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=excelfile.xls");
header("Pragma: no-cache");
header("Expires: 0");	
if ($data == "") {
	$data = "\nno matching records found\n";
}else
	echo "RELACION DE DESPACHOS EQUIPOS\n";
	echo $header."\n".$data; 
	echo "\n\n\n\n\n\n";
if ($data1 == "") {
	$data1 = "\nno matching records found\n";
}else
	echo "RELACION DE DESPACHOS COMPONENTES\n";
	echo $header1."\n".$data1; 
	
	
?>
