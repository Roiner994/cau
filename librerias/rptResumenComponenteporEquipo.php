<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
require_once("membrete.php");
echo "<title>Planta Componenete</title>";
require_once("formularios.php");
require_once("conexionsql.php");
require_once("rptPedidos.php");

	
	
	if ($_GET[idDescripcion]==100)
		$_GET[idDescripcion]="";
		
	
     conectarMysql();

	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}
	
	$_pagi_sql = "SELECT * FROM vistainventarioequipos
				WHERE 
				DESCRIPCION ='MICROCOMPUTADOR' AND
				ESTADO='OPERATIVO' AND
				CONFIGURACION NOT IN (SELECT configuracion 
				FROM vistacomponentesasociadosequiposgarantia
				WHERE componente_id_descripcion ='$idDescripcion')
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

///Supongamos que sólo nos interesa propagar estas dos variables
$_pagi_propagar = array("idDescripcion","ordenado");//No importa si son POST o GET

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
			echo "<td class=\"tituloPagina\" colspan=\"15\" align=\"center\"> EQUIPOS QUE NO POSEEN ALGUN COMPONENTE
			| <a class=\"rptResumenPlantaComponente\" href=\"rptResumenCompxEquipoExcel.php?Descripcion=$idDescripcion\">EXCEL</a></td>						 
		</tr>
		<tr>";
			
		// Ordenar configuracion
		if ($_GET[ordenado]=='configuracion' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=configuracion&ordentipo=asc\">DESCRIPCION</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=configuracion&ordentipo=desc\">DESCRIPCION</a></b></td>";		

		// Ordenar activo_fijo
		if ($_GET[ordenado]=='activo_fijo' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=activo_fijo&ordentipo=asc\">ACTVO FIJO</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=activo_fijo&ordentipo=desc\">ACTVO FIJO</a></b></td>";		

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

		// Ordenar serial
		if ($_GET[ordenado]=='serial' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=serial&ordentipo=asc\">SERIAL</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=serial&ordentipo=desc\">SERIAL</b></a></td>";

		// Ordenar gerencia
		if ($_GET[ordenado]=='gerencia' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=gerencia&ordentipo=asc\"><b>GERENICA</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=gerencia&ordentipo=desc\"><b>GERENCIA</b></a></td>";

		// Ordenar division
		if ($_GET[ordenado]=='division' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=division&ordentipo=asc\">DIVISION</b></a></td>";
		else 	
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=division&ordentipo=desc\">DIVISION</b></a></td>";

		// Ordenar departamento
		if ($_GET[ordenado]=='departamento' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=departamento&ordentipo=asc\">DEPARTAMENTO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=departamento&ordentipo=desc\">DEPARTAMENTO</b></a></td>";

		// Ordenar sitio
		if ($_GET[ordenado]=='sitio' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=sitio&ordentipo=asc\"><b>SITIO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=sitio&ordentipo=desc\"><b>SITIO</b></a></td>";
			
		// Ordenar estado
		if ($_GET[ordenado]=='estado' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=estado&ordentipo=asc\">ESTADO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=estado&ordentipo=desc\">ESTADO</b></a></td>";

		// Ordenar nombre_usuario
		if ($_GET[ordenado]=='nombre_usuario' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=asc\"><b>NOMBRE USUARIO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=desc\"><b>NOMBRE USUARIO</b></a></td>";
			
		// Ordenar ficha
		if ($_GET[ordenado]=='ficha' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=ficha&ordentipo=asc\">FICHA</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=ficha&ordentipo=desc\">FICHA</b></a></td>";

		// Ordenar extension
		if ($_GET[ordenado]=='extension' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=extension&ordentipo=asc\">EXTENSION</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=extension&ordentipo=desc\">EXTENSION</b></a></td>";

		while ($row=mysql_fetch_array($_pagi_result)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">";
				echo "<td align=\"left\">$row[0]</td>";
				echo "<td align=\"left\">$row[1]</td>";
				echo "<td align=\"left\">$row[12]</td>";
				echo "<td align=\"left\">$row[14] </td>";
				echo "<td align=\"left\">$row[7]</td>";
				echo "<td align=\"left\">$row[34]</td>";
				echo "<td align=\"left\">$row[36]</td>";
				echo "<td align=\"left\">$row[38]</td>";
				echo "<td align=\"left\">$row[32]</td>";				
				echo "<td align=\"left\">$row[45]</td>";
				echo "<td align=\"left\">$row[48] $row[49]</td>";
				echo "<td align=\"left\">$row[46]</td>";				
				echo "<td align=\"left\">$row[52]</td>";							
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