<?php
//Reporte de Mantenimientos por personas
?>
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
<script language="javascript">
	function buscar() {
		document.frmMantenimiento.funcion.value=0;
	 	document.frmMantenimiento.submit();
	}
	function generarReporte(analista) {
		fechaInicio=document.frmMantenimiento.txtFechaInicio.value;
		fechaFinal=document.frmMantenimiento.txtFechaFinal.value;
		window.open('../librerias/rptResumenMantenimientos.php?analista='+analista+'&fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal);	
	}
	
	function generarExcel(analista){
		fechaInicio=document.frmMantenimiento.txtFechaInicio.value;
		fechaFinal=document.frmMantenimiento.txtFechaFinal.value;
		window.open('../librerias/detalleMantenimientoporPersona.php?analista='+analista+'&fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal);	
	}
</script>
<?php
switch ($funcion) {
	case 1:
		break 1;
	case 2:
		break 2;
	default:
		frmMantenimiento();	
}

function frmMantenimiento() {
	require_once("formularios.php");
	require_once("mantenimientoAdmin.php");
	
	$fecha=getdate();
	$conParamMantenimiento="select id_mes,mes,cantidad,personal,(cantidad/personal) promedio from param_mantenimiento where id_mes=$fecha[mon]";
	conectarMysql();
	$result=mysql_query($conParamMantenimiento);
	mysql_close();
	if ($result && mysql_numrows($result)>0) {
		$rowParam=mysql_fetch_array($result);
	}
	$conUss="SELECT distinct usuario_sistema.ID_USS, concat(nombre,' ',apellido) as nombres From mantenimiento_preventivo Inner Join usuario_sistema ON mantenimiento_preventivo.ID_USS = usuario_sistema.ID_USS  where usuario_sistema.status_activo=1 order by nombres";
	if (isset($_POST[txtFechaInicio]) && !empty($_POST[txtFechaInicio])) { 
		$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10");
	}
	else {
		$fecha=getdate();
		$dia='01';
			$mes="$fecha[mon]";
		if (strlen($fecha[mon])==1) {
			$mes="0$mes";
		}
	$anho=$fecha[year];
		$_POST[txtFechaInicio]="$dia/$mes/$anho";
		$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10");
	}
	$txtFechaInicio=$fechaInicio->retornar();

	if (isset($_POST[txtFechaFinal]) && !empty($_POST[txtFechaFinal])) {
		$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
	} else {
		$fecha=getdate();
		$dia='01';
		$mes=$fecha[mon]+1;
		if (strlen($fecha[mon])==1) {
			$mes="0$mes";
		}
		$anho=$fecha[year];
		$_POST[txtFechaFinal]="$dia/$mes/$anho";
		$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
	}
	$txtFechaFinal=$fechaFinal->retornar();
	
	$usuarioSistema= new campoSeleccion("selUsuarioSistema","formularioCampoSeleccion","$_POST[selUsuarioSistema]","","",$conUss,"--TODOS--","");
	$selUsuarioSistema=$usuarioSistema->retornar();	
	
	echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
		echo "<table class=\"formularioTabla\"align=center width=\"580\" border=\"0\">";
		echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">MANTENIMIENTOS PREVENTIVOS POR PERSONAS</td>
	  				</tr>";
		echo "<tr>";
		echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">SELECCCIONE EL RANGO DE FECHA O EL ANALISTA</td>
		</tr>";
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\" >FECHA INICIAL<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmMantenimiento.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a><br>
		FECHA FINAL<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmMantenimiento.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a><br>
		ANALISTA<br>$selUsuarioSistema<br></td>
		<td class=\"tituloPagina\" align=\"center\">METAS PARA EL MES DE $rowParam[1]:<BR>$rowParam[2] EQUIPOS.</td>
		
		</tr>";
		echo "<tr>";
		echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=301'\">
		<input name=\"Limpiar\" type=\"button\" value=\"BUSCAR\" onClick=\"buscar()\"></td>
		</tr>";
		echo "</table>";

	$mantenimiento= new mantenimiento();
	if ($_POST[selUsuarioSistema]==100)
		$_POST[selUsuarioSistema]="";
		
	$resultado=$mantenimiento->retornaMantenimientosPorPersonas($_POST[txtFechaInicio],$_POST[txtFechaFinal],$_POST[selUsuarioSistema]);
	if ($resultado && $resultado!=1) {
		$plan=(int)($rowParam[4]);
		echo "<table width=\"40%\" border=\"0\" align=\"center\">
		<tr>
		<td valign=top class=\"tablaTitulo\" colspan=\"6\"><b>RESULTADO DE LA BUSQUEDA</b></td>
		</tr>
		<tr>
		<td valign=top class=\"tablaTitulo\"><b>ANALISTA</b></td>
		<td valign=top class=\"tablaTitulo\"><b>META POR PERSONA</b></td>
		<td valign=top class=\"tablaTitulo\"><b>EJECUTADOS</b></td>		  
		<td valign=top class=\"tablaTitulo\"><b>RESTAN</b></td>		  
		<td valign=top class=\"tablaTitulo\"><b>TIEMPO (HORAS)</b></td>
		<td valign=top class=\"tablaTitulo\"><b>PROMEDIO</b></td>
		</tr>";
		$total=0;
		while ($row=mysql_fetch_array($resultado)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">";
			echo "<td align=\"left\"><a class=enlace href=\"#\" onclick=\"generarReporte('$row[0]')\">$row[1] $row[2]</a> </td>";
			echo "<td align=\"left\">$plan</td>";
			echo "<td align=\"left\">$row[3]</td>";
			echo "<td align=\"left\">".(int)($plan-$row[3])."</td>";
			echo "<td align=\"left\">$row[4]</td>";
			echo "<td align=\"left\">$row[5]</td>";
			echo "</tr>";
			$total=$total+$row[3];
			$horaTotal=$horaTotal+$row[4];
			$restan=$restan+(int)($plan-$row[3]);
			$promedioTotal=$promedioTotal+$row[5];
			$i++;
		}
		
		echo "<tr class=\"$clase\">";
		echo "<td align=\"left\"> <a class=enlace href=\"#\" onclick=\"generarExcel('')\"> TOTAL </a></td>";
		echo "<td align=\"left\"><b>$rowParam[2]</b></td>";
		echo "<td align=\"left\"><b>$total</b></td>";
		echo "<td align=\"left\"><b>$restan</b></td>";
		echo "<td align=\"left\"><b>$horaTotal</b></td>";
		echo "<td align=\"left\"><b>$promedioTotal</b></td>";
		echo "</tr>";
		
		echo "</table>";
	} else {
		echo "<table width=\"70%\" border=\"0\" align=\"center\">
		<tr>
		<td valign=top class=\"tablaTitulo\" colspan=\"4\"><b>NO HAY RESULTADO</b></td>
		</tr>
		</table";
		
	}
}
?>
