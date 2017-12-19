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
		$fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];
		




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
$filename = '../formularios/salida.rtf';
$fp = fopen ( $filename, 'r' );
//read our template into a variable
$output = fread( $fp, filesize( $filename ) );
fclose ( $fp );

// send the generated document to the browser

if ($result && mysql_numrows($result)>0) {
$row=mysql_fetch_array($result);

if ($row[28]==$row[32])
	$unidad=$row[29];
else 
	$unidad="$row[38] / $row[42]";
$output = str_replace( "#PROVEEDOR#", strtoupper( $row[29] ), $output );
$output = str_replace( "#DIR#", strtoupper( $row[35] ), $output );
$output = str_replace( "#FECHA#", strtoupper( $fecha ), $output );

conectarMysql();
$resultComponentes=mysql_query($conDespacho);
mysql_close();
if ($resultComponentes && mysql_numrows($resultComponentes)>0) {
	while ($row2=mysql_fetch_array($resultComponentes)) {
		$i++;
		$output = str_replace( "#RE$i#", strtoupper( $i ), $output ); 
		$output = str_replace( "#DES$i#", strtoupper( $row2[19].' '.$row2[21].' '.$row2[23].' '.$row2[24].' '.$row2[25] ), $output );
		$output = str_replace( "#SER$i#", strtoupper( $row2[17] ), $output );
		$output = str_replace( "#CAN$i#", strtoupper('1' ), $output );
	}
}
	$output = str_replace( "#TOTAL#", strtoupper($i ), $output );
	while ($i++ <=12) {
		$output = str_replace( "#RE$i#", strtoupper( $i ), $output ); 
		$output = str_replace( "#DES$i#", strtoupper( '-----------' ), $output );
		$output = str_replace( "#MARCA$i#", strtoupper( '-----------' ), $output );
		$output = str_replace( "#MODELO$i#", strtoupper( '-----------' ), $output );
		$output = str_replace( "#SER$i#", strtoupper( '-----------' ), $output );
		$output = str_replace( "#CAN$i#", strtoupper('0' ), $output );
	}

	$output = str_replace( "#ANALISTA#", strtoupper( $row[2].' '.$row[3] ), $output );	
	

echo $output;
} else {
	echo "IMPOSIBLE DESPACHAR ESTE EQUIPO, VERIFIQUE SI TIENE UN USUARIO ASOCIADO Y UNA UBICACION";	
}
}
?>