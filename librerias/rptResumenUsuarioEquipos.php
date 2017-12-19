<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">

<script type="text/javascript" src="date-picker.js"></script>
<script type="text/javascript">
	
</script>


<?php
require_once("membrete.php");
echo "<title>REPORTES DE USUARIO</title>";
require_once("formularios.php");
require_once("conexionsql.php");


    if ($_GET[sitio]==100)
		$_GET[sitio]="";

	if ($_GET[gerencia]==100)
		$_GET[gerencia]="";

	if ($_GET[departamento]==100) 	
		$_GET[departamento]="";		

	if ($_GET[division]==100) 	
		$_GET[division]="";
		
	if ($_GET[idCargo]==100) 	
		$_GET[idCargo]="";	


	conectarMysql();
	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= "ORDER BY $_GET[ordenado] $_GET[ordentipo]";
	} else {
		$orden="";
	}

	if (isset($_GET[txtFicha]) && !empty($_GET[txtFicha])) {
			$conFicha="AND (FICHA like '%$_GET[txtFicha]')";
		} 

    
	$_pagi_sql = "SELECT * FROM vistausuario
        WHERE
        ID_SITIO  Like '%$_GET[sitio]' AND
    	ID_GERENCIA Like '%$_GET[gerencia]' AND
    	ID_CARGO like '%$_GET[idCargo]' AND		
    	ID_DEPARTAMENTO Like '%$_GET[departamento]' AND
    	ID_DIVISION Like '%$_GET[division]' AND
    	NOMBRE_USUARIO LIKE '%$_GET[txtNombre]%' AND
    	APELLIDO_USUARIO Like '%$_GET[txtApellido]%' AND
    	CEDULA like '%$_GET[txtCedula]' AND
		EXTENSION LIKE '%$_GET[txtExtension]'
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
$_pagi_propagar = array("idCargo","sitio","gerencia","departamento","division","txtNombre","txtApellido","txtCedula","txtExtension","ordenado");//No importa si son POST o GET

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
			echo "<td class=\"tituloPagina\" colspan=\"12\" align=\"center\">REPORTE DE USUARIO 
			| <a class=\"rptResumenUsuarioEquipos\" href=\"rptResumenUsuaEquipoExcel.php?Cargo=$idCargo&Nombre=$txtNombre&Apellido=$txtApellido&Ficha=$txtFicha&Cedula=$txtCedula&Gerencia=$gerencia&Departamento=$departamento&Sitio=$sitio&Division=$division\">EXCEL</a></td>			
		</tr>
		<tr>";
			
					
		// Ordenar gerencia
		if ($_GET[ordenado]=='gerencia' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=gerencia&ordentipo=asc\"><b>GERENCIA</b></a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=gerencia&ordentipo=desc\"><b>GERENCIA</b></a></b></td>";
		
		// Ordenar division
		if ($_GET[ordenado]=='division' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=division&ordentipo=asc\"><b>DIVISION</b></a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=division&ordentipo=desc\"><b>DIVISION</b></a></b></td>";
			
		// Ordenar departamento
		if ($_GET[ordenado]=='departamento' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=departamento&ordentipo=asc\"><b>DEPARTAMENTO</b></a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=departamento&ordentipo=desc\"><b>DEPARTAMENTO</b></a></b></td>";
		
		// Ordenar sitio
		if ($_GET[ordenado]=='sitio' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=sitio&ordentipo=asc\"><b>SITIO</b></a></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=sitio&ordentipo=desc\"><b>SITIO</b></a></td>";
			
		// Ordenar cargo
		if ($_GET[ordenado]=='cargo' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=cargo&ordentipo=asc\"><b>CARGO</b></a></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=cargo&ordentipo=desc\"><b>CARGO</b></a></td>";
				
			
			// Ordenar usario
		if ($_GET[ordenado]=='nombre_usuario' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=asc\"><b>NOMBRE USUARIO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=desc\"><b>NOMBRE USUARIO</b></a></td>";	
			
		if ($_GET[ordenado]=='ficha_usuario' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=ficha_usuario&ordentipo=asc\"><b>FICHA USUARIO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=ficha_usuario&ordentipo=desc\"><b>FICHA USUARIO</b></a></td>";	
				
		if ($_GET[ordenado]=='cedula_usuario' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=cedula_usuario&ordentipo=asc\"><b>CEDULA USUARIO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=cedula_usuario&ordentipo=desc\"><b>CEDULA USUARIO</b></a></td>";	
							
        if ($_GET[ordenado]=='extension_usuario' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=extension_usuario&ordentipo=asc\"><b>EXTENSION</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=extension_usuario&ordentipo=desc\"><b>EXTENSION</b></a></td>";	
				
				
		while ($row=mysql_fetch_array($_pagi_result)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">";
			echo "<td align=\"left\">$row[7]</td>";
			echo "<td align=\"left\">$row[9]</td>";
			echo "<td align=\"left\">$row[11]</td>";
			echo "<td align=\"left\">$row[13]</td>";				
			echo "<td align=\"left\">$row[5]</td>";			
			echo "<td align=\"left\">$row[2] $row[3]</td>";			
			echo "<td align=\"left\">$row[0]</td>";
			echo "<td align=\"left\">$row[1]</td>";	
			echo "<td align=\"left\">$row[14]</td>";													
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