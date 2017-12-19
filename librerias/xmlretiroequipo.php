<?php
require_once("conexionsql.php");


conectarMysql();
$conDespacho="select * from vistainventarioequipos where configuracion='$_GET[configuracion]'";
$result=mysql_query($conDespacho);
if ($result && mysql_numrows($result)>0) {
	$row=mysql_fetch_array($result);
	$configuracion=$row[0];

	
}
$conComponentesAsociados="select * from vistacomponentesasociadosequipos where configuracion='$configuracion' and status_actual=1 order by descripcion";
//mysql_close();

		$fecha=getdate();
		$fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];
		

//$score = $HTTP_POST_VARS['score'];
// check we have the parameters we need
if( !$configuracion)
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
$filename = '../formularios/retiroEquipo.rtf';
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
$result=mysql_query($conDespacho);
if ($result && mysql_numrows($result)>0) {
	$row=mysql_fetch_array($result);

if ($row[34]==$row[38])
	$unidad=$row[35];
else 
	$unidad="$row[35] / $row[39]";
$output = str_replace( "#NOMBRES#", strtoupper( $row[49].' '.$row[50] ), $output );
$output = str_replace( "#FICHA#", strtoupper( $row[47] ), $output );
$output = str_replace( "#CARGO#", strtoupper( $row[52] ), $output );
$output = str_replace( "#EXT#", strtoupper( $row[53] ), $output );
$output = str_replace( "#GERENCIA#", strtoupper( $unidad ), $output );
$output = str_replace( "#UBICACION#", strtoupper( $row[33] ), $output );
$output = str_replace( "#ACTIVO#", strtoupper( $row[1] ), $output );
$output = str_replace( "#CONF#", strtoupper( $row[0] ), $output );
$output = str_replace( "#DES1#", strtoupper( $row[10] ), $output );
$output = str_replace( "#MARCA1#", strtoupper( $row[13] ), $output );
$output = str_replace( "#MODELO1#", strtoupper( $row[15].' '.$row[16].' '.$row[17] ), $output );
$output = str_replace( "#SERIAL1#", strtoupper( $row[8] ), $output );
$output = str_replace( "#FECHA#", strtoupper( $fecha ), $output );
		
$i=1;
conectarMysql();
$resultComponentes=mysql_query($conComponentesAsociados);
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
	while ($i <= 13) {		
		$output = str_replace( "#DES$i#", strtoupper( '-----------' ), $output );
		$output = str_replace( "#MARCA$i#", strtoupper( '-----------' ), $output );
		$output = str_replace( "#MODELO$i#", strtoupper( '-----------' ), $output );
		$output = str_replace( "#SERIAL$i#", strtoupper( '-----------' ), $output );   
		$i++;
	}

/*$consultaSoftware="Select
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
if ($resultadoSoftware && mysql_numrows($resultadoSoftware)>0) {
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
}
$output = str_replace( "#SO#", strtoupper( $sistemaOperativo ), $output );
$output = str_replace( "#OFIMATICA#", strtoupper( $ofimatica ), $output );
$output = str_replace( "#PRODUCCION#", strtoupper($produccion ), $output );
$output = str_replace( "#ANTIVIRUS#", strtoupper( $Antivirus ), $output );
$output = str_replace( "#OTRAS#", strtoupper( $otras ), $output );
$output = str_replace( "#AVANZADAS#", strtoupper( $avanzadas ), $output );	

	$output = str_replace( "#ANALISTA#", strtoupper( "" ), $output );	
	
*/
echo $output;
} else {
	echo "IMPOSIBLE DESPACHAR ESTE EQUIPO, VERIFIQUE SI TIENE UN USUARIO ASOCIADO Y UNA UBICACION";	
}
}
?>