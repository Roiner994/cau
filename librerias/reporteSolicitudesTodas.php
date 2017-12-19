<?php
//Reporte de solicitudes
?>
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
<script language="javascript">

    function cambiarSeleccion() {
		document.frmSolicitudes.funcion.value=0;
		document.frmSolicitudes.submit();
	}
	
	function buscar() {
		document.frmSolicitudes.funcion.value=0;	
		document.frmSolicitudes.validarboton.value=1;
	 	document.frmSolicitudes.submit();
	}
	
		
	function generarReporte(idDescripcion){
		
		sitio=document.frmSolicitudes.selSitio.value;
		idDescripcion=document.frmSolicitudes.selDescripcion.value;			
		gerencia=document.frmSolicitudes.selGerencia.value;			
		txtFicha=document.frmSolicitudes.txtFicha.value;		
		fechaInicio=document.frmSolicitudes.txtFechaInicio.value;	
		fechaFinal=document.frmSolicitudes.txtFechaFinal.value;		
		status=document.frmSolicitudes.selStatus.value;
		motivo=document.frmSolicitudes.selMotivo.value;		
		window.open('../librerias/rptResumenSolicitudes.php?sitio='+sitio+'&idDescripcion='+idDescripcion+'&idGerencia='+gerencia+'&txtFicha='+txtFicha+'&status='+status+'&motivo='+motivo+'&fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal);	
	}
	
	function generarExcel() {
		
		sitio=document.frmSolicitudes.selSitio.value;
		idDescripcion=document.frmSolicitudes.selDescripcion.value;			
		gerencia=document.frmSolicitudes.selGerencia.value;			
		txtFicha=document.frmSolicitudes.txtFicha.value;		
		fechaInicio=document.frmSolicitudes.txtFechaInicio.value;	
		fechaFinal=document.frmSolicitudes.txtFechaFinal.value;		
		status=document.frmSolicitudes.selStatus.value;	
		motivo=document.frmSolicitudes.selMotivo.value;		
		window.open('../librerias/rptResumenSolicitudExcel.php?sitio='+sitio+'&idDescripcion='+idDescripcion+'&idGerencia='+gerencia+'&txtFicha='+txtFicha+'&status='+status+'&motivo='+motivo+'&fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal);	
	}
	
	
	
</script>
<?php
switch ($funcion) {
	case 1:
		break 1;
	case 2:
		break 2;
	default:
		frmSolicitudes();	
}
function frmSolicitudes() {
	require_once("formularios.php");
	require_once("conexionsql.php");
	require_once("rptSolicitudes.php");
    
    
	$conSitio="Select   distinct ID_SITIO,SITIO FROM vistasolicitudes	ORDER BY  SITIO";
	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--TODOS--","");
	$selSitio=$sitio->retornar();
	
	
	$conGerencia="Select distinct ID_GERENCIA,GERENCIA FROM vistasolicitudes	ORDER BY  GERENCIA";
	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","","",$conGerencia,"--TODOS--","");
	$selGerencia=$gerencia->retornar();
	
	
	$conDescripcion="Select distinct ID_DESCRIPCION,DESCRIPCION From vistasolicitudes ORDER BY DESCRIPCION ";	  
	$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion","$_POST[selDescripcion]","","",$conDescripcion,"--DESCRIPCION--","");
	$selDescripcion=$descripcion->retornar();
	
	
	$constatus="Select  distinct  ID_STATUS,DES_STATUS From vistasolicitudes  ORDER BY DES_STATUS";
	$status= new campoSeleccion("selStatus","formularioCampoSeleccion","$_POST[selStatus]","","",$constatus,"--TODOS--","");
	$selStatus=$status->retornar();
	
	$conMotivo="Select  distinct  ID_MOTIVO_SOLICITUD,MOTIVO_SOLICITUD From vistasolicitudes  ORDER BY MOTIVO_SOLICITUD";
	$motivo= new campoSeleccion("selMotivo","formularioCampoSeleccion","$_POST[selMotivo]","","",$conMotivo,"--TODOS--","");
	$selMotivo=$motivo->retornar();
	
	$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10");
	$txtFechaInicio=$fechaInicio->retornar();

	$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
	$txtFechaFinal=$fechaFinal->retornar();
	
	
	    echo  "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"validarboton\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"validar\" type=\"hidden\" value=\"0\">";
		echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
		echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">REPORTE DE SOLICITUDES</td>
	  	</tr>";
		echo "<tr>";
		echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">Seleccione el rango de fecha </td>
		</tr>";
		echo"<tr>
		<td valign=top class=\"formularioCampoTitulo\" >FECHA INICIAL<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmSolicitudes.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></td>
		<td valign=top class=\"formularioCampoTitulo\" >FECHA FINAL<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmSolicitudes.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></td>
		</tr>";	
		echo"<tr>		
	    <td valign=top class=\"formularioCampoTitulo\" >SITIO<br>$selSitio</td>
	    <td valign=top class=\"formularioCampoTitulo\" >GERENCIA<br>$selGerencia</td>";
		echo"<tr>
		<td valign=top class=\"formularioCampoTitulo\" >DESCRIPCION<br>$selDescripcion<br></td>		
		<td valign=top class=\"formularioCampoTitulo\" >USUARIO(FICHA)<br><input name=\"txtFicha\" type=\"text\" value=\"$_POST[txtFicha]\"><br></td>	
		</tr>";		
		echo"<tr>	
		<td valign=top class=\"formularioCampoTitulo\" >ESTATUS SOLICITUD<br>$selStatus<br></td>
		<td valign=top class=\"formularioCampoTitulo\" >MOTIVO SOLICITUD<br>$selMotivo<br></td>				
		</tr>";
		echo "<tr>";
		echo "<td class=\"formularioTablaBotones\" colspan=\"2\">GENERAR REPORTE |
		<a class=enlace href=\"#\" onclick=\"generarReporte()\">HTML</a> | <a class=enlace href=\"#\" onclick=\"generarExcel()\">EXCEL</a><br>
		<input name=\"btnBuscar\" type=\"button\" value=\"BUSCAR\" onclick=\"buscar()\">		
		<input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=201'\"></td>		
		</tr>";		
		echo "</table>";
		if ($_POST[validar]!=1)
    	if ($_POST[validarboton]!=0){
        $rptSolicitudes= new rptSolicitudes();        
       
        
   if ($_POST[selSitio]==100) 
		$_POST[selSitio]="";
		
	if ($_POST[selGerencia]==100) 	
		$_POST[selGerencia]="";	
			
	if ($_POST[selDescripcion]==100)
		$_POST[selDescripcion]="";
		
			
	if ($_POST[selStatus]==100)
		$_POST[selStatus]=""; 	
		
	    
	if ($_POST[selMotivo]==100)
		$_POST[selMotivo]=""; 	
		
					
	 $resultado=$rptSolicitudes->retornarSolicitudes($_POST[selSitio],$_POST[txtFechaInicio],$_POST[txtFechaFinal],$_POST[selGerencia],$_POST[selDescripcion],$_POST[txtFicha],"ID_DESCRIPCION",$_POST[selStatus],$_POST[selMotivo]);
     
   echo "<table width=\"40%\" border=\"0\" align=\"center\">";  		
	 if ($resultado && $resultado!=1) {

echo "
		<tr>
		<td valign=top class=\"tablaTitulo\"><b>SOLICITUD</b></td>
		<td valign=top class=\"tablaTitulo\"><b>FECHA</b></td>	
		<td valign=top class=\"tablaTitulo\"><b>FICHA</b></td>		  
		<td valign=top class=\"tablaTitulo\"><b>USUARIO</b></td>
		<td valign=top class=\"tablaTitulo\"><b>EXTENSION</b></td>
		<td valign=top class=\"tablaTitulo\"><b>DESCRIPCION</b></td>	
		<td valign=top class=\"tablaTitulo\"><b>MOTIVO SOLICITUD</b></td>
		<td valign=top class=\"tablaTitulo\"><b>ESTATUS SOLICITUD</b></td>
		<td valign=top class=\"tablaTitulo\"><b>SITIO</b></td>
		<td valign=top class=\"tablaTitulo\"><b>GERENCIA</b></td>
		<td valign=top class=\"tablaTitulo\"><b>OBSERVACION</b></td>	  
		</tr>";
		$total=0;
		while ($row=mysql_fetch_array($resultado)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			$Fecha=substr($row[25],8,2)."/".substr($row[25],5,2)."/".substr($row[25],0,4);
			echo "<tr class=\"$clase\">";
			echo "<td align=\"left\"><a class=\"enlace\" href=\"#\"  onclick=window.open(\"../librerias/solicitudesReportesLink.php?idSolicitud=$row[0]\",\"\",'width=540,height=600,scrollbars=1,top=200,left=350')>$row[0]</a></td>";
			echo "<td align=\"left\">$Fecha</td>";			
			echo "<td align=\"left\">$row[1]</td>";
			echo "<td align=\"left\">$row[2] $row[3]</td>";
			echo "<td align=\"left\">$row[6]</td>";
			echo "<td align=\"left\">$row[22] </td>";
			echo "<td align=\"left\">$row[16] </td>";
			echo "<td align=\"left\">$row[24]</td>";
			echo "<td align=\"left\">$row[14]</td>";
			echo "<td align=\"left\">$row[8]</td>";
			echo "<td align=\"left\">$row[27]</td>";	
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

  }	
	echo "</form>";	
		
		
			
	
 	}	
 ?>	
 