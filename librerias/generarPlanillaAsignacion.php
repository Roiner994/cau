<script language="javascript">
	function buscarFicha() {
		if (document.frmEquipo.txtFicha.value!="") {
			document.frmEquipo.funcion.value=2;
			document.frmEquipo.submit();	
		}
	}
	function buscarConfiguracion() {
		if (document.frmEquipo.txtConfiguracion.value!="") {
			document.frmEquipo.funcion.value=3;
			document.frmEquipo.submit();
		}
	}
	function cambiarSeleccion() {
		document.frmEquipo.funcion.value=2;
		document.frmEquipo.submit();
	}
	function generar() {
		var ruta='../librerias/xmlAsignacionEquipos.php?configuracion='+document.frmEquipo.txtConfiguracion.value
		+'&ficha='+document.frmEquipo.txtFicha.value
		+'&Correo='+document.frmEquipo.selCorreo.value
		+'&Internet='+document.frmEquipo.txtFicha.value
		document.frmEquipo.funcion.value=1;
		document.frmEquipo.submit();
		
		window.open(ruta);
	}
</script>
<?php
//Planillla de Asignacion de Equipos
switch (funcion) {
	case 1:
		planilla();
		break 1;
	case 2:

		break 1;
	default:
	planilla();	
}
function planilla() {
		require_once "equipoAdmin.php";
		require_once "inventarioAdmin.php";
		require_once "conexionsql.php";
		require_once "formularios.php";
		require_once "usuarioAdmin.php";

		if (isset($_POST[txtConfiguracion]) && !empty($_POST[txtConfiguracion])) {	
		$equipo= new equipo($_POST[txtConfiguracion]);	
		$resultado=$equipo->retornarEquipoCampo();
		$resultado4=$equipo->retornarComponenteAsociados();
		if ($resultado && $resultado!=1) {
			$row=mysql_fetch_array($resultado);
			$_POST[txtActivoFijo]=$row[1];
			$_POST[txtSerial]=$row[3];
			$_POST[txtDescripcion]=$row[5];			
			$_POST[txtMarca]=$row[7];
			$_POST[txtModelo]=$row[9];
			if ($pedidoStatus==0) {
				$_POST[selPedido]=$row[12];
				$fecha=substr($row[13],8,2).'/'.substr($row[13],5,2).'/'.substr($row[13],0,4);
				$_POST[txtFechaInicio]=$fecha;
				$fecha=substr($row[14],8,2).'/'.substr($row[14],5,2).'/'.substr($row[14],0,4);
				$_POST[txtFechaFinal]=$fecha;
			}
		}
		}		
	
	if (isset($_POST[txtFicha]) && !empty($_POST[txtFicha])) {
		$usuarioAsignacion= new usuario($_POST[txtFicha]);
		$resultado5= $usuarioAsignacion->retornaUsuario();
		if ($resultado5 && $resultado5!=1) {
			$row5=mysql_fetch_array($resultado5);
			$_POST[txtNombres]=$row5[2];
			$_POST[txtCargo]=$row5[4];
			$_POST[txtExtension]=$row5[14];
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
	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">ASIGNACION DE EQUIPOS</td>
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
			echo "</tr>";
			echo "<tr>
		
			<td valign=top class=\"formularioCampoTitulo\">UBICACION:<br>$selSitio<br>
			DIVISION<br>$selDivision<br>
		
			<td valign=top class=\"formularioCampoTitulo\">GERENCIA<br>$selGerencia<br>
			DEPARTAMENTO<br>$selDepartamento<br>";
			echo "</tr>";

	echo "</table>";
	
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";



			echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\"  colspan=\"2\">DATOS DEL EQUIPO</td>
			</tr>";
			echo "<tr>
				<td valign=top class=\"formularioCampoTitulo\">CONFIGURACION:<br><input class=\"formularioCampoTexto\" name=\"txtConfiguracion\" type=\"text\" value=\"$_POST[txtConfiguracion]\" onKeyPress=\"if (event.keyCode==13) buscarConfiguracion();\">
				<input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"C\" onclick=\"buscarConfiguracion()\" ><br>
				SERIAL:<br><input class=\"formularioCampoTexto\" name=\"txtSerial\" type=\"text\" value=\"$_POST[txtSerial]\" readonly=\"true\"><br>
				MARCA:<br><input class=\"formularioCampoTexto\" name=\"txtMarca\" type=\"text\" value=\"$_POST[txtMarca]\" readonly=\"true\"><br>
				</td>
				<td valign=top class=\"formularioCampoTitulo\">ACTIVO FIJO:<br><input class=\"formularioCampoTexto\" name=\"txtActivoFijo\" type=\"text\" value=\"$_POST[txtActivoFijo]\" readonly=\"true\"><br>
				DESCRIPCION:<br><input class=\"formularioCampoTexto\" name=\"txtDescripcion\" type=\"text\" value=\"$_POST[txtDescripcion]\" readonly=\"true\"><br>
				MODELO:<br><input class=\"formularioCampoTexto\" name=\"txtModelo\" type=\"text\" value=\"$_POST[txtModelo]\" readonly=\"true\"><br>
				</td>

			</tr>";
		echo "</table><BR>";
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
	echo "<tr>
			<td class=\"formularioTablaTitulo\" colspan=\"5\">COMPONENTES ASOCIADOS</td>
		</tr>";


	if ($resultado4 && $resultado4!=1) {
		echo "<tr valign=top class=\"tablaTitulo\">
			<td align=\"left\" class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
			<td valign=top class=\"tablaTitulo\">MARCA</td>
			<td valign=top class=\"tablaTitulo\">MODELO</td>
			<td valign=top class=\"tablaTitulo\">SERIAL</td>
			</tr>";
			while ($row=mysql_fetch_array($resultado4)) {
				if ($i%2==0) {
					$clase="tablaFilaPar";
				} else {
					$clase="tablaFilaNone";
				}
				echo "<tr class=\"$clase\">
					<td align=\"left\">$row[0]</td>
					<td>$row[1]</td>
					<td>$row[2]</td>
					<td>$row[3]</td>";
				echo "</tr>";
				$i++;
			}
	   } else {
		echo "<tr class=\"$clase\">
					<td align=\"center\" colspan=\"5\">LISTA NO DISPONIBLE</td>";
		echo "</tr>";	
	}
	echo "<tr>
			<td class=\"formularioTablaTitulo\" colspan=\"5\">CONFIGURACION:</td>
		</tr>";
	echo "<tr>
			<td class=\"tablaTitulo\" align=\"center\" colspan=\"5\">CORREO:<select name=\"selCorreo\" class=\"formularioSeleccion\"><option>NO</option><option>SI</option></select>
			&nbsp;&nbsp;INTERNET:<select name=\"selInternet\" class=\"formularioSeleccion\"><option>NO</option><option>SI</option></select>
			&nbsp;&nbsp;IMPRESORAS:<select name=\"selImpresoras\" class=\"formularioSeleccion\"><option>NO</option><option>SI</option></select>
			&nbsp;&nbsp;MANUALES:<select name=\"selManuales\" class=\"formularioSeleccion\"><option>NO</option><option>SI</option></select></td>
		</tr>";
	echo "<tr>
			<td class=\"formularioTablaTitulo\" colspan=\"5\">CONDICIONES AMBIENTALES DEL AREA DE OPERACION</td>
		</tr>";
	echo "<tr>
			<td class=\"tablaTitulo\" align=\"center\" colspan=\"5\">HUMEDAD:<select name=\"selHumedad\" class=\"formularioSeleccion\"><option>NO</option><option>SI</option></select>
			&nbsp;&nbsp;PARTICULAS DE POLVO:<select name=\"selParticulas\" class=\"formularioSeleccion\"><option>NO</option><option>SI</option></select>
			&nbsp;&nbsp;AIRE ACONDICIONADO:<select name=\"selAire\" class=\"formularioSeleccion\"><option>NO</option><option>SI</option></select></td>
		</tr>";

	echo "<tr>
			<td class=\"tablaTitulo\" align=\"center\" colspan=\"5\">OBSERVACION:
			<textarea class=\"formularioAreaTextoPlanilla\" name=\"txtObservacion\" cols=\"500\" rows=\"1\">$_POST[txtObservacion]</textarea></td>
		</tr>";
echo "<tr>
			<td class=\"tablaTitulo\" align=\"center\" colspan=\"5\">TRABAJO REALIZADO:
			<textarea class=\"formularioAreaTextoPlanilla\" name=\"txtTrabajo\" cols=\"500\" rows=\"1\">$_POST[txtTrabajo]</textarea></td>
		</tr>";
	echo "<tr>
			<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"5\"><input name=\"btnPlanilla\" type=\"button\" value=\"GENERAR PLANILLA\" onclick=\"generar()\"></td>
		</tr>";	
	echo "</table>";
		
	echo "</form>";
}
?>

