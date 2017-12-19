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

     
//cantidad de resultados por p�gina (opcional, por defecto 20)
$_pagi_cuantos = 10;//Eleg� un n�mero peque�o para que se generen varias p�ginas

//cantidad de enlaces que se mostrar�n como m�ximo en la barra de navegaci�n
$_pagi_nav_num_enlaces = 30;//Eleg� un n�mero peque�o para que se note el resultado

//Decidimos si queremos que se muesten los errores de mysql
$_pagi_mostrar_errores = false;//recomendado true s�lo en tiempo de desarrollo.

//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente, 
//realizamos el conteo alternativo.
$_pagi_conteo_alternativo = true;//recomendado false.

///Supongamos que s�lo nos interesa propagar estas dos variables
//$_pagi_propagar = array("idConfiguracion","idDescripcion","marca","modelo","serial","estado","ordenado");//No importa si son POST o GET

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
		
//Incluimos la informaci�n de la p�gina actual
	echo"<p class=\"enlace\" >Resultados ".$_pagi_info."</p>";
		
?>