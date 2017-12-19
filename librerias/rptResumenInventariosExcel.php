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
		
	if ($_GET[red]==100)
		$_GET[red]=""; 
			
	if ($_GET[critico]==100)
		$_GET[critico]=""; 	
		
	if ($_GET[SP]==100)
		$_GET[SP]=""; 
	
	if ($_GET[correctivo]==100)
		$_GET[correctivo]=""; 
		
	if ($_GET[encontrado]==100)
		$_GET[encontrado]=""; 
	
	if ($_GET[uso]==100)
		$_GET[uso]=""; 

	if ($_GET[equipodisponible]==100)
		$_GET[equipodisponible]=""; 
		
	if ($_GET[antivirusActualizado]==100)
		$_GET[antivirusActualizado]=""; 

	if ($_GET[soActualizado]==100)
		$_GET[soActualizado]="";
		
	$rangoFecha="";
	if ((isset($_GET[fechaInicio]) && !empty($_GET[fechaInicio])) && (isset($_GET[fechaFinal]) && !empty($_GET[fechaFinal]))) {
		$FechaInicio=substr($_GET[fechaInicio],6,6)."-".substr($_GET[fechaInicio],3,2)."-".substr($_GET[fechaInicio],0,2);
		$FechaFinal=substr($_GET[fechaFinal],6,6)."-".substr($_GET[fechaFinal],3,2)."-".substr($_GET[fechaFinal],0,2);
		$rangoFecha=" vistaInventarioEquipos.EQUIPO_FECHA_CREACION Between '$FechaInicio' AND '$FechaFinal' AND ";
	}
	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}
	
	$consulta= "SELECT configuracion as CONFIGURACION, activo_fijo as ACTIVO_FIJO, equipo_fecha_creacion, UBICACION_ESPECIFICA, fecha_asociacion as FECHA_ASOCIACION, if(red=1,'NO','SI') AS RED, TEXTO_RED AS DESCRIPCION_RED, if(conectividad_red=1,'NO','SI') AS CONECTIVIDAD, if(critico=0,'NO','SI') AS CRITICO, TEXTO_CRITICO AS DESCRIPCION_CRITICO, if(disponible=0,'SI','NO') AS DISPONIBLE, TEXTO_DISPONIBLE AS DESCRIPCION_DISPONIBLE, if(sistema_operativo=0,'SI','NO') AS SISTEMA_OPERATIVO_ACTUALIZADO, TEXTO_SO AS DESCRIPCION_SISTEMA_OPERATIVO, if(antivirus=0,'SI','NO') AS ANTIVIRUS_ACTUALIZADO, TEXTO_ANTIVIRUS AS DESCRIPCION_ANTIVIRUS, if(usuario_especializado=0,'NO','SI') as USUARIO_ESPECIALIZADO, if(SP=1,'SP1', if(SP=2,'SP2', if(SP=3,'SP3','NO DEFINIDO'))) as SP, if(correctivo=0,'NO','SI') as CORRECTIVO, TEXTO_CORRECTIVO AS DESCRIPCION_CORRECTIVO, if(encontrado=0,'SI','NO') as ENCONTRADO, TEXTO_ENCONTRADO AS DESCRIPCION_ENCONTRADO, if(uso=0,'NO','SI') as SIN_USO, TEXTO_USO AS DESCRIPCION_USO, IP_IMPRESORA AS IP_IMPRESORA, COLA_IMPRESORA AS COLA_IMPRESORA, MAC_IMPRESORA AS MAC_IMPRESORA,TONER_NEGRO_IMPRESORA AS TONER_NEGRO,TONER_MAGENTA_IMPRESORA AS TONER_MAGENTA,TONER_AMARILLO_IMPRESORA AS TONER_AMARILLO, TONER_CYAN_IMPRESORA AS TONER_CYAN,TAMBOR_IMAGEN_IMPRESORA AS TAMBOR_IMAGEN, CANTIDAD_USUARIOS, DISTANCIA_MAXIMA, serial, descripcion, marca, modelo,cap_vel,unidad, fru, product_number, spare_number, ct, id_pedido as PEDIDO, proveedor, fecha_inicio as FECHA_INICIO_GARANTIA, fecha_final as FECHA_FINAL_GARANTIA,fecha_actualizacion,sitio, gerencia, division, departamento, especifico, estado, nombre as NOMBRE_ANALISTA, apellido as APELLIDO_ANALISTA, ficha, cedula, nombre_usuario, apellido_usuario, cargo, extension
	FROM vistaInventarioEquipos
        where
		$rangoFecha
		vistaInventarioEquipos.CONFIGURACION like '%$_GET[txtConfiguracion]'and
		vistaInventarioEquipos.SERIAL like '%$_GET[txtSerial]' and	
		vistaInventarioEquipos.ACTIVO_FIJO like '%$_GET[txtActivoFijo]' and				
		vistaInventarioEquipos.ID_SITIO like '%$_GET[sitio]' and
		vistaInventarioEquipos.ID_GERENCIA like '%$_GET[idGerencia]' and
		vistaInventarioEquipos.ID_DESCRIPCION like '%$_GET[idDescripcion]' and 
		vistaInventarioEquipos.ID_MARCA like '%$_GET[idMarca]' and
		vistaInventarioEquipos.ID_MODELO like '%$_GET[idModelo]' and
		vistaInventarioEquipos.ID_PEDIDO like '%$_GET[idPedido]' and
		vistaInventarioEquipos.ID_ESTADO like '%$_GET[idEstado]' and
		vistaInventarioEquipos.RED like '%$_GET[red]' and
		vistaInventarioEquipos.CRITICO like '%$_GET[critico]' and
		vistaInventarioEquipos.USUARIO_ESPECIALIZADO like '%$_GET[usuarioEspecializado]' and
		vistaInventarioEquipos.SP like '%$_GET[SP]' and
		vistaInventarioEquipos.CORRECTIVO like '%$_GET[correctivo]' and
		vistaInventarioEquipos.ENCONTRADO like '%$_GET[encontrado]' and
		
		vistaInventarioEquipos.USO like '%$_GET[uso]' and
		vistaInventarioEquipos.DISPONIBLE like '%$_GET[equipodisponible]' and
		vistaInventarioEquipos.ANTIVIRUS like '%$_GET[antivirusActualizado]' and
		vistaInventarioEquipos.SISTEMA_OPERATIVO like '%$_GET[soActualizado]' and
		vistaInventarioEquipos.FICHA like '%$_GET[txtFicha]'		
		$orden";
		
	/*$consulta="select configuracion as CONFIGURACION, activo_fijo as ACTIVO_FIJO, equipo_fecha_creacion, UBICACION_ESPECIFICA, fecha_asociacion as FECHA_ASOCIACION, if(red=1,'NO','SI') AS RED, TEXTO_RED AS DESCRIPCION_RED, if(critico=0,'NO','SI') AS CRITICO, TEXTO_CRITICO AS DESCRIPCION_CRITICO, if(disponible=0,'SI','NO') AS DISPONIBLE, TEXTO_DISPONIBLE AS DESCRIPCION_DISPONIBLE, if(sistema_operativo=0,'SI','NO') AS SISTEMA_OPERATIVO_ACTUALIZADO, TEXTO_SO AS DESCRIPCION_SISTEMA_OPERATIVO, if(antivirus=0,'SI','NO') AS ANTIVIRUS_ACTUALIZADO, TEXTO_ANTIVIRUS AS DESCRIPCION_ANTIVIRUS, if(usuario_especializado=0,'NO','SI') as USUARIO_ESPECIALIZADO, if(SP=1,'SP1', if(SP=2,'SP2', if(SP=3,'SP3','NO DEFINIDO'))) as SP, if(correctivo=0,'NO','SI') as CORRECTIVO, TEXTO_CORRECTIVO AS DESCRIPCION_CORRECTIVO, if(encontrado=0,'SI','NO') as ENCONTRADO, TEXTO_ENCONTRADO AS DESCRIPCION_ENCONTRADO, if(uso=0,'NO','SI') as SIN_USO, TEXTO_USO AS DESCRIPCION_USO, IP_IMPRESORA AS IP_IMPRESORA, COLA_IMPRESORA AS COLA_IMPRESORA, MAC_IMPRESORA AS MAC_IMPRESORA,TONER_NEGRO_IMPRESORA AS TONER_NEGRO,TONER_MAGENTA_IMPRESORA AS TONER_MAGENTA,TONER_AMARILLO_IMPRESORA AS TONER_AMARILLO, TONER_CYAN_IMPRESORA AS TONER_CYAN,TAMBOR_IMAGEN_IMPRESORA AS TAMBOR_IMAGEN, CANTIDAD_USUARIOS, DISTANCIA_MAXIMA, serial, descripcion, marca, modelo, cap_vel, unidad, fru, product_number, spare_number, ct, id_pedido as PEDIDO, proveedor, fecha_inicio as FECHA_INICIO_GARANTIA, fecha_final as FECHA_FINAL_GARANTIA,fecha_actualizacion,sitio, gerencia, division, departamento, especifico, estado, nombre as NOMBRE_ANALISTA, apellido as APELLIDO_ANALISTA, ficha, cedula, nombre_usuario, apellido_usuario, cargo, extension 
	from 
	vistaInventarioEquipos
	Where
	$rangoFecha	
	SERIAL LIKE '%$_GET[serial]' AND
	ID_SITIO  Like '%$_GET[sitio]' AND
    ID_GERENCIA Like '%$_GET[idGerencia]' AND
    ID_DESCRIPCION LIKE '%$_GET[idDescripcion]' AND
    ID_Marca Like '%$_GET[idMarca]' AND
    ID_Modelo Like '%$_GET[idModelo]' AND    
    ID_PEDIDO like '%$_GET[idPedido]'  AND
    ID_ESTADO like '%$_GET[idEstado]' AND
    CONFIGURACION like '%$_GET[configuracion]' AND 
    RED  like '%$_GET[red]' AND 
    CRITICO like '%$_GET[critico]' AND
    SP like '%$_GET[SP]' AND  
	CORRECTIVO like '%$_GET[correctivo]' AND 
	ENCONTRADO like '%$_GET[encontrado]' AND	
	USO like '%$_GET[uso]' AND
	DISPONIBLE like '%$_GET[equipodisponible]' AND
	ANTIVIRUS like '%$_GET[antivirusActualizado]' AND
	SISTEMA_OPERATIVO like '%$_GET[soActualizado]' AND
    ACTIVO_FIJO like '%$_GET[activoFijo]'
    $conFicha           
	$orden";*/
	
conectarMysql();
$result = mysql_query($consulta);

mysql_close();
$count = mysql_num_fields($result);

for ($i = 0; $i < $count; $i++){
    $header .= mysql_field_name($result, $i)."\t";
}

while($row = mysql_fetch_row($result)){
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
