<?php
require_once "conexionsql.php";
require_once "administracion.php";
require_once "usuarioAdmin.php";
require_once "formularios.php";
conectarMySql();

	$rangoFecha="";
	if ((isset($_GET['fechaInicio']) && !empty($_GET['fechaInicio'])) && (isset($_GET['fechaFinal']) && !empty($_GET['fechaFinal']))) {
		$FechaInicio=substr($_GET['fechaInicio'],6,6)."-".substr($_GET['fechaInicio'],3,2)."-".substr($_GET['fechaInicio'],0,2);
		$FechaFinal=substr($_GET['fechaFinal'],6,6)."-".substr($_GET['fechaFinal'],3,2)."-".substr($_GET['fechaFinal'],0,2);
		$rangoFecha=" AND vistainventarioequipos.FECHA_INICIO Between '$FechaInicio' AND '$FechaFinal'";
	}

$query="SELECT CONFIGURACION,DESCRIPCION,MARCA, MODELO, SERIAL, DATE(FECHA_ASOCIACION) AS 'FECHA DE ASOCIACION',DATEDIFF(CURDATE(),pedido.FECHAI_GARANTIA) AS ANTIGUEDAD FROM vistainventarioequipos,pedido 
WHERE vistainventarioequipos.ID_PEDIDO=pedido.ID_PEDIDO AND vistainventarioequipos.FICHA LIKE '%$_GET[txtFicha]' $rangoFecha ";

$resultadoequipos=mysql_query($query);
$count = mysql_num_fields($resultadoequipos);

//echo $query;
	$header="EQUIPOS Y COMPONENTES ASOCIADOS\t\n";
for ($i = 0; $i < $count; $i++){
    $header .= mysql_field_name($resultadoequipos, $i)."\t";
}


while($rowequipos=mysql_fetch_array($resultadoequipos)){	
	$query="SELECT vistacomponentesasociadosequipos.DESCRIPCION,vistacomponentesasociadosequipos.MARCA,
	        vistacomponentesasociadosequipos.MODELO, vistacomponentesasociadosequipos.SERIAL,DATE(vistacomponentesasociadosequipos.FECHA_ASOCIACION) AS 'FECHA DE ASOCIACION',
	        DATEDIFF(CURDATE(),pedido.FECHAI_GARANTIA) AS ANTIGUEDAD
	        FROM vistacomponentesasociadosequipos,inventario,pedido WHERE 
			inventario.ID_INVENTARIO=vistacomponentesasociadosequipos.ID_INVENTARIO AND
			inventario.ID_PEDIDO=pedido.ID_PEDIDO AND configuracion='".$rowequipos[0]."' 
			AND vistacomponentesasociadosequipos.STATUS_ACTUAL='1'
			";
	$resultadocomponentes=mysql_query($query);
	
	$SW=0;
	
	IF(mysql_num_rows($resultadocomponentes)>0){
	while($rowcomponentes=mysql_fetch_array($resultadocomponentes)){
		set_time_limit(20);
		if($SW==0){
			$line='';
			for($w = 0; $w < $count; $w++){
				$value= $rowequipos[$w];
				if(!isset($value) || $value == ""){
					$value = "\t";
				}else{
					$value = str_replace('"', '""', $value);
					$value = '"' . $value . '"' . "\t";
				}      
    
				$line .= $value;				
			}
			$data .= trim($line)."\n";            
			

		}
		
		$SW+=1;
		
		//for($i=0;$i!=$count;$i++){
			$line="";
			for($w = 0; $w < $count-1; $w++){
				$value= $rowcomponentes[$w];
				if(!isset($value) || $value == ""){
					$value = "\t";
				}else{
					$value = str_replace('"', '""', $value);
					$value = '"' . $value . '"' . "\t";
				}      
    
				$line .= $value;
				
			}	
			$data .= "\t".trim($line)."\n";            
		//}
//		echo "<br>";
		
			
			
		
	}
	}else{
		
		$line='';
			for($w = 0; $w < $count; $w++){
				$value= $rowequipos[$w];
				if(!isset($value) || $value == ""){
					$value = "\t";
				}else{
					$value = str_replace('"', '""', $value);
					$value = '"' . $value . '"' . "\t";
				}      
    
				$line .= $value;				
			}
			$data .= trim($line)."\n";   
			
	}	
}


$rangoFecha="";
if ((isset($_GET['fechaInicio']) && !empty($_GET['fechaInicio'])) && (isset($_GET['fechaFinal']) && !empty($_GET['fechaFinal']))) {
		$FechaInicio=substr($_GET['fechaInicio'],6,6)."-".substr($_GET['fechaInicio'],3,2)."-".substr($_GET['fechaInicio'],0,2);
		$FechaFinal=substr($_GET['fechaFinal'],6,6)."-".substr($_GET['fechaFinal'],3,2)."-".substr($_GET['fechaFinal'],0,2);
		$rangoFecha=" AND vistacomponentes.FECHA_INICIO Between '$FechaInicio' AND '$FechaFinal'";
	}

$query="SELECT vistacomponentes.DESCRIPCION,vistacomponentes.MARCA,
	        vistacomponentes.MODELO, vistacomponentes.SERIAL,DATE(vistacomponentes.FECHA_ASOCIACION) AS 'FECHA DE ASOCIACION',
	        DATEDIFF(CURDATE(),pedido.FECHAI_GARANTIA) AS ANTIGUEDAD
FROM vistacomponentes, pedido  WHERE vistacomponentes.FICHA LIKE '%".$_GET['txtFicha']."' AND
vistacomponentes.STATUS_ACTUAL='1' AND

pedido.ID_PEDIDO=vistacomponentes.ID_PEDIDO AND
ID_INVENTARIO NOT IN(SELECT vistacomponentesasociadosequipos.ID_INVENTARIO
      FROM vistacomponentesasociadosequipos, vistainventarioequipos WHERE
      vistainventarioequipos.FICHA LIKE  '%".$_GET['txtFicha']."' AND
      vistacomponentesasociadosequipos.CONFIGURACION=vistainventarioequipos.CONFIGURACION AND
			vistacomponentesasociadosequipos.STATUS_ACTUAL='1'
)

	$rangoFecha

";
set_time_limit(60);
$resultadocomponentes=mysql_query($query);
IF(mysql_num_rows($resultadocomponentes)>0){
	$data .= "COMPONENTES NO ASOCIADOS A EQUIPOS\n";
	$data.='"' . "DESCRIPCION" . '"' . "\t".'"' . "MARCA" . '"' . "\t".'"' . "MODELO" . '"' . "\t".'"' . "SERIAL" . '"' . "\t".'"' . "FECHA DE ASOCIACION" . '"' . "\t".'"' . "ANTIGUEDAD" . '"' . "\t\n";
	while($rowcomponentes=mysql_fetch_array($resultadocomponentes)){
		set_time_limit(20);
		
			$line='';
			for($w = 0; $w < $count; $w++){
				$value= $rowcomponentes[$w];
				if(!isset($value) || $value == ""){
					$value = "\t";
				}else{
					$value = str_replace('"', '""', $value);
					$value = '"' . $value . '"' . "\t";
				}      
    
				$line .= $value;				
			}
			$data .= trim($line)."\n";
			
	}
	
}









$data = str_replace("\r", "", $data);
if ($data == "") {
  $data = "\nno matching records found\n";
}


header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=excelfile.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo $header."\n".$data; 
?>
