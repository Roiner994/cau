<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<script type="text/javascript">
	function actualizar(idRequerimiento) {
		opener.document.frmEquipo.txtIdSolicitud.value=idRequerimiento;
		window.close();
	}

</script>	

<?php
//Nuevos Requerimiento Cerrar.
/*
SE EJECUTAN LOS REQUERIMIENTOS QUE EST�N EN PROCESO O EN ESTADO APROBADO Y QUE LA DESCRIPCION SEA LA MISMA QUE
SE EST� ASIGNANDO Y ADEMAS LA GERENCIA SEA LA MISMA.
*/
require_once("conexionsql.php");

	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}

$_pagi_sql = "select * from vistarequerimientosequipos where id_estado_requerimiento in ('STA0000001','STA0000003') $orden";

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
$_pagi_propagar = array("ordenado");//No importa si son POST o GET

//Definimos qu� estilo CSS se utilizar� para los enlaces de paginaci�n.
//El estilo debe estar definido previamente
$_pagi_nav_estilo = "enlace";

//definimos qu� ir� en el enlace a la p�gina anterior
$_pagi_nav_anterior = "&lt;";// podr�a ir un tag <img> o lo que sea

//definimos qu� ir� en el enlace a la p�gina siguiente
$_pagi_nav_siguiente = "&gt;";// podr�a ir un tag <img> o lo que sea
conectarMysql();
require_once("../paginador/paginator.inc.php");


	echo "<table class=\"formularioTabla\" align=center width=\"100%\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"6\">LISTA DE REQUERIMIENTOS</td>
	</tr>";
	
	
	
	echo "<tr valign=top class=\"tablaTitulo\">";
	
	if ($_GET[ordenado]=='id_detalle_requerimiento' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=id_detalle_requerimiento&ordentipo=asc\">ID SOLICITUD</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=id_detalle_requerimiento&ordentipo=desc\">ID SOLICITUD</a></b></td>";

	if ($_GET[ordenado]=='descripcion' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=descripcion&ordentipo=asc\">DESCRIPCION</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=descripcion&ordentipo=desc\">DESCRIPCION</a></b></td>";
	if ($_GET[ordenado]=='nombre_usuario' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=asc\">USUARIO</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=desc\">USUARIO</a></b></td>";

	if ($_GET[ordenado]=='extension' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=extension&ordentipo=asc\">EXTENSION</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=extension&ordentipo=desc\">EXTENSION</a></b></td>";

	if ($_GET[ordenado]=='gerencia' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=gerencia&ordentipo=asc\">GERENCIA</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=gerencia&ordentipo=desc\">GERENCIA</a></b></td>";

	if ($_GET[ordenado]=='descripcion_detalle' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=descripcion_detalle&ordentipo=asc\">DETALLE</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=descripcion_detalle&ordentipo=desc\">DETALLE</a></b></td>";
			
	while ($row=mysql_fetch_array($_pagi_result)) {
		$i++;
		if ($i%2==0) {
			$clase="tablaFilaPar";
		} else {
			$clase="tablaFilaNone";
		}
		echo "<tr class=\"$clase\">
					<td align=\"left\"><a class=\"enlace\" href=\"#\" onclick=\"actualizar('$row[1]')\")\">$row[1]</a></td>
					<td>$row[21]</td>
					<td>$row[3] $row[4]</td>
					<td>$row[15]</td>
					<td>$row[8]</td>
					<td>$row[22]</td>
				</tr>";
		echo "<tr>";		

	}
   echo "<tr>";
	echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=\"12\">".$_pagi_navegacion."</td>";
	echo "</tr>";

	echo "</table>";
//Incluimos la informaci�n de la p�gina actual
	echo"<p class=\"enlace\" >Resultados ".$_pagi_info."</p>";	
	mysql_close();




?>