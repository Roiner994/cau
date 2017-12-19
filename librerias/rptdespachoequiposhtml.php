<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
echo "<title>Inventario de Equipos</title>";
require_once("formularios.php");
require_once("conexionsql.php");
require_once("rptAdmin.php");

    if ($_GET[idSitio]==100)
		$_GET[idSitio]="";
		
	if ($_GET[idGerencia]==100)
		$_GET[idGerencia]="";
	
	if ($_GET[idDescripcion]==100)	
		$_GET[idDescripcion]="";

	if ($_GET[tipoDespacho]==100)	
		$_GET[tipoDespacho]="";
		
	if ($_GET[statusDespacho]==100)	
		$_GET[statusDespacho]="";
		
	if ($_GET[analista]==100)	
		$_GET[analista]="";						
		
		
	
     conectarMysql();


		$rangoFecha="";
		if ((isset($_GET[fechaInicio]) && !empty($_GET[fechaInicio])) || (isset($_GET[fechaFinal]) && !empty($_GET[fechaFinal]))) {
			$FechaInicio=substr($_GET[fechaInicio],6,6)."-".substr($_GET[fechaInicio],3,2)."-".substr($_GET[fechaInicio],0,2);
			$FechaFinal=substr($_GET[fechaFinal],6,6)."-".substr($_GET[fechaFinal],3,2)."-".substr($_GET[fechaFinal],0,2);
			$rangoFecha=" vistadespachoequipos.fecha_asociacion Between '$FechaInicio' AND '$FechaFinal' AND ";
		}
	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}
	if (isset($_GET[ficha]) && !empty($_GET[ficha])) {
		$conFicha=" and (ficha like '%$_GET[ficha]' or NOMBRE_USUARIO like '%$_GET[ficha]%' OR APELLIDO_USUARIO like '%$_GET[ficha]%')  ";
	}
	
	
		$_pagi_sql="select * 
		from 
		vistadespachoequipos 
		where $rangoFecha 
		id_despacho like '%' and 
		id_uss_detalle like '%' and
		help_desk like '%' and
		id_uss_detalle like '%$_GET[analista]' and
		configuracion_nueva like '%$_GET[configuracion]' and
		configuracion_anterior like '%' and
		id_sitio like '%$_GET[idSitio]' and 
		id_gerencia like '%$_GET[idGerencia]' and 
		id_descripcion like '%$_GET[idDescripcion]' and
		id_despacho_estado like '%$_GET[tipoDespacho]' and 
		status_despacho like '%$_GET[statusDespacho]' $conFicha 
		$orden";

//cantidad de resultados por p�gina (opcional, por defecto 20)
$_pagi_cuantos = 30;//Eleg� un n�mero peque�o para que se generen varias p�ginas

//cantidad de enlaces que se mostrar�n como m�ximo en la barra de navegaci�n
$_pagi_nav_num_enlaces = 30;//Eleg� un n�mero peque�o para que se note el resultado

//Decidimos si queremos que se muesten los errores de mysql
$_pagi_mostrar_errores = false;//recomendado true s�lo en tiempo de desarrollo.

//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente, 
//realizamos el conteo alternativo.
$_pagi_conteo_alternativo = true;//recomendado false.

//Supongamos que s�lo nos interesa propagar estas dos variables
$_pagi_propagar = array("configuracion","configuracion_anterior","idDescripcion","fechaInicio","fechaFinal","idSitio","idGerencia","analista","tipoDespacho","statusDespacho","ficha","ordenado","ordentipo");//No importa si son POST o GET

//Definimos qu� estilo CSS se utilizar� para los enlaces de paginaci�n.
//El estilo debe estar definido previamente
$_pagi_nav_estilo = "enlace";

//definimos qu� ir� en el enlace a la p�gina anterior
$_pagi_nav_anterior = "&lt;";// podr�a ir un tag <img> o lo que sea

//definimos qu� ir� en el enlace a la p�gina siguiente
$_pagi_nav_siguiente = "&gt;";// podr�a ir un tag <img> o lo que sea

//Incluimos el script de paginaci�n. �ste ya ejecuta la consulta autom�ticamente
require_once("../paginador/paginator.inc.php");
		
		  	 
		echo "<table width=\"100%\" border=\"0\" align=\"center\">
		<tr>";		     
			echo "<td class=\"tituloPagina\" colspan=\"11\" align=\"center\">REPORTE DE EQUIPOS DESPACHADOS Y ASIGNADOS</td>			 
		</tr>
		<tr>";
			
		// Ordenar configuraci�n Nueva
		if ($_GET[ordenado]=='configuracion_nueva' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=configuracion_nueva&ordentipo=asc\">CONFIGURACION NUEVA</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=configuracion_nueva&ordentipo=desc\">CONFIGURACION NUEVA</a></b></td>";	
		// Ordenar configuraci�n Anterior
		if ($_GET[ordenado]=='configuracion_anterior' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=configuracion_anterior&ordentipo=asc\"><b>CONFIGURACION ANTERIOR</b></a></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=configuracion_anterior&ordentipo=desc\"><b>CONFIGURACION ANTERIOR</b></a></td>";

		// Ordenar Usuario
		if ($_GET[ordenado]=='ficha' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=ficha&ordentipo=asc\">FICHA</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=ficha&ordentipo=desc\">FICHA</b></a></td>";
			
		// Ordenar Usuario
		if ($_GET[ordenado]=='nombre_usuario' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=asc\">USUARIO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=desc\">USUARIO</b></a></td>";
	  
		// Ordenar Extension
		if ($_GET[ordenado]=='extension' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=extension&ordentipo=asc\"><b>EXTENSION</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=extension&ordentipo=desc\"><b>EXTENSION</b></a></td>";
		// Ordenar Gerencia
		if ($_GET[ordenado]=='gerencia' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=gerencia&ordentipo=asc\">GERENCIA</b></a></td>";
		else 	
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=gerencia&ordentipo=desc\">GERENCIA</b></a></td>";
		// Ordenar Edificio
		if ($_GET[ordenado]=='sitio' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=sitio&ordentipo=asc\">EDIFICIO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=sitio&ordentipo=desc\">EDIFICIO</b></a></td>";
		// Ordenar HelpDesk
		if ($_GET[ordenado]=='help_desk' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=help_desk&ordentipo=asc\">HELP DESK</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=help_desk&ordentipo=desc\">HELP DESK</b></a></td>";
			
		if ($_GET[ordenado]=='fecha_asociacion' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=fecha_asociacion&ordentipo=asc\">FECHA</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=fecha_asociacion&ordentipo=desc\">FECHA</b></a></td>";	
		if ($_GET[ordenado]=='despacho_estado' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=despacho_estado&ordentipo=asc\">TIPO ASIGNACION</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=despacho_estado&ordentipo=desc\">TIPO ASIGNACION</b></a></td>";	
		if ($_GET[ordenado]=='status_despacho' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=status_despacho&ordentipo=asc\">ESTADO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=status_despacho&ordentipo=desc\">ESTADO</b></a></td>";	

		echo "</tr>";	
				
		while ($row=mysql_fetch_array($_pagi_result)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			$FechaAsociacion=substr($row[44],8,2)."/".substr($row[44],5,2)."/".substr($row[44],0,4);
			switch($row[5]) {
				case 1: 
					$estado="DESPACHADO";
					break 1;
				case 2:
					$estado="ASIGNADO";
					break 1;
			}
			echo "<tr class=\"$clase\">";
			echo "<td align=\"left\"><a class=enlace href=\"#\" onclick=\"window.open('rptInventario.php?idDescripcion=$row[13]')\">$row[13]</a></td>";				
			echo "<td align=\"left\">$row[24]</td>";
			echo "<td align=\"left\">$row[6]</td>";
			echo "<td align=\"left\">$row[7] $row[8]</td>";
			echo "<td align=\"left\">$row[11]</td>";
			echo "<td align=\"left\">$row[38]</td>";
			echo "<td align=\"left\">$row[36]</td>";
			echo "<td align=\"left\">$row[4]</td>";
			echo "<td align=\"left\">$FechaAsociacion</td>";
			echo "<td align=\"left\">$row[47]</td>";										
			echo "<td align=\"left\">$estado</td>";										
			echo "</tr>";
			$i++;									
			
		   }
		   echo "<tr>";
	echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=\"12\">".$_pagi_navegacion."</td>";
	echo "</tr>";
	echo "</table>";
		
//Incluimos la informaci�n de la p�gina actual
	echo"<p class=\"enlace\" >Resultados ".$_pagi_info."</p>";
mysql_close();  
?>