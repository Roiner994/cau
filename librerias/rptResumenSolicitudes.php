<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
require_once("membrete.php");
echo "<title>REPORTES DE SOLICITUDES</title>";
require_once("formularios.php");
require_once("conexionsql.php");
require_once("requerimientoAdmin.php");


    if ($_GET[sitio]==100)
		$_GET[sitio]="";
		
	if ($_GET[idGerencia]==100)
		$_GET[idGerencia]="";
	
	if ($_GET[idDescripcion]==100)	
		$_GET[idDescripcion]="";		
	
			
	if ($_GET[usuarioSistema]==100)
		$_GET[usuarioSistema]=""; 	
		
	    
	if ($_GET[requerimientoMotivo]==100)
		$_GET[requerimientoMotivo]=""; 	
		
		
	if ($_GET[estadoRequerimiento]==100)
		$_GET[estadoRequerimiento]=""; 		
	
		
		
	
     conectarMysql();


	
	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}
	
	if (isset($_GET[txtFicha]) && !empty($_GET[txtFicha])) {
			$conFicha=" AND (FICHA like '%$_GET[txtFicha]')  ";
		} 
     

    
     
	$_pagi_sql = "SELECT * FROM vistarequerimientosequipos

        where        			
		vistarequerimientosequipos .ID_SITIO like '%$_GET[sitio]' and
		vistarequerimientosequipos .ID_GERENCIA like '%$_GET[idGerencia]' and
		vistarequerimientosequipos .ID_DESCRIPCION like '%$_GET[idDescripcion]' and  
		vistarequerimientosequipos . ID_ESTADO_REQUERIMIENTO  like '%$_GET[estadoRequerimiento]' and
		vistarequerimientosequipos . ID_REQUERIMIENTO_MOTIVO  like '%$_GET[requerimientoMotivo]'
		$conFicha
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
$_pagi_propagar = array("sitio","idGerencia","idDescripcion","estadoRequerimiento","requerimientoMotivo",
"fechaInicio","fechaFinal","ordenado");//No importa si son POST o GET

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
			echo "<td class=\"tituloPagina\" colspan=\"12\" align=\"center\">REPORTE DE SOLICITUDES</td>			 
		</tr>
		<tr>";
			
		// Ordenar solicitud
		if ($_GET[ordenado]=='id_detalle_requerimiento' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=id_detalle_requerimiento&ordentipo=asc\"><b>SOLICITUD</b></a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=id_detalle_requerimiento&ordentipo=desc\"><b>SOLICITUD</b></a></b></td>";
		// Ordenar gerencia
		if ($_GET[ordenado]=='gerencia' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=gerencia&ordentipo=asc\"><b>GERENCIA</b></a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=gerencia&ordentipo=desc\"><b>GERENCIA</b></a></b></td>";
		// Ordenar usario
		if ($_GET[ordenado]=='nombre_usuario' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=asc\"><b>USUARIO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=desc\"><b>USUARIO</b></a></td>";	
			
		// Ordenar descripcion
		if ($_GET[ordenado]=='descripcion' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=descripcion&ordentipo=asc\"><b>DESCRIPCION</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=descripcion&ordentipo=desc\"><b>DESCRIPCION</b></a></td>";
	  
		// Ordenar motivo 
		if ($_GET[ordenado]=='requerimiento_motivo' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=requerimiento_motivo&ordentipo=asc\"><b>MOTIVO </b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=requerimiento_motivo&ordentipo=desc\"><b>MOTIVO </b></a></td>";	
		// Ordenar estado requerimiento		
		if ($_GET[ordenado]=='estado_Requerimiento' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=estado_Requerimiento&ordentipo=asc\"><b>ESTADO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=estado_Requerimiento&ordentipo=desc\"><b>ESTADO</b></a></td>";		
		// Ordenar detalle
		if ($_GET[ordenado]=='descripcion_detalle' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=descripcion_detalle&ordentipo=asc\"><b>DETALLE</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=descripcion_detalle&ordentipo=desc\"><b>DETALLE</b></a></td>";								
         // Ordenar fecha 
		if ($_GET[ordenado]=='fecha_asociacion' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=fecha_asociacion&ordentipo=asc\"><b>FECHA</b></a></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=fecha_asociacion&ordentipo=desc\"><b>FECHA</b></a></td>";	
		echo "</tr>";	
				
		while ($row=mysql_fetch_array($_pagi_result)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">";
			$fecha=substr($row[23],8,2)."/".substr($row[23],5,2)."/".substr($row[23],0,4);	 		
	 		echo "<td align=\"left\"><a class=enlace href=\"index2.php?item=202&idRequerimiento=$row[1]\"> $row[1]</a></td>";
	 		echo "<td align=\"left\">$row[8]</td>";
	 		echo "<td align=\"left\">$row[3] $row[4]</td>";
	 		echo "<td align=\"left\">$row[21]</td>";
	 		echo "<td align=\"left\">$row[25]</td>";
	 		echo "<td align=\"left\">$row[22]</td>";
	 		echo "<td align=\"left\">$row[27]</td>";
	 		echo "<td align=\"left\">$fecha</td>";
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