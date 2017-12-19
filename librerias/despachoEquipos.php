<?php
require_once("seguridad.php");
?>
<script language="javascript">
	function cambiarSeleccionOtros() {
		document.frmDespacho.funcion.value=0;
		document.frmDespacho.cambiarSeleccion.value=1;
		document.frmDespacho.cambiarConfiguracion.value=1;
		posicionamientoPantalla();
		document.frmDespacho.submit();
	}
	function generarDespacho() {
			document.frmDespacho.funcion.value=1;
			document.frmDespacho.submit();			
	}	
	function buscarConfiguracion() {
		if (document.frmDespacho.txtConfiguracion.value!="") {
			document.frmDespacho.funcion.value=2;
			document.frmDespacho.cambiarConfiguracion.value=1;
			posicionamientoPantalla();
			document.frmDespacho.submit();
		} else {
			document.frmDespacho.txtSerial.value="";
			document.frmDespacho.txtActivoFijo.value="";
			document.frmDespacho.txtDescripcion.value="";
			document.frmDespacho.txtMarca.value="";
			document.frmDespacho.txtModelo.value="";
		}
	}
	function buscarConfiguracionAnterior() {
		if (document.frmDespacho.txtConfiguracionAnterior.value!="") {
			document.frmDespacho.funcion.value=0;
			document.frmDespacho.cambiarConfiguracion.value=1;
			posicionamientoPantalla();
			document.frmDespacho.submit();
		} else {
			document.frmDespacho.txtSerialAnterior.value="";
			document.frmDespacho.txtActivoFijoAnterior.value="";
			document.frmDespacho.txtDescripcionAnterior.value="";
			document.frmDespacho.txtMarcaAnterior.value="";
			document.frmDespacho.txtModeloAnterior.value="";
		}
	}
	function buscarFicha() {
		if (document.frmDespacho.txtFicha.value!="") {
			document.frmDespacho.funcion.value=0;
			document.frmDespacho.cambiarConfiguracion.value=1;
			posicionamientoPantalla();
			document.frmDespacho.submit();	
		} else {
			document.frmDespacho.txtNombres.value="";
			document.frmDespacho.txtCargo.value="";
			document.frmDespacho.txtExtension.value="";
			document.frmDespacho.selSitioUsuario.value=100;

		}
	}
	function limpiarCampo(entrada) {
		var valor=entrada.value;
		if(valor=="NO ENCONTRADO")
			entrada.value="";
	}
	function imprimirPlanilla() {
		configuracion=document.frmDespacho.txtConfiguracion.value;
		analista=document.frmDespacho.selUsuarioSistema.value;
		window.open('../librerias/xmlAsignacionEquipos.php?configuracion='+configuracion+'&analista='+analista);
	}	
</script>
	
<?php
require_once("administracion.php");
require_once("inventarioAdmin.php");
require_once("usuarioAdmin.php");
switch ($funcion) {
	case 1:
		if (isset($_POST[txtConfiguracion]) && empty($_POST[txtConfiguracion])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>CONFIGURACION NUEVA</b>";
			$i++;
			$sw=1;
		}			
		if (isset($_POST[txtNombres]) && empty($_POST[txtNombres])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>USUARIO</b>";
			$i++;
			$sw=1;
		}			
		if (isset($_POST[selSitio]) && $_POST[selSitio]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>SITIO</b>";
			$i++;
			$sw=1;
		}		
		if (isset($_POST[selGerencia]) && $_POST[selGerencia]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>GERENCIA</b>";
			$i++;
			$sw=1;
		}		
		if (isset($_POST[selDivision]) && $_POST[selDivision]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>DIVISION</b>";
			$i++;
			$sw=1;
		}		
		if (isset($_POST[selDepartamento]) && $_POST[selDepartamento]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>DEPARTAMENTO</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[selUsuarioSistema]) && $_POST[selUsuarioSistema]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>ANALISTA</b>";
			$i++;
			$sw=1;
		}

		switch ($i) {
			case 0:
				
				$tipoAsignacion='DEE0000002';
				
				if (isset($_POST[txtConfiguracionAnterior]) && !empty($_POST[txtConfiguracionAnterior])) {
					$tipoAsignacion='DEE0000005';
				}
				if (isset($_POST[chkPrestamo]) && $_POST[chkPrestamo]==1) {
					$tipoAsignacion='DEE0000004';
				}
			
				$login=$_SESSION["login"];
				$despacho= new despachoEquipo();
				$despacho->setDespacho("",$login,$_POST[txtHelpDesk],1,"",$_POST[txtObservacion],$_POST[selSitio],$_POST[selDepartamento],$_POST[txtEspecifico],$_POST[txtFicha]);
				$despacho->setDetalleDespacho("",$_POST[txtConfiguracion],$_POST[txtConfiguracionAnterior],$_POST[selUsuarioSistema],$tipoAsignacion);
				$resultado=$despacho->ingresarDespacho();
				switch ($resultado) {
					case 0:
						$usuario = new usuario($_POST[txtFicha],"","","","","","",$_POST[selDepartamento],$_POST[selSitioUsuario],$_POST[txtExtension]);
						$resultadoUsuario=$usuario->actualizarExtension();
						$resultadoUsuario=$usuario->actualizarDepartamento();
						$resultadoUsuario=$usuario->actualizarSitio();						
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
						$idDespacho=$despacho->retornarIdDespacho();

						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO - DESPACHO DE COMPONENTES</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO EL NUEVO DESPACHO</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>
						<a class=enlace href=\"#\" onclick=\"window.open('../librerias/xmlAsignacionEquipos.php?idDespacho=$idDespacho')\">ASIGNACION DE EQUIPOS</a> | 
						<a class=enlace href=\"#\" onclick=\"window.open('../librerias/xmlsalidaexternaequipos.php?idDespacho=$idDespacho')\">SALIDA EXTERNA</a> | 
						<a class=enlace href=\"#\" onclick=\"window.open('../librerias/xmlsalidainternaequipos.php?idDespacho=$idDespacho')\">SALIDA INTERNA</a><br><br>
						
						
						<input name=\"btn\" type=\"submit\" value=\"REGRESAR\"></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";	
						break 1;
					case 1:
						echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						echo "<input name=\"despachar\" type=\"hidden\" value=\"$_POST[despachar]\">";
						echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
						echo "<input name=\"txtConfiguracionAnterior\" type=\"hidden\" value=\"$_POST[txtConfiguracionAnterior]\">";
						echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtFicha]\">";
						echo "<input name=\"txtNombres\" type=\"hidden\" value=\"$_POST[txtNombres]\">";
						echo "<input name=\"txtCargo\" type=\"hidden\" value=\"$_POST[txtCargo]\">";
						echo "<input name=\"txtExtension\" type=\"hidden\" value=\"$_POST[txtExtension]\">";
						echo "<input name=\"selSitioUsuario\" type=\"hidden\" value=\"$_POST[selSitioUsuario]\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
						echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";
						echo "<input name=\"selUsuarioSistema\" type=\"hidden\" value=\"$_POST[selUsuarioSistema]\">";
						echo "<input name=\"txtHelpDesk\" type=\"hidden\" value=\"$_POST[txtHelpDesk]\">";
						echo "<input name=\"txtObservacion\" type=\"hidden\" value=\"$_POST[txtObservacion]\">";
						echo "<input name=\"cambiarSeleccion\" type=\"hidden\" value=\"1\">";
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO - DESPACHO DE EQUIPOS</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR EL DESPACHO</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";	
						break 1;
				}
				break 1;
			case 1:
				echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<input name=\"despachar\" type=\"hidden\" value=\"$_POST[despachar]\">";
				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
				echo "<input name=\"txtConfiguracionAnterior\" type=\"hidden\" value=\"$_POST[txtConfiguracionAnterior]\">";
				echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtFicha]\">";
				echo "<input name=\"txtNombres\" type=\"hidden\" value=\"$_POST[txtNombres]\">";
				echo "<input name=\"txtCargo\" type=\"hidden\" value=\"$_POST[txtCargo]\">";
				echo "<input name=\"txtExtension\" type=\"hidden\" value=\"$_POST[txtExtension]\">";
				echo "<input name=\"selSitioUsuario\" type=\"hidden\" value=\"$_POST[selSitioUsuario]\">";
				echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
				echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
				echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
				echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";
				echo "<input name=\"selUsuarioSistema\" type=\"hidden\" value=\"$_POST[selUsuarioSistema]\">";
				echo "<input name=\"txtHelpDesk\" type=\"hidden\" value=\"$_POST[txtHelpDesk]\">";
				echo "<input name=\"txtObservacion\" type=\"hidden\" value=\"$_POST[txtObservacion]\">";
				echo "<input name=\"cambiarSeleccion\" type=\"hidden\" value=\"1\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - DESPACHO DE EQUIPOS</td>
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
				echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<input name=\"despachar\" type=\"hidden\" value=\"$_POST[despachar]\">";
				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
				echo "<input name=\"txtConfiguracionAnterior\" type=\"hidden\" value=\"$_POST[txtConfiguracionAnterior]\">";
				echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtFicha]\">";
				echo "<input name=\"txtNombres\" type=\"hidden\" value=\"$_POST[txtNombres]\">";
				echo "<input name=\"txtCargo\" type=\"hidden\" value=\"$_POST[txtCargo]\">";
				echo "<input name=\"txtExtension\" type=\"hidden\" value=\"$_POST[txtExtension]\">";
				echo "<input name=\"selSitioUsuario\" type=\"hidden\" value=\"$_POST[selSitioUsuario]\">";
				echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
				echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
				echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
				echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";
				echo "<input name=\"selUsuarioSistema\" type=\"hidden\" value=\"$_POST[selUsuarioSistema]\">";
				echo "<input name=\"txtHelpDesk\" type=\"hidden\" value=\"$_POST[txtHelpDesk]\">";
				echo "<input name=\"txtObservacion\" type=\"hidden\" value=\"$_POST[txtObservacion]\">";
				echo "<input name=\"cambiarSeleccion\" type=\"hidden\" value=\"1\">";

				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - DESPACHO DE EQUIPOS</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>LOS CAMPOS ".$mensaje. " ESTAN VAC&Iacute;OS</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";	
				break 1;			
		}
		break 1;

	case 2:
		require_once("conexionsql.php");
		require_once("inventarioAdmin.php");
		$equipo= new equipo();
		$equipo->setEquipo($_POST[txtConfiguracion]);
		$resultado=$equipo->buscarEquipo();
		$sitio=$equipo->retornarUltimaUbicacion('u');
		$estado=$equipo->retornarUltimoEstado();
		if ($estado<>'EST0000001' || $sitio<>'SIT0000057') {
			echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: INVENTARIO - DESPACHO DE EQUIPOS</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>EL EQUIPO NO EST&Aacute; EN EL DEPOSITO O NO EST&Aacute; OPERATIVO</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\" onclick=\"location.href='index2.php?item=151&config=$_POST[txtConfiguracion]'\"></td>";
			echo "</tr>";
			echo "</table>";
			echo "</form>";
			exit();
			
		}
		$despacho= new despachoEquipo();
		$despacho->setDespacho("","","",1);
		$despacho->setDetalleDespacho("",$_POST[txtConfiguracion]);
		$resultado=$despacho->buscarDespachoEquipos();
		if ($resultado!=1) {
			echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: INVENTARIO - DESPACHO DE EQUIPOS</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>EL EQUIPO YA FUE DESPACHADO</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\" onclick=\"location.href='index2.php?item=622'\"></td>";
			echo "</tr>";
			echo "</table>";
			echo "</form>";
			exit();
		}
		frmDespachoEquipos();
		break 1;	

	default:
		frmDespachoEquipos();
		break 1;
}

function frmDespachoEquipos() {
	require_once "conexionsql.php";
	require_once "formularios.php";	
	require_once "inventarioAdmin.php";
	require_once "usuarioAdmin.php";
	
	if ($_POST[cambiarConfiguracion]!=1)
		if (isset($_GET[configuracion]) && !empty($_GET[configuracion]))
			$_POST[txtConfiguracion]=$_GET[configuracion];
	
	if (isset($_POST[txtConfiguracion]) && !empty($_POST[txtConfiguracion])) {
		$equipoBuscar= new equipo();
		$equipoBuscar->setEquipo($_POST[txtConfiguracion]);
		$resultado=$equipoBuscar->buscarEquipo();
		if ($resultado && $resultado!=1) {
			$row=mysql_fetch_array($resultado);
			$_POST[txtConfiguracion]=$row[0];
			$_POST[txtActivoFijo]=$row[1];
			$idInventario=$row[2];
			$_POST[txtSerial]=$row[3];
			$_POST[txtDescripcion]=$row[5];
			$_POST[txtMarca]=$row[7];
			$_POST[txtModelo]="$row[9] $row[10] $row[11]";
		} else {
			$_POST[txtConfiguracion]="NO ENCONTRADO";
			unset($_POST[txtActivoFijo]);
			unset($_POST[txtSerial]);
			unset($_POST[txtDescripcion]);
			unset($_POST[txtMarca]);
			unset($_POST[txtModelo]);
		}
	}
	
	if (isset($_POST[txtConfiguracionAnterior]) && !empty($_POST[txtConfiguracionAnterior]))  {
		$equipoAnteriorBuscar= new equipo();
		$equipoAnteriorBuscar->setEquipo($_POST[txtConfiguracionAnterior]);
		$resultadoAnterior=$equipoAnteriorBuscar->buscarEquipo();
		if ($resultadoAnterior && $resultadoAnterior!=1) {
			$row=mysql_fetch_array($resultadoAnterior);
			$_POST[txtConfiguracionAnterior]=$row[0];
			$_POST[txtActivoFijoAnterior]=$row[1];
			$idInventario=$row[2];
			$_POST[txtSerialAnterior]=$row[3];
			$_POST[txtDescripcionAnterior]=$row[5];
			$_POST[txtMarcaAnterior]=$row[7];
			$_POST[txtModeloAnterior]="$row[9] $row[10] $row[11]";
			if  ($_POST[cambiarSeleccion]!=1)
				if ($equipoAnteriorBuscar->retornarUltimaUbicacion('d')!=1) {
					$_POST[selSitio]=$equipoAnteriorBuscar->retornarUltimaUbicacion('u');
					$_POST[selGerencia]=$equipoAnteriorBuscar->retornarUltimaUbicacion('g');
					$_POST[selDivision]=$equipoAnteriorBuscar->retornarUltimaUbicacion('s');
					$_POST[selDepartamento]=$equipoAnteriorBuscar->retornarUltimaUbicacion('d');
					$_POST[txtEspecifico]=$equipoAnteriorBuscar->retornarUltimaUbicacion('e');
				}
				else {
					$_POST[selSitio]="";
					$_POST[selGerencia]="";
					$_POST[selDivision]="";
					$_POST[selDepartamento]="";
				}			
		} else {
			$_POST[txtConfiguracionAnterior]="NO ENCONTRADO";
			unset($_POST[txtActivoFijoAnterior]);
			unset($_POST[txtSerialAnterior]);
			unset($_POST[txtDescripcionAnterior]);
			unset($_POST[txtMarcaAnterior]);
			unset($_POST[txtModeloAnterior]);
		}				
	}
	
	if  ($_POST[cambiarSeleccion]!=1)
	if (isset($_POST[txtFicha]) && !empty($_POST[txtFicha])) {
		$usuarioAsignacion= new usuario($_POST[txtFicha]);
		$resultadoUsuario= $usuarioAsignacion->retornaUsuario();
		if ($resultadoUsuario && $resultadoUsuario!=1) {
			$rowUsuario=mysql_fetch_array($resultadoUsuario);
			$_POST[txtNombres]=$rowUsuario[2];
			$_POST[txtCargo]=$rowUsuario[6];
			$_POST[selSitioUsuario]=$rowUsuario[7];
			$_POST[txtExtension]=$rowUsuario[15];
			if ($_POST[selSitio]==100 && $_POST[selDepartamento]==100) {
				$_POST[selSitio]=$rowUsuario[7];
				$_POST[selGerencia]=$rowUsuario[9];
				$_POST[selDivision]=$rowUsuario[11];
				$_POST[selDepartamento]=$rowUsuario[13];
				
			}
		} else {
			$_POST[txtFicha]="NO ENCONTRADO";
			unset($_POST[txtNombres]);
			unset($_POST[txtCargo]);
			unset($_POST[selSitioUsuario]);
			unset($_POST[txtExtension]);
		}
	}		
	
	$conSitio="select id_sitio,sitio from sitio where status_activo=1 order by sitio";
	$conGerencia="select id_gerencia,gerencia from gerencia where status_activo=1 order by gerencia";
	$conDivision="select id_division,division from division where id_gerencia='$_POST[selGerencia]' and status_activo=1 order by division";
	$conDepartamento="select id_departamento, departamento from departamento where id_division='$_POST[selDivision]' and status_activo=1 ORDER BY departamento";

	$conEstado="SELECT ID_ESTADO, ESTADO FROM inventario_estado ORDER BY ID_ESTADO";	

	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--UBICACION--","");
	$selSitio=$sitio->retornar();
	
	$sitioUsuario= new campoSeleccion("selSitioUsuario","formularioCampoSeleccion","$_POST[selSitioUsuario]","","",$conSitio,"--UBICACION--","");
	$selSitioUsuario=$sitioUsuario->retornar();	

	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","cambiarSeleccionOtros()",$conGerencia,"--GERENCIA--","");
	$selGerencia=$gerencia->retornar();		

	$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","cambiarSeleccionOtros()",$conDivision,"--DIVISION--","");
	$selDivision=$division->retornar();

	$departamento= new campoSeleccion("selDepartamento","formularioCampoSeleccion","$_POST[selDepartamento]","onChange","cambiarSeleccionOtros()",$conDepartamento,"--DEPARTAMENTO--","");
	$selDepartamento=$departamento->retornar();	
	
	$conUss="SELECT distinct usuario_sistema.id_uss, concat(nombre,' ',apellido) as nombres From
		usuario_sistema
		Inner Join usuario_sistema_privilegio ON usuario_sistema.ID_USS = usuario_sistema_privilegio.ID_USS where (status_activo <> 0) order by nombres";

	$usuarioSistema= new campoSeleccion("selUsuarioSistema","formularioCampoSeleccion","$_POST[selUsuarioSistema]","","",$conUss,"--SELECCIONE--","");
	$selUsuarioSistema=$usuarioSistema->retornar();

	
	echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"cambiarSeleccion\" type=\"hidden\" value=\"0\">";
	echo "<input name=\"cambiarConfiguracion\" type=\"hidden\" value=\"0\">";
	echo "<input name=\"top\" type=\"hidden\" value=\"\">";	
	echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"2\">DESPACHO DE EQUIPOS</td>
	</tr>";
			echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL EQUIPO A ENTREGAR</td><td class=\"formularioTablaTitulo\"></td>
			</tr>";	
			echo "<tr>
				<td valign=top class=\"formularioCampoTitulo\">CONFIGURACION NUEVA:<br><input class=\"formularioCampoTexto\" name=\"txtConfiguracion\" type=\"text\" value=\"$_POST[txtConfiguracion]\" onKeyPress=\"if (event.keyCode==13) buscarConfiguracion();\" onBlur=\"buscarConfiguracion()\" onfocus=\"limpiarCampo(this)\">
				<input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"C\" onclick=\"buscarConfiguracion()\" ><br>
				SERIAL:<br><input class=\"formularioCampoTexto\" name=\"txtSerial\" type=\"text\" value=\"$_POST[txtSerial]\" readonly=\"true\"><br>
				MARCA:<br><input class=\"formularioCampoTexto\" name=\"txtMarca\" type=\"text\" value=\"$_POST[txtMarca]\" readonly=\"true\"><br>
				</td>
				<td valign=top class=\"formularioCampoTitulo\">ACTIVO FIJO:<br><input class=\"formularioCampoTexto\" name=\"txtActivoFijo\" type=\"text\" value=\"$_POST[txtActivoFijo]\"><br>
				DESCRIPCION:<br><input class=\"formularioCampoTexto\" name=\"txtDescripcion\" type=\"text\" value=\"$_POST[txtDescripcion]\" readonly=\"true\"><br>
				MODELO:<br><input class=\"formularioCampoTexto\" name=\"txtModelo\" type=\"text\" value=\"$_POST[txtModelo]\" readonly=\"true\"><br>
				</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL EQUIPO A REEMPLAZAR</td><td class=\"formularioTablaTitulo\"></td>
			</tr>";	
			echo "<tr>
				<td valign=top class=\"formularioCampoTitulo\">CONFIGURACION ANTERIOR:<br><input class=\"formularioCampoTexto\" name=\"txtConfiguracionAnterior\" type=\"text\" value=\"$_POST[txtConfiguracionAnterior]\" onKeyPress=\"if (event.keyCode==13) buscarConfiguracionAnterior();\" onBlur=\"buscarConfiguracionAnterior()\" onfocus=\"limpiarCampo(this)\">
				<input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"C\" onclick=\"buscarConfiguracionAnterior()\" ><br>
				SERIAL:<br><input class=\"formularioCampoTexto\" name=\"txtSerialAnterior\" type=\"text\" value=\"$_POST[txtSerialAnterior]\" readonly=\"true\"><br>
				MARCA:<br><input class=\"formularioCampoTexto\" name=\"txtMarcaAnterior\" type=\"text\" value=\"$_POST[txtMarcaAnterior]\" readonly=\"true\"><br>
				</td>
				<td valign=top class=\"formularioCampoTitulo\">ACTIVO FIJO:<br><input class=\"formularioCampoTexto\" name=\"txtActivoFijoAnterior\" type=\"text\" value=\"$_POST[txtActivoFijoAnterior]\"><br>
				DESCRIPCION:<br><input class=\"formularioCampoTexto\" name=\"txtDescripcionAnterior\" type=\"text\" value=\"$_POST[txtDescripcionAnterior]\" readonly=\"true\"><br>
				MODELO:<br><input class=\"formularioCampoTexto\" name=\"txtModeloAnterior\" type=\"text\" value=\"$_POST[txtModeloAnterior]\" readonly=\"true\"><br>
				</td>";
			echo "</tr>";
			echo "<tr>
			<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL USUARIO</td>";
			echo "</tr>";
			echo "<tr>
			<td valign=top class=\"formularioCampoTitulo\">FICHA:<br>
			<input class=\"formularioCampoTexto\" name=\"txtFicha\" type=\"text\" value=\"$_POST[txtFicha]\" onKeyPress=\"if (event.keyCode==13) buscarFicha();\" onfocus=\"limpiarCampo(this)\">
			<input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"C\" onclick=\"buscarFicha()\"><br>
			NOMBRES<br>
			<input class=\"formularioCampoTexto\" name=\"txtNombres\" type=\"text\" value=\"$_POST[txtNombres]\" readonly=\"true\"></td>
			<td valign=top class=\"formularioCampoTitulo\">CARGO<br>
			<input class=\"formularioCampoTexto\" name=\"txtCargo\" type=\"text\" value=\"$_POST[txtCargo]\" readonly=\"true\"><br>
			EXTENSION<br>
			<input class=\"formularioCampoTexto\" name=\"txtExtension\" type=\"text\" value=\"$_POST[txtExtension]\">
			<br>UBICACION:<br>$selSitioUsuario<br></td>";
			echo "</tr>";
			echo "<tr>
			<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DE UBICACION</td>";
			echo "</tr>
	  		<tr>
			<td class=\"formularioCampoTitulo\">UBICACION<br>$selSitio<br>
			DIVISION<br>$selDivision</td>
			<td class=\"formularioCampoTitulo\">
			GERENCIA<br>$selGerencia<br>
			DEPARTAMENTO<br>$selDepartamento</td>
		</tr>";
		echo "<tr>";
		echo "<td colspan=\"2\" align=\"center\"><textarea class=\"formularioAreaTextoPlanilla\" name=\"txtEspecifico\" cols=\"600\" rows=\"2\">$_POST[txtEspecifico]</textarea></td>";
		echo "</tr>";
			echo "<tr>
			<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL DESPACHO</td>";
			echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"formularioCampoTitulo\">ANALISTA<br>$selUsuarioSistema</td>
		<td valign=top class=\"formularioCampoTitulo\">CASO HELP DESK<br><input name=\"txtHelpDesk\" value=\"$_POST[txtHelpDesk]\" class=\"formularioCampoTexto\"></td>
		</tr>";
		echo "<tr>";
		echo "<td class=\"formularioCampoTitulo\" colspan=\"2\" align=\"center\">MARQUE SI ES UN PRESTAMO";
		if ($_POST[chkPrestamo]==1)
			echo "<input name=\"chkPrestamo\" type=\"checkbox\" value=\"1\" checked><br>";
		else 
			echo "<input name=\"chkPrestamo\" type=\"checkbox\" value=\"1\"><br>";
		echo "<br>OBSERVACION</td>";
		echo "</tr>";
			echo "<tr>";
		echo "<td colspan=\"2\" align=\"center\"><textarea class=\"formularioAreaTextoPlanilla\" name=\"txtObservacion\" cols=\"600\" rows=\"2\">$_POST[txtObservacion]</textarea></td>";
		echo "</tr>";
		echo "<tr>
			<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"5\">
			<input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=621'\">
			<input name=\"btnGuardar\" type=\"button\" value=\"DESPACHAR\" onclick=\"generarDespacho()\">
			</td>
		</tr>";	
	echo "</table>";
	echo "</form>";
}
?>

