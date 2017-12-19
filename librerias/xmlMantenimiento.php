<?php
require_once("conexionsql.php");
		$consultaMantenimiento="select *,TIME_TO_SEC(TIMEDIFF(FECHA_FINAL,FECHA_INICIO))/60 AS TIEMPO_EJECUCION from vistamantenimientospreventivos where vistamantenimientospreventivos.ID_MANTENIMIENTO='$_GET[idMantenimiento]'";
conectarMysql();
$result=mysql_query($consultaMantenimiento);
mysql_close();







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
header( 'Content-Disposition: inline, filename=SG-061.xml');
$date = date( 'F d, Y' );
// open our template file
$filename = '../formularios/mantenimientoPreventivo.rtf';
$fp = fopen ( $filename, 'r' );
//read our template into a variable
$output = fread( $fp, filesize( $filename ) );
fclose ( $fp );
// replace the place holders in the template with our data

//	$output = str_replace( '$equivalencia[$i][0]', strtoupper( '$equivalencia[$i][1]' ), $output );
//for($i=0;$i<2;$i++) {
//	$output = str_replace( $equivalencia[$i][0], strtoupper( $equivalencia[$i][1] ), $output );
//}
// send the generated document to the browser
if ($result && mysql_numrows($result)>0) {

	$row=mysql_fetch_array($result);
	$hora=substr($row[33],11,2);
	$minuto=substr($row[33],13,3);
	$min="AM";
	if ($hora>12) {
		$hora=$hora-12;
		$min="PM";
	}
	$HoraInicial=$hora.$minuto.' '.$min;
	
	$hora=substr($row[34],11,2);
	$minuto=substr($row[34],13,3);
	$min="AM";
	if ($hora>12) {
		$hora=$hora-12;
		$min="PM";
	}
	$HoraFinal=$hora.$minuto.' '.$min;
	if($row[36]==1) {
		$so="NO";	
	} else {
		if ($row[7] == 'DES0000008')
			$so="NO";
		else
			$so="SI";
	}
	if($row[37]==1) {
		$antivirus="NO";	
	} else {
		if ($row[7] == 'DES0000008')
			$antivirus="NO";
		else
			$antivirus="SI";
	}
	if($row[3]==1) {
		$red="NO";	
	} else {
		$red="SI";
	}
$fecha=substr($row[33],0,10);
$output = str_replace( "#NOMBRES#", strtoupper( $row[19].' '.$row[20] ), $output );
$output = str_replace( "#FICHA#", strtoupper( $row[18] ), $output );	
$output = str_replace( "#CARGO#", strtoupper( $row[23] ), $output );	
$output = str_replace( "#EXT#", strtoupper( $row[21] ), $output );	
$output = str_replace( "#GERENCIA#", strtoupper( $row[29] ), $output );	
$output = str_replace( "#UBICACION#", strtoupper( $row[31] ), $output );	
$output = str_replace( "#ACTIVO#", strtoupper( $row[2] ), $output );	
$output = str_replace( "#CONF#", strtoupper( $row[1] ), $output );
$output = str_replace( "#HORA_I#", strtoupper( $HoraInicial ), $output );
$output = str_replace( "#HORA_F#", strtoupper( $HoraFinal ), $output );
$output = str_replace( "#TIEMPO_EJECUCION#", strtoupper( abs($row[45]) ), $output );
$output = str_replace( "#DES1#", strtoupper( $row[8] ), $output );
$output = str_replace( "#MARCA1#", strtoupper( $row[10] ), $output );
$output = str_replace( "#MODELO1#", strtoupper( $row[12].' '.$row[13].' '.$row[14] ), $output );
$output = str_replace( "#SERIAL1#", strtoupper( $row[6] ), $output );
$output = str_replace( "#SO_ACTUALIZADO#", strtoupper( $so ), $output );
$output = str_replace( "#ANTIVIRUS_ACTUALIZADO#", strtoupper( $antivirus ), $output );
$output = str_replace( "#RED#", strtoupper( $red ), $output );
$output = str_replace( "#TRABAJO#", strtoupper( $row[38] ), $output );
$output = str_replace( "#OBSERVACION#", strtoupper( $row[39] ), $output );
$output = str_replace( "#CANTIDAD_HOJAS#", strtoupper( $row[42] ), $output );

$output = str_replace( "#HUMEDAD#", strtoupper( "NO" ), $output );
$output = str_replace( "#PARTICULAS#", strtoupper( "NO" ), $output );
$output = str_replace( "#AIRE#", strtoupper( "SI" ), $output );
$output = str_replace( "#FECHA#", strtoupper( $fecha ), $output );
$output = str_replace( "#TECNICO#", strtoupper( $row[16].' '.$row[17] ), $output );
$configuracion=$row[1];
$consultaComponentesAsociados="SELECT * FROM vistacomponentesasociadosequipos where configuracion='$configuracion' and status_actual=1 order by descripcion";



$i++;
conectarMysql();
$resultComponentes=mysql_query($consultaComponentesAsociados);
mysql_close();
if ($resultComponentes && mysql_numrows($resultComponentes)>0) {
	while ($row2=mysql_fetch_array($resultComponentes)) {
		$i++;
		$output = str_replace( "#DES$i#", strtoupper( $row2[5] ), $output );
		$output = str_replace( "#MARCA$i#", strtoupper( $row2[9] ), $output );
		$output = str_replace( "#MODELO$i#", strtoupper( $row2[11].' '.$row2[12].' '.$row2[13] ), $output );
		$output = str_replace( "#SERIAL$i#", strtoupper( $row2[3] ), $output );
	}
}
	while ($i++ <=14) {

		$output = str_replace( "#DES$i#", strtoupper( '-----------' ), $output );
		$output = str_replace( "#MARCA$i#", strtoupper( '-----------' ), $output );
		$output = str_replace( "#MODELO$i#", strtoupper( '-----------' ), $output );
		$output = str_replace( "#SERIAL$i#", strtoupper( '-----------' ), $output );   
	}
	
$consultaSoftware="Select
		equipo_campo_software.CONFIGURACION,
		equipo_campo_software.ID_SOFTWARE,
		software.SOFTWARE,
		software.ID_TIPO_SOFTWARE,
		tipo_software.TIPO_SOFTWARE
		From
		equipo_campo_software
		Inner Join software ON equipo_campo_software.ID_SOFTWARE = software.ID_SOFTWARE
		Inner Join tipo_software ON software.ID_TIPO_SOFTWARE = tipo_software.ID_TIPO_SOFTWARE
		Where
		equipo_campo_software.CONFIGURACION = '$configuracion' order by id_tipo_software";

conectarMysql();
$resultadoSoftware=mysql_query($consultaSoftware);
mysql_close();
	while ($rowSoftware=mysql_fetch_array($resultadoSoftware)) {
		switch ($rowSoftware[3]) {
			case 'ITS0000001':
				$sistemaOperativo=$sistemaOperativo.$rowSoftware[2].' - ';
				break 1;
			case 'ITS0000002':
				$ofimatica=$ofimatica.$rowSoftware[2].' - ';
				break 1;	
			case 'ITS0000003':
				$produccion=$produccion.$rowSoftware[2].' - ';
				break 1;	
			case 'ITS0000004':
				$Antivirus=$Antivirus.$rowSoftware[2].' - ';
				break 1;	
			case 'ITS0000008':
				$otras=$otras.$rowSoftware[2].' - ';
				break 1;	
			case 'ITS0000009':
				$avanzadas=$avanzadas.$rowSoftware[2].' - ';
				break 1;	

		}
	}
$output = str_replace( "#SO#", strtoupper( $sistemaOperativo ), $output );
$output = str_replace( "#OFIMATICA#", strtoupper( $ofimatica ), $output );
$output = str_replace( "#PRODUCCION#", strtoupper( $produccion ), $output );
$output = str_replace( "#ANTIVIRUS#", strtoupper( $Antivirus ), $output );
$output = str_replace( "#OTRAS#", strtoupper( $otras ), $output );
$output = str_replace( "#AVANZADAS#", strtoupper( $avanzadas ), $output );

/*
	while ($row=mysql_fetch_array($result)) {
		$i++;
		//create short variable names
		
		$fecha=getdate();
		$fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];
		
		$output = str_replace( "#SER$i#", strtoupper( $row[2] ), $output );
		$output = str_replace( "#DES$i#", strtoupper( $row[7].','.$row[8].','.$row[6].'.'.$row[11]  ), $output );
		$output = str_replace( "#FECHA#", strtoupper( $fecha ), $output );
		$output = str_replace( "#PROVEEDOR#", strtoupper($row[5] ), $output );
		$output = str_replace( "#CAN$i#", strtoupper('1' ), $output );
		$output = str_replace( "#DIR#", strtoupper($row[16] ), $output );   
		$output = str_replace( "#RE$i#", strtoupper( $i ), $output );       	
     	
	}
	$output = str_replace( "#TOTAL#", strtoupper($i ), $output );
	while ($i++ <=11) {

		$output = str_replace( "#SER$i#", strtoupper( '-----------' ), $output );
		$output = str_replace( "#DES$i#", strtoupper( '-----------' ), $output );
		$output = str_replace( "#CAN$i#", strtoupper( '-' ), $output );
		$output = str_replace( "#RE$i#", strtoupper( '-' ), $output );   
	}
*/		
}

echo $output;
}
?>