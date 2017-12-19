<?php
require_once ("formularios.php");
require_once ("conexionsql.php");
require_once ("inventarioAdmin.php");
			if(!empty($_GET['inicial'])){
				$fecha1=split("/",$_GET['inicial']);
				$fecha1=$fecha1[2]."-".$fecha1[1]."-".$fecha1[0];
				$fecha1=" AND DATE(mantenimiento_preventivo.HORA_INICIO) >= '$fecha1'";
			}
			if(!empty($_GET['final'])){
				$fecha2=split("/",$_GET['final']);
				$fecha2=$fecha2[2]."-".$fecha2[1]."-".$fecha2[0];
				$fecha2=" AND DATE(mantenimiento_preventivo.HORA_INICIO) <= '$fecha2'";
			}
	
	$sitio=isset($_GET['sitio'])&&$_GET['sitio']!=100  ? " AND sitio.ID_SITIO='".$_GET['sitio']."'" : "";
	
	
	
	
	
	
	
	
	
	conectarMysql();
	
	//se obtienen los tecnicos con mantenimientos en el periodo
	
	$query="Select			
			equipo_campo.CONFIGURACION,
			
			
			
			descripcion.DESCRIPCION,
			
			
			
			marca.MARCA,
			

			
			CONCAT(modelo.MODELO,' ',modelo.CAP_VEL,' ',modelo.UNIDAD) AS MODELO		
			

			From
			equipo_campo		
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
			Inner Join inventario_ubicacion ON inventario_ubicacion.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join sitio ON inventario_ubicacion.ID_SITIO = sitio.ID_SITIO
			Inner Join mantenimiento_preventivo ON (equipo_campo.CONFIGURACION=mantenimiento_preventivo.CONFIGURACION AND mantenimiento_preventivo.ID_SITIO=sitio.ID_SITIO)						
			Inner Join detalle_mantenimiento_preventivo ON (detalle_mantenimiento_preventivo.ID_MANTENIMIENTO_PREVENTIVO=mantenimiento_preventivo.ID_MANTENIMIENTO)			
			Where
			inventario_ubicacion.STATUS_ACTUAL = '1' ".$fecha1." ".$fecha2.
			" $sitio 
			and mantenimiento_preventivo.STATUS_MANTENIMIENTO='2'
			and descripcion.id_descripcion in ('DES0000001','DES0000008','DES0000042') 			
			and mantenimiento_preventivo.HORA_INICIO IN (SELECT MAX(mp.HORA_INICIO) FROM mantenimiento_preventivo as mp WHERE mp.CONFIGURACION=equipo_campo.CONFIGURACION)
			order by descripcion.descripcion, equipo_campo.configuracion";
	
	
		
		
		$resultado = mysql_query($query);
		if(!mysql_num_rows($resultado)>0)
			exit(0);
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
