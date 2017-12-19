<?php
//Mantenimiento Preventivo Radar
?>

<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
<script language="javascript">
	function generarHtml() {
		fechaInicio=document.frmMantenimiento.txtFechaInicio.value;
		fechaFinal=document.frmMantenimiento.txtFechaFinal.value;
		idSitio=document.frmMantenimiento.selSitio.value;
		window.open('../librerias/rptMantenimientoRadar.php?fechaInicio='+fechaInicio+'&idSitio='+idSitio+'&fechaFinal='+fechaFinal);	
	}
	function generarExcel() {
		fechaInicio=document.frmMantenimiento.txtFechaInicio.value;
		idSitio=document.frmMantenimiento.selSitio.value;
		window.open('../librerias/rptMantenimientoRadarExcel.php?fechaInicio='+fechaInicio+'&idSitio='+idSitio+'&fechaFinal='+fechaFinal);	
	}	
</script>

<?php
switch ($funcion) {
	case 1:
		break 1;
	case 2:
		break 1;
	default:
		frmReporte();	
}

function frmReporte() {
	require_once("formularios.php");
	require_once("mantenimientoAdmin.php");
		
	
		$conSitio="select id_sitio,sitio from sitio where status_activo=1 order by sitio";
		
		$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10");
		$txtFechaInicio=$fechaInicio->retornar();

		$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
		$txtFechaFinal=$fechaFinal->retornar();		
		
		$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--TODOS--","");
		$selSitio=$sitio->retornar();		
		
		echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
		echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
		echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">MANTENIMIENTOS RADAR DE EQUIPOS</td>
	  	</tr>";
		echo "<tr>";
		echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">INGRESE LOS DATOS</td>
		</tr>";
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\">
		FECHA INICIO<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmMantenimiento.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></td>
		<td valign=top class=\"formularioCampoTitulo\">
		FECHA FINAL<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmMantenimiento.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></td>
		</tr>";
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\">EDIFICIO<br>$selSitio</td>
		</tr>";
		echo "<tr>";
		echo "<td class=\"formularioTablaBotones\" colspan=\"2\">GENERAR REPORTE |
		<a class=enlace href=\"#\" onclick=\"generarHtml()\">HTML</a> | <a class=enlace href=\"#\" onclick=\"generarExcel()\">EXCEL</a></td>
		</tr>";	
		echo "</table>";
		echo "</form>";
}
?>