<?php
//Reportes de Mantenimientos Preventivos
?>
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
<script language="javascript">
	function generarReporteGestion() {
		fechaInicio=document.frmMantenimiento.txtFechaInicio.value;
		fechaFinal=document.frmMantenimiento.txtFechaFinal.value;
		window.open('../librerias/pdfMantPreventivoGestion.php?fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal);	
	}
	function generarEvaluacionServicios() {
		fechaInicio=document.frmMantenimiento.txtFechaInicio.value;
		fechaFinal=document.frmMantenimiento.txtFechaFinal.value;
		window.open('../librerias/pdfMantenimientoEvaluacionServicios.php?fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal);	
	}
	function generarReporte() {
		fechaInicio=document.frmMantenimiento.txtFechaInicio.value;
		fechaFinal=document.frmMantenimiento.txtFechaFinal.value;
		idGerencia=document.frmMantenimiento.selGerencia.value;
		idSitio=document.frmMantenimiento.selSitio.value;
		analista=document.frmMantenimiento.selUsuarioSistema.value;
		idDescripcion=document.frmMantenimiento.selDescripcion.value;
		idCorrectivo=document.frmMantenimiento.selCorrectivo.value;
		idSistemaOperativo=document.frmMantenimiento.selSistemaOperativo.value;
		idAntivirus=document.frmMantenimiento.selAntivirus.value;
		idRed=document.frmMantenimiento.selStatusRed.value;
		idStatusMantenimiento=document.frmMantenimiento.selStatusMantenimiento.value;
		txtConfiguracion=document.frmMantenimiento.txtConfiguracion.value;
		window.open('../librerias/rptResumenMantenimientos.php?fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal+'&idGerencia='+idGerencia+'&idSitio='+idSitio
		+'&analista='+analista+'&idDescripcion='+idDescripcion+'&idCorrectivo='+idCorrectivo+'&idSistemaOperativo='+idSistemaOperativo+'&idAntivirus='+idAntivirus
		+'&idStatusMantenimiento='+idStatusMantenimiento+'&txtConfiguracion='+txtConfiguracion+'&idRed='+idRed);	
	}

	function generarExcel() {
		fechaInicio=document.frmMantenimiento.txtFechaInicio.value;
		fechaFinal=document.frmMantenimiento.txtFechaFinal.value;
		idGerencia=document.frmMantenimiento.selGerencia.value;
		idSitio=document.frmMantenimiento.selSitio.value;
		analista=document.frmMantenimiento.selUsuarioSistema.value;
		idDescripcion=document.frmMantenimiento.selDescripcion.value;
		idCorrectivo=document.frmMantenimiento.selCorrectivo.value;
		idSistemaOperativo=document.frmMantenimiento.selSistemaOperativo.value;
		idAntivirus=document.frmMantenimiento.selAntivirus.value;
		idRed=document.frmMantenimiento.selStatusRed.value;
		idStatusMantenimiento=document.frmMantenimiento.selStatusMantenimiento.value;
		txtConfiguracion=document.frmMantenimiento.txtConfiguracion.value;
		window.open('../librerias/rptResumenMantenimientosExcel.php?fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal+'&idGerencia='+idGerencia+'&idSitio='+idSitio
		+'&analista='+analista+'&idDescripcion='+idDescripcion+'&idCorrectivo='+idCorrectivo+'&idSistemaOperativo='+idSistemaOperativo+'&idAntivirus='+idAntivirus
		+'&idStatusMantenimiento='+idStatusMantenimiento+'&txtConfiguracion='+txtConfiguracion+'&idRed='+idRed);	
	}	
</script>
	<?php
	require_once("formularios.php");
	require_once("mantenimientoAdmin.php");
	
	$conUss="SELECT distinct usuario_sistema.ID_USS, concat(nombre,' ',apellido) as nombres From mantenimiento_preventivo Inner Join usuario_sistema ON mantenimiento_preventivo.ID_USS = usuario_sistema.ID_USS  where usuario_sistema.status_activo=1 order by nombres";
	
	$conSitio="select id_sitio,sitio from sitio where status_activo=1 order by sitio";
	
	$conSistemaOperativo="select distinct vistamantenimientospreventivos.sistema_operativo,
		CASE vistamantenimientospreventivos.sistema_operativo
		WHEN 0 THEN 'ACTUALIZADO'
		WHEN 1 THEN 'NO ACTUALIZADO' end AS SISTEMA_OPERATIVO from vistamantenimientospreventivos order by sistema_operativo";
	
	$conStatusMantenimiento="select distinct vistamantenimientospreventivos.status_mantenimiento,
		CASE vistamantenimientospreventivos.status_mantenimiento
		WHEN 1 THEN 'EN PROCESO'
		WHEN 2 THEN 'CULMINADOS' end AS ESTADO_MANTENIMIENTO from vistamantenimientospreventivos order by ESTADO_MANTENIMIENTO";
	
	$conAntivirus="select distinct vistamantenimientospreventivos.antivirus,
		CASE vistamantenimientospreventivos.antivirus
		WHEN 1 THEN 'NO ACTUALIZADO'
		WHEN 0 THEN 'ACTUALIZADO' end AS antivirus from vistamantenimientospreventivos order by antivirus";
	
	$conRed="select distinct vistamantenimientospreventivos.RED,
		CASE vistamantenimientospreventivos.RED
		WHEN 1 THEN 'NO CONECTADO A RED'
		WHEN 0 THEN 'CONECTADO A RED' end AS RED from vistamantenimientospreventivos order by RED";
	
	$conCorrectivo="select distinct vistamantenimientospreventivos.CORRECTIVO,
		CASE vistamantenimientospreventivos.CORRECTIVO
		WHEN 0 THEN 'NO GENERO MANTENIMIENTO CORRECTIVO'
		WHEN 1 THEN 'GENERO MANTENIMIENTO CORRECTIVO' end AS CORRECTIVO from vistamantenimientospreventivos order by CORRECTIVO";
	
	
	$conGerencia="select id_gerencia,gerencia from gerencia where status_activo=1 order by gerencia";

	$conDescripcion="Select
		vistamantenimientospreventivos.ID_DESCRIPCION,
		vistamantenimientospreventivos.DESCRIPCION
		From
		vistamantenimientospreventivos
		
		Group By
		vistamantenimientospreventivos.ID_DESCRIPCION
		Order By
		vistamantenimientospreventivos.DESCRIPCION Asc";
	
	$usuarioSistema= new campoSeleccion("selUsuarioSistema","formularioCampoSeleccion","$_POST[selUsuarioSistema]","","",$conUss,"--TODOS--","");
	$selUsuarioSistema=$usuarioSistema->retornar();

	$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion","$_POST[selDescripcion]","","",$conDescripcion,"--TODOS--","");
	$selDescripcion=$descripcion->retornar();	
		
	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--TODOS--","");
	$selSitio=$sitio->retornar();
	
	$sistemaOperativo= new campoSeleccion("selSistemaOperativo","formularioCampoSeleccion","$_POST[selSistemaOperativo]","","",$conSistemaOperativo,"--TODOS--","");
	$selSistemaOperativo=$sistemaOperativo->retornar();

	
	$antivirus= new campoSeleccion("selAntivirus","formularioCampoSeleccion","$_POST[selAntivirus]","","",$conAntivirus,"--TODOS--","");
	$selAntivirus=$antivirus->retornar();	
	
	$statusMantenimiento= new campoSeleccion("selStatusMantenimiento","formularioCampoSeleccion","$_POST[selStatusMantenimiento]","","",$conStatusMantenimiento,"--TODOS--","");
	$selStatusMantenimiento=$statusMantenimiento->retornar();

	$statusRed= new campoSeleccion("selStatusRed","formularioCampoSeleccion","$_POST[selStatusRed]","","",$conRed,"--TODOS--","");
	$selStatusRed=$statusRed->retornar();	
	
	$statusCorrectivo= new campoSeleccion("selCorrectivo","formularioCampoSeleccion","$_POST[selCorrectivo]","","",$conCorrectivo,"--TODOS--","");
	$selCorrectivo=$statusCorrectivo->retornar();	
	
	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","","",$conGerencia,"--TODOS--","");
	$selGerencia=$gerencia->retornar();		
	
	$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10");
	$txtFechaInicio=$fechaInicio->retornar();

	$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
	$txtFechaFinal=$fechaFinal->retornar();
	echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
		echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
		echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">MANTENIMIENTOS PREVENTIVOS</td>
	  	</tr>";
		echo "<tr>";
		echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">SELECCCIONE EL RANGO DE FECHA</td>
		</tr>";
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\">
		FECHA INICIAL<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmMantenimiento.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></td>
		<td valign=top class=\"formularioCampoTitulo\">
		FECHA FINAL<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmMantenimiento.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a><br>
		</td>
		</tr>";
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\">
		GERENCIA<br>$selGerencia</a></td>
		<td valign=top class=\"formularioCampoTitulo\">
		EDIFICIO<br>$selSitio
		</td>
		</tr>";
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\">
		ANALISTA<br>$selUsuarioSistema</a></td>
		<td valign=top class=\"formularioCampoTitulo\">
		DESCRIPCION<br>
			$selDescripcion
		</td>
		</tr>";
				
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\">
		CONEXION A RED<br>$selStatusRed</td>
				
		<td valign=top class=\"formularioCampoTitulo\">
		ESTADO DEL SISTEMA OPERATIVO<br>$selSistemaOperativo<br></td>
		</tr>";
				
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\">
		TRABAJOS CORRECTIVOS<br>$selCorrectivo</td>
		<td valign=top class=\"formularioCampoTitulo\">
			ESTADO DE MANTENIMIENTO<br>$selStatusMantenimiento
		</td>
		</tr>";
				
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\">
		ESTADO DEL ANTIVIRUS<br>$selAntivirus</td>
		<td valign=top class=\"formularioCampoTitulo\">
			CONFIGURACION<br><input class=\"formularioCampoTexto\" name=\"txtConfiguracion\" type=\"text\" value=\"$_POST[txtConfiguracion]\">
		</td>
		</tr>";
				
		echo "<tr>";
		echo "<td class=\"formularioTablaBotones\" colspan=\"2\">GENERAR REPORTE |
		<a class=enlace href=\"#\" onclick=\"generarReporte()\">HTML</a> | <a class=enlace href=\"#\" onclick=\"generarExcel()\">EXCEL</a><br><br>
		REPORTE DE GESTION | <a class=enlace href=\"#\" onclick=\"generarReporteGestion()\">PDF</a><br><br>
		<a class=enlace href=\"#\" onclick=\"generarEvaluacionServicios()\">EVALUACION DE SERVICIO</a><br></td>
		</tr>";
		echo "</table>";
		echo "</form>"
?>