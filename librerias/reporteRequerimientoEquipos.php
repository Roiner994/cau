<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
<script type="text/javascript">
	function buscar() {
			document.frmReporteRequerimientos.funcion.value=0;
			document.frmReporteRequerimientos.submit();
	}
	
	function generarReporte(idDescripcion){ 
		
		sitio=document.frmReporteRequerimientos.selSitio.value;
		idDescripcion=document.frmReporteRequerimientos.selDescripcion.value;					
		gerencia=document.frmReporteRequerimientos.selGerencia.value;			
		usuarioSistema=document.frmReporteRequerimientos.selUsuarioSistema.value;
		estadoRequerimiento=document.frmReporteRequerimientos.selEstadoRequerimiento.value;	
		requerimientoMotivo=document.frmReporteRequerimientos.selRequerimientoMotivo.value;
		txtFicha=document.frmReporteRequerimientos.txtFicha.value;				
		fechaInicio=document.frmReporteRequerimientos.txtFechaInicio.value;	
		fechaFinal=document.frmReporteRequerimientos.txtFechaFinal.value;				
		window.open('../librerias/rptResumenSolicitudes.php?sitio='+sitio+'&idDescripcion='+idDescripcion+'&idGerencia='+gerencia+'&usuarioSistema='+usuarioSistema+'&estadoRequerimiento='+estadoRequerimiento+'&requerimientoMotivo='+requerimientoMotivo+'&txtFicha='+txtFicha+'&fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal);		
	}
	
	function generarExcel() {
		
		sitio=document.frmReporteRequerimientos.selSitio.value;
		idDescripcion=document.frmReporteRequerimientos.selDescripcion.value;			
		gerencia=document.frmReporteRequerimientos.selGerencia.value;			
		usuarioSistema=document.frmReporteRequerimientos.selUsuarioSistema.value;
		estadoRequerimiento=document.frmReporteRequerimientos.selEstadoRequerimiento.value;	
		requerimientoMotivo=document.frmReporteRequerimientos.selRequerimientoMotivo.value;
		txtFicha=document.frmReporteRequerimientos.txtFicha.value;				
		fechaInicio=document.frmReporteRequerimientos.txtFechaInicio.value;	
		fechaFinal=document.frmReporteRequerimientos.txtFechaFinal.value;			
		window.open('../librerias/rptResumenSolicitudExcel.php?sitio='+sitio+'&idDescripcion='+idDescripcion+'&idGerencia='+gerencia+'&usuarioSistema='+usuarioSistema+'&estadoRequerimiento='+estadoRequerimiento+'&requerimientoMotivo='+requerimientoMotivo+'&txtFicha='+txtFicha+'&fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal);	
	}
	
	
</script>
<?php


//Reporte de Nuevos Requerimientos
	switch ($_GET[funcion]) {
		case 1:
			break 1;
		default:
			frmReporteRequerimientos();
	}


function frmReporteRequerimientos() {
	require_once("formularios.php");
	require_once("conexionsql.php");
	require_once("requerimientoAdmin.php");
	
	
		if(!isset($_POST[selEstadoRequerimiento]) && empty($_POST[selEstadoRequerimiento])) {
			$_POST[selEstadoRequerimiento]='STA0000003';
		}
	
	$conSitio="Select distinct ID_SITIO,SITIO FROM vistarequerimientosequipos ORDER BY SITIO";
	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_GET[selSitio]","","",$conSitio,"--TODOS--","");
	$selSitio=$sitio->retornar();

	$conGerencia="Select distinct ID_GERENCIA,GERENCIA FROM vistarequerimientosequipos ORDER BY  GERENCIA";
	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_GET[selGerencia]","","",$conGerencia,"--TODOS--","");
	$selGerencia=$gerencia->retornar();
	
	$conDescripcion="Select distinct ID_DESCRIPCION,DESCRIPCION From vistarequerimientosequipos ORDER BY DESCRIPCION ";	  
	$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion","$_GET[selDescripcion]","","",$conDescripcion,"--TODOS--","");
	$selDescripcion=$descripcion->retornar();
	
	$conUsuarioSistema="Select distinct ID_USS,concat(NOMBRE,' ',APELLIDO) AS ANALISTA FROM vistarequerimientosequipos ORDER BY  ANALISTA";
	$usuarioSistema= new campoSeleccion("selUsuarioSistema","formularioCampoSeleccion","$_GET[selUsuarioSistema]","","",$conUsuarioSistema,"--TODOS--","");
	$selUsuarioSistema=$usuarioSistema->retornar();	
	
	$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_GET[txtFechaInicio]","10","10");
	$txtFechaInicio=$fechaInicio->retornar();

	$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_GET[txtFechaFinal]","10","10");
	$txtFechaFinal=$fechaFinal->retornar();	
	
	$conEstadoRequerimiento="Select  distinct  id_estado_requerimiento,estado_requerimiento From vistarequerimientosequipos  ORDER BY estado_requerimiento";
	$estadoRequerimiento= new campoSeleccion("selEstadoRequerimiento","formularioCampoSeleccion","$_GET[selEstadoRequerimiento]","","",$conEstadoRequerimiento,"--TODOS--","");
	$selEstadoRequerimiento=$estadoRequerimiento->retornar();
	
	$conRequerimientoMotivo="select distinct id_requerimiento_motivo,requerimiento_motivo from vistarequerimientosequipos order by requerimiento_motivo";	
	$requerimientoMotivo= new campoSeleccion("selRequerimientoMotivo","formularioCampoSeleccion","$_GET[selRequerimientoMotivo]","","",$conRequerimientoMotivo,"--TODOS--","");
	$selRequerimientoMotivo=$requerimientoMotivo->retornar();		
	
	echo  "<form name=\"frmReporteRequerimientos\" method=\"GET\" action=\"\">";	
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"item\" type=\"hidden\" value=\"201\">";
	echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"2\">REPORTE DE SOLICITUDES</td>
	</tr>";
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">Seleccione el rango de fecha </td>
	</tr>";
	echo"<tr>
	<td valign=top class=\"formularioCampoTitulo\" >FECHA INICIAL<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmReporteRequerimientos.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></td>
	<td valign=top class=\"formularioCampoTitulo\" >FECHA FINAL<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmReporteRequerimientos.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></td>
	</tr>";	
	echo"<tr>		
	<td valign=top class=\"formularioCampoTitulo\" >SITIO<br>$selSitio</td>
	<td valign=top class=\"formularioCampoTitulo\" >GERENCIA<br>$selGerencia</td>";
	echo"<tr>
	<td valign=top class=\"formularioCampoTitulo\" >DESCRIPCION<br>$selDescripcion<br></td>		
	<td valign=top class=\"formularioCampoTitulo\" >FICHA DEL USUARIO<br><input name=\"txtFicha\" type=\"text\" value=\"$_GET[txtFicha]\"><br></td>	
	</tr>";		
	echo"<tr>	
	<td valign=top class=\"formularioCampoTitulo\" >ESTADO SOLICITUD<br>$selEstadoRequerimiento<br></td>
	<td valign=top class=\"formularioCampoTitulo\" >MOTIVO SOLICITUD<br>$selRequerimientoMotivo<br></td>				
	</tr>";
	echo"<tr>	
	<td valign=top class=\"formularioCampoTitulo\">USUARIO SISTEMA<br>$selUsuarioSistema<br></td>
	<td valign=top class=\"formularioCampoTitulo\">&nbsp;</td>				
	</tr>";	
	echo "<tr>";
	echo "<td class=\"formularioTablaBotones\" colspan=\"2\">GENERAR REPORTE |
	<a class=enlace href=\"#\" onclick=\"generarReporte()\">HTML</a> | <a class=enlace href=\"#\" onclick=\"generarExcel()\">EXCEL</a><br>
	<input name=\"btnBuscar\" type=\"button\" value=\"BUSCAR\" onclick=\"buscar()\">		
	<input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=201'\"></td>		
	</tr>";		
	echo "</table>";
	
	$requerimientoHardware= new requerimientoHardware();
	
	$resultado= $requerimientoHardware->buscarRequerimiento($_GET[selSitio],$_GET[selGerencia],$_GET[selDescripcion],$_GET[selEstadoRequerimiento],$_GET[selRequerimientoMotivo],$_GET[selUsuarioSistema],$_GET[txtFechaInicio],$_GET[txtFechaFinal],$_GET[txtFicha]);
 	echo "<table width=\"70%\" border=\"0\" align=\"center\">";  		
	 if ($resultado && $resultado!=1) {

   echo "
		<tr>
		<td valign=top class=\"tablaTitulo\" colspan=\"7\"><b>RESULTADO DE LA BUSQUEDA</b></td>
		</tr>
		<tr>
		<td valign=top class=\"tablaTitulo\"><b>SOLICITUD</b></td>
		<td valign=top class=\"tablaTitulo\"><b>USUARIO</b></td>		  
		<td valign=top class=\"tablaTitulo\"><b>DESCRIPCION</b></td>		  
		<td valign=top class=\"tablaTitulo\"><b>MOTIVO</b></td>		  
		<td valign=top class=\"tablaTitulo\"><b>DETALLE</b></td>		  
		<td valign=top class=\"tablaTitulo\"><b>ESTADO</b></td>		  
		<td valign=top class=\"tablaTitulo\"><b>FECHA</b></td>		  
		</tr>";
	 	$total=0;
	 	while ($row=mysql_fetch_array($resultado)) {
	 		if ($i%2==0) {
	 			$clase="tablaFilaPar";
	 		} else {
	 			$clase="tablaFilaNone";
	 		}
	 		$fecha=substr($row[23],8,2)."/".substr($row[23],5,2)."/".substr($row[23],0,4);
	 		echo "<tr class=\"$clase\">";
	 		echo "<tr class=\"$clase\" title=\"SOLICITUD: $row[1] \nFICHA: $row[2] \nUSUARIO: $row[3] $row[4] \nCARGO: $row[6] \nEXTENSION: $row[15] \nGERENCIA: $row[8] \rDIVISION: $row[10] \nDEPARTAMENTO:$row[12] \nSITIO: $row[14] \n\nDESCRIPCION: $row[21] \nMOTIVO: $row[25]  \nDETALLE SOLICITUD: $row[22] \nESTADO DEL REQUERIMIENTO: $row[27] \nFECHA: $fecha\">";
	 		echo "<td align=\"left\"><a class=enlace href=\"index2.php?item=202&idRequerimiento=$row[1]\"> $row[1]</a></td>";
	 		echo "<td align=\"left\">$row[3] $row[4]</td>";
	 		echo "<td align=\"left\">$row[21]</td>";
	 		echo "<td align=\"left\">$row[25]</td>";
	 		echo "<td align=\"left\">$row[22]</td>";
	 		echo "<td align=\"left\">$row[27]</td>";
	 		echo "<td align=\"left\">$fecha</td>";
	 		echo "</tr>";
	 		
	 		$i++;
	 	} 
		echo "<tr class=\"$clase\">";
		echo "<td align=\"left\">TOTAL</td>";
		echo "<td align=\"center\"><b>$i</b></td>";
		echo "</tr>";
	  } else {
	 	echo "<tr class=\"tablaTitulo\">
		<td valign=top colspan=\"2\">NO HAY RESULTADO
		</td></tr>";
	 }
	 echo "</table>";

	echo "</form>";	
	
	
}
?>