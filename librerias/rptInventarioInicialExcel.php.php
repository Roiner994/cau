<?php
require_once ("formularios.php");
require_once ("conexionsql.php");
require_once ("inventarioAdmin.php");


	$sitio=isset($_GET['sitio'])&&$_GET['sitio']!=100  ? " AND ID_SITIO='".$_GET['sitio']."'" : "";
	
	$mes=isset($_GET['mes'])&&$_GET['mes']!=100 ? " AND MONTH(fecha_inicio)=".$_GET['mes'] : "";	
	
	$anno=isset($_GET['anno'])&&$_GET['anno']!=100 ? "AND YEAR(fecha_inicio)<=".$_GET['anno'] : "";
	
	
	conectarMysql();
	
	//se obtienen los tecnicos con mantenimientos en el periodo
	
	
	$query="SELECT descripcion FROM vistainventarioequipos
	WHERE (descripcion = 'MICROCOMPUTADOR' or descripcion = 'IMPRESORA' or descripcion = 'LAPTOP' or descripcion = 'PLOTTER' )	
	 $sitio $anno
	GROUP BY descripcion";	
	
	//echo $query;
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
					CASE (descripcion)
					WHEN '$tid[$i]' THEN 1                           
					END        
					)AS `$tid[$i]` ";
		$total.="+COUNT(
					CASE (descripcion)
					WHEN '$tid[$i]' THEN 1                           
					END        
					)";
	}
	
	if(!empty($tecnicos)){
	$query="SELECT SITIO, GERENCIA, CONFIGURACION ".$tecnicos."".$total."AS TOTAL".  
	"
	FROM vistainventarioequipos
	WHERE (descripcion = 'MICROCOMPUTADOR' or descripcion = 'IMPRESORA' or descripcion = 'LAPTOP' or descripcion = 'PLOTTER' ) 	
	 $sitio $anno
	GROUP BY SITIO, GERENCIA, CONFIGURACION";	
		
	
		$resultado = mysql_query($query);
//mysql_close();
$count = mysql_num_fields($resultado);

for ($i = 0; $i < $count; $i++){
    $header .= mysql_field_name($resultado, $i)."\t";
}

while($row = mysql_fetch_row($resultado)){
	$ba=0;
  $line = '';
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
		
		
	}
	 
	
?>
