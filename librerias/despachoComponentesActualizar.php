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
		if (isset($_POST[txtConfiguracion]) && empty($_POST[txtConfiguracion])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>CONFIGURACION</b>";
			$i++;
			$sw=1;
		}
		switch ($i) {
			case 0:
			if (($_POST[tipoEquipo]==$_POST[tipoComponente] || $_POST[tipoEquipo]==DSP0000057 || $_POST[tipoEquipo]=DES0000042) || ($_POST[idDescripcion]==DES0000022)) {
				$login=$_SESSION["login"];
				$componenteAsociar= new componente();
				$componenteAsociar->setInventario($_POST[optInventario]);
				$resultado=$componenteAsociar->buscarEquipoAsociado();
				if ($resultado==1) {
					$componenteAsociar->setComponente($_POST[txtConfiguracion]);
					$componenteAsociar->setInventarioPropiedad("",$login);
					$asociar=$componenteAsociar->asociarComponenteEquipo();
					if ($asociar==0) {
						$despacho= new despacho();
						$despacho->setDespacho("",$idDetalle,$_POST[optInventario],$login,"","","","","",$_POST[txtConfiguracion]);
						if ($_POST[chkPrestamo]==1)
							$tipoAsignacion='DEE0000004';
						else
							$tipoAsignacion='DEE0000002';
						$resultado=$despacho->actualizarDespacho("$tipoAsignacion");
						
						require_once("requerimientoAdmin.php");
						$requerimiento= new requerimientoHardware();
						$requerimiento->setRequerimientoHardware("","",$login);
						$requerimiento->setDetalleRequerimiento($_POST[txtIdSolicitud]);
						$resultado=$requerimiento->cerrarRequerimientoComponente($_POST[optInventario]);
						echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
						echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
						$configuracion=$_POST[txtConfiguracion];
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
					} else {
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
					}			
				} else {
					
					require_once("requerimientoAdmin.php");
					$requerimiento= new requerimientoHardware();
					$requerimiento->setRequerimientoHardware("","",$login);
					$requerimiento->setDetalleRequerimiento($_POST[txtIdSolicitud]);
					$resultadoCerrar=$requerimiento->cerrarRequerimientoComponente($_POST[optInventario]);
					
					echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: INVENTARIO - CONTROL EQUIPO</td>
					</tr>";
					$serial=$componenteAsociar->buscarInventario();
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>EL COMPONENTE CON SERIAL 
					<B>$serial</B> ESTÁ ASOCIADO AL EQUIPO <b>$resultado</b>.<br>
					¿DESEA ASOCIARLO AHORA AL EQUIPO <b>$_POST[txtConfiguracion]</b>?</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnSI\" type=\"button\" value=\"SI\" onclick=\"cambiarEquipo()\">
					<input name=\"btnNO\" type=\"button\" value=\"NO\" onclick=\"buscarConfiguracion()\"></td>";
					echo "</tr>";
					echo "</table>";
					echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
					echo "<input name=\"optInventario\" type=\"hidden\" value=\"$_POST[optInventario]\">";
					echo "</form>";		
				}

			} else {
				unset($_POST[txtConfiguracion]);
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - CONTROL EQUIPO</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>NO PUEDE ASIGNAR ESTE TIPO DE COMPONENTE AL EQUIPO</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\" onclick=\"\">
				</td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";				
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
	case 4:
			require_once "conexionsql.php";
			require_once "inventarioAdmin.php";
//			require_once "componenteAdmin.php";
//			require_once "equipoAdmin.php";
			require_once "administracion.php";
			$login=$_SESSION["login"];
			$componenteAsociar= new componente();
			$componenteAsociar->setInventario($_POST[optInventario]);
			$componenteAsociar->setComponente($_POST[txtConfiguracion]);
			$componenteAsociar->setInventarioPropiedad("",$login);
			$asociar=$componenteAsociar->asociarComponenteEquipo();
			if ($asociar==0) {
				$despacho= new despacho();
				$despacho->setDespacho("",$idDetalle,$_POST[optInventario],$login);
				if ($_POST[chkPrestamo]==1)
					$tipoAsignacion='DEE0000004';
				else
					$tipoAsignacion='DEE0000002';
				$resultado=$despacho->actualizarDespacho("$tipoAsignacion");
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
				$configuracion=$_POST[txtConfiguracion];
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
			} else {
				echo "<br>estado de Componente<br>";
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
			}		
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
		$gerencia=$equipoBuscar->retornarUltimaUbicacion('g');
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
		$idDescripcion=$row[4];
	} else {
		echo "<tr class=\"tablaFilaPar\">
					<td align=\"center\" colspan=\"5\">NO HAY COMPONENTES DESPACHADOS</td>";
		echo "</tr>";
	}
	echo "</table>";
	
	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
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
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\"  colspan=\"2\">DATOS DEL EQUIPO</td>
			</tr>";
		
			echo "<tr>
				<td valign=top class=\"formularioCampoTitulo\">CONFIGURACION:<br><input class=\"formularioCampoTexto\" name=\"txtConfiguracion\" type=\"text\" value=\"$_POST[txtConfiguracion]\" onKeyPress=\"if (event.keyCode==13) buscarConfiguracion();\" onBlur=\"buscarConfiguracion()\">
				<input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"C\" onclick=\"buscarConfiguracion()\" ><br>
				SERIAL:<br><input class=\"formularioCampoTexto\" name=\"txtSerial\" type=\"text\" value=\"$_POST[txtSerial]\" readonly=\"true\"><br>
				MARCA:<br><input class=\"formularioCampoTexto\" name=\"txtMarca\" type=\"text\" value=\"$_POST[txtMarca]\" readonly=\"true\"><br>
				</td>
				<td valign=top class=\"formularioCampoTitulo\">ACTIVO FIJO:<br><input class=\"formularioCampoTexto\" name=\"txtActivoFijo\" type=\"text\" value=\"$_POST[txtActivoFijo]\"><br>
				DESCRIPCION:<br><input class=\"formularioCampoTexto\" name=\"txtDescripcion\" type=\"text\" value=\"$_POST[txtDescripcion]\" readonly=\"true\"><br>
				MODELO:<br><input class=\"formularioCampoTexto\" name=\"txtModelo\" type=\"text\" value=\"$_POST[txtModelo]\" readonly=\"true\"><br>
				</td>

			</tr>";

			echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\"  colspan=\"2\">SOLICITUD DE NUEVO REQUERIMIENTO</td>
			</tr>";
						
			echo "<tr>
				<td valign=top class=\"formularioCampoTitulo\">ID DE SOLICITUD:<br>
				<input class=\"formularioCampoTexto\" name=\"txtIdSolicitud\" type=\"text\" value=\"$_POST[txtIdSolicitud]\">
				<input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"BUSCAR\" onclick=\"modificarRequerimiento('$idDescripcion','$gerencia')\">
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