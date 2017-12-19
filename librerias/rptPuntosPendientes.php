<?php
//Reporte de Puntos Pendientes
?>
<script type="text/javascript" src="date-picker.js"></script>
<script type="text/javascript">
	
	 function generarExcel() {
		sitio=document.frmEquipo.selSitio.value;
		estado=document.frmEquipo.selPendiente.value;
		tipo=document.frmEquipo.selTipoPendiente.value;
		fechaInicio=document.frmEquipo.txtFechaInicio.value;		
		fechaFinal=document.frmEquipo.txtFechaFinal.value;
		window.open('../librerias/rptResumenPendientesExcel.php?sitio='+sitio+'&estado='+estado+'&tipo='+tipo+'&fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal);

		
	}
	
</script>


<?php
		require_once("formularios.php");
		require_once("puntoPendienteAdmin.php");
			$conTipoPendiente="Select
				tipo_punto_pendiente.ID_TIPO_PENDIENTE,
				tipo_punto_pendiente.NOMBRE_PUNTO_PENDIENTE
				From
				tipo_punto_pendiente
				Order By
				tipo_punto_pendiente.NOMBRE_PUNTO_PENDIENTE Asc";

	$conSitio="select id_sitio,sitio from sitio where status_activo=1 order by sitio";
			
	//Campo Fecha Inicio
	$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10","","");
	$txtFechaInicio=$fechaInicio->retornar();

	//Campo Fecha Final
	$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
	$txtFechaFinal=$fechaFinal->retornar();			
	$tipoPendiente= new campoSeleccion("selTipoPendiente","formularioCampoSeleccion","$_POST[selTipoPendiente]","","",$conTipoPendiente,"--TODOS--","");
	$selTipoPendiente=$tipoPendiente->retornar();
	
	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--TODOS--","");
	$selSitio=$sitio->retornar();

	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">INVENTARIO - NUEVO EQUIPO</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL EQUIPO</td>
  				</tr>
  		<tr>
  		<td colspan=\"2\" valign=top class=\"formularioCampoTitulo\">SITIO</td>
  		</tr>		
  		<tr>
  		<td colspan=\"2\" valign=top class=\"formularioCampoTitulo\">$selSitio</td>
  		</tr>		
  				
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">ESTADO<br>
			<select name=\"selPendiente\" class=\"formularioSeleccion\">";
			if ($_POST[selPendiente]==0) {
				echo "<option selected value=\"0\">PENDIENTE POR RESOLVER</option>";
				echo "<option value=\"1\">RESUELTOS</option>";
			} else {
				echo "<option value=\"0\">PENDIENTES POR RESOLVER</option>";
				echo "<option selected value=\"1\">RESUELTOS</option>";
			}
			echo "</select><br>
			FECHA INICIO<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmEquipo.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a><br>
			</td>
    		
			<td valign=top class=\"formularioCampoTitulo\">TIPO<br>
			$selTipoPendiente<br>
			FECHA FINAL<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmEquipo.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a><br>
			</td>
		</tr>";
	 	echo "<tr>";
		echo "<td class=\"formularioTablaBotones\" colspan=\"2\">GENERAR REPORTE | <a class=enlace href=\"#\" onclick=\"generarExcel()\">EXCEL</a><br>
			  <input name=\"Buscar\" type=\"submit\" value=\"Buscar\">		
		</td>			
		</tr>";	
	echo "</table>";
	echo "</form>";	
	
				echo "<br><br>";
				if ($_POST[selTipoPendiente]==100)
					$_POST[selTipoPendiente]="";
				$puntosPendientes= new puntoPendiente();
				$puntosPendientes->setPuntoPendiente();
				$puntosPendientes->setDetallePuntoPendiente("",$_POST[selTipoPendiente],"",$_POST[selPendiente]);
				$resultado=$puntosPendientes->retornarPuntosPendientes($_POST[txtFechaInicio],$_POST[txtFechaFinal],$_POST[selSitio]);	
				if ($resultado && $resultado!=1) {
					echo "<table width=\"70%\" border=\"0\" align=\"center\">
					<tr>";
						echo "<td class=\"tituloPagina\" colspan=\"6\" align=\"center\">PUNTOS PENDIENTE ACTUALES</td>
					</tr>";
					echo "<tr valign=top class=\"tablaTitulo\">
					<td align=\"left\" class=\"tablaTitulo\">CONFIGURACION</td>
					<td valign=top class=\"tablaTitulo\">ANALISTA</td>
					<td valign=top class=\"tablaTitulo\">TIPO DE PUNTO PENDIENTE</td>
					<td valign=top class=\"tablaTitulo\">OBSERVACION</td>
					<td valign=top class=\"tablaTitulo\">SITIO</td>
					<td valign=top class=\"tablaTitulo\">FECHA</td>
					</tr>";	

					while ($row=mysql_fetch_array($resultado)) {
						if ($i%2==0) {
							$clase="tablaFilaPar";
						} else {
							$clase="tablaFilaNone";
						}
						echo "<tr class=\"$clase\">
							<td align=\"left\"><a class=enlace href=\"index2.php?item=10&idPendiente=$row[0]\">$row[1]</a></td>
							<td>$row[9] $row[10]</td>
							<td>$row[5]</td>
							<td>$row[6]</td>
							<td>$row[19]</td>
							<td>$row[11]</td>
						</tr>";
						$i++;
					}
				}
				echo "</table>";	

?>
