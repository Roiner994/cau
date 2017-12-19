<?php
require_once ("formularios.php");
require_once ("conexionsql.php");
require_once ("inventarioAdmin.php");


	$sitio=isset($_GET['sitio'])&&$_GET['sitio']!=100  ? " AND ID_SITIO='".$_GET['sitio']."'" : "";	
	
	
		
	if(isset($_GET['anno']))
		$annp=$_GET['anno'];
	
	$anno=isset($_GET['anno'])&&$_GET['anno']!=100 ? "AND YEAR(fecha_inicio)=".$_GET['anno'] : "";
	$sitio.=" AND ID_SITIO NOT IN ('SIT0000057','SIT0000092') AND ID_ESTADO='EST0000001'";
	
	conectarMysql();
	if(isset($_GET['total'])){
		$total=$_GET['total']+0;		
		$pag=$_GET['pag']+0;
		
		$ls=($total+0);
		$li=$ls*$pag-$total;
		if($li<0)
			$li=0;
		
		
		
		if(isset($_GET['inventario'])){
			$query="SELECT * FROM vistainventarioequipos
				WHERE (descripcion = 'MICROCOMPUTADOR' or descripcion = 'IMPRESORA' or descripcion = 'LAPTOP' or descripcion = 'PLOTTER' ) and 
				(configuracion not in (
							select configuracion from vistamantenimientospreventivos
							 WHERE TRUE $anno $sitio
							 ))
	
				GROUP BY configuracion LIMIT $li,$ls";	
		
	}else{	
	//se obtienen los tecnicos con mantenimientos en el periodo
	$query="SELECT cantidad_mantenimientos_anual($annp)";
	$rs=mysql_query($query);
	if($rs){
		$row=mysql_fetch_array($rs);
		$cantidad=$row[0];
		$cantidad=(($cantidad+0)>4 ? 4: $cantidad);
		
			
	}
	
	$query="SELECT * FROM vistainventarioequipos
	WHERE (descripcion = 'MICROCOMPUTADOR' or descripcion = 'IMPRESORA' or descripcion = 'LAPTOP' or descripcion = 'PLOTTER' )  and 
	(configuracion not in (
							select configuracion from vistamantenimientospreventivos AS vmp
							 WHERE TRUE $anno							 
							  AND (($cantidad)>(cantidad_mantenimientos_anual_configuracion($annp,vmp.CONFIGURACION)))
							 ))
	
	GROUP BY configuracion LIMIT $li,$ls";	
	
	}
		
	}else{
	if(isset($_GET['inventario'])){
		$query="SELECT * FROM vistainventarioequipos WHERE ID_INVENTARIO='$_GET[inventario]'";
		
	}else{	
	//se obtienen los tecnicos con mantenimientos en el periodo
	$query="SELECT cantidad_mantenimientos_anual($annp)";
	$rs=mysql_query($query);
	if($rs){
		$row=mysql_fetch_array($rs);
		$cantidad=$row[0];
		$cantidad=(($cantidad+0)>4 ? 4: $cantidad);
		
			
	}
	
	$query="SELECT * FROM vistainventarioequipos
	WHERE (descripcion = 'MICROCOMPUTADOR' or descripcion = 'IMPRESORA' or descripcion = 'LAPTOP' or descripcion = 'PLOTTER' ) $sitio and 
	(configuracion not in (
							select configuracion from vistamantenimientospreventivos AS vmp
							 WHERE TRUE $anno
							 
							  AND (($cantidad)>(cantidad_mantenimientos_anual_configuracion($annp,vmp.CONFIGURACION)))
							 ))
	
	GROUP BY configuracion";	
	
	}
	}
	
	
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

