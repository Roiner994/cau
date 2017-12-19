<?php
//Nuevos Requerimientos de Hardware
require_once("requerimientoAdmin.php");	

?>
<script language="javascript" type="text/javascript">
	function buscarFicha() {
		if (document.frmRequerimiento.txtFicha.value!="") {
			document.frmRequerimiento.funcion.value=0;
			posicionamientoPantalla();
			document.frmRequerimiento.submit();	
		}
	}
	function nuevoSi(ficha) {
		document.frmRequerimiento.funcion.value=2;
		document.frmRequerimiento.submit();	
	}
	var miPopup
	function modificarUsuario(ficha) {
		
		miPopup=window.open('../librerias/usuarioModificarSolicitudes.php?funcion=2&ficha='+ficha,width=800,height=600);
		miPopup.focus();
	}
	
</script>
<?php

switch ($funcion) {
	case 1:
		if (isset($_POST[txtFicha]) && empty($_POST[txtFicha])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>FICHA</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[txtEspecifico]) && empty($_POST[txtEspecifico])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>DETALLE REQUERIMIENTO</b>";
			$i++;
			$sw=1;
		}

		if (isset($_POST[selDescripcion]) && $_POST[selDescripcion]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>DESCRIPCION</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[selRequerimientoMotivo]) && $_POST[selRequerimientoMotivo]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>MOTIVO</b>";
			$i++;
			$sw=1;
		}		
		
		switch($i) {
			case 0:
		$requerimiento= new requerimientoHardware();
		$requerimiento->setRequerimientoHardware($_POST[idRequerimiento],$_POST[txtFicha],$login);
		$requerimiento->setDetalleRequerimiento($_POST[idRequerimiento],$_POST[selDescripcion],$_POST[txtEspecifico],$_POST[selRequerimientoMotivo],'STA0000003');
		
		$resultado=$requerimiento->ingresar();
		switch ($resultado) {
			case 0:
				$_POST[idRequerimiento]=$requerimiento->retornaIdRequerimiento();
				echo "<form name=\"frmRequerimiento\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<input name=\"idRequerimiento\" type=\"hidden\" value=\"$_POST[idRequerimiento]\">";
				echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtFicha]\">";
				echo "<input name=\"selRequerimientoMotivo\" type=\"hidden\" value=\"$_POST[selRequerimientoMotivo]\">";
				echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";

				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - NUEVO EQUIPO</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO LA NUEVA SOLICITUD.<br>¿DESEA AGREGARLE OTRA SOLICITUD A ESTE USUARIO?</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>
				<input name=\"btnSi\" type=\"button\" value=\"SI\" onclick=\"nuevoSi()\">
				<input name=\"btnNo\" type=\"button\" value=\"NO\" onclick=\"location.href='index2.php?item=200'\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";	
				break 1;			
			case 1:
				echo "<form name=\"frmRequerimiento\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";

				echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtFicha]\">";

				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - NUEVO EQUIPO</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR LA SOLICITUD</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";	
				break 1;
			case 2:


				break 1;
		
			default:
				break;
		}				
			
			break 1;
			case 1:
				echo "<form name=\"frmRequerimiento\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
				echo "<input name=\"idRequerimiento\" type=\"hidden\" value=\"$_POST[idRequerimiento]\">";
				echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtFicha]\">";
				echo "<input name=\"selRequerimientoMotivo\" type=\"hidden\" value=\"$_POST[selRequerimientoMotivo]\">";
				echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";				
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - NUEVO EQUIPO</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>EL CAMPO ".$mensaje. " ESTA VAC&Iacute;O</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";		
				break 1;
			default:
				echo "<form name=\"frmRequerimiento\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
 				echo "<input name=\"idRequerimiento\" type=\"hidden\" value=\"$_POST[idRequerimiento]\">";
				echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtFicha]\">";
				echo "<input name=\"selRequerimientoMotivo\" type=\"hidden\" value=\"$_POST[selRequerimientoMotivo]\">";
				echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";						
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - NUEVO EQUIPO</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>LOS CAMPOS ".$mensaje. " ESTAN VAC&Iacute;OS</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";			
				echo "</form>";				
		}
		break 1;
	case 2:
		echo "<form name=\"frmRequerimiento\" method=\"post\" action=\"\">";
		echo "<input name=\"idRequerimiento\" type=\"hidden\" value=\"$_POST[idRequerimiento]\">";
		echo "</form>";	
		frmRequerimiento();
		break 1;
	case 3:
		frmRequerimiento();
		break 1;	
	default:
		frmRequerimiento();
}

function frmRequerimiento() {

	require_once("formularios.php");
	require_once("usuarioAdmin.php");
	require_once("rptAdmin.php");
	
	if (isset($_POST[txtFicha]) && !empty($_POST[txtFicha])) {
		$usuario= new usuario($_POST[txtFicha]);
		$resultadoUsuario= $usuario->retornaUsuario();
		if ($resultadoUsuario && $resultadoUsuario!=1) {
			$rowUsuario=mysql_fetch_array($resultadoUsuario);
			$fichaUsuario=$rowUsuario[0];
			$nombreApellido=$rowUsuario[2];
			$cargo=$rowUsuario[6];
			$gerencia=$rowUsuario[10];
			$division=$rowUsuario[12];
			$departamento=$rowUsuario[14];
			$sitio=$rowUsuario[8];
			$extension=$rowUsuario[15];
			$encontrado=1;
		} else {
			$encontrado=0;
			unset($_POST[txtFicha]);
		}
	}


	$conRequerimientoMotivo="select id_requerimiento_motivo,requerimiento_motivo from requerimiento_motivo where status_activo=1 order by requerimiento_motivo";
	$conDescripcion="select id_descripcion,descripcion from descripcion order by descripcion";

	
	
	$requerimientoMotivo= new campoSeleccion("selRequerimientoMotivo","formularioCampoSeleccion","$_POST[selRequerimientoMotivo]","","",$conRequerimientoMotivo,"--SELECCIONE--","");
	$selRequerimientoMotivo=$requerimientoMotivo->retornar();		
	
	$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion","$_POST[selDescripcion]","","",$conDescripcion,"--DESCRIPCION--","");
	$selDescripcion=$descripcion->retornar();	
	
	
	
	echo "<form name=\"frmRequerimiento\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"idRequerimiento\" type=\"hidden\" value=\"$_POST[idRequerimiento]\">";
	echo "<table class=\"formularioTabla\" align=\"center\" width=\"70%\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"2\">NUEVO REQUERIMIENTO DE HARDWARE</td>
  	</tr>";
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL USUARIO</td>
  	</tr>";

	if ($encontrado==0) {
		$Usuario="<input class=\"formularioCampoTexto\" name=\"txtFicha\" type=\"text\" value=\"$_POST[txtFicha]\" onKeyPress=\"if (event.keyCode==13) buscarFicha();\">
		<input name=\"btnBuscarFicha\" type=\"button\" value=\"B\" onClick=\"buscarFicha()\">";
	} else {
		$Usuario="<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtFicha]\"><b class=\"campo\">".$fichaUsuario."</b>";
	}
	echo "<tr>
    		<td valign=top class=\"formularioCampoTitulo\">FICHA<br>
    		
			$Usuario
			<br>
			NOMBRE Y APELLIDO<br><b class=\"campo\">$nombreApellido</b><br>
			CARGO<br><b class=\"campo\">$cargo</b><br>
			EXTENSION<br><b class=\"campo\">$extension</b><br>
			</td>
    		
			<td valign=top class=\"formularioCampoTitulo\">GERENCIA<br>
			<b class=\"campo\">$gerencia</b><br>
			DIVISION<br><b class=\"campo\">$division</b><br>
			DEPARTAMENTO<br><b class=\"campo\">$departamento</b><br>
			SITIO<br><b class=\"campo\">$sitio</b><br>
			</td>
		</tr>";
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL REQUERIMIENTO</td>
  	</tr>";	
	echo "<tr>
    		<td valign=top class=\"formularioCampoTitulo\">MOTIVO SOLICITUD<br>
			$selRequerimientoMotivo<br>
			</td>
    		
			<td valign=top class=\"formularioCampoTitulo\">TIPO DE REQUERIMIENTO<br>
			$selDescripcion<br>
			</td>
		</tr>";
	
	echo "<tr>
		<td colspan=\"2\" align=\"center\" class=\"formularioCampoTitulo\">DESCRIBA AQU&Iacute; EL REQUERIMIENTO</td>
		</tr>
		<tr>
		<td colspan=\"2\" align=\"center\"><textarea class=\"formularioAreaTextoPlanilla\" name=\"txtEspecifico\" cols=\"600\" rows=\"2\">$_POST[txtEspecifico]</textarea></td>
		</tr>";	
	

	echo "<tr>";
		echo "<td colspan=\"4\" align=\"center\">
		<input name=\"btnGuardar\" type=\"submit\" value=\"GUARDAR\">
		<input name=\"btnModificar\" type=\"button\" value=\"MODIFICAR\" onclick=\"modificarUsuario($_POST[txtFicha])\"></td>
		</tr>";
	echo "</table>";
		if (isset($_POST[txtFicha]) && !empty($_POST[txtFicha])) {


//SOLICITUDES
			
			$rptSolicitudes= new requerimientoHardware(); 			
			$resultadoSolicitudes=$rptSolicitudes->buscarRequerimientoPorPersonas($_POST[txtFicha]);
 	echo "<table width=\"40%\" border=\"0\" align=\"center\">  
 			<tr>
		<td valign=top class=\"tablaTitulo\" colspan=\"2\"><b>SOLICITUDES HECHAS</b></td>
		</tr>";	
	 if ($resultadoSolicitudes && $resultadoSolicitudes!=1) {

   echo "<tr>
		<td valign=top class=\"tablaTitulo\"><b>DESCRIPCION</b></td>
		<td valign=top class=\"tablaTitulo\"><b>CANTIDAD</b></td>		  
		</tr>";
	 	$total=0;
	 	while ($row=mysql_fetch_array($resultadoSolicitudes)) {
	 		if ($i%2==0) {
	 			$clase="tablaFilaPar";
	 		} else {
	 			$clase="tablaFilaNone";
	 		}
	 		echo "<tr class=\"$clase\">";
	 		echo "<td align=\"left\"><a class=enlace href=\"#\" onclick=\"window.open('../librerias/rptResumenInventarios.php?idDescripcion=$row[0]&txtFicha=$_POST[txtFicha]')\"> $row[1]</a></td>";
	 		echo "<td align=\"center\">$row[2]</td>";
	 		echo "</tr>";
	 		$total=$total+$row[2];
	 		$i++;
	 	}

	 	echo "<tr class=\"$clase\">";
	 	echo "<td align=\"left\">TOTAL</td>";
	 	echo "<td align=\"center\"><b>$total</b></td>";
	 	echo "</tr>";

	 } else {
	 	echo "<tr class=\"tablaTitulo\">
		<td valign=top colspan=\"2\">NO HAY RESULTADO
		</td></tr>";
	 }
	 echo "</table>";
			
//EQUIPOS			
			$rptEquipos= new rptEquipos(); 			
			$resultado=$rptEquipos->retornaEquipoAsignadoporUsuario($fichaUsuario);
     
 	echo "<table width=\"40%\" border=\"0\" align=\"center\">  
 			<tr>
		<td valign=top class=\"tablaTitulo\" colspan=\"2\"><b>EQUIPOS ASIGNADOS</b></td>
		</tr>";	
	 if ($resultado && $resultado!=1) {

   echo "<tr>
		<td valign=top class=\"tablaTitulo\"><b>DESCRIPCION</b></td>
		<td valign=top class=\"tablaTitulo\"><b>CANTIDAD</b></td>		  
		</tr>";
	 	$total=0;
	 	while ($row=mysql_fetch_array($resultado)) {
	 		if ($i%2==0) {
	 			$clase="tablaFilaPar";
	 		} else {
	 			$clase="tablaFilaNone";
	 		}
	 		echo "<tr class=\"$clase\">";
	 		echo "<td align=\"left\"><a class=enlace href=\"#\" onclick=\"window.open('../librerias/rptResumenInventarios.php?idDescripcion=$row[0]&txtFicha=$_POST[txtFicha]')\"> $row[1]</a></td>";
	 		echo "<td align=\"center\">$row[2]</td>";
	 		echo "</tr>";
	 		$total=$total+$row[2];
	 		$i++;
	 	}

	 	echo "<tr class=\"$clase\">";
	 	echo "<td align=\"left\">TOTAL</td>";
	 	echo "<td align=\"center\"><b>$total</b></td>";
	 	echo "</tr>";

	 } else {
	 	echo "<tr class=\"tablaTitulo\">
		<td valign=top colspan=\"2\">NO HAY RESULTADO
		</td></tr>";
	 }
	 echo "</table>";

//COMPONENTES	


	$rptComponentes= new rptComponentes();		
	$resultado=$rptComponentes->retornarInventarioComponentes("","","","","",$fichaUsuario,"","","","","","","","ID_DESCRIPCION");
     
 	echo "<table width=\"40%\" border=\"0\" align=\"center\">  
 			<tr>
		<td valign=top class=\"tablaTitulo\" colspan=\"2\"><b>COMPONENTES ASIGNADOS</b></td>
		</tr>";	
	 if ($resultado && $resultado!=1) {

   echo "<tr>
		<td valign=top class=\"tablaTitulo\"><b>DESCRIPCION</b></td>
		<td valign=top class=\"tablaTitulo\"><b>CANTIDAD</b></td>		  
		</tr>";
	 	$total=0;
	 	while ($row=mysql_fetch_array($resultado)) {
	 		if ($i%2==0) {
	 			$clase="tablaFilaPar";
	 		} else {
	 			$clase="tablaFilaNone";
	 		}
	 		echo "<tr class=\"$clase\">";
	 		echo "<td align=\"left\"><a class=enlace href=\"#\" onclick=\"generarReporte('$row[2]')\"> $row[3]</a></td>";
	 		echo "<td align=\"center\">$row[45]</td>";
	 		echo "</tr>";
	 		$total=$total+$row[45];
	 		$i++;
	 	}

	 	echo "<tr class=\"$clase\">";
	 	echo "<td align=\"left\">TOTAL</td>";
	 	echo "<td align=\"center\"><b>$total</b></td>";
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
