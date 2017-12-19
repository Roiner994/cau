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
	
    
	$consulta="SELECT vistacomponentes.DESCRIPCION, vistacomponentes.ESTADO, vistacomponentes.GERENCIA, vistacomponentes.DIVISION,
	vistacomponentes.SITIO, vistacomponentes.MARCA, vistacomponentes.MODELO, vistacomponentes.SERIAL , vistacomponentes.ID_ESTADO,
	DATEDIFF(CURDATE(),pedido.FECHAI_GARANTIA),DATEDIFF(vistacomponentes.ESTADO_FECHA_ASOCIACION,pedido.FECHAI_GARANTIA)
    FROM pedido,vistacomponentes
	Where	
	$rangoFecha	
	SERIAL LIKE '%$_GET[serial]' AND
    ID_GERENCIA Like '%$_GET[idGerencia]' AND
    ID_DESCRIPCION LIKE '%$_GET[idDescripcion]' AND
    ID_Marca Like '%$_GET[idMarca]' AND
    ID_Modelo Like '%$_GET[idModelo]' AND
    pedido.ID_PEDIDO like '%$_GET[idPedido]'  AND
    ID_ESTADO like '%$_GET[idEstado]'    
    $consitio
    AND vistacomponentes.FICHA LIKE '%$txtFicha'
     AND pedido.ID_PEDIDO=vistacomponentes.ID_PEDIDO 
	$orden";     
    
    
	conectarMysql();
$result = mysql_query($consulta);
mysql_close();
$count = mysql_num_fields($result)-3;

for ($i = 0; $i < $count; $i++){
    $header .= mysql_field_name($result, $i)."\t";
}
$header .= "TIEMPO OPERACION"."\t";
$header .= "TIEMPO VIDA UTIL"."\t";
$header .= "TIEMPO INOPERATIVO"."\t";

while($row = mysql_fetch_row($result)){
  $line = '';
  
  
  for($w = 0; $w < 8; $w++){
	$value= $row[$w];
    if(!isset($value) || $value == ""){
      $value = "\t";
    }else{
      $value = str_replace('"', '""', $value);
      $value = '"' . $value . '"' . "\t";
    }
    
    //SE DETERMINA EL  TIPO DE ESTADO  DEL COMPONENTE
    
    
    
    
    
    
    
    //INICIO DE NUEVE FILA
    $line .= $value;
    
        
  }
	$value=$row[8];
	
	
	if($value=='EST0000001'||$value=='EST0000007'){
			$value1=$row[9];
			if(!isset($value1) || $value1 == ""){
				$value1 = "\t";
			}else{
				$value1 = str_replace('"', '""', $value1);
				$value1 = '"' . $value1 . '"' . "\t";
				$line .= $value1.'"' . '"' . "\t".'"' . '"' . "\t";
				
			}
			
	}else{
		
		if($value=='EST0000008'||$value=='EST0000002'){
			$antes=$row[9]+0;
			$despues=$row[10]+0;
			$value1=$antes-$despues;
			
			
			if(!isset($value1) || $value1 == ""){
				$value1 = "\t";
			}else{
				$value1 = str_replace('"', '""', $value1);								
				$value1 = '"' . $value1 . '"' . "\t";
				$line .= '"' . '"' . "\t".'"' . '"' . "\t".$value1;
			}
			
			
		}else{
		
			$value1=$row[10];
			if(!isset($value1) || $value1 == ""){
				$value1 = "\t";
			}else{
				$value1 = str_replace('"', '""', $value1);								
				$value1 = '"' . $value1 . '"' . "\t";
				$line .= '"' . '"' . "\t".$value1;
			}
			
		}
			
		
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
		
