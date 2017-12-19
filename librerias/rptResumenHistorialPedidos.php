<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
require_once("membrete.php");
echo "<title>Inventario de Equipos</title>";
require_once("formularios.php");
require_once("conexionsql.php");

	if ($_GET[idDescripcion]==100)
		$_GET[idDescripcion]="";

	if ($_GET[idMarca]==100)
		$_GET[idMarca]="";

	if ($_GET[idModelo]==100)
		$_GET[idModelo]="";

	if ($_GET[idPedido]==100)
		$_GET[idPedido]="";

     conectarMysql();


	$rangoFecha="";
	if ((isset($_GET[fechaInicio]) && !empty($_GET[fechaInicio])) && (isset($_GET[fechaFinal]) && !empty($_GET[fechaFinal]))) {
		$FechaInicio=substr($_GET[fechaInicio],6,6)."-".substr($_GET[fechaInicio],3,2)."-".substr($_GET[fechaInicio],0,2);
		$FechaFinal=substr($_GET[fechaFinal],6,6)."-".substr($_GET[fechaFinal],3,2)."-".substr($_GET[fechaFinal],0,2);
		$rangoFecha=" vistainventarioequipos.EQUIPO_FECHA_CREACION Between '$FechaInicio' AND '$FechaFinal' AND ";
	}
	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}
	
     
	$_pagi_sql = "SELECT * FROM vistaInventarioEquipos
        where
		$rangoFecha
		CONFIGURACION like '%$_GET[txtConfiguracion]' AND
		SERIAL LIKE '%$_GET[txtSerial]' AND
	    ID_DESCRIPCION LIKE '%$_GET[idDescripcion]' AND
    	ID_Marca Like '%$_GET[idMarca]' AND
    	ID_Modelo Like '%$_GET[idModelo]' AND
    	ID_PEDIDO like '%$_GET[idPedido]'  AND
    	ACTIVO_FIJO like '%$_GET[txtActivoFijo]'			
		$orden";
	 
	
//cantidad de resultados por página (opcional, por defecto 20)
$_pagi_cuantos = 30;//Elegí un número pequeño para que se generen varias páginas

//cantidad de enlaces que se mostrarán como máximo en la barra de navegación
$_pagi_nav_num_enlaces = 30;//Elegí un número pequeño para que se note el resultado

//Decidimos si queremos que se muesten los errores de mysql
$_pagi_mostrar_errores = false;//recomendado true sólo en tiempo de desarrollo.

//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente, 
//realizamos el conteo alternativo.
$_pagi_conteo_alternativo = true;//recomendado false.

//Supongamos que sólo nos interesa propagar estas dos variables
$_pagi_propagar = array("txtConfiguracion","txtSerial","txtActivoFijo","idDescripcion","idMarca","idModelo","idPedido","idEstado","idProveedor","idTelefono","idSitio","idNombre","idApellido","fechaInicio","fechaFinal","ordenado");//No importa si son POST o GET

//Definimos qué estilo CSS se utilizará para los enlaces de paginación.
//El estilo debe estar definido previamente
$_pagi_nav_estilo = "enlace";

//definimos qué irá en el enlace a la página anterior
$_pagi_nav_anterior = "&lt;";// podría ir un tag <img> o lo que sea

//definimos qué irá en el enlace a la página siguiente
$_pagi_nav_siguiente = "&gt;";// podría ir un tag <img> o lo que sea

//Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
require_once("../paginador/paginator.inc.php");
		
		  	 
		echo "<table width=\"100%\" border=\"0\" align=\"center\">
		<tr>";		     
			echo "<td class=\"tituloPagina\" colspan=\"15\" align=\"center\"> HISTORIAL DE PEDIDOS POR EQUIPO
			| <a class=\"rptResumenHistorialPedidos\" href=\"rptResumenHistorialPedidosEquipoExcel.php?pedido=$idPedido&fechaIni=$fechaInicio&fechaFin=$fechaFinal&Configuracion=$txtConfiguracion&Serial=$txtSerial&ActivoFijo=$txtActivoFijo&Descripcion=$idDescripcion&Marca=$idMarca&Modelo=$idModelo\">EXCEL</a></td>						 
		</tr>
		<tr>";
			
			
		// Equipo creacion
		if ($_GET[ordenado]=='fecha_inicio' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=fecha_inicio&ordentipo=asc\"><b>FECHA INICIO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=fecha_inicio&ordentipo=desc\"><b>FECHA INICIO</b></a></td>";				

		if ($_GET[ordenado]=='fecha_final' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=fecha_final&ordentipo=asc\"><b>FECHA FINAL</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=fecha_final&ordentipo=desc\"><b>FECHA FINAL</b></a></td>";				

			
		// Ordenar configuración
		if ($_GET[ordenado]=='configuracion' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=configuracion&ordentipo=asc\">CONFIGURACION</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=configuracion&ordentipo=desc\">CONFIGURACION</a></b></td>";	
		
		// Ordenar activo Fijo 
		if ($_GET[ordenado]=='activo_fijo' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=activo_fijo&ordentipo=asc\"><b>ACTIVO FIJO</b></a></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=activo_fijo&ordentipo=desc\"><b>ACTIVO FIJO</b></a></td>";
		
		// Ordenar serial
		if ($_GET[ordenado]=='serial' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=serial&ordentipo=asc\">SERIAL</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=serial&ordentipo=desc\">SERIAL</b></a></td>";
	  
		// Ordenar marca
		if ($_GET[ordenado]=='marca' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=marca&ordentipo=asc\"><b>MARCA</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=marca&ordentipo=desc\"><b>MARCA</b></a></td>";
		
		// Ordenar modelo
		if ($_GET[ordenado]=='modelo' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=modelo&ordentipo=asc\">MODELO</b></a></td>";
		else 	
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=modelo&ordentipo=desc\">MODELO</b></a></td>";
		
		// Ordenar estado
		if ($_GET[ordenado]=='estado' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=estado&ordentipo=asc\"><b>ESTADO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=estado&ordentipo=desc\"><b>ESTADO</b></a></td>";				
			
		// Ordenar usuario
		if ($_GET[ordenado]=='nombre_usuario' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=asc\"><b>USUARIO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=desc\"><b>USUARIO</b></a></td>";				
		
		// Ordenar sitio
		if ($_GET[ordenado]=='sitio' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=sitio&ordentipo=asc\"><b>SITIO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=sitio&ordentipo=desc\"><b>SITIO</b></a></td>";				
			
			
		// Ordenar pedido
		if ($_GET[ordenado]=='pedido' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=pedido&ordentipo=asc\"><b>PEDIDO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=pedido&ordentipo=desc\"><b>PEDIDO</b></a></td>";				

					
		// Ordenar proveedor
		if ($_GET[ordenado]=='proveedor' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=proveedor&ordentipo=asc\"><b>PROVEEDOR</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=proveedor&ordentipo=desc\"><b>PROVEEDOR</b></a></td>";				

		if ($_GET[ordenado]=='telefono' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=telefono&ordentipo=asc\"><b>TELEFONO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=telefono&ordentipo=desc\"><b>TELEFONO</b></a></td>";				
		
						
		while ($row=mysql_fetch_array($_pagi_result)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">";			
			echo "<td align=\"left\">$row[29]</td>";
			echo "<td align=\"left\">$row[30]</td>";
			echo "<td align=\"left\">$row[0]</td>";
			echo "<td align=\"left\">$row[1]</td>";
			echo "<td align=\"left\">$row[7] </td>";
			echo "<td align=\"left\">$row[12]</td>";
			echo "<td align=\"left\">$row[14]</td>";						
			echo "<td align=\"left\">$row[45]</td>";								
			echo "<td align=\"left\">$row[48] $row[49]</td>";
			echo "<td align=\"left\">$row[32]</td>";
			echo "<td align=\"left\">$row[21]</td>";										
			echo "<td align=\"left\">$row[23]</td>";			
			echo "<td align=\"left\">$row[26]</td>";										
			echo "</tr>";
			$i++;									
			
		   }
		   echo "<tr>";
	echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=\"12\">".$_pagi_navegacion."</td>";
	echo "</tr>";
	echo "</table>";
		
//Incluimos la información de la página actual
	echo"<p class=\"enlace\" >Resultados ".$_pagi_info."</p>";
mysql_close();
		
?>