<?php
//Planilla de Asignacion de Componentes
require_once("conexionsql.php");
		

	$consulta="select * from vistadespachocomponentes
		Where
		ID_DESPACHO = '$idDespacho'";
		
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		
	if ($result && mysql_numrows($result)>0) {
		$row=mysql_fetch_array($result);
		$HelpDesk=$row[5];
		$Configuracion=$row[27];
		$Fecha=$row[6];
		$Fecha=substr($Fecha,8,2)."/".substr($Fecha,5,2)."/".substr($Fecha,0,4);
		$Ficha=$row[26];
	}
		
		
		

	unset($row);

	$conBuscarEquipo="select * from vistainventarioequipos where configuracion='$Configuracion'";
	conectarMysql();
	$result=mysql_query($conBuscarEquipo);
	mysql_close();
	
	if ($result && mysql_numrows($result)>0) {
		$row=mysql_fetch_array($result);
		$Equipo="$row[10] $row[13] $row[15] $row[16] $row[17] $row[8]";
		
		if ($row[33]==$row[37]) {
			$UnidadOrganizativaEquipo="$row[35]";
		} else {
			$UnidadOrganizativaEquipo="$row[35] / $row[39]";
		}
		$Sitio=$row[32];
		
	}
	unset($row);	
	$conBuscarUsuario="select * from vistausuario where ficha='$Ficha'";
	
	conectarMysql();
	$result=mysql_query($conBuscarUsuario);
	mysql_close();

	if ($result && mysql_numrows($result)>0) {
		$row=mysql_fetch_array($result);
		$Usuario="$row[2] $row[3]";
		$Cargo=$row[5];
		$Extension=$row[14];
		if ($row[3]) {
			$UnidadOrganizativaUsuario="$row[7]";
		} else {
			$UnidadOrganizativaUsuario="$row[7] / $row[11]";
		}
		$Sitio=$row[13];
	}

	if (isset($Configuracion) && !empty($Configuracion)) {
		$UnidadOrganizativa=$UnidadOrganizativaEquipo;
	} else {
		$UnidadOrganizativa=$UnidadOrganizativaUsuario;
	}
$Fecha=getdate();
$Fecha=$Fecha[mday]."/".$Fecha[mon]."/".$Fecha[year];

$configuracion='VEM-2142';
$activo_fijo='VEN00004444';

//$score = $HTTP_POST_VARS['score'];
// check we have the parameters we need
if( !$configuracion || !$activo_fijo)
{
echo '<h1>Error:</h1>This page was called incorrectly';
}
else
{
//generate the headers to help a browser choose the correct application
header( 'Content-type: application/msword' );
header( 'Content-Disposition: inline, filename=asignacionComponentes.rtf');
$date = date( 'F d, Y' );
// open our template file
$filename = '../formularios/asignacionComponentes.rtf';
$fp = fopen ( $filename, 'r' );
//read our template into a variable
$output = fread( $fp, filesize( $filename ) );
fclose ( $fp );
	$output = str_replace( "#CONFIGURACION#", strtoupper( $Configuracion ), $output );
	$output = str_replace( "#EQUIPO#", strtoupper( $Equipo ), $output );
	$output = str_replace( "#UNIDAD_ORGANIZATIVA#", strtoupper( $UnidadOrganizativa ), $output );
	$output = str_replace( "#SITIO#", strtoupper( $Sitio ), $output );
	$output = str_replace( "#NOMBRE_USUARIO#", strtoupper( $Usuario ), $output );
	$output = str_replace( "#FICHA#", strtoupper( $Ficha ), $output );
	$output = str_replace( "#CARGO#", strtoupper( $Cargo ), $output );
	$output = str_replace( "#EXTENSION#", strtoupper( $Extension ), $output );

	conectarMysql();
	$result=mysql_query($consulta);
	mysql_close();	
	if ($result && mysql_numrows($result)>0) {
		$row=mysql_fetch_array($result);
		$output = str_replace( "#FECHA#", strtoupper( $Fecha ), $output );
		$output = str_replace( "#ANALISTA#", strtoupper( $row[12].' '.$row[13] ), $output );
		if (isset($HelpDesk) && !empty($HelpDesk))
			$output = str_replace( "#HELP_DESK#", strtoupper( $HelpDesk ), $output );
		else
			$output = str_replace( "#HELP_DESK#", strtoupper( "" ), $output );
	}

	
	if ($result && mysql_numrows($result)>0) {
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
	while ($row=mysql_fetch_array($result)) {
		$i++;
		$output = str_replace( "#DES$i#", strtoupper( $row[19] ), $output );
		$output = str_replace( "#MARCA$i#", strtoupper( $row[21] ), $output );
		$output = str_replace( "#MODELO$i#", strtoupper( $row[23].' '.$row[24].' '.$row[25] ), $output );
		$output = str_replace( "#SERIAL$i#", strtoupper( $row[17] ), $output );
	}
}
	while ($i++ <=12) {

		$output = str_replace( "#DES$i#", strtoupper( '-----------' ), $output );
		$output = str_replace( "#MARCA$i#", strtoupper( '-----------' ), $output );
		$output = str_replace( "#MODELO$i#", strtoupper( '-----------' ), $output );
		$output = str_replace( "#SERIAL$i#", strtoupper( '-----------' ), $output );   
	}
echo $output;			
}	
?>