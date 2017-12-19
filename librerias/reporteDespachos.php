<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
<script type="text/javascript">
	function cambiarSeleccion() {
		document.frmDespacho.funcion.value=0;		
		document.frmDespacho.submit();
	}
	
	function generarHTML(idDescripcion) {
		
		
		sitio=document.frmDespacho.selSitio.value;
		idDescripcion=document.frmDespacho.selDescripcion.value;			
		gerencia=document.frmDespacho.selGerencia.value;			
		usuarioSistema=document.frmDespacho.selUsuarioSistema.value;
		statusDespacho=document.frmDespacho.selStatusDespacho.value;	
		txtSerial=document.frmDespacho.txtSerial.value;
		txtFicha=document.frmDespacho.txtFicha.value;				
		fechaInicio=document.frmDespacho.txtFechaInicio.value;	
		fechaFinal=document.frmDespacho.txtFechaFinal.value;			
		window.open('../librerias/rptResumenDespachos.php?sitio='+sitio+'&idDescripcion='+idDescripcion+'&gerencia='+gerencia+'&usuarioSistema='+usuarioSistema+'&txtSerial='+txtSerial+'&txtFicha='+txtFicha+'&statusDespacho='+statusDespacho+'&fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal);	
	}
	
	 function generarExcel() {
		sitio=document.frmDespacho.selSitio.value;
		idDescripcion=document.frmDespacho.selDescripcion.value;			
		gerencia=document.frmDespacho.selGerencia.value;			
		despachadoPor=document.frmDespacho.selDespachadoPor.value;
		despachadoA=document.frmDespacho.selDespachadoA.value;
		statusDespacho=document.frmDespacho.selStatusDespacho.value;	
		txtSerial=document.frmDespacho.txtSerial.value;
		txtFicha=document.frmDespacho.txtFicha.value;				
		fechaInicio=document.frmDespacho.txtFechaInicio.value;	
		fechaFinal=document.frmDespacho.txtFechaFinal.value;	
		window.open('../librerias/rptResumenDespachosExcel.php?sitio='+sitio+'&idDescripcion='+idDescripcion+'&gerencia='+gerencia+'&despachadoPor='+despachadoPor+'&despachadoA='+despachadoA+'&txtSerial='+txtSerial+'&txtFicha='+txtFicha+'&statusDespacho='+statusDespacho+'&fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal);	
	
}
	

</script>
<?php
//Reporte de Despachos
switch ($funcion) {
	case 1:
		break 1;
	default:
		frmDespacho();
}


function frmDespacho() {
		if(!isset($_POST[selStatusDespacho]) && empty($_POST[selStatusDespacho])) {
			$_POST[selStatusDespacho]='DEE0000001';
		}
		require_once("inventarioAdmin.php");
		require_once("formularios.php");
		
		$conGerencia="select distinct id_gerencia,gerencia from vistadespachocomponentes order by gerencia";
		$conSitio="select distinct id_sitio,sitio from vistadespachocomponentes order by sitio";

			$conUssDespachadoPor="select distinct vistadespachocomponentes.id_uss,
			concat(vistadespachocomponentes.nombre,' ',vistadespachocomponentes.apellido) as nombres from vistadespachocomponentes
			order by nombres";
		
			$conUssDespachadoA="Select
				distinct vistadespachocomponentes.detalle_id_uss,
				concat(vistadespachocomponentes.detalle_nombre,' ',vistadespachocomponentes.detalle_apellido) as nombres
				From
				vistadespachocomponentes
				
				Order By
				nombres Asc";
			
			$conDescripcion="Select distinct
				vistadespachocomponentes.ID_DESCRIPCION,
				vistadespachocomponentes.DESCRIPCION
				From
				vistadespachocomponentes
				
				Order By
				vistadespachocomponentes.DESCRIPCION Asc";	
			
			$conStatusDespacho="select distinct vistadespachocomponentes.id_despacho_estado,
				vistadespachocomponentes.despacho_estado
				from vistadespachocomponentes order by id_despacho_estado";
		
			$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","cambiarSeleccion()",$conGerencia,"--TODOS--","");
			$selGerencia=$gerencia->retornar();	
		
			$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","onChange","cambiarSeleccion()",$conSitio,"--TODOS--","");
			$selSitio=$sitio->retornar();	
		
			$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion","$_POST[selDescripcion]","onChange","cambiarSeleccion()",$conDescripcion,"--TODOS--","");
			$selDescripcion=$descripcion->retornar();
			
			$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10");
			$txtFechaInicio=$fechaInicio->retornar();
		
			$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
			$txtFechaFinal=$fechaFinal->retornar();
			
			$despachadoPor= new campoSeleccion("selDespachadoPor","formularioCampoSeleccion","$_POST[selDespachadoPor]","onChange","cambiarSeleccion()",$conUssDespachadoPor,"--TODOS--","");
			$selDespachadoPor=$despachadoPor->retornar();

			$despachadoA= new campoSeleccion("selDespachadoA","formularioCampoSeleccion","$_POST[selDespachadoA]","onChange","cambiarSeleccion()",$conUssDespachadoA,"--TODOS--","");
			$selDespachadoA=$despachadoA->retornar();
			
			$statusDespacho= new campoSeleccion("selStatusDespacho","formularioCampoSeleccion","$_POST[selStatusDespacho]","onChange","cambiarSeleccion()",$conStatusDespacho,"--TODOS--","");
			$selStatusDespacho=$statusDespacho->retornar();		
			
			
		
			   echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
				echo "<input name=\"generarReporte\" type=\"hidden\" value=\"0\">";
				echo "<table class=\"formularioTabla\"align=center width=\"80%\" border=\"0\">";
				echo "<tr>";
				echo "<td class=\"tituloPagina\" colspan=\"2\">REPORTE DE DESPACHO DE COMPONENTES</td>
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
				DESPACHADO POR:<br>$selDespachadoPor</td>
				<td valign=top class=\"formularioCampoTitulo\">
				DESPACHADO A:<br>$selDespachadoA
				</td>
				</tr>";
						
				echo "<tr>
				<td valign=top class=\"formularioCampoTitulo\">
				FICHA<br><input class=\"formularioCampoTexto\" name=\"txtFicha\" type=\"text\" value=\"$_POST[txtFicha]\"></td>
						
				<td valign=top class=\"formularioCampoTitulo\">
				DESCRIPCION<br>
				$selDescripcion
				</td>
				</tr>";
						
				echo "<tr>
				<td valign=top class=\"formularioCampoTitulo\">
				ESTADO DEL DESPACHO<br>$selStatusDespacho</td>
				<td valign=top class=\"formularioCampoTitulo\">
				SERIAL<br><input class=\"formularioCampoTexto\" name=\"txtSerial\" type=\"text\" value=\"$_POST[txtSerial]\"><br>
				</td>
				</tr>";
					
				echo "<tr>";
				echo "<td class=\"formularioTablaBotones\" colspan=\"2\">GENERAR REPORTE | <a class=enlace href=\"#\" onclick=\"generarExcel()\">EXCEL</a><br><br>
				<br>
				<a class=enlace href=\"#\" onclick=\"cambiarSeleccion()\">GENERAR REPORTE</a><br></td>
				</tr>";
				echo "</table>";
				echo "</form>";
		
			echo "<table class=\"formularioTabla\"align=center width=\"80%\" border=\"0\">";
			echo "<tr>
					<td class=\"formularioTablaTitulo\" align=center colspan=\"8\">REPORTE DE COMPONENTES DESPACHADOS</td>
				</tr>";
			$despacho=new despacho();
			$despacho->setDespacho("","","",$_POST[selDespachadoA],$_POST[selDespachadoPor],"","",$_POST[txtSerial],$_POST[txtFicha]);
			$resultado=$despacho->reporteDespacho($_POST[selGerencia],$_POST[selSitio],$_POST[selDescripcion],$_POST[selStatusDespacho],$_POST[txtFicha],$_POST[txtFechaInicio],$_POST[txtFechaFinal]);
			if ($resultado && $resultado!=1) {
				echo "<tr valign=top class=\"tablaTitulo\">
					<td valign=top class=\"tablaTitulo\">SERIAL</td>
					<td align=\"left\" class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
					<td valign=top class=\"tablaTitulo\">MARCA</td>
					<td valign=top class=\"tablaTitulo\">MODELO</td>
					<td valign=top class=\"tablaTitulo\">ANALISTA</td>
					<td valign=top class=\"tablaTitulo\">FECHA</td>
					<td valign=top class=\"tablaTitulo\">ESTADO</td>
					<td valign=top class=\"tablaTitulo\">PLANILLA</td>
					</tr>";
				
				$i=0;
					while ($row=mysql_fetch_array($resultado)) {
						if ($i%2==0) {
							$clase="tablaFilaPar";
						} else {
							$clase="tablaFilaNone";
						}
						echo "<tr class=\"$clase\" title=\"DESPACHO: $row[0] \nDESPACHADO POR: $row[2] $row[3]\">";
							echo "<td align=\"left\">";
							if ($row[9]=='DEE0000001') {
								echo "<a class=enlace href=\"index2.php?item=620&idDetalle=$row[8]\">USUARIO</a> | 
								<a class=enlace href=\"index2.php?item=618&idDetalle=$row[8]\">EQUIPO</a> | $row[17]";
							} else {
								echo "$row[17]";
							}
							echo "</td>";
							$fecha=substr($row[6],8,2).'/'.substr($row[6],5,2).'/'.substr($row[6],0,4);
						echo "<td>$row[19]</td>
							<td>$row[21]</td>
							<td>$row[23] $row[24] $row[25]</td>
							<td>$row[12] $row[13]</td>
							<td>$fecha</td>
							<td>$row[10]</td>
							<td><a class=enlace href=\"#\" onclick=\"window.open('../librerias/xmlAsignacionComponentes.php?idDespacho=$row[0]')\">ASIG |</a>
							<a class=enlace href=\"#\" onclick=\"window.open('../librerias/xmlsalidainternacomponentes.php?idDespacho=$row[0]')\">INT |</a>
							<a class=enlace href=\"#\" onclick=\"window.open('../librerias/xmlsalidaexternacomponentes.php?idDespacho=$row[0]')\">EXT</a></td>
						</tr>";
						$i++;
					}
			
			   } else {	   	
			   	
			   	
				echo "<tr class=\"$clase\">				
							<td align=\"center\" colspan=\"6\">NO HAY COMPONENTES DESPACHADOS</td>";
				echo "</tr>";
			}
			
			echo "</table>";

}
?>