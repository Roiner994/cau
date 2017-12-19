<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
require_once("membrete.php");
echo "<title>Planta Componenete</title>";
require_once("formularios.php");
require_once("conexionsql.php");
require_once("rptComponenteEquipoComp.php");
require_once("rptResumenComponetorEqipoAdmin.php");


	if ($_GET[idDescripcion]==100)
		$_GET[idDescripcion]="";

	
     conectarMysql();

	
	  $_pagi_sql = "SELECT vistacomponentesasociadosequiposgarantia.configuracion , 
		      	count(componente_id_descripcion),
		      	vistacomponentesasociadosequiposgarantia.equipo_descripcion,
		      	vistacomponentesasociadosequiposgarantia.equipo_id_inventario,
		      	vistacomponentesasociadosequiposgarantia.componente_id_inventario,
		      	vistacomponentes.ID_INVENTARIO,
		      	vistacomponentes.ID_ESTADO,
		      	vistacomponentes.ESTADO,
		      	vistacomponentesasociadosequiposgarantia.activo_fijo,
		      	vistacomponentesasociadosequiposgarantia.equipo_serial
				FROM 
				vistacomponentesasociadosequiposgarantia
				Inner Join vistacomponentes ON vistacomponentesasociadosequiposgarantia.componente_id_inventario = vistacomponentes.ID_INVENTARIO		
				WHERE 
				vistacomponentes.ESTADO	= 'OPERATIVO'
				AND vistacomponentesasociadosequiposgarantia.equipo_descripcion = 'MICROCOMPUTADOR' and
				vistacomponentesasociadosequiposgarantia.componente_id_descripcion ='$idDescripcion'
	    		Group By vistacomponentesasociadosequiposgarantia.configuracion
	    		HAVING count(vistacomponentesasociadosequiposgarantia.componente_id_descripcion ) > 1"; 

     
//cantidad de resultados por página (opcional, por defecto 20)
$_pagi_cuantos = 10;//Elegí un número pequeño para que se generen varias páginas

//cantidad de enlaces que se mostrarán como máximo en la barra de navegación
$_pagi_nav_num_enlaces = 30;//Elegí un número pequeño para que se note el resultado

//Decidimos si queremos que se muesten los errores de mysql
$_pagi_mostrar_errores = false;//recomendado true sólo en tiempo de desarrollo.

//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente, 
//realizamos el conteo alternativo.
$_pagi_conteo_alternativo = true;//recomendado false.

///Supongamos que sólo nos interesa propagar estas dos variables
//$_pagi_propagar = array("idConfiguracion","idDescripcion","marca","modelo","serial","estado","ordenado");//No importa si son POST o GET

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
			echo "<td class=\"tituloPagina\" colspan=\"15\" align=\"center\"> EQUIPOS QUE POSEEN MAS UN COMPONENTE</td>
			</tr>
		<tr>";


		while ($row=mysql_fetch_array($_pagi_result)) {
			echo "</table>";
			echo "<br>";
			echo "<table class=\"formularioTabla\" align=center width=\"80%\" border=\"0\">";
			echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"4\">EQUIPO</td><td class=\"formularioTablaTitulo\"></td>
			</tr>";
			echo "<tr valign=top class=\"tablaTitulo\">
			<td align=\"left\" class=\"campoTitulo\">CONFIGURACI&Oacute;N: <b class=\"campo\">$row[0]</td>
			<td valign=top class=\"campoTitulo\">ACTIVO FIJO: <b class=\"campo\">$row[8]</b></td>
			<td valign=top class=\"campoTitulo\">SERIAL:<b class=\"campo\">$row[9]</td>
			<td valign=top class=\"campoTitulo\">DESCRIPCI&Oacute;N:<b class=\"campo\">$row[2]</td>
			</tr>";			
			echo "</table>";
			echo "<br>";
			echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";
			echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"6\">COMPONENTES ASOCIADOS AL EQUIPO</td><td class=\"formularioTablaTitulo\"></td>
			</tr>";


			$rptComponenteEquipo= new rptComponenteEquipo(); 
						
			$resultado=$rptComponenteEquipo->retornarInventarioComponentes($_GET[idDescripcion],$row[0],"componente_id_descripcion");
		
			if ($resultado && $resultado!=1) {
				echo "<tr valign=top class=\"tablaTitulo\">
				<td align=\"left\" class=\"campoTitulo\">DESCRIPCI&Oacute;N<b class=\"campo\"></td>
				<td valign=top class=\"campoTitulo\">MARCA<b class=\"campo\"></td>
				<td valign=top class=\"campoTitulo\">MODELO<b class=\"campo\"></td>
				<td valign=top class=\"campoTitulo\">SERIAL<b class=\"campo\"></td>
				<td valign=top class=\"campoTitulo\">SITIO<b class=\"campo\"></td>
				<td valign=top class=\"campoTitulo\">ESTADO<b class=\"campo\"></td>
				</tr>";
			
				while ($rowComponentesAsociados=mysql_fetch_array($resultado)) {
					if ($i%2==0) {
						$clase="tablaFilaPar";
					} else {
						$clase="tablaFilaNone";
					}
					echo "<tr valign=top class=\"tablaTitulo\">
					<td >$rowComponentesAsociados[5]</td>
					<td>$rowComponentesAsociados[7]</td>
					<td>$rowComponentesAsociados[9] $rowComponentesAsociados[10] $rowComponentesAsociados[11]</td>
					<td>$rowComponentesAsociados[3]</td>
					<td>$rowComponentesAsociados[20]</td>
					<td>$rowComponentesAsociados[22]</td>
					</tr>";
					$i++;
				}
				echo "</table>";
			}		
			
			echo "</table>";
			echo "</tr>";
			//$i++;
		   }
	
		   echo "<tr>";
		   
	echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=\"12\">".$_pagi_navegacion."</td>";
	echo "</tr>";
	echo "</table>";
		
//Incluimos la información de la página actual
	echo"<p class=\"enlace\" >Resultados ".$_pagi_info."</p>";
		
?>