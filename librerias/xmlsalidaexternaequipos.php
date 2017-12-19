<?php
require_once("conexionsql.php");


conectarMysql();
$conDespacho="select * from vistadespachoequipos where id_despacho='$_GET[idDespacho]'";
$result=mysql_query($conDespacho);
if ($result && mysql_numrows($result)>0) {
	$row=mysql_fetch_array($result);
	$configuracion=$row[13];
	switch ($row[46]) {
		case 'DEE0000002':
			$tipoAsignacion="ASIGNACION";
		break 1;

		case 'DEE0000004':
			$tipoAsignacion="PRESTAMO";
		break 1;
			
		case 'DEE0000005':
			$tipoAsignacion="REEMPLAZO";
		break 1;
	}
	
}
$conComponentesAsociados="select * from vistacomponentesasociadosequipos where configuracion='$configuracion' and status_actual=1 and id_descripcion in ('DES0000002','DES0000003','DES0000007','DES0000019','DES0000022')";
//mysql_close();

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
// replace the place holders in the template with our data

//	$output = str_replace( '$equivalencia[$i][0]', strtoupper( '$equivalencia[$i][1]' ), $output );
//for($i=0;$i<2;$i++) {
//	$output = str_replace( $equivalencia[$i][0], strtoupper( $equivalencia[$i][1] ), $output );
//}
// send the generated document to the browser
$result=mysql_query($conDespacho);
if ($result && mysql_numrows($result)>0) {
$row=mysql_fetch_array($result);

if ($row[37]==$row[41])
	$unidad=$row[38];
else 
	$unidad="$row[38] / $row[42]";
$output = str_replace( "#NOMBRES#", strtoupper( $row[7].' '.$row[8] ), $output );
$output = str_replace( "#FICHA#", strtoupper( $row[6] ), $output );
$output = str_replace( "#CARGO#", strtoupper( $row[10] ), $output );
$output = str_replace( "#EXT#", strtoupper( $row[11] ), $output );
$output = str_replace( "#PROVEEDOR#", strtoupper( $row[38] ), $output );
$output = str_replace( "#DIR#", strtoupper( $row[36] ), $output );
$output = str_replace( "#ACTIVO#", strtoupper( $row[14] ), $output );
$output = str_replace( "#CONFIGURACION1#", strtoupper( $row[13] ), $output );
$output = str_replace( "#CONF_ANTERIOR#", strtoupper( $row[24] ), $output );
$output = str_replace( "#TIPO_ASIGNACION#", strtoupper( $tipoAsignacion ), $output );
$output = str_replace( "#DES1#", strtoupper( $row[17].' '.$row[19].' '.$row[21].' '.$row[22].' '.$row[23] ), $output );
$output = str_replace( "#MARCA1#", strtoupper( $row[19] ), $output );
$output = str_replace( "#MODELO1#", strtoupper( $row[21].' '.$row[22].' '.$row[23] ), $output );
$output = str_replace( "#SER1#", strtoupper( $row[15] ), $output );
$output = str_replace( "#FECHA#", strtoupper( $fecha ), $output );
$output = str_replace( "#RE1#", strtoupper( 1 ), $output ); 	
$output = str_replace( "#CAN1#", strtoupper('1' ), $output );

$i++;
conectarMysql();
$resultComponentes=mysql_query($conComponentesAsociados);
mysql_close();
if ($resultComponentes && mysql_numrows($resultComponentes)>0) {
	while ($row2=mysql_fetch_array($resultComponentes)) {
		$i++;
		$output = str_replace( "#RE$i#", strtoupper( $i ), $output ); 
		$output = str_replace( "#DES$i#", strtoupper( $row2[5].' '.$row2[9].' '.$row2[11].' '.$row2[12].' '.$row2[13] ), $output );
		$output = str_replace( "#MARCA$i#", strtoupper( $row2[9] ), $output );
		$output = str_replace( "#MODELO$i#", strtoupper( $row2[11].' '.$row2[12].' '.$row2[13] ), $output );
		$output = str_replace( "#SER$i#", strtoupper( $row2[3] ), $output );
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


$output = str_replace( "#SO#", strtoupper( $sistemaOperativo ), $output );
$output = str_replace( "#OFIMATICA#", strtoupper( $ofimatica ), $output );
$output = str_replace( "#PRODUCCION#", strtoupper($produccion ), $output );
$output = str_replace( "#ANTIVIRUS#", strtoupper( $Antivirus ), $output );
$output = str_replace( "#OTRAS#", strtoupper( $otras ), $output );
$output = str_replace( "#AVANZADAS#", strtoupper( $avanzadas ), $output );	

	$output = str_replace( "#ANALISTA#", strtoupper( $row[2].' '.$row[3] ), $output );	
	

echo $output;
} else {
	echo "IMPOSIBLE DESPACHAR ESTE EQUIPO, VERIFIQUE SI TIENE UN USUARIO ASOCIADO Y UNA UBICACION";	
}
}
?>