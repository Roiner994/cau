<?php
require_once("conexionsql.php");

$valores=str_replace("\\","",$valores);

$consulta="Select
			garantia.ID_GARANTIA,
			garantia.ID_INVENTARIO,
			garantia.FECHA_ASOCIACION,
			detalle_garantia.ID_GARANTIA,
			detalle_garantia.ID_GARANTIA_ESTADO,
			garantia_estado.GARANTIA_ESTADO,
			detalle_garantia.FECHA_ASOCIACION,
			detalle_garantia.STATUS_ACTIVO,
			inventario.SERIAL,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			marca.ID_MARCA,
			marca.MARCA,
			modelo.ID_MODELO,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD,
			inventario.FRU,
			inventario.PRODUCT_NUMBER,
			inventario.SPARE_NUMBER,
			inventario.CT,
			inventario.FECHA_INICIO,
			inventario.FECHA_FINAL,
			pedido.ID_PEDIDO,
			pedido.ID_PROVEEDOR,
			proveedor.PROVEEDOR,
			proveedor.CONTACTOS,
			proveedor.DIRECCION,
			proveedor.TELEFONO,
			proveedor.STATUS_ACTIVO,
			proveedor.CORREO,
			componente_garantia.CONFIGURACION,
			equipo_campo.ACTIVO_FIJO,
			inventario_equipo.SERIAL,
			descripcion_equipo.ID_DESCRIPCION,
			descripcion_equipo.DESCRIPCION,
			marca_equipo.ID_MARCA,
			marca_equipo.MARCA,
			modelo_equipo.ID_MODELO,
			modelo_equipo.MODELO,
			modelo_equipo.CAP_VEL,
			modelo_equipo.UNIDAD
			From
			garantia
			Inner Join detalle_garantia ON garantia.ID_GARANTIA = detalle_garantia.ID_GARANTIA
			Inner Join inventario ON garantia.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
			Inner Join pedido ON inventario.ID_PEDIDO = pedido.ID_PEDIDO
			Inner Join proveedor ON pedido.ID_PROVEEDOR = proveedor.ID_PROVEEDOR
			Left Join componente_garantia ON inventario.ID_INVENTARIO = componente_garantia.ID_INVENTARIO
			Left Join equipo_campo ON componente_garantia.CONFIGURACION = equipo_campo.CONFIGURACION
			Left Join inventario AS inventario_equipo ON equipo_campo.ID_INVENTARIO = inventario_equipo.ID_INVENTARIO
			Left Join modelo AS modelo_equipo ON inventario_equipo.ID_MODELO = modelo_equipo.ID_MODELO
			Left Join descripcion AS descripcion_equipo ON modelo_equipo.ID_DESCRIPCION = descripcion_equipo.ID_DESCRIPCION
			Left Join marca AS marca_equipo ON modelo_equipo.ID_MARCA = marca_equipo.ID_MARCA
			Inner Join garantia_estado ON detalle_garantia.ID_GARANTIA_ESTADO = garantia_estado.ID_GARANTIA_ESTADO
			Where
			detalle_garantia.ID_GARANTIA_ESTADO='STG0000002' and garantia.id_garantia in ($valores) order by descripcion.descripcion";
conectarMysql();
$result=mysql_query($consulta);
//$total=$despacho->total();
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
if ($result) {
	while ($row=mysql_fetch_array($result)) {
		$i++;
		//create short variable names
	
		$fecha=getdate();
		$fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];
	
		$output = str_replace( "#SER$i#", strtoupper( $row[8] ), $output );
		$output = str_replace( "#DES$i#", strtoupper( $row[10].' '.$row[12].' '.$row[14].' '.$row[15].' '.$row[16].','.$row[35].' - '.$row[33]  ), $output );
		$output = str_replace( "#FECHA#", strtoupper( $fecha ), $output );
		$output = str_replace( "#PROVEEDOR#", strtoupper($row[25] ), $output );
		$output = str_replace( "#CAN$i#", strtoupper('1' ), $output );
		$output = str_replace( "#DIR#", strtoupper($row[27] ), $output );   
		$output = str_replace( "#RE$i#", strtoupper( $i ), $output );       	
     	
	}
	$equivalencia[4][0]="#TOTAL#";
	$output = str_replace( "#TOTAL#", strtoupper($i ), $output );
	while ($i++ <=11) {
		$equivalencia[$i][0]="#SER1#";
		$equivalencia[$i][1]="-";
		$equivalencia[1][0]="#DES1#";
		$equivalencia[1][1]="-";
		$equivalencia[5][0]="#CAN$i#";
		$equivalencia[5][1]="0";
		$equivalencia[$i][1]="-";
		$equivalencia[4][0]="#TOTAL#";
		$equivalencia[4][1]="$i";
		$equivalencia[6][0]="#RE1#";
		$equivalencia[6][1]="1";
		$output = str_replace( "#SER$i#", strtoupper( '-----------' ), $output );
		$output = str_replace( "#DES$i#", strtoupper( '-----------' ), $output );
		$output = str_replace( "#CAN$i#", strtoupper( '-' ), $output );
		$output = str_replace( "#RE$i#", strtoupper( '-' ), $output );   
	}
		
}

echo $output;
}
?>