<?php
require_once ("formularios.php");
require_once ("conexionsql.php");
require_once ("inventarioAdmin.php");


	$sitio=isset($_GET['sitio'])&&$_GET['sitio']!=100  ? " AND mantenimiento_preventivo.ID_SITIO='".$_GET['sitio']."'" : "";
	
	$mes=isset($_GET['mes'])&&$_GET['mes']!=100 ? " AND MONTH(mantenimiento_preventivo.HORA_INICIO)=".$_GET['mes'] : "";	
	
	$anno=isset($_GET['anno'])&&$_GET['anno']!=100 ? "AND YEAR(mantenimiento_preventivo.HORA_INICIO)=".$_GET['anno'] : "";
	
	
	conectarMysql();
	
	//se obtienen los tecnicos con mantenimientos en el periodo
	$query="SELECT usuario_sistema.NOMBRE ,usuario_sistema.ID_USS
		FROM usuario_sistema,mantenimiento_preventivo
		WHERE usuario_sistema.ID_USS=mantenimiento_preventivo.ID_USS
		 $sitio $mes $anno
		GROUP BY usuario_sistema.ID_USS";		
		
	$query="SELECT modelo.CAP_VEL FROM 
inventario, modelo, sitio, inventario_ubicacion,equipo_componente_campo, inventario_propiedad, inventario_estado,usuario_sistema,componente_campo
WHERE modelo.ID_MODELO=inventario.ID_MODELO AND
inventario_ubicacion.ID_INVENTARIO=inventario.ID_INVENTARIO AND
componente_campo.ID_INVENTARIO=inventario.ID_INVENTARIO AND
inventario_ubicacion.ID_SITIO=sitio.ID_SITIO AND
equipo_componente_campo.ID_INVENTARIO=inventario.ID_INVENTARIO AND
inventario_propiedad.ID_INVENTARIO=inventario.ID_INVENTARIO AND
inventario_estado.ID_ESTADO=inventario_propiedad.ID_ESTADO AND
usuario_sistema.ID_USS=equipo_componente_campo.ID_USS AND
inventario_estado.ESTADO='OPERATIVO'  AND
inventario_ubicacion.STATUS_ACTUAL=1 AND
sitio.SITIO!='OTROS' AND
sitio.SITIO!='DEPOSITO' AND
modelo.ID_DESCRIPCION='DES0000010'
GROUP BY modelo.CAP_VEL
";
	$rs=mysql_query($query);
	
	if($rs&&mysql_num_rows($rs)>0){
		$nt=mysql_num_rows($rs);
		
		while($row=mysql_fetch_array($rs)){			
			$tid[]=$row[1];					
			$tn[]=$row[0];					
		}
	}
	$tecnicos="";
	$lm=count($tid);
	$total=" ,0";
	
	for($i=0;$i!=$lm;$i++){
		$tecnicos.=" , COUNT(
					CASE (usuario_sistema.ID_USS)
					WHEN '$tid[$i]' THEN 1                           
					END        
					)AS `$tn[$i]` ";
		$total.="+COUNT(
					CASE (usuario_sistema.ID_USS)
					WHEN '$tid[$i]' THEN 1                           
					END        
					)";
	}
	
	if(!empty($tecnicos)){
	$query="SELECT DAY(mantenimiento_preventivo.HORA_INICIO) AS DIA".$tecnicos."".$total."AS TOTAL".  
	"
		FROM usuario_sistema,mantenimiento_preventivo
		WHERE usuario_sistema.ID_USS=mantenimiento_preventivo.ID_USS
		 $sitio $mes $anno
		GROUP BY DIA";	
		
		
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
		
		
	}
		
		
	 
	
?>
