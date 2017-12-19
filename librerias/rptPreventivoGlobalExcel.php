<?php
require_once("mantenimientoAdmin.php");
require_once("conexionsql.php");

//	$mantenimiento= new mantenimiento();
	$campos="SITIO";
	$suma="";
	
		
	$anno=isset($_GET['anno'])&&$_GET['anno']!=100 ? " WHERE ANNO=".$_GET['anno'] : "";
	
		
		
	if ($_GET['mes']==100){
		$campos.=", ENERO,FEBRERO,MARZO,ABRIL,MAYO,JUNIO,JULIO,AGOSTO,SEPTIEMBRE,OCTUBRE,NOVIEMBRE,DICIEMBRE ";
		$suma.=", ENERO+FEBRERO+MARZO+ABRIL+MAYO+JUNIO+JULIO+AGOSTO+SEPTIEMBRE+OCTUBRE+NOVIEMBRE+DICIEMBRE AS TOTAL";
	}else{
				switch($_GET['mes']){
			case "1":
					$campos.=", ENERO ";
					break 1;
			case "2":
					$campos.=", FEBRERO ";
					break 1;
			case "3":
					$campos.=", MARZO ";
					break 1;
			case "4":
					$campos.=", ABRIL ";
					break 1;
			case "5":
					$campos.=", MAYO ";
					break 1;
			case "6":
					$campos.=", JUNIO ";
					break 1;
			case "7":
					$campos.=", JULIO ";
					break 1;
			case "8":
					$campos.=", AGOSTO ";
					break 1;
			case "9":
					$campos.=", SEPTIEMBRE ";
					break 1;					
			case "10":
					$campos.=", OCTUBRE ";
					break 1;
			case "11":
					$campos.=", NOVIEMBRE ";
					break 1;					
			case "12":
					$campos.=", DICIEMBRE ";
					break 1;					
		}
	}
		
		
		
	
	$vistaNOINTRUSIVA="(SELECT  sitio.SITIO,    
        
        COUNT(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 1 THEN 1                           
            END        
        )AS ENERO,
        
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 2 THEN 1           
                ELSE 0
            END        
        )AS FEBRERO,
        
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 3 THEN 1           
                ELSE 0
            END        
        )AS MARZO,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 4 THEN 1           
                ELSE 0
            END        
        )AS ABRIL,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 5 THEN 1           
                ELSE 0
            END        
        )AS MAYO,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 6 THEN 1           
                ELSE 0
            END        
        )AS JUNIO,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 7 THEN 1           
                ELSE 0
            END        
        )AS JULIO,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 8 THEN 1           
                ELSE 0
            END        
        )AS AGOSTO,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 9 THEN 1           
                ELSE 0
            END        
        )AS SEPTIEMBRE,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 10 THEN 1           
                ELSE 0
            END        
        )AS OCTUBRE,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 11 THEN 1           
                ELSE 0
            END        
        )AS NOVIEMBRE,
        
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 12 THEN 1           
                ELSE 0
            END        
        )AS DICIEMBRE,
        YEAR(DATE(mantenimiento_preventivo.HORA_INICIO)) AS ANNO
        
        




FROM sitio, mantenimiento_preventivo
WHERE sitio.ID_SITIO=mantenimiento_preventivo.ID_SITIO
GROUP BY sitio.SITIO".(empty($anno)? "": ",YEAR(DATE(mantenimiento_preventivo.HORA_INICIO))").
	
	
	"
	) temporal ";

$query="SELECT $campos $suma FROM $vistaNOINTRUSIVA $anno";
	
conectarMysql();
$resultado = mysql_query($query);
mysql_close();
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
