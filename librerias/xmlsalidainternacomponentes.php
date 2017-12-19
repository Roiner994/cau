<?php
require_once("conexionsql.php");


conectarMysql();
$conDespacho="select * from vistadespachocomponentes where id_despacho='$_GET[idDespacho]'";
$result=mysql_query($conDespacho);
mysql_close();

		$fecha=getdate();
		switch ($fecha[mon]) {
			case '01':
				$mes="ENERO";
			break 1;
			case '02':
				$mes="FEBRERO";
			break 1;
			case '03':
				$mes="MARZO";
			break 1;
			case '04':
				$mes="ABRIL";
			break 1;
			case '05':
				$mes="MAYO";
			break 1;
			case '06':
				$mes="JUNIO";
			break 1;
			case '07':
				$mes="JULIO";
			break 1;
			case '08':
				$mes="AGOSTO";
			break 1;
			case '09':
				$mes="SEPTIEMBRE";
			break 1;
			case '10':
				$mes="OCTUBRE";
			break 1;
			case '11':
				$mes="NOVIEMBRE";
			break 1;
			case '12':
				$mes="DICIEMBRE";
			break 1;
			
		}
		$fecha=$fecha[mday]." de ".$mes." de ".$fecha[year];

		




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
$filename = '../formularios/salidainterna.rtf';
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
conectarMysql();
$resultComponentes=mysql_query($conDespacho);
mysql_close();
if ($resultComponentes && mysql_numrows($resultComponentes)>0) {
	$output = str_replace( "#FECHA#", strtoupper( $fecha ), $output );
	while ($row2=mysql_fetch_array($resultComponentes)) {
		$i++;
		$output = str_replace( "#DES$i#", strtoupper( $row2[19] ), $output );
		$output = str_replace( "#MARCA$i#", strtoupper( $row2[21] ), $output );
		$output = str_replace( "#MODELO$i#", strtoupper( $row2[23].' '.$row2[24].' '.$row2[25] ), $output );
		$output = str_replace( "#SERIAL$i#", strtoupper( $row2[17] ), $output );
    	$output = str_replace( "#SITIO_ENTREGA#", strtoupper( $row2[35] ), $output );
	}

	while ($i++ <=12) {

		$output = str_replace( "#DES$i#", strtoupper( '-----------' ), $output );
		$output = str_replace( "#MARCA$i#", strtoupper( '-----------' ), $output );
		$output = str_replace( "#MODELO$i#", strtoupper( '-----------' ), $output );
		$output = str_replace( "#SERIAL$i#", strtoupper( '-----------' ), $output );   
	}


	

echo $output;
} else {
	echo "<br>ERROR AL GENERAR LA PLANILLA<BR>";
}
}
?>