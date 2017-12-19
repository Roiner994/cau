<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
	require_once("formularios.php");
	require_once("mantenimientoAdmin.php");
	require_once("conexionsql.php");
	

//	$mantenimiento= new mantenimiento();
	if ($_POST[selUsuarioSistema]==100)
		$_POST[selUsuarioSistema]="";
		
	if ($_GET[idGerencia]==100)
		$_GET[idGerencia]="";
		
	if ($_GET[idSitio]==100)
		$_GET[idSitio]="";
		
	if ($_GET[analista]==100)
		$_GET[analista]="";
	
	if ($_GET[idDescripcion]==100)
		$_GET[idDescripcion]="";	

	if ($_GET[idCorrectivo]==100)
		$_GET[idCorrectivo]="";
		
	if ($_GET[idRed]==100)
		$_GET[idRed]="";
		
	if ($_GET[idSistemaOperativo]==100)
		$_GET[idSistemaOperativo]="";

	if ($_GET[idAntivirus]==100)
		$_GET[idAntivirus]="";
		
	if ($_GET[idStatusMantenimiento]==100)
		$_GET[idStatusMantenimiento]="";
				

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

	


//Sentencia sql (sin limit)
$_pagi_sql = "SELECT * FROM vistamantenimientospreventivos 

where
		$rangoFecha 
		vistamantenimientospreventivos.STATUS_MANTENIMIENTO like '%$_GET[idStatusMantenimiento]' and
		vistamantenimientospreventivos.id_uss like '%$_GET[analista]' and
		vistamantenimientospreventivos.id_mantenimiento like '%$idMantenimiento' and
		vistamantenimientospreventivos.ID_GERENCIA like '%$_GET[idGerencia]' and
		vistamantenimientospreventivos.ID_SITIO like '%$_GET[idSitio]' and
		vistamantenimientospreventivos.ID_DESCRIPCION like '%$_GET[idDescripcion]' and 
		vistamantenimientospreventivos.CORRECTIVO like '%$_GET[idCorrectivo]' and
		vistamantenimientospreventivos.SISTEMA_OPERATIVO like '%$_GET[idSistemaOperativo]' and
		vistamantenimientospreventivos.ANTIVIRUS like '%$_GET[idAntivirus]' and
		vistamantenimientospreventivos.RED like '%$_GET[idRed]' and
		vistamantenimientospreventivos.CONFIGURACION like '%$_GET[txtConfiguracion]'
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
$_pagi_propagar = array("idStatusMantenimiento","analista","idGerencia","idSitio","idDescripcion","idCorrectivo",
"idSistemaOperativo","idAntivirus","txtConfiguracion","fechaInicio","fechaFinal","ordenado");//No importa si son POST o GET

//Definimos qué estilo CSS se utilizará para los enlaces de paginación.
//El estilo debe estar definido previamente
$_pagi_nav_estilo = "enlace";

//definimos qué irá en el enlace a la página anterior
$_pagi_nav_anterior = "&lt;";// podría ir un tag <img> o lo que sea

//definimos qué irá en el enlace a la página siguiente
$_pagi_nav_siguiente = "&gt;";// podría ir un tag <img> o lo que sea

//Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
require_once("../paginador/paginator.inc.php");
$evento="<a class=enlace href=\"#\" onclick=\"window.open('detalleMantenimientoporPersona.php?analista=$_GET[analista]&fechaInicio=$_GET[fechaInicio]&fechaFinal=$_GET[fechaFinal]')\"> GENERAR EXCEL </a>";
echo "<table width=\"100%\" border=\"0\" align=\"center\">
		<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"12\" align=\"center\">MANTENIMIENTOS PREVENTIVOS
				
				$evento
			
			</td>
			
			         
			
		</tr>
		<tr>";
		
		
		
		
		

		//Configuracion Ordenar
		if ($_GET[ordenado]=='configuracion' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=configuracion&ordentipo=asc\">CONFIGURACION</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=configuracion&ordentipo=desc\">CONFIGURACION</a></b></td>";

		//Activo Fijo Ordenar
		if ($_GET[ordenado]=='activo_fijo' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=activo_fijo&ordentipo=asc\"><b>ACTIVO FIJO</b></a></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=activo_fijo&ordentipo=desc\"><b>ACTIVO FIJO</b></a></td>";
		//Serial Ordenar
		if ($_GET[ordenado]=='serial' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=serial&ordentipo=asc\">SERIAL</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=serial&ordentipo=desc\">SERIAL</b></a></td>";

		//Descripcion Ordenar
		if ($_GET[ordenado]=='descripcion' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=descripcion&ordentipo=asc\"><b>DESCRIPCION</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=descripcion&ordentipo=desc\"><b>DESCRIPCION</b></a></td>";
		
		
		//Marca Ordenar
		if ($_GET[ordenado]=='marca' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=marca&ordentipo=asc\"><b>MARCA</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=marca&ordentipo=desc\"><b>MARCA</b></a></td>";
		//Modelo Orndenar
		if ($_GET[ordenado]=='modelo' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=modelo&ordentipo=asc\">MODELO</b></a></td>";
		else 	
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=modelo&ordentipo=desc\">MODELO</b></a></td>";
		//Usuario Ordenar
		if ($_GET[ordenado]=='nombre_usuario' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=asc\">USUARIO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=desc\">USUARIO</b></a></td>";
		
		//Extension Ordenar
		if ($_GET[ordenado]=='extension' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=extension&ordentipo=asc\"><b>EXTENSION</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=extension&ordentipo=desc\"><b>EXTENSION</b></a></td>";	

		//Edificio Ordenar
		if ($_GET[ordenado]=='sitio' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=sitio&ordentipo=asc\"><b>EDIFICIO</b></a></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=sitio&ordentipo=desc\"><b>EDIFICIO</b></a></td>";

		//Gerencia Ordenar
		if ($_GET[ordenado]=='gerencia' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=gerencia&ordentipo=asc\"><b>GERENCIA</b></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=gerencia&ordentipo=desc\"><b>GERENCIA</b></td>";
		
		//Tecnico Ordenar
		if ($_GET[ordenado]=='nombre' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre&ordentipo=asc\"><b>TECNICO</b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre&ordentipo=desc\"><b>TECNICO</b></td>";
		
		//Fecha Mantenimiento Ordenar
		if ($_GET[ordenado]=='hora_inicio' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=hora_inicio&ordentipo=asc\"><b>FECHA MANTENIMIENTO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=hora_inicio&ordentipo=desc\"><b>FECHA MANTENIMIENTO</b></a></td>";
		echo "</tr>";
		


//Leemos y escribimos los registros de la página actual
while($row = mysql_fetch_array($_pagi_result)){
	if ($i%2==0) {
		$clase="tablaFilaPar";
	} else {
		$clase="tablaFilaNone";
	}
	echo "<tr class=\"$clase\">";
	echo "<td align=\"left\"><a class=enlace href=\"#\" onclick=\"window.open('rptMantenimiento.php?idMantenimiento=$row[0]')\">$row[1]</a></td>";
	echo "<td align=\"left\">$row[2]</td>";
	echo "<td align=\"left\">$row[6]</td>";
	echo "<td align=\"left\">$row[8]</td>";
	echo "<td align=\"left\">$row[10]</td>";
	echo "<td align=\"left\">$row[12] $row[13] $row[14]</td>";
	echo "<td align=\"left\">$row[19] $row[20]</td>";
	echo "<td align=\"left\">$row[21]</td>";
	echo "<td align=\"left\">$row[31]</td>";
	echo "<td align=\"left\">$row[27]</td>";
	echo "<td align=\"left\">$row[16] $row[17]</td>";
	echo "<td align=\"left\">$row[33]</td>";
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
