<?php
require_once("seguridad.php");
?>
<script language="javascript">
function realizar() {
	document.frmMantenimiento.funcion.value=2;
	document.frmMantenimiento.submit();		
}
function actualizar() {
	document.frmMantenimiento.funcion.value=4;
	document.frmMantenimiento.submit();		
}
function cambiarSeleccion() {
		document.frmMantenimiento.funcion.value=3;
		document.frmMantenimiento.submit();
}
function finalizar() {
	document.frmMantenimiento.funcion.value=5;
	document.frmMantenimiento.submit();		
}	

function buscarFicha() {
	if (document.frmMantenimiento.txtFicha.value!="") {
		document.frmMantenimiento.funcion.value=3;
		document.frmMantenimiento.submit();	
	}
}
</script>
<?php
//Mantenimiento Preventivo

switch ($funcion) {
	case 1:
		require_once("mantenimientoAdmin.php");
		require_once "usuarioSistemaAdmin.php";	
		$login=$_SESSION["login"];	
		$mantenimiento= new mantenimiento("",$_POST[txtConfiguracion],$login);
		$resultado=$mantenimiento->verificarMantenimiento();
		switch ($resultado) {
			case 4:
				echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
				$_POST[txtConfiguracion]=strtoupper($_POST[txtConfiguracion]);
				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>EL EQUIPO <b>$_POST[txtConfiguracion]</b> NO ESTÁ HABILITADO PARA REALIZARLE MANTENIMIENTO</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";				
				break 1;
			case 1:
				echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
				$_POST[txtConfiguracion]=strtoupper($_POST[txtConfiguracion]);
				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>EL EQUIPO <B>$_POST[txtConfiguracion]</B> EST&Aacute; HABILITADO PARA REALIZARLE MANTENIMIENTO</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"CANCELAR\"><input name=\"txtBoton\" type=\"button\" value=\"REALIZAR MANTENIMIENTO\" onClick=\"realizar()\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";
				break 1;

				break 1;
			case 2:
				echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
				$_POST[txtConfiguracion]=strtoupper($_POST[txtConfiguracion]);
				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>EL EQUIPO <B>$_POST[txtConfiguracion]</B> NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";
				break 1;
			case 3:
					$login=$_SESSION["login"];	
					$mantenimiento= new mantenimiento();
					$mantenimiento->setDatosMantenimiento("",$_POST[txtConfiguracion],$login);
					$mantenimiento->continuarMantenimiento();
					frmMantenimientoPreventivo($mantenimiento,0,1);
				break 1;
			default:
				echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
				$_POST[txtConfiguracion]=strtoupper($_POST[txtConfiguracion]);
				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>PRIMERO DEBE DE CULMINAR EL MANTENIMIENTO AL EQUIPO <B>$resultado</B>.</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";				
		}
		break 1;
	case 2:
		require_once "usuarioSistemaAdmin.php";	
		require_once("mantenimientoAdmin.php");
		$login=$_SESSION["login"];		
		$mantenimiento= new mantenimiento();
		$mantenimiento->setDatosMantenimiento("",$_POST[txtConfiguracion],$login);
		$resultado=$mantenimiento->ingresarMantenimiento();
		frmMantenimientoPreventivo($mantenimiento);
		break 1;
	case 3:
		require_once "usuarioSistemaAdmin.php";	
		require_once("mantenimientoAdmin.php");
		$login=$_SESSION["login"];		
		$mantenimiento= new mantenimiento();
		$mantenimiento->setDatosMantenimiento("",$_POST[txtConfiguracion],$login);
		$mantenimiento->continuarMantenimiento();		
		frmMantenimientoPreventivo($mantenimiento,1,0,$_POST[txtConfiguracion]);
		break 1;
	case 4:
		require_once "usuarioSistemaAdmin.php";	
		require_once("mantenimientoAdmin.php");
		require_once("inventarioAdmin.php");
		require_once("usuarioAdmin.php");
		$login=$_SESSION["login"];
		$usuario=new usuario($_POST[txtFicha],"","","","","","","","",$_POST[txtExtension]);
		$resultadoUsuario=$usuario->actualizarExtension();		
		
		$mantenimiento= new mantenimiento($_POST[idMantenimiento]);
		$mantenimiento->setUsuario($_POST[txtFicha]);
		$mantenimiento->setDetalleMantenimiento($_POST[selSO],$_POST[txtSistemaOperativo],$_POST[selAntivirus],$_POST[txtAntivirus],$_POST[selRed],$_POST[txtRed],$_POST[txtTrabajo],$_POST[txtObservacion],$_POST[selPendiente],$_POST[txtPuntoPendiente],
		$_POST[selCorrectivo],$_POST[txtCorrectivo],$_POST[txtCantidadHojas]);
		$equipo=new equipo();
		$equipo->setEquipo($_POST[txtConfiguracion]);
		$resultadoConfiguracion=$equipo->buscarEquipo();
		$equipo->setInventarioUbicacion($_POST[selDepartamento],$_POST[selSitio],$_POST[txtEspecifico],$login);
		//$conf=$equipo->buscarConfiguracion();
		$equipo->setInventarioUsuario($_POST[txtFicha],$login);
		$equipo->ingresarSoftware($_POST[chkSoftware]);
		$resultado=$equipo->ingresarInventarioUsuario();		
		$resultado=$equipo->ingresarInventarioUbicacion();
		$mantenimiento->setUbicacion($_POST[selDepartamento],$_POST[selSitio],"",$login);
		$resultado=$mantenimiento->actualizarMantenimiento();	
		frmMantenimientoPreventivo($mantenimiento,1,0,$_POST[txtConfiguracion]);
		break 1;
	case 5:
		if (isset($_POST[selSO]) && $_POST[selSO]==0 && empty($_POST[txtSistemaOperativo]) && ( $_POST[idDescripcion]=='DES0000001' || $_POST[idDescripcion]=='DES0000042')) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>SISTEMA OPERATIVO</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[selAntivirus]) && $_POST[selAntivirus]==0 && empty($_POST[txtAntivirus]) && ($_POST[idDescripcion]=='DES0000001' || $_POST[idDescripcion]=='DES0000042')) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>ANTIVIRUS</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[selRed]) && $_POST[selRed]==0 && empty($_POST[txtRed])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>RED</b>";
			$i++;
			$sw=1;
		}		
		switch($i) {
			case 0:
				require_once "usuarioSistemaAdmin.php";	
				require_once("mantenimientoAdmin.php");
				require_once("inventarioAdmin.php");
				require_once("usuarioAdmin.php");
				$mantenimiento= new mantenimiento($_POST[idMantenimiento]);
				$mantenimiento->setUsuario($_POST[txtFicha]);
				$mantenimiento->setDetalleMantenimiento($_POST[selSO],$_POST[txtSistemaOperativo],$_POST[selAntivirus],$_POST[txtAntivirus],$_POST[selRed],$_POST[txtRed],$_POST[txtTrabajo],$_POST[txtObservacion],$_POST[selPendiente],$_POST[txtPuntoPendiente],
				$_POST[selCorrectivo],$_POST[txtCorrectivo],$_POST[txtCantidadHojas]);
				$equipo=new equipo();
				$equipo->setEquipo($_POST[txtConfiguracion]);
				$equipo->setInventarioUbicacion($_POST[selDepartamento],$_POST[selSitio],$_POST[txtEspecifico],$login);
				//$conf=$equipo->buscarConfiguracion();
				$equipo->setInventarioUsuario($_POST[txtFicha]);
				$equipo->ingresarSoftware($_POST[chkSoftware]);
				$usuario=new usuario($_POST[txtFicha],"","","","","","","","",$_POST[txtExtension]);
				$resultadoUsuario=$usuario->actualizarExtension();		
				$resultado=$equipo->ingresarInventarioUsuario();		
				$resultado=$equipo->ingresarInventarioUbicacion();
				$mantenimiento->setUbicacion($_POST[selDepartamento],$_POST[selSitio],$_POST[txtEspecifico]);
				$resultado=$mantenimiento->actualizarMantenimiento();	
		//		frmMantenimientoPreventivo($mantenimiento,1,0,$_POST[txtConfiguracion]);
				$mantenimiento= new mantenimiento($_POST[idMantenimiento]);
				$resultado=$mantenimiento->finalizarMantenimiento();
				switch ($resultado) {
					case 0:
						echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
						$_POST[txtConfiguracion]=strtoupper($_POST[txtConfiguracion]);
						$man=$mantenimiento->retornaridMantenimiento();
						echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"\">";
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>SE FINALIZ&Oacute; EL MANTENIMIENTO<BR>
						<input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"><input name=\"txtBoton\" type=\"button\" value=\"IMPRIMIR\" onclick=\"window.open('../librerias/xmlMantenimiento.php?idMantenimiento=$man')\"></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";	
						break 1;
					case 1:
						echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
						$_POST[txtConfiguracion]=strtoupper($_POST[txtConfiguracion]);
						$man=$mantenimiento->retornaridMantenimiento();
						echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"\">";
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR EL MANTENIMIENTO<BR>
						<input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"><input name=\"txtBoton\" type=\"button\" value=\"IMPRIMIR\" onclick=\"window.open('../librerias/xmlMantenimiento.php?idMantenimiento=$man')\"></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";	
						break 1;	
				}

			break 1;
			case 1:
				echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
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
				echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - NUEVO EQUIPO</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>LOS CAMPOS ".$mensaje. " ESTAN VAC&IacuteOS</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";			
				echo "</form>";	
		}
		break 1;
	default:
		frmMantenimiento();	
}

function frmMantenimiento() {
	echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"400\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\">MANTENIMIENTO PREVENTIVO</td>
	</tr>";
	echo "<tr>
	<td valign=top class=\"formularioTablaTitulo\">DATOS DEL EQUIPO</td>";
	echo "</tr>";
	echo "<tr>
	<td valign=top class=\"formularioCampoTitulo\">ESCRIBA LA CONFIGURACION DEL EQUIPO Y PRESIONE ACEPTAR<br>
	<input class=\"formularioCampoTexto\" name=\"txtConfiguracion\" type=\"text\" value=\"$_POST[txtConfiguracion]\"><br>
	<input name=\"btnChequear\" title=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\"><br>
	</td>";
	echo "</tr>";
	echo "</table>";
	echo "</form>";
}
function frmMantenimientoPreventivo($mantenimiento,$cambiarSeleccion=0,$continuar=0,$configuracion=0) {
	require_once "usuarioAdmin.php";
	require_once "conexionsql.php";
	require_once "formularios.php";
	require_once "inventarioAdmin.php";
	require_once("softwareAdmin.php");
	$_POST[txtConfiguracion]=$configuracion;
	if (isset($mantenimiento) && !empty($mantenimiento) && $cambiarSeleccion==0) {
		$_POST[idMantenimiento]=$mantenimiento->retornarIdMantenimiento();
		$resultadoMantenimiento=$mantenimiento->retornarMantenimiento();
		if ($resultadoMantenimiento && $resultadoMantenimiento!=1) {
			$rowMantenimiento=mysql_fetch_array($resultadoMantenimiento);
			$configuracion=$rowMantenimiento[1];
			$_POST[txtFicha]=$rowMantenimiento[3];
			$_POST[selSO]=$rowMantenimiento[10];
			$_POST[selAntivirus]=$rowMantenimiento[11];
			$_POST[selRed]=$rowMantenimiento[12];
			$_POST[txtTrabajo]=$rowMantenimiento[13];
			$_POST[txtObservacion]=$rowMantenimiento[14];
			$_POST[selPendiente]=$rowMantenimiento[15];
			$_POST[txtPuntoPendiente]=$rowMantenimiento[16];
			$_POST[selCorrectivo]=$rowMantenimiento[17];
			$_POST[txtCorrectivo]=$rowMantenimiento[18];
			$_POST[txtSistemaOperativo]=$rowMantenimiento[20];			
			$_POST[txtAntivirus]=$rowMantenimiento[21];
			$_POST[txtRed]=$rowMantenimiento[22];
			$ubicacion= new ubicacion("","","",$rowMantenimiento[4]);
			$resultadoUbicacion=$ubicacion->retornarUbicacion();
			if ($resultadoUbicacion && $resultadoUbicacion!=1) {
				$ubicacionMantenimiento=1;
				$rowUbicacion=mysql_fetch_array($resultadoUbicacion);
				$_POST[selGerencia]=$rowUbicacion[0];
				$_POST[selDivision]=$rowUbicacion[2];
				$_POST[selDepartamento]=$rowUbicacion[4];
			}
			$resultadoSitio=$ubicacion->retornarSitio();
			if ($resultadoSitio && $resultadoSitio!=1) {
				$rowSitio=mysql_fetch_array($resultadoSitio);
				$_POST[selSitio]=$rowSitio[0];	
			}
			
		}
	}
//	$mantenimiento->continuarMantenimiento();	
	if (isset($configuracion) && !empty($configuracion)) {
		$_POST[txtConfiguracion]=$configuracion;
		$equipo= new equipo();
		$equipo->setEquipo($_POST[txtConfiguracion]);
		$datosdelEquipo=$equipo->buscarEquipo();
		$componentesAsociados=$equipo->buscarComponentesAsociados('a');
		if ($datosdelEquipo && $datosdelEquipo!=1) {
			$rowEquipo=mysql_fetch_array($datosdelEquipo);
			$_POST[txtActivoFijo]=$rowEquipo[1];
			$_POST[idDescripcion]=$rowEquipo[4];	
		}
		
	}
	if ($cambiarSeleccion==0) {
			if ($equipo->retornarUltimoUsuario('f')!=1)	
				$_POST[txtFicha]=$equipo->retornarUltimoUsuario('f');
			if ($equipo->retornarUltimoUsuario('n')!=1)
				$_POST[txtNombres]=$equipo->retornarUltimoUsuario('n'). " ".$equipo->retornarUltimoUsuario('a');;
			if($equipo->retornarUltimoUsuario('C')!=1)
				$_POST[txtCargo]=$equipo->retornarUltimoUsuario('C');
			if($equipo->retornarUltimoUsuario('e')!=1)		
				$_POST[txtExtension]=$equipo->retornarUltimoUsuario('e');
		if ($equipo->retornarUltimaUbicacion('d')!=1) {
			$_POST[selSitio]=$equipo->retornarUltimaUbicacion('u');
			$_POST[selGerencia]=$equipo->retornarUltimaUbicacion('g');
			$_POST[selDivision]=$equipo->retornarUltimaUbicacion('s');
			$_POST[selDepartamento]=$equipo->retornarUltimaUbicacion('d');
			$_POST[txtEspecifico]=$equipo->retornarUltimaUbicacion('e');
		} else {
			$_POST[selSitio]="";
			$_POST[selGerencia]="";
			$_POST[selDivision]="";
			$_POST[selDepartamento]="";
			$_POST[txtEspecifico]="";
		}
		
	}

		if (isset($_POST[txtFicha]) && !empty($_POST[txtFicha])) {
			$usuarioAsignacion= new usuario($_POST[txtFicha]);
			$resultado5= $usuarioAsignacion->retornaUsuario();
			if ($resultado5 && $resultado5!=1) {
				$row5=mysql_fetch_array($resultado5);
				$_POST[txtNombres]=$row5[2];
				$_POST[txtCargo]=$row5[6];
				$_POST[txtExtension]=$row5[15];
			}
		}

	$conSitio="select id_sitio,sitio from sitio where status_activo=1 order by sitio";
	$conGerencia="select id_gerencia,gerencia from gerencia where status_activo=1 order by gerencia";
	$conDivision="select id_division,division from division where id_gerencia='$_POST[selGerencia]' and status_activo=1 order by division";
	$conDepartamento="select id_departamento, departamento from departamento where id_division='$_POST[selDivision]' and status_activo=1 ORDER BY departamento";

	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--UBICACION--","");
	$selSitio=$sitio->retornar();

	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","cambiarSeleccion()",$conGerencia,"--GERENCIA--","");
	$selGerencia=$gerencia->retornar();		

	$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","cambiarSeleccion()",$conDivision,"--DIVISION--","");
	$selDivision=$division->retornar();

	$departamento= new campoSeleccion("selDepartamento","formularioCampoSeleccion","$_POST[selDepartamento]","onChange","cambiarSeleccion()",$conDepartamento,"--DEPARTAMENTO--","");
	$selDepartamento=$departamento->retornar();	
	
	echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"idDescripcion\" type=\"hidden\" value=\"$_POST[idDescripcion]\">";
	echo "<input name=\"idMantenimiento\" type=\"hidden\" value=\"$_POST[idMantenimiento]\">";
	echo "<table class=\"formularioTabla\"align=center width=\"650\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"2\">MANTENIMIENTO PREVENTIVO</td>
	</tr>";
	echo "<tr>
	<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL USUARIO</td>";
	echo "</tr>";
	echo "<tr>
	<td valign=top class=\"formularioCampoTitulo\">FICHA:<br><input class=\"formularioCampoTexto\" name=\"txtFicha\" type=\"text\" value=\"$_POST[txtFicha]\">
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
	echo "</tr>";
	echo "<tr>

	<td valign=top class=\"formularioCampoTitulo\">UBICACION:<br>$selSitio<br>
	GERENCIA<br>$selGerencia<br>

	<td valign=top class=\"formularioCampoTitulo\">DIVISION<br>$selDivision<br>
	DEPARTAMENTO<br>$selDepartamento<br>";
	echo "</tr>";
	echo "<tr>";
	echo "<td colspan=\"2\" align=\"center\"><textarea class=\"formularioAreaTextoPlanilla\" name=\"txtEspecifico\" cols=\"600\" rows=\"2\">$_POST[txtEspecifico]</textarea></td>";
	echo "</tr>";
	echo "<tr>
	<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL EQUIPO</td>";
	echo "</tr>";
	
	echo "<tr>
	<td valign=top class=\"formularioCampoTitulo\">CONFIGURACION:<br><input class=\"formularioCampoTexto\" name=\"txtConfiguracion\" type=\"text\" value=\"$_POST[txtConfiguracion]\" readonly=\"true\"><br>
	<td valign=top class=\"formularioCampoTitulo\">ACTIVO FIJO<br>
	<input class=\"formularioCampoTexto\" name=\"txtActivoFijo\" type=\"text\" value=\"$_POST[txtActivoFijo]\" readonly=\"true\"><br>
	</td>";
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
		
	if ($_POST[idDescripcion]=='DES0000001' || $_POST[idDescripcion]=='DES0000042') { 
		$software=new software();
		$resultadoTipoSoftware=$software->retornarSoftware(1);
		echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
		 	echo "<tr>";
				echo "<td class=\"formularioTablaTitulo\" colspan=\"4\">SOFTWARE ASOCIADO</td>
	  			</tr>";
		if ($resultadoTipoSoftware && $resultadoTipoSoftware!=1) {
			
			while ($row=mysql_fetch_array($resultadoTipoSoftware)) {
				$i=0;
				echo 	"<tr>
						<td class=\"formularioCampoTitulo\" colspan=\"4\">$row[1]<br>					
						</td>
			
				</tr><tr>";
				$resultadoSoftware=$software->retornarSoftware();
				while ($row2=mysql_fetch_array($resultadoSoftware)) {		
				
					//if ($i==0) {
						//echo 	"<tr>";
					//}
					if ($row2[1]==$row[1]) {
						$resultadoSoftwareEquipo=$equipo->verificarSoftwareInstalado($row2[2]);
						if ($resultadoSoftwareEquipo==1) {
							echo "<td class=\"formularioCampo\" valign=\"top\"><input name=\"chkSoftware[]\" type=\"checkbox\" value=\"$row2[2]\" checked>&nbsp;&nbsp;$row2[3]</td>";					
						} else {
							echo "<td class=\"formularioCampo\" valign=\"top\"><input name=\"chkSoftware[]\" type=\"checkbox\" value=\"$row2[2]\">&nbsp;&nbsp;$row2[3]</td>";					
						}
					} else {
						$i=-1;	
					}
					if ($i++==3) {
						$i=0;
						echo "</tr><tr>";
						
					}
				}
			}
		}			
		echo "</table>";
	}
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">TRABAJO REALIZADO</td>
  			</tr>";
			echo 	"<tr>
			<td class=\"formularioCampo\" colspan=\"2\">";
			if ($_POST[idDescripcion]=='DES0000001' || $_POST[idDescripcion]=='DES0000042') {
				echo "SISTEMA OPERATIVO ACTUALIZADO:
				<select name=\"selSO\" class=\"formularioSeleccion\">";
				if ($_POST[selSO]==0) {
					echo "<option selected value=\"0\">NO</option>";
					echo "<option value=\"1\">SI</option>";
				} else {
					echo "<option value=\"0\">NO</option>";
					echo "<option selected value=\"1\">SI</option>";
				}
				echo "</select><br>
				<textarea class=\"formularioAreaTextoPlanilla\" name=\"txtSistemaOperativo\" cols=\"500\" rows=\"2\">$_POST[txtSistemaOperativo]</textarea><BR>
				ANTIVIRUS ACTUALIZADO:
				<select name=\"selAntivirus\" class=\"formularioSeleccion\">";
				if ($_POST[selAntivirus]==0) {
					echo "<option selected value=\"0\">NO</option>";
					echo "<option value=\"1\">SI</option>";
				} else {
					echo "<option value=\"0\">NO</option>";
					echo "<option selected value=\"1\">SI</option>";
				}
				echo "</select><br>
				<textarea class=\"formularioAreaTextoPlanilla\" name=\"txtAntivirus\" cols=\"500\" rows=\"2\">$_POST[txtAntivirus]</textarea><BR>";
			}
			echo "CONECTADO EN RED:
			<select name=\"selRed\" class=\"formularioSeleccion\">";
			if ($_POST[selRed]==0) {
				echo "<option selected value=\"0\">NO</option>";
				echo "<option value=\"1\">SI</option>";
			} else {
				echo "<option value=\"0\">NO</option>";
				echo "<option selected value=\"1\">SI</option>";
			}
			echo "</select><br>
			<textarea class=\"formularioAreaTextoPlanilla\" name=\"txtRed\" cols=\"500\" rows=\"2\">$_POST[txtRed]</textarea><BR>";
			if ($_POST[idDescripcion]=='DES0000008') {
			echo "CANTIDAD DE HOJAS IMPRESAS:<br><input class=\"formularioCampoTexto\" name=\"txtCantidadHojas\" type=\"text\" value=\"$_POST[txtCantidadHojas]\" onKeyPress=\"if (event.keyCode > 47 && event.keyCode > 58) event.returnValue = false;\">";
			}
			echo "</td>
			</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioCampo\" valign=\"top\" colspan=\"2\">DESCRIPCION DEL TRABAJO REALIZADO:<BR>
			<textarea class=\"formularioAreaTextoPlanilla\" name=\"txtTrabajo\" cols=\"500\" rows=\"2\">$_POST[txtTrabajo]</textarea><BR>
			OBSERVACION:<br>
			<textarea class=\"formularioAreaTextoPlanilla\" name=\"txtObservacion\" cols=\"500\" rows=\"2\">$_POST[txtObservacion]</textarea><BR>
			SI EXISTE ALGUN PUNTO PENDIENTE PRESIONE <a class=\"enlace\" href=\"#\" onclick=\"window.open('../librerias/puntoPendienteGenerar.php?configuracion=$_POST[txtConfiguracion]')\">AQUI</a> PARA GENERARLO<BR><BR>
			¿REALIZ&Oacute; UN MANTENIMIENTO CORRECTIVO?:<select name=\"selCorrectivo\" class=\"formularioSeleccion\">";
			if ($_POST[selCorrectivo]==0) {
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