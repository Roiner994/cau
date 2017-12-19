<?php
require_once ("formularios.php");
require_once ("conexionsql.php");
require_once ("inventarioAdmin.php");
?>
<script type="text/javascript" src="date-picker.js"></script>
<script language="javascript">
	
		
	function generarExcel(){			
			sitio=document.frmEquipo.selSitio.value;			
			inicial=document.frmEquipo.txtFechaInicio.value;
			fin=document.frmEquipo.txtFechaFinal.value;			
			window.open('../librerias/rptEjecucionEdificiosExcel.php?sitio='+sitio+"&inicial="+inicial+"&final="+fin);		
	}
	
	function generarReporte(){						
			sitio=document.frmEquipo.selSitio.value;			
			inicial=document.frmEquipo.txtFechaInicio.value;
			fin=document.frmEquipo.txtFechaFinal.value;			
			window.open('../librerias/rptResumenEjecucionEdificios.php?sitio='+sitio+"&inicial="+inicial+"&final="+fin);		
	}
	
</script>
<?php
$conSitio="SELECT ID_SITIO,SITIO FROM sitio ORDER BY SITIO";
$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--SITIO--","");
$selSitio=$sitio->retornar();

$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10");
$txtFechaInicio=$fechaInicio->retornar();

$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
$txtFechaFinal=$fechaFinal->retornar();
echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"500\" border=\"0\">";
	
		echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">INVENTARIO - REPORTE DE EJECUCION DE MANTENIMIENTOS POR EDIFICIOS</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">SELECCIONE EL EDIFICIO</td>
  				</tr>";
			echo "<tr>";
			echo "<td class=\"formularioCampoTitulo\">UBICACION<br>$selSitio<br>";
			echo "</tr>";
			
			echo "<tr>";			
			echo "<td valign=top class=\"formularioCampoTitulo\" >FECHA INICIAL<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmEquipo.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></td>";
			echo "</tr>";			
			
			echo "<tr>";			
			echo "<td valign=top class=\"formularioCampoTitulo\" >FECHA FINAL<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmEquipo.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></td>";
			echo "</tr>";
			
			
			echo "<tr>
			<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"2\">
			<input name=\"btnBuscar\" type=\"submit\" value=\"BUSCAR\">
			</td>
			</tr>";
			
			echo "<tr>";
		echo "<td class=\"formularioTablaBotones\" colspan=\"2\">GENERAR REPORTE |
		<a class=enlace href=\"#\" onclick=\"generarReporte();\">HTML</a> | <a class=enlace href=\"#\" onclick=\"generarExcel();\">EXCEL</a><br>		
		
		</tr>";
		echo "</table>";
		
	echo "</form>";		
	
	
	
	
	if ($_POST[selSitio]!=100 && !empty($_POST[selSitio])) {
		$equipo= new equipo ();
		$equipo->setInventarioUbicacion("",$_POST[selSitio]);		
		$resultado=$equipo->retornarReporteEjecucionEquipoEdificios($_POST['txtFechaInicio'],$_POST['txtFechaFinal']);
		
		if ($resultado && $resultado!=1) {			
			
			if($resultado==1)
				exit();
				echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
			echo "<tr>
			<td class=\"formularioTablaTitulo\" colspan=\"6\">$row[13]</td>
			</tr>";	
			echo "<tr valign=top class=\"tablaTitulo\">
				<td align=\"left\" class=\"tablaTitulo\">CONFIGURACION</td>
				<td valign=top class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
				<td valign=top class=\"tablaTitulo\">MARCA</td>
				<td valign=top class=\"tablaTitulo\">MODELO</td>				
				<td valign=top class=\"tablaTitulo\">VALIDADO</td>
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
						<td>$row[9] $row[10] $row[11]</td>";						
						$st=$row[17]+0;
						$st = $st ? "true" : "false";
						$Id= new campo($row[14],"checkbox","","","","","onclick","this.checked=!this.checked; window.open('../librerias/RegistrarDetalleMantenimiento.php?target=".$row[14]."','','width=550,height=250,status=no,resizable=no,top=200,left=500');",$row[17]+0,$row[14]);
						$txtId=$Id->retornar();
						
						
					echo "<td>
						$txtId
						</td>	
						
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
