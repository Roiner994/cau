<?php
//Reporte Mantenimiento Radar
?>
<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
	require_once("formularios.php");
	require_once("mantenimientoAdmin.php");
	require_once("conexionsql.php");
	

//	$mantenimiento= new mantenimiento();
		
	if ($_GET[idSitio]==100)
		$_GET[idSitio]="";
		

conectarMysql();


	if ((isset($_GET[fechaInicio]) && !empty($_GET[fechaInicio])) && (isset($_GET[fechaFinal]) && !empty($_GET[fechaFinal]))) {
		$FechaInicio=substr($_GET[fechaInicio],6,6)."-".substr($_GET[fechaInicio],3,2)."-".substr($_GET[fechaInicio],0,2);
		$FechaFinal=substr($_GET[fechaFinal],6,6)."-".substr($_GET[fechaFinal],3,2)."-".substr($_GET[fechaFinal],0,2);
	}
	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}

	


//Sentencia sql (sin limit)
$_pagi_sql = "Select
			sitio.ID_SITIO,
			sitio.SITIO,
			mantenimiento_preventivo.CONFIGURACION,
			descripcion.DESCRIPCION,
			marca.MARCA,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD,
			inventario.ID_INVENTARIO,
			inventario.SERIAL,
			usuario.FICHA,
			usuario.NOMBRE_USUARIO,
			usuario.APELLIDO_USUARIO,
			usuario.EXTENSION,
			inventario_propiedad.ID_ESTADO,
			inventario_estado.ESTADO,
			inventario_propiedad.FECHA_ASOCIACION,
			inventario_propiedad.STATUS_ACTUAL
			From
			mantenimiento_preventivo
			Inner Join equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Inner Join usuario ON mantenimiento_preventivo.FICHA = usuario.FICHA
			Inner Join inventario_propiedad ON inventario.ID_INVENTARIO = inventario_propiedad.ID_INVENTARIO
			Inner Join inventario_estado ON inventario_propiedad.ID_ESTADO = inventario_estado.ID_ESTADO
			Where
			sitio.ID_SITIO Like '%$_GET[idSitio]' AND
			(mantenimiento_preventivo.HORA_INICIO between '$FechaInicio' and '$FechaFinal') AND inventario_propiedad.status_actual=1 and mantenimiento_preventivo.configuracion not in (Select
			mantenimiento_preventivo.CONFIGURACION
			From
			mantenimiento_preventivo
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Where
			sitio.ID_SITIO Like '%$_GET[idSitio]' AND
			mantenimiento_preventivo.HORA_INICIO > '$FechaFinal'
			Group By
			mantenimiento_preventivo.CONFIGURACION
			)
			Group By
			mantenimiento_preventivo.CONFIGURACION
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
$_pagi_propagar = array("fechaInicio","fechaFinal","idSitio","ordenado");//No importa si son POST o GET

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
			echo "<td class=\"tituloPagina\" colspan=\"12\" align=\"center\">MANTENIMIENTOS PREVENTIVOS</td>
		</tr>
		<tr>";

		//Configuracion Ordenar
		if ($_GET[ordenado]=='sitio' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=sitio&ordentipo=asc\">SITIO</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=sitio&ordentipo=desc\">SITIO</a></b></td>";

		//Activo Fijo Ordenar
		if ($_GET[ordenado]=='configuracion' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=configuracion&ordentipo=asc\"><b>CONFIGURACION</b></a></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=configuracion&ordentipo=desc\"><b>CONFIGURACION</b></a></td>";
		//Serial Ordenar
		if ($_GET[ordenado]=='descripcion' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=descripcion&ordentipo=asc\">DESCRIPCION</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=descripcion&ordentipo=desc\">DESCRIPCION</b></a></td>";

		//Descripcion Ordenar
		if ($_GET[ordenado]=='marca' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=marca&ordentipo=asc\"><b>MARCA</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=marca&ordentipo=desc\"><b>MARCA</b></a></td>";
		
		
		//Marca Ordenar
		if ($_GET[ordenado]=='modelo' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=modelo&ordentipo=asc\"><b>MODELO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=modelo&ordentipo=desc\"><b>MODELO</b></a></td>";
		//Modelo Orndenar
		if ($_GET[ordenado]=='estado' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=estado&ordentipo=asc\">ESTADO</b></a></td>";
		else 	
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=estado&ordentipo=desc\">ESTADO</b></a></td>";
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

	
//Leemos y escribimos los registros de la página actual
while($row = mysql_fetch_array($_pagi_result)){
	if ($i%2==0) {
		$clase="tablaFilaPar";
	} else {
		$clase="tablaFilaNone";
	}
	echo "<tr class=\"$clase\">";
	echo "<td align=\"left\">$row[1]</td>";
	echo "<td align=\"left\"><a class=enlace href=\"EquipoDetalle.php?configuracion=$row[2]\">$row[2]</a></td>";
	echo "<td align=\"left\">$row[3]</td>";
	echo "<td align=\"left\">$row[4]</td>";
	echo "<td align=\"left\">$row[5] $row[6] $row[7]</td>";
	echo "<td align=\"left\">$row[15]</td>";
	echo "<td align=\"left\">$row[11] $row[12]</td>";
	echo "<td align=\"left\">$row[13]</td>";
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