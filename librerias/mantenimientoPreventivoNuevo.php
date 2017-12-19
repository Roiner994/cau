<?php
require_once("seguridad.php");
?>
<script language="javascript">
function cambiar() {
		document.frmMantenimiento.funcion.value=0;
		document.frmMantenimiento.cambiarSeleccion.value=1;
		posicionamientoPantalla();
		document.frmMantenimiento.submit();
}

function actualizar() {
		document.frmMantenimiento.funcion.value=2;
		document.frmMantenimiento.submit();
}

function finalizar() {
		document.frmMantenimiento.funcion.value=1;
		document.frmMantenimiento.submit();
}


function cambiarGerencia() {
		document.frmMantenimiento.funcion.value=0;
		document.frmMantenimiento.cambiarSeleccion.value=1;
		document.frmMantenimiento.selDivision.value=100;
		document.frmMantenimiento.selDepartamento.value=100;
		posicionamientoPantalla();
		document.frmMantenimiento.submit();
}

function cambiarDivision() {
		document.frmMantenimiento.funcion.value=0;
		document.frmMantenimiento.cambiarSeleccion.value=1;
		document.frmMantenimiento.selDepartamento.value=100;
		posicionamientoPantalla();
		document.frmMantenimiento.submit();
}


function buscarFicha() {
	if (document.frmMantenimiento.txtFicha.value!="") {
		document.frmMantenimiento.funcion.value=0;
		document.frmMantenimiento.cambiarSeleccion.value=1;
		posicionamientoPantalla();
		document.frmMantenimiento.submit();	
	}
}
</script>
<?php
require_once("mantenimientoAdmin.php");
require_once("inventarioAdmin.php");
require_once("softwareAdmin.php");
require_once("usuarioAdmin.php");
$login=$_SESSION["login"];




switch ($funcion) {
	case 1:
		if (isset($_POST[txtFicha]) && empty($_POST[txtFicha])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>USUARIO</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[selTiempoEjecucion]) && $_POST[selTiempoEjecucion]==0) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>TIEMPO DE EJECUCI&Oacute;N</b>";
			$i++;
			$sw=1;
		}
		switch ($i) {
			case 0:
				$sistemaOperativo=$_POST[chkSistemaOperativo];
				$antivirus=$_POST[chkAntivirus];
				$critico=$_POST[chkCritico];
				$usuarioEspecializado=$_POST[chkUsuarioEspecializado];
				$red=$_POST[chkRed];
				$textoSO=$_POST[txtSistemaOperativo];
				$textoAntivirus=$_POST[txtAntivirus];
				$mantenimiento= new mantenimiento();
				$mantenimiento->setDatosMantenimiento($_GET[idMantenimiento]);
				$mantenimiento->setUsuario($_POST[txtFicha]);
				$mantenimiento->setUbicacion($_POST[selDepartamento],$_POST[selSitio],$_POST[txtEspecifico]);
				$mantenimiento->setDetalleMantenimiento($_POST[chkSistemaOperativo],$_POST[chkAntivirus],$_POST[txtTrabajo],$_POST[txtObservacion],$_POST[selCorrectivo],$_POST[txtCorrectivo]);
				$mantenimiento->setHoraFinal($_POST[selTiempoEjecucion]);
				$resultadoMantenimiento=$mantenimiento->actualizarMantenimiento();
				$resultadoFinalizar=$mantenimiento->finalizarMantenimiento();

				switch ($resultadoFinalizar) {
					case 0:
						$equipo= new equipo($_POST[txtConfiguracion]);
						$equipo->setEquipo($_POST[txtConfiguracion],$_POST[txtActivoFijo],$_POST[chkCritico],$_POST[chkRed],$_POST[chkUsuarioEspecializado],"",$_POST[txtRed],"","","","","","","",$_POST[txtCritico],"","",$_POST[chkSistemaOperativo],$_POST[txtSistemaOperativo],$_POST[chkAntivirus],$_POST[txtAntivirus]);
						$equipo->setInventarioUbicacion($_POST[selDepartamento],$_POST[selSitio],$_POST[txtEspecifico],$login);
						$resultadoBusqueda=$equipo->buscarEquipo();

						$equipo->ingresarSoftware($_POST[chkSoftware]);
						$equipo->setInventarioUsuario($_POST[txtFicha],$login);
						$resultado=$equipo->ingresarInventarioUsuario();
						$resultado=$equipo->ingresarInventarioUbicacion();
						$resultadoEquipo=$equipo->actualizarCritico();
						$resultadoEquipo=$equipo->actualizarTextoCritico();
						$resultadoEquipo=$equipo->actualizarRed();
						$resultadoEquipo=$equipo->actualizarTextoRed();
						$resultadoEquipo=$equipo->actualizarSistemaOperativo();
						$resultadoEquipo=$equipo->actualizarTextoSistemaOperativo();
						$resultadoEquipo=$equipo->actualizarAntivirus();
						$resultadoEquipo=$equipo->actualizarTextoAntivirus();						
						$resultadoEquipo=$equipo->actualizarUsuarioEspecializado();
						$usuario = new usuario($_POST[txtFicha],"","","","","","",$_POST[selDepartamento],$_POST[selSitioUsuario],$_POST[txtExtension]);
						$resultadoUsuario=$usuario->actualizarExtension();
						$resultadoUsuario=$usuario->actualizarDepartamento();
						$resultadoUsuario=$usuario->actualizarSitio();
						echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
						echo "<input name=\"chkSistemaOperativo\" type=\"hidden\" value=\"$_POST[chkSistemaOperativo]\">";
						echo "<input name=\"chkAntivirus\" type=\"hidden\" value=\"$_POST[chkAntivirus]\">";
						echo "<input name=\"chkCritico\" type=\"hidden\" value=\"$_POST[chkCritico]\">";
						echo "<input name=\"chkUsuarioEspecializado\" type=\"hidden\" value=\"$_POST[chkUsuarioEspecializado]\">";
						echo "<input name=\"chkRed\" type=\"hidden\" value=\"$_POST[chkRed]\">";
						echo "<input name=\"selTiempoEjecucion\" type=\"hidden\" value=\"$_POST[selTiempoEjecucion]\">";

						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO - NUEVO MANTENIMIENTO</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>SE ACTUALIZÓ EL MANTENIMIENTO</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>
				<input name=\"btnCerrar\" type=\"button\" value=\"CERRAR\" onclick=\"location.href='index2.php'\">
				<input name=\"btnImprimir\" type=\"button\" value=\"IMPRIMIR\" onclick=\"window.open('../librerias/xmlMantenimiento.php?idMantenimiento=$_GET[idMantenimiento]')\">
				</td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";
						break 1;

					case 1:
						echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
						echo "<input name=\"chkSistemaOperativo\" type=\"hidden\" value=\"$_POST[chkSistemaOperativo]\">";
						echo "<input name=\"chkAntivirus\" type=\"hidden\" value=\"$_POST[chkAntivirus]\">";
						echo "<input name=\"chkCritico\" type=\"hidden\" value=\"$_POST[chkCritico]\">";
						echo "<input name=\"chkUsuarioEspecializado\" type=\"hidden\" value=\"$_POST[chkUsuarioEspecializado]\">";
						echo "<input name=\"chkRed\" type=\"hidden\" value=\"$_POST[chkRed]\">";
						echo "<input name=\"selTiempoEjecucion\" type=\"hidden\" value=\"$_POST[selTiempoEjecucion]\">";
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO - NUEVO MANTENIMIENTO</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE ACTUALIZAR LOS DATOS DEL MANTENIMIENTO</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnAceptar\" type=\"submit\" value=\"VOLVER AL MANTENIMIENTO\" onclick=\"\"></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";
						break 1;
				}

				break 1;
			case 1:
				echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
				echo "<input name=\"chkSistemaOperativo\" type=\"hidden\" value=\"$_POST[chkSistemaOperativo]\">";
				echo "<input name=\"chkAntivirus\" type=\"hidden\" value=\"$_POST[chkAntivirus]\">";
				echo "<input name=\"chkCritico\" type=\"hidden\" value=\"$_POST[chkCritico]\">";
				echo "<input name=\"chkUsuarioEspecializado\" type=\"hidden\" value=\"$_POST[chkUsuarioEspecializado]\">";
				echo "<input name=\"chkRed\" type=\"hidden\" value=\"$_POST[chkRed]\">";
				echo "<input name=\"selTiempoEjecucion\" type=\"hidden\" value=\"$_POST[selTiempoEjecucion]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO - NUEVO MANTENIMIENTO</td>
						</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>EL CAMPO ".$mensaje. " ESTA VAC&Iacute;O</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnAceptar\" type=\"submit\" value=\"VOLVER AL MANTENIMIENTO\" onclick=\"\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";
				break 1;
			default:
				echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
				echo "<input name=\"chkSistemaOperativo\" type=\"hidden\" value=\"$_POST[chkSistemaOperativo]\">";
				echo "<input name=\"chkAntivirus\" type=\"hidden\" value=\"$_POST[chkAntivirus]\">";
				echo "<input name=\"chkCritico\" type=\"hidden\" value=\"$_POST[chkCritico]\">";
				echo "<input name=\"chkUsuarioEspecializado\" type=\"hidden\" value=\"$_POST[chkUsuarioEspecializado]\">";
				echo "<input name=\"chkRed\" type=\"hidden\" value=\"$_POST[chkRed]\">";
				echo "<input name=\"selTiempoEjecucion\" type=\"hidden\" value=\"$_POST[selTiempoEjecucion]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO - NUEVO MANTENIMIENTO</td>
						</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>LOS CAMPOS ".$mensaje. " ESTAN VAC&Iacute;OS</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnAceptar\" type=\"submit\" value=\"VOLVER AL MANTENIMIENTO\" onclick=\"\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";
		}

		break 1;
	case 2:


		$sistemaOperativo=$_POST[chkSistemaOperativo];
		$antivirus=$_POST[chkAntivirus];
		$critico=$_POST[chkCritico];
		$usuarioEspecializado=$_POST[chkUsuarioEspecializado];
		$red=$_POST[chkRed];
		$textoSO=$_POST[txtSistemaOperativo];
		$textoAntivirus=$_POST[txtAntivirus];
		$mantenimiento= new mantenimiento();
		$mantenimiento->setDatosMantenimiento($_GET[idMantenimiento]);
		$mantenimiento->setUsuario($_POST[txtFicha]);
		$mantenimiento->setUbicacion($_POST[selDepartamento],$_POST[selSitio],$_POST[txtEspecifico]);
		if (!isset($_POST[chkSistemaOperativo]) && empty($_POST[chkSistemaOperativo])) {
			$_POST[chkSistemaOperativo]=0;
		}
		if (!isset($_POST[chkAntivirus]) && empty($_POST[chkAntivirus])) {
			$_POST[chkAntivirus]=0;
		}
		if (!isset($_POST[txtTrabajo]) && empty($_POST[txtTrabajo])) {
			$_POST[txtTrabajo]=0;
		}
		if (!isset($_POST[selCorrectivo]) && empty($_POST[selCorrectivo])) {
			$_POST[selCorrectivo]=0;
		}

		$mantenimiento->setDetalleMantenimiento($_POST[chkSistemaOperativo],$_POST[chkAntivirus],$_POST[txtTrabajo],$_POST[txtObservacion],$_POST[selCorrectivo],$_POST[txtCorrectivo]);
		$resultadoMantenimiento=$mantenimiento->actualizarMantenimiento();
		switch ($resultadoMantenimiento) {
			case 0:
				$equipo= new equipo($_POST[txtConfiguracion]);
				$equipo->setEquipo($_POST[txtConfiguracion],$_POST[txtActivoFijo],$_POST[chkCritico],$_POST[chkRed],$_POST[chkUsuarioEspecializado],"",$_POST[txtRed],"","","","","","","",$_POST[txtCritico],"","",$_POST[chkSistemaOperativo],$_POST[txtSistemaOperativo],$_POST[chkAntivirus],$_POST[txtAntivirus]);
				$equipo->ingresarSoftware($_POST[chkSoftware]);
				$resultadoEquipo=$equipo->actualizarCritico();
				$resultadoEquipo=$equipo->actualizarTextoCritico();
				$resultadoEquipo=$equipo->actualizarRed();
				$resultadoEquipo=$equipo->actualizarTextoRed();
				$resultadoEquipo=$equipo->actualizarSistemaOperativo();
				$resultadoEquipo=$equipo->actualizarTextoSistemaOperativo();
				$resultadoEquipo=$equipo->actualizarAntivirus();
				$resultadoEquipo=$equipo->actualizarTextoAntivirus();
				$resultadoEquipo=$equipo->actualizarUsuarioEspecializado();
				$usuario = new usuario($_POST[txtFicha],"","","","","","",$_POST[selDepartamento],$_POST[selSitioUsuario],$_POST[txtExtension]);
				$resultadoUsuario=$usuario->actualizarExtension();
				$resultadoUsuario=$usuario->actualizarDepartamento();
				$resultadoUsuario=$usuario->actualizarSitio();
				echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
				echo "<input name=\"chkSistemaOperativo\" type=\"hidden\" value=\"$_POST[chkSistemaOperativo]\">";
				echo "<input name=\"chkAntivirus\" type=\"hidden\" value=\"$_POST[chkAntivirus]\">";
				echo "<input name=\"chkCritico\" type=\"hidden\" value=\"$_POST[chkCritico]\">";
				echo "<input name=\"chkUsuarioEspecializado\" type=\"hidden\" value=\"$_POST[chkUsuarioEspecializado]\">";
				echo "<input name=\"chkRed\" type=\"hidden\" value=\"$_POST[chkRed]\">";
				echo "<input name=\"selTiempoEjecucion\" type=\"hidden\" value=\"$_POST[selTiempoEjecucion]\">";

				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO - NUEVO MANTENIMIENTO</td>
						</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>SE ACTUALIZÓ EL MANTENIMIENTO</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnAceptar\" type=\"submit\" value=\"VOLVER AL MANTENIMIENTO\" onclick=\"\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";
				break 1;

			case 1:
				echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO - NUEVO MANTENIMIENTO</td>
						</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE ACTUALIZAR LOS DATOS DEL MANTENIMIENTO</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnAceptar\" type=\"submit\" value=\"VOLVER AL MANTENIMIENTO\" onclick=\"\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";
				break 1;
		}


		break 1;
	default:

		if (isset($_POST[txtConfiguracion]) && !empty($_POST[txtConfiguracion])) {
			if (isset($_POST[chkSistemaOperativo]) && !empty($_POST[chkSistemaOperativo])) {
				$sistemaOperativo=$_POST[chkSistemaOperativo];
			}
			if (isset($_POST[chkAntivirus]) && !empty($_POST[chkAntivirus])) {
				$antivirus=$_POST[chkAntivirus];
			}
			if (isset($_POST[chkCritico]) && !empty($_POST[chkCritico])) {
				$critico=$_POST[chkCritico];
			}
			if (isset($_POST[chkUsuarioEspecializado]) && !empty($_POST[chkUsuarioEspecializado])) {
				$usuarioEspecializado=$_POST[chkUsuarioEspecializado];
			}
			if (isset($_POST[chkRed]) && !empty($_POST[chkRed])) {
				$red=$_POST[chkRed];
			}
			$equipo= new equipo($_POST[txtConfiguracion]);
			$equipo->setEquipo($_POST[txtConfiguracion],"",$critico[0],$red[0],$usuarioEspecializado[0]);
			$equipo->ingresarSoftware($_POST[chkSoftware]);
			$resultadoEquipo=$equipo->actualizarCritico();
			$resultadoEquipo=$equipo->actualizarRed();
			$resultadoEquipo=$equipo->actualizarUsuarioEspecializado();
		}
		frmMantenimiento($_GET[idMantenimiento]);
}
function frmMantenimiento($idMantenimiento="") {
	require_once("formularios.php");
	$login=$_SESSION["login"];
	if (isset($idMantenimiento) && !empty($idMantenimiento)) {
		$mantenimiento= new mantenimiento();
		$mantenimiento->setDatosMantenimiento($idMantenimiento);
		if ($mantenimiento->verificarTecnicoMantenimiento()!=$login) {
				echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
				echo "<input name=\"top\" type=\"hidden\" value=\"\">";
				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO - NUEVO MANTENIMIENTO</td>
						</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE ABRIR EL MANTENIMIENTO</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnAceptar\" type=\"button\" value=\"VOLVER AL MANTENIMIENTO\" onclick=\"window.close()\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";				
			exit();
		}
		
		$resultadoMantenimiento=$mantenimiento->retornarMantenimiento();
		if ($resultadoMantenimiento && $resultadoMantenimiento!=1) {
			
			$rowMantenimiento=mysql_fetch_array($resultadoMantenimiento);
			$configuracion=$rowMantenimiento[1];
			$_POST[txtConfiguracion]=$rowMantenimiento[1];
			if ($_POST[cambiarSeleccion]==0) {
				$_POST[txtFicha]=$rowMantenimiento[3];
				$_POST[selDepartamento]=$rowMantenimiento[4];
				$_POST[selTiempoEjecucion]=abs($rowMantenimiento[17]);
				$Ubicacion=$mantenimiento->retornaMantenimientos("","","",1);
				if ($Ubicacion && $Ubicacion!=1) {
					$rowUbicacion=mysql_fetch_array($Ubicacion);
					$_POST[selGerencia]=$rowUbicacion[24];	
					$_POST[selDivision]=$rowUbicacion[26];
				}
				$_POST[selSitio]=$rowMantenimiento[5];
				$_POST[txtEspecifico]=$rowMantenimiento[6];
				//$_POST[chkSistemaOperativo]=$rowMantenimiento[10];
				//$_POST[chkAntivirus]=$rowMantenimiento[11];
				$correctivo=$rowMantenimiento[14];
				$_POST[txtTrabajo]=$rowMantenimiento[12];
				$_POST[txtObservacion]=$rowMantenimiento[13];
				$_POST[txtCorrectivo]=$rowMantenimiento[15];
				//$_POST[txtSistemaOperativo]=$rowMantenimiento[17];
				//$_POST[txtAntivirus]=$rowMantenimiento[18];
			}

		}
	}
	
		$equipoBuscar= new equipo();
		$equipoBuscar->setEquipo($_POST[txtConfiguracion]);
		$datosdelEquipo=$equipoBuscar->buscarEquipo();
		$componentesAsociados=$equipoBuscar->buscarComponentesAsociados('a');
		if ($datosdelEquipo && $datosdelEquipo!=1) {
			$rowEquipo=mysql_fetch_array($datosdelEquipo);
			$_POST[txtActivoFijo]=$rowEquipo[1];
			$_POST[idDescripcion]=$rowEquipo[4];
			$_POST[chkCritico]=$rowEquipo[22];
			$_POST[chkRed]=$rowEquipo[23];
			$_POST[chkUsuarioEspecializado]=$rowEquipo[24];	
			$_POST[txtRed]=$rowEquipo[32];
			$_POST[txtCritico]=$rowEquipo[36];
			$_POST[chkSistemaOperativo]=$rowEquipo[39];
			$_POST[txtSistemaOperativo]=$rowEquipo[40];
			$_POST[chkAntivirus]=$rowEquipo[41];
			$_POST[txtAntivirus]=$rowEquipo[42];
		}


			if (isset($_POST[txtFicha]) && !empty($_POST[txtFicha])) {
				$usuarioBuscar= new usuario($_POST[txtFicha]);
				$resultadoUsuario= $usuarioBuscar->retornaUsuario();
				if ($resultadoUsuario && $resultadoUsuario!=1) {
					$rowUsuario=mysql_fetch_array($resultadoUsuario);
					$_POST[txtNombres]=$rowUsuario[2];
					$_POST[txtCargo]=$rowUsuario[6];
					$_POST[selSitioUsuario]=$rowUsuario[7];
					$_POST[txtExtension]=$rowUsuario[15];
				}
			}

	

	$conSitio="select id_sitio,sitio from sitio where status_activo=1 order by sitio";
	$conGerencia="select id_gerencia,gerencia from gerencia where status_activo=1 order by gerencia";
	$conDivision="select id_division,division from division where id_gerencia='$_POST[selGerencia]' and status_activo=1 order by division";
	$conDepartamento="select id_departamento, departamento from departamento where id_division='$_POST[selDivision]' and status_activo=1 ORDER BY departamento";

	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--UBICACION--","");
	$selSitio=$sitio->retornar();
	
	$sitioUsuario= new campoSeleccion("selSitioUsuario","formularioCampoSeleccion","$_POST[selSitioUsuario]","","",$conSitio,"--UBICACION--","");
	$selSitioUsuario=$sitioUsuario->retornar();	

	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","cambiarGerencia()",$conGerencia,"--GERENCIA--","");
	$selGerencia=$gerencia->retornar();		

	$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","cambiarDivision()",$conDivision,"--DIVISION--","");
	$selDivision=$division->retornar();

	$departamento= new campoSeleccion("selDepartamento","formularioCampoSeleccion","$_POST[selDepartamento]","","",$conDepartamento,"--DEPARTAMENTO--","");
	$selDepartamento=$departamento->retornar();
	
	
	echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"top\" type=\"hidden\" value=\"\">";
	echo "<input name=\"cambiarSeleccion\" type=\"hidden\" value=\"0\">";
	echo "<input name=\"idDescripcion\" type=\"hidden\" value=\"$_POST[idDescripcion]\">";
	echo "<input name=\"idMantenimiento\" type=\"hidden\" value=\"$_POST[idMantenimiento]\">";
	echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"2\">MANTENIMIENTO PREVENTIVO N° $idMantenimiento</td>
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
	<input class=\"formularioCampoTexto\" name=\"txtExtension\" type=\"text\" value=\"$_POST[txtExtension]\">
	<br>UBICACION:<br>$selSitioUsuario";

	echo "	</td>";
	echo "</tr>";
	echo "<tr>
	<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DE UBICACION</td>";
	echo "</tr>";
	echo "<tr>

	<td valign=top class=\"formularioCampoTitulo\">UBICACION:<br>$selSitio<br>
	DIVISION<br>$selDivision<br>

	<td valign=top class=\"formularioCampoTitulo\">GERENCIA<br>$selGerencia<br>
	DEPARTAMENTO<br>$selDepartamento<br>";
	echo "</tr>";
	echo "<tr>";
	echo "<td colspan=\"2\" align=\"center\"><textarea class=\"formularioAreaTextoPlanilla\" name=\"txtEspecifico\" cols=\"600\" rows=\"2\">$_POST[txtEspecifico]</textarea></td>";
	echo "</tr>";
	echo "<tr>
	<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL EQUIPO</td>";
	echo "</tr>";
	
	echo "<tr>
	<td valign=top class=\"formularioCampoTitulo\">CONFIGURACION:<br>
	<input class=\"formularioCampoTexto\" name=\"txtConfiguracion\" type=\"text\" value=\"$_POST[txtConfiguracion]\" readonly=\"true\">
	<br></td>
	<td valign=top class=\"formularioCampoTitulo\">ACTIVO FIJO<br>
	<input class=\"formularioCampoTexto\" name=\"txtActivoFijo\" type=\"text\" value=\"$_POST[txtActivoFijo]\" readonly=\"true\"><br>
	</td>";
	echo "<tr>";
	echo "<td valign=top class=\"formularioCampoTitulo\">";
	echo "¿EQUIPO CRITICO?<br>";
				if ($_POST[chkCritico]==1){
					echo "<input name=\"chkCritico\" type=\"checkbox\" value=\"1\" checked>SI<br>";
					echo "<textarea name=\"txtCritico\" cols=\"35\" rows=\"1\">$_POST[txtCritico]</textarea><br>";
				}else
					echo "<input name=\"chkCritico\" type=\"checkbox\" value=\"1\">SI<br>";
			echo "¿USUARIO ESPECIALIZADO?<br>";
				if ($_POST[chkUsuarioEspecializado]==1)
					echo "<input name=\"chkUsuarioEspecializado\" type=\"checkbox\" value=\"1\" checked>SI<br>";
				else 
					echo "<input name=\"chkUsuarioEspecializado\" type=\"checkbox\" value=\"1\">SI<br>";	
	echo "</td>";
	
	echo "<td valign=top class=\"formularioCampoTitulo\">";
			echo "¿CONECTADO A RED?<br>";
				if ($_POST[chkRed]==1){
					echo "<input name=\"chkRed\" type=\"checkbox\" value=\"1\" checked>NO<br>";
					echo "<textarea name=\"txtRed\" cols=\"35\" rows=\"1\">$_POST[txtRed]</textarea><br>";
				}else 
					echo "<input name=\"chkRed\" type=\"checkbox\" value=\"1\">NO<br>";
			echo "TIEMPO DE EJECUCI&Oacute;N<br>";
			echo "<select name=\"selTiempoEjecucion\" class=\"formularioSeleccion\">";
			switch($_POST[selTiempoEjecucion]) {
				case 45:
					echo "<option value=\"0\">SELECCIONE</option>";
					echo "<option selected value=\"45\">45</option>";
					echo "<option value=\"60\">60</option>";
					echo "<option value=\"90\">90</option>";
					echo "<option value=\"120\">120</option>";
					break 1;
				case 60:
					echo "<option value=\"0\">SELECCIONE</option>";
					echo "<option value=\"45\">45</option>";
					echo "<option selected value=\"60\">60</option>";
					echo "<option value=\"90\">90</option>";
					echo "<option value=\"120\">120</option>";
					break 1;
				case 90:
					echo "<option value=\"0\">SELECCIONE</option>";
					echo "<option value=\"45\">45</option>";
					echo "<option value=\"60\">60</option>";
					echo "<option selected value=\"90\">90</option>";
					echo "<option value=\"120\">120</option>";
					break 1;
				case 120:
					echo "<option value=\"0\">SELECCIONE</option>";
					echo "<option value=\"45\">45</option>";
					echo "<option value=\"60\">60</option>";
					echo "<option value=\"90\">90</option>";
					echo "<option selected value=\"120\">120</option>";
					break 1;
				default:
					echo "<option selected value=\"0\">SELECCIONE</option>";
					echo "<option value=\"45\">45</option>";
					echo "<option value=\"60\">60</option>";
					echo "<option value=\"90\">90</option>";
					echo "<option value=\"120\">120</option>";
					break 1;
			}
			echo "</select>";					
	echo "</td>";	

	echo "</tr>";
	echo "</table><br>";
	
	
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
	echo "<tr>
			<td class=\"formularioTablaTitulo\" colspan=\"5\">COMPONENTES ASOCIADOS</td>
		</tr>";
		echo "<tr valign=top class=\"tablaTitulo\">
			<td align=\"left\" class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
			<td valign=top class=\"tablaTitulo\">MARCA</td>
			<td valign=top class=\"tablaTitulo\">MODELO</td>
			<td valign=top class=\"tablaTitulo\">SERIAL</td>
			</tr>";

		$clase="tablaFilaNone";		
			echo "<tr class=\"$clase\">
			<td align=\"left\">$rowEquipo[5]</td>
			<td>$rowEquipo[7]</td>
			<td>$rowEquipo[9]</td>
			<td>$rowEquipo[3]</td>
			</tr>";
	if ($componentesAsociados && $componentesAsociados!=1) {
		while ($row=mysql_fetch_array($componentesAsociados)) {
				if ($i%2==0) {
					$clase="tablaFilaPar";
				} else {
					$clase="tablaFilaNone";
				}
				echo "<tr class=\"$clase\">
					<td align=\"left\">$row[5]</td>
					<td>$row[7]</td>
					<td>$row[9] $row[10] $row[11]</td>
					<td>$row[3]</td>
				</tr>";
				$i++;
			}
	}
		echo "</table>";
		
		echo "<br><br>";
	if ($_POST[idDescripcion]=='DES0000008') {
		echo "<table align=\"center\">";
		echo "<tr align=\"center\">";
		echo "<td>";
		echo "<input name=\"btnHojas\" type=\"button\" value=\"INGRESE LAS HOJAS IMPRESAS AQUI\" onclick=\"window.open('../librerias/hojas_impresas.php?configuracion=$_POST[txtConfiguracion]&idMantenimiento=$_GET[idMantenimiento]')\">";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
	}		
				$contador=0;		
	if ($_POST[idDescripcion]=='DES0000001' || $_POST[idDescripcion]=='DES0000042') { 
		$software=new software();
		$resultadoTipoSoftware=$software->retornarSoftware(1);
		echo "<table class=\"formularioTabla\" align=center width=\"600\" border=\"0\">";
		 	echo "<tr>";
				echo "<td class=\"formularioTablaTitulo\" colspan=\"4\">SOFTWARE ASOCIADO</td>
	  			</tr>";
				$i=0;
				$resultadoSoftware=$software->retornarSoftware();
				$y=0;
				while ($row2=mysql_fetch_array($resultadoSoftware)) {
					
					$y++;
			
					
					if ($i==0 ) {
						echo "<tr>";
					}
				

					$resultadoSoftwareEquipo=$equipoBuscar->verificarSoftwareInstalado($row2[2]);
					if ($resultadoSoftwareEquipo==1) {
						echo "<td class=\"formularioCampo\" valign=\"top\"><input name=\"chkSoftware[]\" type=\"checkbox\" value=\"$row2[2]\" checked>&nbsp;&nbsp;$row2[3]</td>";					
					} else {
						echo "<td class=\"formularioCampo\" valign=\"top\"><input name=\"chkSoftware[]\" type=\"checkbox\" value=\"$row2[2]\">&nbsp;&nbsp;$row2[3]</td>";					
					}
					$i++;
					if ($i==4) {
						$i=0;
						echo "</tr>";	
					}
					if ($y==$software->retornaTotal()) {
						$valor=$y;
						$i=0;
						$encontrado=0;
						while ($encontrado==0) {
							if (($valor % 4)==0) {
								$encontrado=1;	
							} else {
								$valor++;	
							}
						}
						for ($x=1;$x<=$valor-$software->retornaTotal();$x++) {
							echo "<td>&nbsp;</td>";
						}
						echo "</tr>";
						
					}
					
					

				}
			}
			echo "</table>";

	echo "<br><br>";
	echo "<table class=\"formularioTabla\" align=center width=\"600\" border=\"0\">";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">TRABAJO REALIZADO</td>
  			</tr>";
			
			if ($_POST[idDescripcion]=='DES0000001' || $_POST[idDescripcion]=='DES0000042') {

				echo 	"<tr>
			<td class=\"formularioCampoTitulo\">";
				echo "SISTEMA OPERATIVO ACTUALIZADO:<br>";
				if ($_POST[chkSistemaOperativo]==1){
				echo "<input name=\"chkSistemaOperativo\" type=\"checkbox\" value=\"1\" checked>NO<br>";
				echo "<textarea name=\"txtSistemaOperativo\" cols=\"35\" rows=\"1\">$_POST[txtSistemaOperativo]</textarea><br>";
				}else
				echo "<input name=\"chkSistemaOperativo\" type=\"checkbox\" value=\"1\">NO<br>";
				echo "</td>";
				echo "<td class=\"formularioCampoTitulo\">";

				echo "ANTIVIRUS ACTUALIZADO:<br>";
				if ($_POST[chkAntivirus]==1){
				echo "<input name=\"chkAntivirus\" type=\"checkbox\" value=\"1\" checked>NO<br>";
				echo "<textarea name=\"txtAntivirus\" cols=\"35\" rows=\"1\">$_POST[txtAntivirus]</textarea><br>";
				}else
				echo "<input name=\"chkAntivirus\" type=\"checkbox\" value=\"1\">NO<br>";
				echo "</td>";

				echo "</tr>";
			}

			echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" valign=\"top\" colspan=\"2\">DESCRIPCION DEL TRABAJO REALIZADO:<BR>
			<textarea class=\"formularioAreaTextoPlanilla\" name=\"txtTrabajo\" cols=\"500\" rows=\"2\">$_POST[txtTrabajo]</textarea><BR>
			OBSERVACION:<br>
			<textarea class=\"formularioAreaTextoPlanilla\" name=\"txtObservacion\" cols=\"500\" rows=\"2\">$_POST[txtObservacion]</textarea><BR>
			SI EXISTE ALGUN PUNTO PENDIENTE PRESIONE <a class=\"enlace\" href=\"#\" onclick=\"window.open('../librerias/puntoPendienteGenerar.php?configuracion=$_POST[txtConfiguracion]')\">AQUI</a> PARA GENERARLO<BR><BR>
			¿REALIZ&Oacute; UN MANTENIMIENTO CORRECTIVO?:<select name=\"selCorrectivo\" class=\"formularioSeleccion\">";
			if ($correctivo==0) {
				echo "<option selected value=\"0\">NO</option>";
				echo "<option value=\"1\">SI</option>";
			} else {
				echo "<option value=\"0\">NO</option>";
				echo "<option selected value=\"1\">SI</option>";
			}
			echo "</select><br>
			<textarea class=\"formularioAreaTextoPlanilla\" name=\"txtCorrectivo\" cols=\"500\" rows=\"2\">$_POST[txtCorrectivo]</textarea><BR>						
			</td>
  			</tr>";	
 		
			echo "<tr>
			<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"5\">
			<input name=\"btnActualizar\" type=\"button\" value=\"ACTUALIZAR\" onclick=\"actualizar()\">
			<input name=\"btnFinalizar\" type=\"button\" value=\"FINALIZAR\" onclick=\"finalizar()\"></td>
			</tr>";	
						
			echo "</table>";

echo "</form>";	
	
}
?>