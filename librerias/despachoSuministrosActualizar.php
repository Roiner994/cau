<script>
	function buscarConfiguracion() {
		if (document.frmEquipo.txtConfiguracion.value!="") {
			document.frmEquipo.funcion.value=5;
			document.frmEquipo.submit();
		}
	}
	function buscarFicha() {
		if (document.frmEquipo.txtFicha.value!="") {
			document.frmEquipo.funcion.value=2;
			document.frmEquipo.submit();	
		}
	}
	function cambiarSeleccionOtros() {
		document.frmEquipo.funcion.value=2;
		document.frmEquipo.cambiarUbicacion.value=1;
		document.frmEquipo.txtAsociar.value=0;
		document.frmEquipo.submit();
	}
	function devolverInventario() {
		document.frmEquipo.funcion.value=3;
		document.frmEquipo.txtAsociar.value=0;
		document.frmEquipo.submit();
	}
	function actualizarAsignacion() {
		document.frmEquipo.funcion.value=1;
		document.frmEquipo.txtAsociar.value=0;
		document.frmEquipo.submit();
	}
	function cambiarEquipo() {
		document.frmEquipo.funcion.value=4;
		document.frmEquipo.submit();
	}
	var miPopup
	function modificarRequerimiento(descripcion,gerencia) {
		miPopup=window.open('../librerias/requerimientoCerrar.php');
		miPopup.focus();
	}					
</script>
<?php
switch ($funcion) {
	case 1:
		//Asocia los Componentes al Equipo
		require_once "conexionsql.php";
		require_once "inventarioAdmin.php";
		require_once "administracion.php";
		require_once "usuarioAdmin.php";
		if (isset($_POST[txtFicha]) && empty($_POST[txtFicha])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>FICHA</b>";
			$i++;
			$sw=1;
		}
		switch ($i) {
			case 0:
				$login=$_SESSION["login"];
				$usuario= new usuario($_POST[txtFicha],"","","","","","",$_POST[selDepartamento],$_POST[selSitio],$_POST[txtExtension]);
				$resultado=$usuario->actualizarUsuario();
				$componenteAsociar= new componente();
				$componenteAsociar->setInventario($_POST[optInventario]);
				$componenteAsociar->setInventarioUsuario($_POST[txtFicha],$login);
				$componenteAsociar->setInventarioUbicacion($_POST[selDepartamento],$_POST[selSitio],$_POST[txtEspecifico],$login);
				$resultado=$componenteAsociar->ingresarInventarioUsuario();
				$resultado=$componenteAsociar->ingresarInventarioUbicacion();
				switch ($resultado) {
					case 0:
						$despacho= new despacho();
						$despacho->setDespacho("",$idDetalle,$_POST[optInventario],$login,"","","","",$_POST[txtFicha]);
						if ($_POST[chkPrestamo]==1)
							$tipoAsignacion='DEE0000004';
						else
							$tipoAsignacion='DEE0000002';
						$resultado=$despacho->actualizarDespacho("$tipoAsignacion");

						require_once("requerimientoAdmin.php");
						$requerimiento= new requerimientoHardware();
						$requerimiento->setRequerimientoHardware("","",$login);
						$requerimiento->setDetalleRequerimiento($_POST[txtIdSolicitud]);
						$resultadoRequerimiento=$requerimiento->cerrarRequerimientoComponente($_POST[optInventario]);
						
						echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
						echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO - CONTROL EQUIPO</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>SE ASIGNÓ EL COMPONENTE</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnAceptar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php?item=151&config=$configuracion'\">
						</td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";				
						break 1;
					case 1:
						echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
						echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO - CONTROL EQUIPO</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE REALIZAR LA ASOCIACION</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\" onclick=\"\">
						</td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";	
						break 1;
					default:	
					
				}
				break 1;
			case 1:
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
				echo "<input name=\"txtActivoFijo\" type=\"hidden\" value=\"$_POST[txtActivoFijo]\">";
				echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
				echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
				echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
				echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
				echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
				echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
				echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
				echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
				echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
				echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
				echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
				echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
				echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
				echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
				echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
				echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";

				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - ASIGNACION DE COMPONENTES</td>
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
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
				echo "<input name=\"txtActivoFijo\" type=\"hidden\" value=\"$_POST[txtActivoFijo]\">";
				echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
				echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
				echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
				echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
				echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
				echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
				echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
				echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
				echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
				echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
				echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
				echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
				echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
				echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
				echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
				echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";

				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - ASIGNACION DE COMPONENTES</td>
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
		despachoActualizar($idDetalle,$_POST[txtConfiguracion],1);
		break 1;
	case 3:
		require_once("inventarioAdmin.php");
		require_once("administracion.php");
		$despacho= new despacho();
		$despacho->setDespacho("",$idDetalle,$_POST[optInventario],$login);
		$resultado=$despacho->eliminarDespacho();
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - ASIGNACION DE COMPONENTES</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>SE REINTEGRO EL COMPONENTE AL INVENTARIO</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\" onclick=\"location.href='index2.php?item=617'\"></td>";
				echo "</tr>";
				echo "</table>";			
				echo "</form>";		
		break 1;
	case 5:
			despachoActualizar($idDetalle,$_POST[txtConfiguracion]);
		break 1;
	default:
		despachoActualizar($idDetalle);	
}


function despachoActualizar($idDetalle,$configuracion="",$cambiarSeleccion=0) {
require_once("inventarioAdmin.php");
		require_once "conexionsql.php";
		require_once "formularios.php";
		require_once "usuarioAdmin.php";
		if (isset($configuracion) && !empty($configuracion)) {	
		$equipoBuscar= new equipo();
		$equipoBuscar->setEquipo($configuracion);	
		$resultado=$equipoBuscar->buscarEquipo();
		$_POST[selEstado]=$equipoBuscar->retornarUltimoEstado();
		$componenteAsociado=$equipoBuscar->buscarComponentesAsociados();
		if ($resultado && $resultado!=1) {
			$row=mysql_fetch_array($resultado);
			$_POST[txtConfiguracion]=$row[0];
			$_POST[txtActivoFijo]=$row[1];
			$idInventario=$row[2];
			$_POST[txtSerial]=$row[3];
			$_POST[txtDescripcion]=$row[5];	
			$_POST[txtMarca]=$row[7];
			$_POST[txtModelo]="$row[9] $row[10] $row[11]";
			$descrip=$row[4];
			$descrip=str_replace('DES','DSP',$descrip);
			$_POST[tipoEquipo]=$descrip;
		} else {
			unset($_POST[selEstado]);
			unset($_POST[txtConfiguracion]);
			unset($_POST[txtActivoFijo]);
			unset($_POST[txtSerial]);
			unset($_POST[txtDescripcion]);
			unset($_POST[txtMarca]);
			unset($_POST[txtModelo]);
		}
		
		}

	if (isset($_POST[txtFicha]) && !empty($_POST[txtFicha]) && $_POST[cambiarUbicacion]==0) {
			$usuarioAsignacion= new usuario($_POST[txtFicha]);
			$resultadoUsuario= $usuarioAsignacion->retornaUsuario();
			if ($resultadoUsuario && $resultadoUsuario!=1) {
				$row5=mysql_fetch_array($resultadoUsuario);
				$_POST[txtNombres]=$row5[2];
				$_POST[txtCargo]=$row5[6];
				$_POST[selSitio]=$row5[7];
				$_POST[selGerencia]=$row5[9];
				$_POST[selDivision]=$row5[11];
				$_POST[selDepartamento]=$row5[13];
				$_POST[txtExtension]=$row5[15];
			}
	}
	$conSitio="select id_sitio,sitio from sitio where status_activo=1 order by sitio";
	$conGerencia="select id_gerencia,gerencia from gerencia where status_activo=1 order by gerencia";
	$conDivision="select id_division,division from division where id_gerencia='$_POST[selGerencia]' and status_activo=1 order by division";
	$conDepartamento="select id_departamento, departamento from departamento where id_division='$_POST[selDivision]' and status_activo=1 ORDER BY departamento";
	
	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--UBICACION--","");
	$selSitio=$sitio->retornar();

	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","cambiarSeleccionOtros()",$conGerencia,"--GERENCIA--","");
	$selGerencia=$gerencia->retornar();		

	$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","cambiarSeleccionOtros()",$conDivision,"--DIVISION--","");
	$selDivision=$division->retornar();

	$departamento= new campoSeleccion("selDepartamento","formularioCampoSeleccion","$_POST[selDepartamento]","onChange","cambiarSeleccionOtros()",$conDepartamento,"--DEPARTAMENTO--","");
	$selDepartamento=$departamento->retornar();	
	
//Despacho
//DespachoComponentesActualizar.php
		echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
		echo "<tr>
				<td class=\"formularioTablaTitulo\" align=center colspan=\"5\">COMPONENTES PARA ASIGNAR</td>
			</tr>";
$despacho= new despacho();
	$resultado=$despacho->retornarDetalleDespacho($idDetalle);
	if ($resultado && $resultado!=1) {
		echo "<tr valign=top class=\"tablaTitulo\">
			<td valign=top class=\"tablaTitulo\">SERIAL</td>
			<td align=\"left\" class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
			<td valign=top class=\"tablaTitulo\">MARCA</td>
			<td valign=top class=\"tablaTitulo\">MODELO</td>
			<td valign=top class=\"tablaTitulo\">ANALISTA</td>
			</tr>";
		$row=mysql_fetch_array($resultado);
		$_POST[tipoComponente]=$row[17];
		$_POST[optInventario]=$row[2];
		$_POST[idDescripcion]=$row[4];
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}	
		echo "<tr class=\"$clase\">
					<td align=\"left\">$row[3]</td>
					<td>$row[5]</td>
					<td>$row[7]</td>
					<td>$row[9] $row[10] $row[11]</td>
					<td>$row[15] $row[16]</td>
				</tr>";
		echo "<tr>";
	} else {
		echo "<tr class=\"tablaFilaPar\">
					<td align=\"center\" colspan=\"5\">NO HAY COMPONENTES DESPACHADOS</td>";
		echo "</tr>";
	}
	echo "</table>";
	
	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"cambiarUbicacion\" type=\"hidden\" value=\"0\">";
	echo "<input name=\"txtAsociar\" type=\"hidden\" value=\"$_POST[txtAsociar]\">";
	echo "<input name=\"optInventario\" type=\"hidden\" value=\"$_POST[optInventario]\">";
	echo "<input name=\"tipoEquipo\" type=\"hidden\" value=\"$_POST[tipoEquipo]\">";
	echo "<input name=\"tipoComponente\" type=\"hidden\" value=\"$_POST[tipoComponente]\">";
	echo "<input name=\"idDescripcion\" type=\"hidden\" value=\"$_POST[idDescripcion]\">";

	echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
		echo "<tr>
				<td class=\"formularioTablaTitulo\" align=center colspan=\"5\">TIPO DE ASIGNACION</td>
			</tr>";
			echo "<tr>
				<td valign=top class=\"formularioCampoTitulo\">¿PRESTAMO?<br>";
				if ($_POST[chkPrestamo]==1)
					echo "<input name=\"chkPrestamo\" type=\"checkbox\" value=\"1\" checked><br>";
				else
					echo "<input name=\"chkPrestamo\" type=\"checkbox\" value=\"1\"><br>";
			echo "</td>

			</tr>";			
			echo "<tr>
			<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL USUARIO</td>";
			echo "</tr>";
			echo "<tr>
			<td valign=top class=\"formularioCampoTitulo\">FICHA:<br><input class=\"formularioCampoTexto\" name=\"txtFicha\" type=\"text\" value=\"$_POST[txtFicha]\" onKeyPress=\"if (event.keyCode==13) buscarFicha();\">
			<input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"C\" onclick=\"buscarFicha()\"><br>
			NOMBRES<br>
			<input class=\"formularioCampoTexto\" name=\"txtNombres\" type=\"text\" value=\"$_POST[txtNombres]\" readonly=\"true\"></td>
			<td valign=top class=\"formularioCampoTitulo\">CARGO<br>
			<input class=\"formularioCampoTexto\" name=\"txtCargo\" type=\"text\" value=\"$_POST[txtCargo]\" readonly=\"true\"><br>
			EXTENSION<br>
			<input class=\"formularioCampoTexto\" name=\"txtExtension\" type=\"text\" value=\"$_POST[txtExtension]\"></td>";
			echo "</tr>";
			echo "<tr>
			<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DE UBICACION</td>";
			echo "</tr>
	  		<tr>
			<td class=\"formularioCampoTitulo\">UBICACION<br>$selSitio<br>
			GERENCIA<br>$selGerencia</td>
			<td class=\"formularioCampoTitulo\">
			DIVISION<br>$selDivision<br>
			DEPARTAMENTO<br>$selDepartamento</td>
		</tr>";
		echo "<tr>";
		echo "<td colspan=\"2\" align=\"center\"><textarea class=\"formularioAreaTextoPlanilla\" name=\"txtEspecifico\" cols=\"600\" rows=\"2\">$_POST[txtEspecifico]</textarea></td>";
		echo "</tr>";
		echo "<tr>
			<td valign=top class=\"formularioCampoTitulo\">ID DE SOLICITUD:<br>
			<input class=\"formularioCampoTexto\" name=\"txtIdSolicitud\" type=\"text\" value=\"$_POST[txtIdSolicitud]\">
			<input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"BUSCAR\" onclick=\"modificarRequerimiento('$_POST[idDescripcion]','$_POST[selGerencia]')\">
			<br>
			</td>
			<td valign=top class=\"formularioCampoTitulo\">&nbsp;</td>

		</tr>";
		echo "<tr>
			<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"5\">
			<a class=\"botonEnlace\" href=\"#\" onclick=\"devolverInventario()\">DEVOLVER AL INVENTARIO</a>
			<a class=\"botonEnlace\" href=\"#\" onclick=\"actualizarAsignacion()\">ASIGNAR <br>DESPACHO</a>
			</td>
		</tr>";
	echo "</table>";
	echo "<input name=\"optInventario\" type=\"hidden\" value=\"$_POST[optInventario]\">";
	echo "</form>";
}

?>