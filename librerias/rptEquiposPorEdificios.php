<script language="javascript">
	
	
	
	
	function generarExcel(){						
			sitio=document.frmEquipo.selSitio.value;			
			window.open('../librerias/rptEquiposPorEdificiosExcel.php?sitio='+sitio);		
	}
	

</script>




<?php
require_once ("formularios.php");
require_once ("conexionsql.php");
require_once ("inventarioAdmin.php");
$conSitio="SELECT ID_SITIO,SITIO FROM sitio ORDER BY SITIO";
$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--SITIO--","");
$selSitio=$sitio->retornar();

$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10");
$txtFechaInicio=$fechaInicio->retornar();

	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">INVENTARIO - REPORTE DE EQUIPOS POR EDIFICIOS</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">SELECCIONE EL EDIFICIO</td>
  				</tr>";
			echo "<tr>";
			echo "<td class=\"formularioCampoTitulo\">UBICACION<br>$selSitio<br>";
			echo "</tr>";	
			
			echo "<tr>";
		echo "<td class=\"formularioTablaBotones\" colspan=\"2\">GENERAR REPORTE |
		<a class=enlace href=\"#\" onclick=\"generarExcel();\"> EXCEL </a> |
		
		</tr>";
			
			
			echo "<tr>
			<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"2\">
			<input name=\"btnBuscar\" type=\"submit\" value=\"BUSCAR\">
			</td>
			</tr>";
		echo "</table>";
		
	echo "</form>";
		if (!empty($_POST[selSitio])) {
		$equipo= new equipo ();
		if($_POST[selSitio]==100)$_POST[selSitio]="";
		set_time_limit(70);
		$equipo->setInventarioUbicacion("",$_POST[selSitio]);
		$resultado=$equipo->retornarReporteEquipoEdificios();
		if ($resultado && $resultado!=1) {
			$row=mysql_fetch_array($resultado);
			
			
			
				echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
			echo "<tr>
			<td class=\"formularioTablaTitulo\" colspan=\"6\">$row[13]</td>
			</tr>";	
			echo "<tr valign=top class=\"tablaTitulo\">
				<td align=\"left\" class=\"tablaTitulo\">CONFIGURACION</td>
				<td valign=top class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
				<td valign=top class=\"tablaTitulo\">MARCA</td>
				<td valign=top class=\"tablaTitulo\">MODELO</td>
				<td valign=top class=\"tablaTitulo\">SERIAL</td>
				<td valign=top class=\"tablaTitulo\">USUARIO</td>
				<td valign=top class=\"tablaTitulo\">SITIO</td>				
				<td valign=top class=\"tablaTitulo\">FICHA</td>
				
				<td valign=top class=\"tablaTitulo\">GERENCIA</td>				
				<td valign=top class=\"tablaTitulo\">MANT</td>
				</tr>";
				while ($row=mysql_fetch_array($resultado)) {
						if ($i%2==0) {
							$clase="tablaFilaPar";
						} else {
							$clase="tablaFilaNone";
						}
						echo "<tr class=\"$clase\">
						<td align=\"left\"><a class=enlace href=\"../librerias/EquipoDetalle.php?configuracion=$row[0]\">$row[0]</a></td>
						<td>$row[5]</td>	
						<td>$row[7]</td>
						<td>$row[9] $row[10] $row[11]</td>
						<td>$row[3]</td>
						<td>$row[15]</td>
						<td>$row[18]</td>
						<td>$row[16]</td>
						<td>$row[17]</td>";
						
						echo "<td>$row[14]</td>
						</tr>";
						$i++;	
					}	
			echo "<tr>
				<td class=\"formularioTablaTitulo\" colspan=\"6\">MICROCOMPUTADOR: ".$equipo->retornarCantidadPorSitio('DES0000001')."<br>
				IMPRESORAS: ".$equipo->retornarCantidadPorSitio('DES0000008').
				"<br>LAPTOP: ".$equipo->retornarCantidadPorSitio('DES0000042')."</td>
				</tr>";
		}
		

		}
		echo "</table>";
?>
