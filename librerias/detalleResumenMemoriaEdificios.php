<?php
require_once ("formularios.php");
require_once ("conexionsql.php");
require_once ("inventarioAdmin.php");


	
	
	
		
	
	conectarMysql();
	if(isset($_GET[configuracion]))	{
		$sitio=isset($_GET['sitio'])&&$_GET['sitio']!=100  ? " AND ID_SITIO='".$_GET['sitio']."'" : "";			
		$configuracion=isset($_GET['configuracion'])&&$_GET['configuracion']!=100  ? " AND CONFIGURACION='".$_GET['configuracion']."'" : "";			
		$query="SELECT configuracion,vistacomponentes.* FROM equipo_componente_campo, vistacomponentes
			WHERE equipo_componente_campo.ID_INVENTARIO=vistacomponentes.ID_INVENTARIO
			 AND vistacomponentes.ID_DESCRIPCION='DES0000010' $sitio   $configuracion";
		
		
		
	}
	else{
		$sitio=isset($_GET['sitio'])&&$_GET['sitio']!=100  ? " AND ID_SITIO='".$_GET['sitio']."'" : "";			
		$query="SELECT configuracion AS CONFIGURACION ,vistacomponentes.* FROM equipo_componente_campo, vistacomponentes
			WHERE equipo_componente_campo.ID_INVENTARIO=vistacomponentes.ID_INVENTARIO
			 AND vistacomponentes.ID_DESCRIPCION='DES0000010' $sitio ";
			
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

# This line will stream the file to the user rather than spray it across the screen
header("Content-type: application/octet-stream");

# replace excelfile.xls with whatever you want the filename to default to
header("Content-Disposition: attachment; filename=excelfile.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo $header."\n".$data; 
		
		
	
	 
	
?>

