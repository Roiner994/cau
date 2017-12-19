<?php
require_once("seguridad.php");
?>
<script language="javascript">
function salir() {
		document.frmMantenimiento.funcion.value=0;
		document.frmMantenimiento.submit();
}
</script>


<?php
require_once("mantenimientoAdmin.php");
$login=$_SESSION['login'];
switch ($funcion) {
	case 1:
	$mantenimiento= new mantenimiento();
	$mantenimiento->setDatosMantenimiento("",$_POST[txtConfiguracion]);

	$resultado=$mantenimiento->retornarEstadoMantenimiento();
	switch ($resultado) {
		case 1:
		echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
		echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO - NUEVO MANTENIMIENTO</td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>EL EQUIPO NO ESTA REGISTRADO EN EL SISTEMA</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\" onclick=\"\"></td>";
		echo "</tr>";
		echo "</table>";
		echo "</form>";
		break 1;
		case 2:
		$idMantenimiento=$mantenimiento->retornaridMantenimiento();
		echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
		echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO - NUEVO MANTENIMIENTO</td>
				</tr>";
		if ($mantenimiento->verificarTecnicoMantenimiento()!=$login) {
			require_once("usuarioSistemaAdmin.php");
			$usuarioSistema= new usuarioSistema($mantenimiento->verificarTecnicoMantenimiento());
			$resultadoUsuarioSistema=$usuarioSistema->retornarUsuario();
			if ($resultadoUsuarioSistema && $resultadoUsuarioSistema!=1) {
				$rowUsuario=mysql_fetch_array($resultadoUsuarioSistema);	
			}
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>EL EQUIPO <b>".strtoupper($_POST[txtConfiguracion])."</b> TIENE UN MANTENIMIENTO SIN CERRAR, Y LO ESTA EJECUTANDO <b>$rowUsuario[1] $rowUsuario[2]</b>.</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>
					<input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\" onclick=\"\">
					</td>";
			echo "</tr>";
				
		} else {
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>EL EQUIPO <b>".strtoupper($_POST[txtConfiguracion])."</b> TIENE UN MANTENIMIENTO SIN CERRAR</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>
					<input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\" onclick=\"\">
					<input name=\"btnCancelar\" type=\"button\" value=\"CONTINUAR\" onclick=\"location.href='index2.php?item=308&idMantenimiento=$idMantenimiento'\">
					</td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "</form>";
		break 1;
		case 3:
		//MANTENIMIENTO MAYOR DE 2 MESES
		$mantenimiento= new mantenimiento();
		$mantenimiento->setDatosMantenimiento("",$_POST[txtConfiguracion]);
		$resultado=$mantenimiento->retornaUltimoMantenimiento();
		if ($resultado && $resultado!=1) {
			echo "<table width=\"30%\" border=\"0\" align=\"center\">
					<tr>
					<td valign=top class=\"tablaTitulo\" colspan=\"4\"><b>ULTIMO MANTENIMIENTO</b></td>
					</tr>
					<tr>
					<td valign=top class=\"tablaTitulo\"><b>CONFIGURACION</b></td>
					<td valign=top class=\"tablaTitulo\"><b>TECNICO</b></td>		  
					<td valign=top class=\"tablaTitulo\"><b>FECHA</b></td>
					<td valign=top class=\"tablaTitulo\"><b>SITIO</b></td>
					</tr>";
			$total=0;
			while ($row=mysql_fetch_array($resultado)) {
				if ($i%2==0) {
					$clase="tablaFilaPar";
				} else {
					$clase="tablaFilaNone";
				}
				echo "<tr class=\"$clase\">";
				echo "<td align=\"left\">$row[1]</td>";
				echo "<td align=\"left\">$row[3] $row[4]</td>";
				echo "<td align=\"left\">$row[5]</td>";
				echo "<td align=\"left\">$row[7]</td>";
				echo "</tr>";
				$i++;
			}

			echo "</table>";
		}  

		echo "<br><br>";

		echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
		echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO - NUEVO MANTENIMIENTO</td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>EL EQUIPO ESTÁ DISPONIBLE PARA REALIZARLE MANTENIMIENTO<br>¿DESEA REALIZARLE MANTENIMIENTO?</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>
		<input name=\"btnCancelar\" type=\"button\" value=\"NO\" onclick=\"salir()\">
		<input name=\"btnAceptar\" type=\"submit\" value=\"SI\" onclick=\"\">
		</td>";
		echo "</tr>";
		echo "</table>";
		echo "</form>";
		break 1;
		case 4:
		//EL MANTENIMIENTO ES MENOR DE 2 MESES.
		$mantenimiento= new mantenimiento();
		$mantenimiento->setDatosMantenimiento("",$_POST[txtConfiguracion]);
		$resultado=$mantenimiento->retornaUltimoMantenimiento();
		if ($resultado && $resultado!=1) {
			echo "<table width=\"30%\" border=\"0\" align=\"center\">
					<tr>
					<td valign=top class=\"tablaTitulo\" colspan=\"4\"><b>ULTIMO MANTENIMIENTO</b></td>
					</tr>
					<tr>
					<td valign=top class=\"tablaTitulo\"><b>CONFIGURACION</b></td>
					<td valign=top class=\"tablaTitulo\"><b>TECNICO</b></td>		  
					<td valign=top class=\"tablaTitulo\"><b>FECHA</b></td>
					<td valign=top class=\"tablaTitulo\"><b>SITIO</b></td>
					</tr>";
			$total=0;
			while ($row=mysql_fetch_array($resultado)) {
				if ($i%2==0) {
					$clase="tablaFilaPar";
				} else {
					$clase="tablaFilaNone";
				}
				echo "<tr class=\"$clase\">";
				echo "<td align=\"left\">$row[1]</td>";
				echo "<td align=\"left\">$row[3] $row[4]</td>";
				echo "<td align=\"left\">$row[5]</td>";
				echo "<td align=\"left\">$row[7]</td>";
				echo "</tr>";
				$i++;
			}

			echo "</table>";
		}
		echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
		echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO - NUEVO MANTENIMIENTO</td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>EL EQUIPO NO ESTA DISPONIBLE PARA HACERLE MANTENIMIENTO</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\" onclick=\"\"></td>";
		echo "</tr>";
		echo "</table>";
		echo "</form>";
		break 1;
		case 5:
		echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
		echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO - NUEVO MANTENIMIENTO</td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>EL EQUIPO NO SE LE HA REALIZADO NINGUN MANTENIMIENTO<br>¿DESEA REALIZARLE MANTENIMIENTO?</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>
				<input name=\"btnCancelar\" type=\"button\" value=\"NO\" onclick=\"salir()\">
				<input name=\"btnAceptar\" type=\"submit\" value=\"SI\" onclick=\"\">
				</td>";
		echo "</tr>";
		echo "</table>";
		echo "</form>";
		break 1;
		case 6:
		$mantenimiento= new mantenimiento();
		$mantenimiento->setDatosMantenimiento("",$_POST[txtConfiguracion]);
		$resultado=$mantenimiento->retornarUltimoMantenimiento();
		if ($resultado && $resultado!=1) {
			echo "<table width=\"30%\" border=\"0\" align=\"center\">
					<tr>
					<td valign=top class=\"tablaTitulo\" colspan=\"2\"><b>ULTIMO MANTENIMIENTO</b></td>
					</tr>
					<tr>
					<td valign=top class=\"tablaTitulo\"><b>CONFIGURACION</b></td>
					<td valign=top class=\"tablaTitulo\"><b>TECNICO</b></td>		  
					<td valign=top class=\"tablaTitulo\"><b>FECHA</b></td>
					</tr>";
			$total=0;
			while ($row=mysql_fetch_array($resultado)) {
				if ($i%2==0) {
					$clase="tablaFilaPar";
				} else {
					$clase="tablaFilaNone";
				}
				echo "<tr class=\"$clase\">";
				echo "<td align=\"left\">$row[1]</td>";
				echo "<td align=\"left\">$row[2] $row[3]</td>";
				echo "<td align=\"left\">$row[5]</td>";
				echo "</tr>";
				$i++;
			}

			echo "</table>";
		}
		echo "<br><br>";


		echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
		echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO - NUEVO MANTENIMIENTO</td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>EL EQUIPO ESTA HABILITADO PARA REALIZARLE MANTENIMIENTO <BR>¿DESEA REALIZARLE MANTENIMIENTO?</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>
				<input name=\"btnCancelar\" type=\"button\" value=\"NO\" onclick=\"salir()\">
				<input name=\"btnAceptar\" type=\"submit\" value=\"SI\" onclick=\"\">
				</td>";
		echo "</tr>";
		echo "</table>";
		echo "</form>";
		break 1;
		default:
		echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
		echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO - NUEVO MANTENIMIENTO</td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>EL EQUIPO NO ESTÁ REGISTRADO EN EL SISTEMA</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\" onclick=\"\">
				</td>";
		echo "</tr>";
		echo "</table>";
		echo "</form>";
	}

	break 1;
	case 2:
	//Nuevo Mantenimiento
		$login=$_SESSION["login"];
		$mantenimiento= new mantenimiento();
		$mantenimiento->setDatosMantenimiento("",$_POST[txtConfiguracion],$login);
		$resultado=$mantenimiento->ingresarMantenimiento();
		switch ($resultado) {
			case 0:
			$idMantenimiento=$mantenimiento->retornaridMantenimiento();
			echo "<script language=\"javascript\"> location.href='index2.php?item=308&idMantenimiento=$idMantenimiento'</script>";
			break 1;
			case 1:
			echo "error al Cargar";
			break 1;
		}

		
		
		
	break 1;
	default:
	frmMantenimientoPreventivo();
}

function frmMantenimientoPreventivo() {
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
?>