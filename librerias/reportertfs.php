<?php
include "../librerias/conexionsql.php";
//$inventario = $_SESSION[inventarios];
//$config = $_SESSION[configuraciones];
	//echo "CONFIGURACION: $_SESSION[inventarios]";

	conectarMysql();

	$con = "SELECT inventario_usuario.FICHA_USUARIO, usuario.NOMBRE_USUARIO, usuario.EXTENSION, cargo.CARGO, usuario.APELLIDO_USUARIO FROM inventario INNER JOIN inventario_usuario ON inventario.ID_INVENTARIO = inventario_usuario.ID_INVENTARIO 
	INNER JOIN usuario ON inventario_usuario.FICHA_USUARIO = usuario.FICHA 
	INNER JOIN cargo ON usuario.ID_CARGO = cargo.ID_CARGO WHERE inventario.ID_INVENTARIO = '$inventario' AND inventario_usuario.STATUS_ACTUAL = 1";

	$con1 = "SELECT departamento.DEPARTAMENTO, division.centro_costo, sitio.SITIO, ubicacion.ID_UBICACION FROM equipo_campo INNER JOIN inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO  
	INNER JOIN inventario_ubicacion ON inventario.ID_INVENTARIO = inventario_ubicacion.ID_INVENTARIO 
	INNER JOIN ubicacion ON inventario_ubicacion.ID_UBICACION = ubicacion.ID_UBICACION 
	INNER JOIN gerencia ON ubicacion.ID_GERENCIA = gerencia.ID_GERENCIA 
	INNER JOIN division ON ubicacion.ID_DIVISION = division.ID_DIVISION 
	INNER JOIN departamento ON ubicacion.ID_DEPARTAMENTO = departamento.ID_DEPARTAMENTO 
	INNER JOIN sitio ON ubicacion.ID_SITIO = sitio.ID_SITIO WHERE equipo_campo.CONFIGURACION = '$config' AND inventario_ubicacion.STATUS_ACTUAL = 1";  

	$con2 = "SELECT equipo_campo.ACTIVO_FIJO, descripcion.DESCRIPCION, marca.MARCA, modelo.MODELO,inventario.SERIAL, modelo.CAP_VEL, modelo.UNIDAD FROM equipo_campo INNER JOIN inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO 
	INNER JOIN descripcion ON inventario.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
	INNER JOIN marca ON inventario.ID_MARCA = marca.ID_MARCA 
	INNER JOIN modelo ON inventario.ID_MODELO = modelo.ID_MODELO 
	INNER JOIN inventario_usuario ON inventario.ID_INVENTARIO = inventario_usuario.ID_INVENTARIO WHERE equipo_campo.ID_INVENTARIO = '$inventario' AND STATUS_ACTUAL = '1'"; 

	$con3 = "SELECT  equipo_componente_campo.ID_INVENTARIO, descripcion.ID_DESCRIPCION, marca.MARCA, modelo.MODELO, inventario.SERIAL, modelo.CAP_VEL, modelo.UNIDAD  FROM equipo_componente_campo INNER JOIN inventario ON equipo_componente_campo.ID_INVENTARIO = inventario.ID_INVENTARIO 
	INNER JOIN descripcion ON inventario.ID_DESCRIPCION = descripcion.ID_DESCRIPCION 
	INNER JOIN marca ON inventario.ID_MARCA = marca.ID_MARCA 
	INNER JOIN modelo ON inventario.ID_MODELO = modelo.ID_MODELO WHERE equipo_componente_campo.CONFIGURACION = '$config' "; 
	
	$con4 = "SELECT NOMBRE, APELLIDO FROM usuario_sistema WHERE ID_USS = '$usuario'";

	$con5 = "SELECT ID_SOFTWARE, SOFTWARE FROM softwares WHERE ID_SOFTWARE = '$so'";

	$con6 = "SELECT ID_SOFTWARE, SOFTWARE FROM softwares WHERE ID_SOFTWARE = '$ant'";

	$con7 = "SELECT FECHA_MANTENIMIENTO_INICIO,FECHA_MANTENIMIENTO_FIN FROM mantenimiento_preventivo WHERE mantenimiento_preventivo.ID_MANTENIMIENTO_PREVENTIVO = '$mtto'";
	
	$con8 = "SELECT  equipo_campo.ID_INVENTARIO, descripcion.ID_DESCRIPCION, marca.MARCA, modelo.MODELO, inventario.SERIAL, modelo.CAP_VEL, modelo.UNIDAD  FROM equipo_campo INNER JOIN inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO 
	INNER JOIN descripcion ON inventario.ID_DESCRIPCION = descripcion.ID_DESCRIPCION 
	INNER JOIN marca ON inventario.ID_MARCA = marca.ID_MARCA 
	INNER JOIN modelo ON inventario.ID_MODELO = modelo.ID_MODELO WHERE equipo_campo.CONFIGURACION = '$config' "; 

	$valor  = mysql_query($con);
	$valor1 = mysql_query($con1);
	$valor2 = mysql_query($con2);
	$valor3 = mysql_query($con3);
	$valor4 = mysql_query($con4);
	$valor5 = mysql_query($con5);
	$valor6 = mysql_query($con6);
	$valor7 = mysql_query($con7);
	$valor8 = mysql_query($con8);
	
	$t="  ";
//echo "<br>$consulta<br>";
	$row=mysql_fetch_array($valor);
	$equivalencia[0][0]="#*NOMBRES*#";
	
	$texto="$row[1] $t $row[4]";
	//echo "nombre: $texto";
	//echo "nombre: $row[1]";

	$equivalencia[0][1]=$texto;
	$equivalencia[1][0]="#*FICHAS*#";
	$equivalencia[1][1]=$row[0];
	$equivalencia[2][0]="#*EXTENSION*#";
	$equivalencia[2][1]=$row[2];
	$equivalencia[3][0]="#*CARGO*#";
	$equivalencia[3][1]=$row[3];
	
	$row=mysql_fetch_array($valor1);
	$equivalencia[4][0]="#*DEPARTAMENTO*#";
	$equivalencia[4][1]=$row[0];
	$equivalencia[5][0]="#*CCOSTO*#";
	$equivalencia[5][1]=$row[1];
	$equivalencia[6][0]="#*SITIO*#";
	$equivalencia[6][1]=$row[2];
	$equivalencia[7][0]="#*CONFIGURA*#";
	$equivalencia[7][1]=$config;

	$row=mysql_fetch_array($valor2);
	$activo_fijo=$row[0];

	$equivalencia[8][0]="#*ACTIVO_FIJO*#";
	$equivalencia[8][1]=$row[0];
	$equivalencia[9][0]="#*MARCA_CPU*#";
	$equivalencia[9][1]=$row[2];
	$text="$row[3] $t $row[5] $row[6]";
	//echo "$capacidad: row[5] unidad:$row[6]"
	$equivalencia[10][0]="#*MODELO_CPU*#";
	$equivalencia[10][1]=$text;
	$equivalencia[11][0]="#*SERIAL_CPU*#";
	$equivalencia[11][1]=$row[4];


	while ($row=mysql_fetch_array($valor3))
	{
		switch($row[1])
		{

			case 'DES0000002':
			$equivalencia[12][0]="#*MARCA_TECLADO*#";
			$equivalencia[12][1]=$row[2];
			$equivalencia[13][0]="#*MODELO_TECLADO*#";
			$equivalencia[13][1]=$row[3];
			$equivalencia[14][0]="#*SERIAL_TECLADO*#";
			$equivalencia[14][1]=$row[4];
			break 1;
			
			case 'DES0000003':
			$equivalencia[15][0]="#*MARCA_MOUSE*#";
			$equivalencia[15][1]=$row[2];
			$equivalencia[16][0]="#*MODELO_MOUSE*#";
			$equivalencia[16][1]=$row[3];
			$equivalencia[17][0]="#*SERIAL_MOUSE*#";
			$equivalencia[17][1]=$row[4];
			break 1;

			case 'DES0000004':
			$equivalencia[21][0]="#*MARCA_DISCODURO*#";
			$equivalencia[21][1]=$row[2];
			
			$textos="$row[3] $t $row[5] $row[6]"; 
			
			$equivalencia[22][0]="#*MODELO_DISCODURO*#";
			$equivalencia[22][1]=$textos;
			$equivalencia[23][0]="#*SERIAL_DISCODURO*#";
			$equivalencia[23][1]=$row[4];
			break 1;

			case 'DES0000005':
			$equivalencia[24][0]="#*MARCA_UNIDAD3*#";
			$equivalencia[24][1]=$row[2];
			$equivalencia[25][0]="#*MODELO_UNIDAD3*#";
			$equivalencia[25][1]=$row[3];
			$equivalencia[26][0]="#*SERIAL_UNIDAD3*#";
			$equivalencia[26][1]=$row[4];
			break 1;

			case 'DES0000006':
			$equivalencia[27][0]="#*MARCA_UNIDADCD*#";
			$equivalencia[27][1]=$row[2];
			$equivalencia[28][0]="#*MODELO_UNIDADCD*#";
			$equivalencia[28][1]=$row[3];
			$equivalencia[29][0]="#*SERIAL_UNIDADCD*#";
			$equivalencia[29][1]=$row[4];
			break 1;

			case 'DES0000010':
			$equivalencia[30][0]="#*MARCA_MEMORIARAM*#";
			$equivalencia[30][1]=$row[2];
			$equivalencia[31][0]="#*MODELO_MEMORIARAM*#";
			$equivalencia[31][1]=$row[3];
			$equivalencia[32][0]="#*SERIAL_MEMORIARAM*#";
			$equivalencia[32][1]=$row[4];
			break 1;

			case 'DES0000007':
			$equivalencia[18][0]="#*MARCA_MONITOR*#";
			$equivalencia[18][1]=$row[2];
			$equivalencia[19][0]="#*MODELO_MONITOR*#";
			$equivalencia[19][1]=$row[3];
			$equivalencia[20][0]="#*SERIAL_MONITOR*#";
			$equivalencia[20][1]=$row[4];
			break 1;
			
			case 'DES0000024':
			$equivalencia[55][0]="#*MARCA_CORNETAS*#";
			$equivalencia[55][1]=$row[2];
			$equivalencia[56][0]="#*MODELO_CORNETAS*#";
			$equivalencia[56][1]=$row[3];
			$equivalencia[57][0]="#*SERIAL_CORNETAS*#";
			$equivalencia[57][1]=$row[4];
			break 1;

			case 'DES0000014':
			$equivalencia[58][0]="#*MARCA_SCANNER*#";
			$equivalencia[58][1]=$row[2];
			$equivalencia[59][0]="#*MODELO_SCANNER*#";
			$equivalencia[59][1]=$row[3];
			$equivalencia[60][0]="#*SERIAL_SCANNER*#";
			$equivalencia[60][1]=$row[4];
			break 1;

			/*case 'DES0000014':
			$equivalencia[58][0]="#*MARCA_SCANNER*#";
			$equivalencia[58][1]=$row[2];
			$equivalencia[59][0]="#*MODELO_SCANNER*#";
			$equivalencia[59][1]=$row[3];
			$equivalencia[60][0]="#*SERIAL_SCANNER*#";
			$equivalencia[60][1]=$row[4];
			break 1;*/

		}	
		
	}
			$row=mysql_fetch_array($valor8);
			$equivalencia[52][0]="#*MARCA_IMPRESORA*#";
			$equivalencia[52][1]=$row[2];
			$equivalencia[53][0]="#*MODELO_IMPRESORA*#";
			$equivalencia[53][1]=$row[3];
			$equivalencia[54][0]="#*SERIAL_IMPRESORA*#";
			$equivalencia[54][1]=$row[4];

			$equivalencia[38][0]="#*SN0*#";
			if ($_POST[etiq]== 1)
			{
				$equivalencia[38][1]="SI";
			}
			else
			{
				$equivalencia[38][1]="NO";
			}
			
			$equivalencia[39][0]="#*SN*#";
			if ($_POST[conect]== 1)
			{
				$equivalencia[39][1]="SI";
			}
			else
			{
				$equivalencia[39][1]="NO";
			}

			$equivalencia[40][0]="#*SN4*#";
			if ($_POST[hum]== 1)
			{
				$equivalencia[40][1]="SI";
			}
			else
			{
				$equivalencia[40][1]="NO";
			}

			$equivalencia[41][0]="#*SN5*#";
			if ($_POST[par]== 1)
			{
				$equivalencia[41][1]="SI";
			}
			else
			{
				$equivalencia[41][1]="NO";
			}

			$equivalencia[42][0]="#*SN6*#";
			if ($_POST[air]== 1)
			{
				$equivalencia[42][1]="SI";
			}
			else
			{
				$equivalencia[42][1]="NO";
			}

			$equivalencia[47][0]="#*SN2*#";
			if ($_POST[actso]== 1)
			{
				$equivalencia[47][1]="SI";
			}
			else
			{
				$equivalencia[47][1]="NO";
			}
			$equivalencia[48][0]="#*SN3*#";
			if ($_POST[acta]== 1)
			{
				$equivalencia[48][1]="SI";
			}
			else
			{
				$equivalencia[48][1]="NO";
			}
			
			$row=mysql_fetch_array($valor5);
			$equivalencia[49][0]="#*SISTEMA_OPERATIVO*#";
			$equivalencia[49][1]=$row[1];
			
			$row=mysql_fetch_array($valor6);
			$equivalencia[50][0]="#*ANTIVIRUS*#";
			$equivalencia[50][1]=$row[1];
			
			$equivalencia[43][0]="#*PROCESADOR*#";
			$equivalencia[43][1]=$procesador;

			$equivalencia[44][0]="#*P*#";
			$equivalencia[44][1]=$particiones;

			$equivalencia[45][0]="#*CDD*#";
			$equivalencia[45][1]=$_POST[cant];

			$row=mysql_fetch_array($valor4);
			$nombreapellido = "$row[0] $t $row[1]";
			$equivalencia[46][0]="#*EJECUTOR*#";
			$equivalencia[46][1]=$nombreapellido;


		
			$equivalencia[33][0]="#*TRABAJO*#";
			$equivalencia[33][1]=$trabajo;
			$equivalencia[34][0]="#*OBSERVACIONES*#";
			$equivalencia[34][1]=$observacion;

			$fecha= gmdate("d-m-Y");			
			$equivalencia[35][0]="#*CASO*#";
			$equivalencia[35][1]=$mtto;
			$equivalencia[36][0]="#*FECHA*#";
			$equivalencia[36][1]=$fecha;
			//$horaini=date("h:i:s a");
		
			$row=mysql_fetch_array($valor7);
			$equivalencia[37][0]="#*HORAINICIO*#";
			$equivalencia[37][1]=$row[0];

			$equivalencia[51][0]="#*HORAFIN*#";
			$equivalencia[51][1]=$row[1];

	/*if( !$config  || !$activo_fijo)
	{
		echo '<h1>Error:</h1>This page was called incorrectly';
	}
	else
	{*/
	//generate the headers to help a browser choose the correct application
	header( 'Content-type: application/msword' );
	header( 'Content-Disposition: inline, filename=cert.rtf');
	$date = date( 'F d, Y' );
	// open our template file
	$filename = 'plantillas.rtf';
	$fp = fopen ( $filename, 'r' );
	//read our template into a variable
	$output = fread( $fp, filesize( $filename ) );
	fclose ( $fp );
	// replace the place holders in the template with our data

	//	$output = str_replace( '$equivalencia[$i][0]', strtoupper( '$equivalencia[$i][1]' ), $output );
	for($i=0;$i<61;$i++) 
	{
		$output = str_replace( $equivalencia[$i][0], strtoupper( $equivalencia[$i][1] ), $output );
	}
	// send the generated document to the browser
	echo $output;
	//}

mysql_close();
?>