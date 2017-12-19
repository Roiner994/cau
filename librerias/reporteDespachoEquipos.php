<?php
require_once("seguridad.php");
?>
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
<script language="javascript">
function buscar() {
	document.frmDespacho.funcion.value=0;
	document.frmDespacho.generarReporte.value=1;
	document.frmDespacho.submit();
}

	function generarHtml() {
		fechaInicio=document.frmDespacho.txtFechaInicio.value;
		fechaFinal=document.frmDespacho.txtFechaFinal.value;
		idGerencia=document.frmDespacho.selGerencia.value;
		idSitio=document.frmDespacho.selSitio.value;
		despachadoA=document.frmDespacho.selDespachadoA.value;
		despachadoPor=document.frmDespacho.selDespachadoPor.value;
		idDescripcion=document.frmDespacho.selDescripcion.value;
		ficha=document.frmDespacho.txtFicha.value;
		statusDespacho=document.frmDespacho.selStatusDespacho.value;
		tipoDespacho=document.frmDespacho.selTipoDespacho.value;
		configuracion=document.frmDespacho.txtConfiguracion.value;
		window.open('../librerias/rptdespachoequiposhtml.php?fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal+'&idGerencia='+idGerencia+
		'&idSitio='+idSitio+'&analista='+despachadoA+'&despachadoPor='+despachadoPor+'&idDescripcion='+idDescripcion+'&ficha='+ficha+'&statusDespacho='+statusDespacho+'&tipoDespacho='+tipoDespacho+'&configuracion='+configuracion);	
	}

	function generarExcel() {
		fechaInicio=document.frmDespacho.txtFechaInicio.value;
		fechaFinal=document.frmDespacho.txtFechaFinal.value;
		idGerencia=document.frmDespacho.selGerencia.value;
		idSitio=document.frmDespacho.selSitio.value;
		despachadoA=document.frmDespacho.selDespachadoA.value;
		despachadoPor=document.frmDespacho.selDespachadoPor.value;
		idDescripcion=document.frmDespacho.selDescripcion.value;
		ficha=document.frmDespacho.txtFicha.value;
		statusDespacho=document.frmDespacho.selStatusDespacho.value;
		tipoDespacho=document.frmDespacho.selTipoDespacho.value;
		configuracion=document.frmDespacho.txtConfiguracion.value;
		window.open('../librerias/rptdespachoequiposexcel.php?fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal+'&idGerencia='+idGerencia+
		'&idSitio='+idSitio+'&analista='+despachadoA+'despachadoPor='+despachadoPor+'&idDescripcion='+idDescripcion+'&ficha='+ficha+'&statusDespacho='+statusDespacho+'&tipoDespacho='+tipoDespacho+'&configuracion='+configuracion);	
	}
</script>
<?php
//Reporte Despacho Equipos

if(!isset($_POST[selStatusDespacho]) && empty($_POST[selStatusDespacho])) {
	$_POST[selStatusDespacho]='1';
}

	require_once("formularios.php");
	require_once("mantenimientoAdmin.php");
	require_once("inventarioadmin.php");
	$conUss="Select
		vistadespachoequipos.id_uss_detalle,
		concat(vistadespachoequipos.nombre_detalle,' ',vistadespachoequipos.apellido_detalle) as nombres
		From
		vistadespachoequipos
		
		Group By
		vistadespachoequipos.id_uss_detalle
		Order By
		nombres Asc";
	
	$conSitio="select distinct id_sitio,sitio from vistadespachoequipos order by sitio";
	
	$conUssDespachadoPor="select distinct vistadespachoequipos.id_uss,
	concat(vistadespachoequipos.nombre,' ',vistadespachoequipos.apellido) as nombres from vistadespachoequipos
	order by nombres";

	$conUssDespachadoA="Select distinct vistadespachoequipos.id_uss_detalle,
		concat(vistadespachoequipos.nombre_detalle,' ',vistadespachoequipos.apellido_detalle) as nombres
		From
		vistadespachoequipos
		Order By
		nombres Asc";	
	
	$conStatusDespacho="select distinct vistadespachoequipos.status_despacho,
		CASE vistadespachoequipos.status_despacho
		WHEN 1 THEN 'DESPACHADO'
		WHEN 2 THEN 'ASIGNADO'
		WHEN 3 THEN 'DEVUELTO' end AS STATUS_DESPACHO from vistadespachoequipos order by STATUS_DESPACHO";
	

	$conTipoDespacho="select distinct vistadespachoequipos.id_despacho_estado, despacho_estado from vistadespachoequipos order by despacho_estado";
	
	
	$conGerencia="select distinct id_gerencia,gerencia from vistadespachoequipos order by gerencia";

	$conDescripcion="Select
		vistadespachoequipos.ID_DESCRIPCION,
		vistadespachoequipos.DESCRIPCION
		From
		vistadespachoequipos
		
		Group By
		vistadespachoequipos.ID_DESCRIPCION
		Order By
		vistadespachoequipos.DESCRIPCION Asc";
	
	$usuarioSistema= new campoSeleccion("selUsuarioSistema","formularioCampoSeleccion","$_POST[selUsuarioSistema]","","",$conUss,"--TODOS--","");
	$selUsuarioSistema=$usuarioSistema->retornar();

	$despachadoPor= new campoSeleccion("selDespachadoPor","formularioCampoSeleccion","$_POST[selDespachadoPor]","onChange","cambiarSeleccion()",$conUssDespachadoPor,"--TODOS--","");
	$selDespachadoPor=$despachadoPor->retornar();

	$despachadoA= new campoSeleccion("selDespachadoA","formularioCampoSeleccion","$_POST[selDespachadoA]","onChange","cambiarSeleccion()",$conUssDespachadoA,"--TODOS--","");
	$selDespachadoA=$despachadoA->retornar();	
	
	$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion","$_POST[selDescripcion]","","",$conDescripcion,"--TODOS--","");
	$selDescripcion=$descripcion->retornar();	
		
	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--TODOS--","");
	$selSitio=$sitio->retornar();
	
	
	$tipoDespacho= new campoSeleccion("selTipoDespacho","formularioCampoSeleccion","$_POST[selTipoDespacho]","","",$conTipoDespacho,"--TODOS--","");
	$selTipoDespacho=$tipoDespacho->retornar();

	$statusDespacho= new campoSeleccion("selStatusDespacho","formularioCampoSeleccion","$_POST[selStatusDespacho]","","",$conStatusDespacho,"--TODOS--","");
	$selStatusDespacho=$statusDespacho->retornar();	
	
	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","","",$conGerencia,"--TODOS--","");
	$selGerencia=$gerencia->retornar();		
	
	$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10");
	$txtFechaInicio=$fechaInicio->retornar();

	$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
	$txtFechaFinal=$fechaFinal->retornar();

	echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"generarReporte\" type=\"hidden\" value=\"0\">";
		echo "<table class=\"formularioTabla\"align=center width=\"80%\" border=\"0\">";
		echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">REPORTE DE DESPACHO DE EQUIPOS</td>
	  	</tr>";
		echo "<tr>";
		echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">SELECCCIONE EL RANGO DE FECHA</td>
		</tr>";
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\">
		FECHA INICIAL<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmDespacho.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></td>
		<td valign=top class=\"formularioCampoTitulo\">
		FECHA FINAL<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmDespacho.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a><br>
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
		DESPACHADO POR:<br>$selDespachadoPor</a></td>
		<td valign=top class=\"formularioCampoTitulo\">
		DESPACHADO A:<br>
		$selDespachadoA
		</td>
		</tr>";
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\">
		DESCRIPCION<br>
		$selDescripcion</td>
		<td valign=top class=\"formularioCampoTitulo\">
		&nbsp;
		</td>
		</tr>";		
				
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\">
		USUARIO<br><input class=\"formularioCampoTexto\" name=\"txtFicha\" type=\"text\" value=\"$_POST[txtFicha]\"></td>
				
		<td valign=top class=\"formularioCampoTitulo\">
		CONFIGURACION<br><input class=\"formularioCampoTexto\" name=\"txtConfiguracion\" type=\"text\" value=\"$_POST[txtConfiguracion]\"><br></td>
		</tr>";
				
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\">
		ESTADO DEL DESPACHO<br>$selStatusDespacho</td>
		<td valign=top class=\"formularioCampoTitulo\">
		TIPO DE ASIGNACION<br>$selTipoDespacho
		</td>
		</tr>";
		

			
		echo "<tr>";
		echo "<td class=\"formularioTablaBotones\" colspan=\"2\">GENERAR REPORTE | <a class=enlace href=\"#\" onclick=\"generarExcel()\">EXCEL</a><br><br>
		<br>
		<a class=enlace href=\"#\" onclick=\"buscar()\">GENERAR REPORTE</a><br></td>
		</tr>";
		echo "</table>";
		echo "</form>";


			    if ($_POST[selSitio]==100) 
					$_POST[selSitio]="";
					
				if ($_POST[selGerencia]==100)
					$_POST[selGerencia]="";
					
				if($_POST[selDescripcion]==100)
					$_POST[selDescripcion]="";
					
				if ($_POST[selDespachadoPor]==100)
					$_POST[selDespachadoPor]="";

					if ($_POST[selDespachadoA]==100)
					$_POST[selDespachadoA]="";
					
				if($_POST[selTipoDespacho]==100)
					$_POST[selTipoDespacho]="";
					
				if($_POST[selStatusDespacho]==100)
					$_POST[selStatusDespacho]="";
				
			
			
			$reporteDespacho= new despachoEquipo();

			$reporteDespacho->setDespacho("",$_POST[selDespachadoPor],"",$_POST[selStatusDespacho],"","",$_POST[selSitio],"","",$_POST[txtFicha],$_POST[selGerencia]);
			$reporteDespacho->setDetalleDespacho("",$_POST[txtConfiguracion],"",$_POST[selDespachadoA],$_POST[selTipoDespacho]);



			$resultado=$reporteDespacho->buscarDespachoEquipos($_POST[txtFechaInicio],$_POST[txtFechaFinal],$_POST[selDescripcion]);

			echo "<table width=\"75%\" border=\"0\" align=\"center\">";
			if ($resultado && $resultado!=1) {

				echo "
		<tr>
		<td valign=top class=\"tablaTitulo\" colspan=\"8\"><b>RESULTADO DE LA BUSQUEDA</b></td>
		</tr>
		<tr>
		<td valign=top class=\"tablaTitulo\"><b>CONFIGURACION</b></td>
		<td valign=top class=\"tablaTitulo\"><b>DESCRIPCION</b></td>		  
		<td valign=top class=\"tablaTitulo\"><b>MARCA</b></td>
		<td valign=top class=\"tablaTitulo\"><b>MODELO</b></td>
		<td valign=top class=\"tablaTitulo\"><b>SERIAL</b></td>
		<td valign=top class=\"tablaTitulo\"><b>TIPO</b></td>
		<td valign=top class=\"tablaTitulo\"><b>ESTADO</b></td>
		<td valign=top class=\"tablaTitulo\"><b>PLANILLA</b></td>
		</tr>";
				$total=0;
				while ($row=mysql_fetch_array($resultado)) {
					if ($i%2==0) {
						$clase="tablaFilaPar";
					} else {
						$clase="tablaFilaNone";
					}

					switch ($row[46]) {
						case 'DEE0000002':
							$tipoAsignacion="ASIGNACION";
							break 1;
						case 'DEE0000003':
							$tipoAsignacion="DEVUELTO";
							break 1;
						case 'DEE0000004':
							$tipoAsignacion="PRESTAMO";
							break 1;

						case 'DEE0000005':
							$tipoAsignacion="REEMPLAZO";
							break 1;
					}

					echo "<tr class=\"$clase\">";
					if ($row[5]=='1')
						echo "<td align=\"left\"><a class=enlace href=\"index2.php?item=623&idDespacho=$row[0]\">$row[13]</a></td>";
					else
						echo "<td align=\"left\">$row[13]</td>";

					switch ($row[5]) {
						case 1:
							$estado='DESPACHADO';
							break 1;
						case 2:
							$estado='ASIGNADO';
							break 1;
						case 3:
							$estado='DEVUELTO';
							break 1;
					}
					echo "<td align=\"center\">$row[17]</td>";
					echo "<td align=\"center\">$row[19]</td>";
					echo "<td align=\"center\">$row[21] $row[22] $row[23]</td>";
					echo "<td align=\"center\">$row[15]</td>";
					echo "<td align=\"center\">$tipoAsignacion</td>";
					echo "<td align=\"center\">$estado</td>";
					echo "<td align=\"center\"><a class=enlace href=\"#\" onclick=\"window.open('../librerias/xmlAsignacionEquipos.php?idDespacho=$row[0]')\">ASIG</a> | <a class=enlace href=\"#\" onclick=\"window.open('../librerias/xmlsalidainternaequipos.php?idDespacho=$row[0]')\">INT</a> | <a class=enlace href=\"#\" onclick=\"window.open('../librerias/xmlsalidaexternaequipos.php?idDespacho=$row[0]')\">EXT</a></td>";
					echo "</tr>";
					$total++;
					$i++;
				}

				echo "<tr class=\"$clase\">";
				echo "<td align=\"left\">TOTAL</td>";
				echo "<td align=\"center\"><b>$total</b></td>";
				echo "</tr>";

			} else {
				echo "<tr class=\"tablaTitulo\">
				<td valign=top colspan=\"2\">NO HAY RESULTADO</td></tr>";
			}
			echo "</table>";
		
?>

