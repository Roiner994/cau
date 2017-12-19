<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php

require_once("conexionsql.php");


 	if ($_GET[sitio]==100)
		$_GET[sitio]="";

	if ($_GET[gerencia]==100)
		$_GET[gerencia]="";

	if ($_GET[idDescripcion]==100)
		$_GET[idDescripcion]="";

	if ($_GET[idMarca]==100)
		$_GET[idMarca]="";

	if ($_GET[idModelo]==100)	
		$_GET[idModelo]="";
	
	
     conectarMysql();


	$rangoFecha="";
	if ((isset($_GET[fechaInicio]) && !empty($_GET[fechaInicio])) && (isset($_GET[fechaFinal]) && !empty($_GET[fechaFinal]))) {
		$FechaInicio=substr($_GET[fechaInicio],6,6)."-".substr($_GET[fechaInicio],3,2)."-".substr($_GET[fechaInicio],0,2);
		$FechaFinal=substr($_GET[fechaFinal],6,6)."-".substr($_GET[fechaFinal],3,2)."-".substr($_GET[fechaFinal],0,2);
		$rangoFecha=" vistamantenimientospreventivos.FECHA_INICIO Between '$FechaInicio' AND '$FechaFinal' AND ";
	}
	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}
    if (isset($_GET[txtFicha]) && !empty($_GET[txtFicha])) {
			$conFicha=" AND (FICHA like '%$_GET[txtFicha]' OR NOMBRE_USUARIO like '%$_GET[txtFicha]%' OR APELLIDO_USUARIO like '%$_GET[txtFicha]%')  ";
		} 
     
	$_pagi_sql = "SELECT * FROM vistamantenimientospreventivos 
        where
		$rangoFecha
		SERIAL LIKE '%$_GET[txtSerial]' AND
		ID_SITIO  Like '%$_GET[sitio]' AND
    	ID_GERENCIA Like '%$_GET[gerencia]' AND
    	ID_DESCRIPCION LIKE '%$_GET[idDescripcion]' AND
    	ACTIVO_FIJO LIKE '%$_GET[txtActivoFijo]' AND
    	ID_Marca Like '%$_GET[idMarca]' AND
    	ID_Modelo Like '%$_GET[idModelo]' AND       
    	CONFIGURACION like '%$_GET[configuracion]'
		$conFicha
		$orden";

//cantidad de resultados por página (opcional, por defecto 20)
$_pagi_cuantos = 20;//Elegí un número pequeño para que se generen varias páginas

//cantidad de enlaces que se mostrarán como máximo en la barra de navegación
$_pagi_nav_num_enlaces = 30;//Elegí un número pequeño para que se note el resultado

//Decidimos si queremos que se muesten los errores de mysql
$_pagi_mostrar_errores = false;//recomendado true sólo en tiempo de desarrollo.

//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente, 
//realizamos el conteo alternativo.
$_pagi_conteo_alternativo = true;//recomendado false.

//Supongamos que sólo nos interesa propagar estas dos variables
$_pagi_propagar = array("txtConfiguracion","txtActivoFijo","idMarca","idModelo","txtSerial","gerencia","idDivision","idDepartamento","sitio","idEstado","idCargo","txtNombre","txtApellido","txtFicha","txtCedula","txtExtension","ordenado");//No importa si son POST o GET

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
			echo "<td class=\"tituloPagina\" colspan=\"12\" align=\"center\">INVENTARIO HOJAS IMPRESAS POR EQUIPO 
			</td>			
		</tr>
		<tr>";
			
		
		// Ordenar configuración
		if ($_GET[ordenado]=='configuracion' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\">CONFIGURACION</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\">CONFIGURACION</a></b></td>";		
		
			// Ordenar fecha
		if ($_GET[ordenado]=='fecha_inicio' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\">FECHA</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\">FECHA</a></b></td>";		

			// Ordenar mantenimiento
		if ($_GET[ordenado]=='id_mantenimiento' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\"><b>MANTENIMIENTO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\"><b>MANTENIMIENTO</b></a></td>";
			
		// Ordenar marca
		if ($_GET[ordenado]=='marca' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\"><b>MARCA</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\"><b>MARCA</b></a></td>";
		// Ordenar modelo
		if ($_GET[ordenado]=='modelo' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\">MODELO</b></a></td>";
		else 	
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\">MODELO</b></a></td>";
		
			// Ordenar serial
		if ($_GET[ordenado]=='serial' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\">SERIAL</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\">SERIAL</b></a></td>";
	  			
		// Ordenar gerencia
		if ($_GET[ordenado]=='gerencia' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\"><b>GERENCIA</b></a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\"><b>GERENCIA</b></a></b></td>";
					
		// Ordenar sitio
		if ($_GET[ordenado]=='sitio' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\"><b>SITIO</b></a></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\"><b>SITIO</b></a></td>";
					
		//Ordenar Cantidad					
        if ($_GET[ordenado]=='cant_hojas_impresas' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\"><b>CANTIDAD HOJAS</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\"><b>CANTIDAD HOJAS</b></a></td>";	
				
		$total=0;		
		while ($row=mysql_fetch_array($_pagi_result)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">";
			echo "<td align=\"left\">$row[1]</td>";
			$fechaReporte=substr($row[43],8,2)."-".substr($row[43],5,2)."-".substr($row[43],0,4);
			echo "<td align=\"left\">$fechaReporte</td>";
			echo "<td align=\"left\">$row[0]</td>";
			echo "<td align=\"left\">$row[10]</td>";				
			echo "<td align=\"left\">$row[12]</td>";
			echo "<td align=\"left\">$row[6]</td>";
			echo "<td align=\"left\">$row[25]</td>";
			echo "<td align=\"left\">$row[31]</td>";
			echo "<td align=\"left\">$row[42]</td>";
			echo "</tr>";
			$total=$total+$row[42];
			$i++;									
			
		   }
		echo "<tr class=\"$clase\">";
	 	echo "<td align=\"right\">TOTAL</td>";
	 	echo "<td align=\"center\"><b>$total</b></td>";
	 	echo "</tr>";
		   
		   echo "<tr>";
	echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=\"12\">".$_pagi_navegacion."</td>";
	echo "</tr>";
	echo "</table>";
		
//Incluimos la información de la página actual
	echo"<p class=\"enlace\" >Resultados ".$_pagi_info."</p>";
mysql_close();   	
		
		  	 
		
			
?>