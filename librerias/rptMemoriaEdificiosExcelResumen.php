<?php
require_once ("formularios.php");
require_once ("conexionsql.php");
require_once ("inventarioAdmin.php");


	$sitio=isset($_GET['sitio'])&&$_GET['sitio']!=100  ? " AND sitio.ID_SITIO='".$_GET['sitio']."'" : "";
	conectarMysql();
	
	//se obtienen los tecnicos con mantenimientos en el periodo
	
	

		
		
		
		
		
	$query="SELECT CONCAT(modelo.CAP_VEL,' ',modelo.UNIDAD,' ',tipo.TIPO)AS MEMORIAS,COUNT(*) AS 'CANTIDAD DE PASTILLAS',COUNT(*)*MODELO.CAP_VEL AS 'CAPACIDAD DE MEMORIA',
	
	(SELECT COUNT(DISTINCT equipo_componente_campo.CONFIGURACION) FROM 
	inventario, modelo, sitio, inventario_ubicacion,equipo_componente_campo, inventario_propiedad, inventario_estado,usuario_sistema,componente_campo, tipo
	WHERE modelo.ID_MODELO=inventario.ID_MODELO AND
	modelo.id_tipo=tipo.id_tipo AND
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
	modelo.ID_DESCRIPCION='DES0000010' $sitio
	AND CONCAT(modelo.CAP_VEL,' ',modelo.UNIDAD,' ',tipo.TIPO)=MEMORIAS	
	
	
	
	) as 'CANTIDAD DE EQUIPOS'
	
	
	
	
	FROM 
inventario, modelo, sitio, inventario_ubicacion,equipo_componente_campo as eqc, inventario_propiedad, inventario_estado,usuario_sistema,componente_campo, tipo
WHERE modelo.ID_MODELO=inventario.ID_MODELO AND
modelo.id_tipo=tipo.id_tipo AND
inventario_ubicacion.ID_INVENTARIO=inventario.ID_INVENTARIO AND
componente_campo.ID_INVENTARIO=inventario.ID_INVENTARIO AND
inventario_ubicacion.ID_SITIO=sitio.ID_SITIO AND
eqc.ID_INVENTARIO=inventario.ID_INVENTARIO AND
inventario_propiedad.ID_INVENTARIO=inventario.ID_INVENTARIO AND
inventario_estado.ID_ESTADO=inventario_propiedad.ID_ESTADO AND
usuario_sistema.ID_USS=eqc.ID_USS AND
inventario_estado.ESTADO='OPERATIVO'  AND
inventario_ubicacion.STATUS_ACTUAL=1 AND
sitio.SITIO!='OTROS' AND
sitio.SITIO!='DEPOSITO' AND
modelo.ID_DESCRIPCION='DES0000010' $sitio GROUP BY 	CONCAT(modelo.CAP_VEL,' ',modelo.UNIDAD,' ',tipo.TIPO)";	
		
		
set_time_limit(60);

		
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



// This line will stream the file to the user rather than spray it across the screen
header("Content-type: application/octet-stream");

# replace excelfile.xls with whatever you want the filename to default to
header("Content-Disposition: attachment; filename=excelfile.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo $header."\n".$data; 
		
		
	
	
	

		
	 
	
?>
