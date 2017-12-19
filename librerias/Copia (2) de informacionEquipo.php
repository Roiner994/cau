<?php
session_start();
$Acceso=array ("PRV0000001");
switch ($_SESSION['authUser']) {
	case '0':
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
		</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>SITIO RESTRINGIDO. NO PUEDE ENTRAR AL SISTEMA</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
		echo "</tr>";
		echo "</table>";
		exit();
		break 1;
	case '1':
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
		</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>SISTEMA DEL CENTRO DE ATENCI&Oacute;N A USUARIO. SISTRIO RESTRINGIDO</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
		echo "</tr>";
		echo "</table>";
		exit();
		break 1;
	default:
	require_once  "../librerias/usuarioSistemaAdmin.php";
	require_once "../librerias/conexionsql.php";
	$acceso= new usuarioSistema("",$_SESSION['userName'],$_SESSION['userPass']);
	$resultado= $acceso->validar();
	switch ($resultado) {
		case 1:
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>CLAVE INCORRECTA. NO PUEDE ENTRAR A LA P&Aacute;GINA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";
			exit();
			break 1;
		case 2:
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";
			exit();
			break 1;
		default:
			foreach($Acceso as $valor) {
				if ($_SESSION['authUser']!=$valor) {
					$sw=1;
				} else {
					$sw=0;
					break 1;
				}
			}
			if ($sw==1) {
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>DISCULPE,USTED NO TIENE SUFUCIENTE PRIVILEGIO PARA ENTRAR A ESTE SITIO</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";
				exit();
			}
	}
}

?>
<script language="javascript">
	function actualizarUbicacion() {
		if (document.frmEquipo.txtSitio.value!="") {
			location.href="secciones.php?item=136";
		}
	}
	function buscarConfiguracion() {
		if (document.frmEquipo.txtConfiguracion.value!="") {
			document.frmEquipo.funcion.value=2;
			document.frmEquipo.submit();
		} else {
			document.frmEquipo.funcion.value=0;
			document.frmEquipo.submit();
		}
	}

</script>
<?php
switch ($funcion) {
	case 1:
		break 1;
	case 2:
		$configuracion=$_POST[txtConfiguracion];
		$_SESSION['configuracion']=$configuracion;
		$_SESSION['pagina']="componentesAsociar.php";
		equipoComponentes($configuracion);
		break 1;
	case 3:
		require_once "administracion.php";
		require_once "usuarioSistemaAdmin.php";
		require_once "equipoAdmin.php";
		require_once "conexionsql.php";
	
		$configuracion=$_SESSION['configuracion'];
		//$_SESSION['configuracion']=$configuracion;
		
		$equipo= new equipo($_POST[txtConfiguracion],$_POST[txtActivoFijo],"",$_POST[txtSerial],$_POST[selDescripcion],$_POST[selMarca],$_POST[selModelo],
		$_POST[txtCt],$_POST[txtFru],$_POST[txtSpareNumber],$_POST[txtProductNumber],
		$_POST[selEstado],"",$_POST[selPedido],$_POST[txtFechaInicio],$_POST[txtFechaFinal],"","",
		$_POST[selGerencia],$_POST[selDivision],$_POST[selDepartamento],$_POST[selSitio],"","","","",$login,
		"","");
		$_SESSION[idInventario]=$equipo->retornarIdInventario();
		
		$_POST[txtConfiguracion]=$configuracion;
		$_SESSION['pagina']="componentesAsociar.php";
		equipoComponentes($configuracion);
		break 1;
	case 4:
		$configuracion=$_SESSION['configuracion'];
		$equipo= new equipo($configuracion);
		$_SESSION[idInventario]=$equipo->retornarIdInventario();
		break 1;
	default:
		equipoComponentes();
}

function equipoComponentes($configuracion="") {
		require_once "equipoAdmin.php";
		require_once "conexionsql.php";
		require_once "formularios.php";
	if (isset($configuracion) && !empty($configuracion)) {	
		$equipo= new equipo($configuracion);	
		$resultado=$equipo->retornarEquipoCampo();
		if ($resultado && $resultado!=1) {
			$row=mysql_fetch_array($resultado);
			$_SESSION['idInventario']=$row[2];
		}
		$resultado2=$equipo->retornarEquipoUbicacion();
		if ($resultado2 && $resultado2!=1) {
			$row2=mysql_fetch_array($resultado2);
		}
		$resultado3=$equipo->retornarEquipoUsuario();
		if ($resultado3 && $resultado3!=1) {
			$row3=mysql_fetch_array($resultado3);	
		}
	}

	$conSitio="select id_sitio,sitio from sitio where status_activo=1 order by sitio";
	$conGerencia="select id_gerencia,gerencia from gerencia where status_activo=1 order by gerencia";
	$conDivision="select id_division,division from division where id_gerencia='$_POST[selGerencia]' and status_activo=1 order by division";
	$conDepartamento="select id_departamento, departamento from departamento where id_division='$_POST[selDivision]' and status_activo=1 ORDER BY departamento";
	$conAnalista="select usuario_sistema.id_uss,concat(usuario_sistema.nombre,' ',usuario_sistema.apellido) as nombres from usuario_sistema order by nombres";
	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--UBICACION--","");
	$selSitio=$sitio->retornar();

	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","cambiarSeleccion()",$conGerencia,"--GERENCIA--","");
	$selGerencia=$gerencia->retornar();		

	$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","cambiarSeleccion()",$conDivision,"--DIVISION--","");
	$selDivision=$division->retornar();

	$departamento= new campoSeleccion("selDepartamento","formularioCampoSeleccion","$_POST[selDepartamento]","onChange","cambiarSeleccion()",$conDepartamento,"--DEPARTAMENTO--","");
	$selDepartamento=$departamento->retornar();	
		
//Equipos con sus Componentes Asociados
	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">EQUIPO - INFORMACI&Oacute;N</td>
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
			GERENCIA<br>$selGerencia<br>
		
			<td valign=top class=\"formularioCampoTitulo\">DIVISION<br>$selDivision<br>
			DEPARTAMENTO<br>$selDepartamento<br>";
			echo "</tr>";

			echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">DATOS DEL EQUIPO</td>
			<td class=\"formularioTablaTitulo\">DATOS DE UBICACION</td>
			</tr>";
			echo "<tr>
				<td valign=top class=\"formularioCampoTitulo\">CONFIGURACION:<br><input class=\"formularioCampoTexto\" name=\"txtConfiguracion\" type=\"text\" value=$_POST[txtConfiguracion]>
				<input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"C\" onclick=\"buscarConfiguracion()\" ><br>
				ACTIVO FIJO:<br><input class=\"formularioCampoTexto\" name=\"txtActivoFijo\" type=\"text\" value=\"$row[1]\" readonly=\"true\"><br>
				DESCRIPCION:<br><input class=\"formularioCampoTexto\" name=\"txtDescripcion\" type=\"text\" value=\"$row[5]\" readonly=\"true\"><br>
				MARCA:<br><input class=\"formularioCampoTexto\" name=\"txtMarca\" type=\"text\" value=\"$row[7]\" readonly=\"true\"><br>
				MODELO:<br><input class=\"formularioCampoTexto\" name=\"txtModelo\" type=\"text\" value=\"$row[9]\" readonly=\"true\"><br>
				SERIAL:<br><input class=\"formularioCampoTexto\" name=\"txtSerial\" type=\"text\" value=\"$row[3]\" readonly=\"true\"><br></td>
				
				<td valign=top class=\"formularioCampoTitulo\">SITIO:<br><input class=\"formularioCampoTexto\" name=\"txtSitio\" type=\"text\" value=\"$row2[9]\" readonly=\"true\"><input name=\"btnActualizarUbicacion\" title=\"Actualizar\" type=\"button\" value=\"A\" onclick=\"actualizarUbicacion()\"><br>
				GERENCIA:<br><input class=\"formularioCampoTexto\" name=\"txtGerencia\" type=\"text\" value=\"$row2[3]\" readonly=\"true\"><br>
				DIVISION:<br><input class=\"formularioCampoTexto\" name=\"txtDivision\" type=\"text\" value=\"$row2[5]\" readonly=\"true\"><br>
				DEPARTAMENTO:<br><input class=\"formularioCampoTexto\" name=\"txtDepartamento\" type=\"text\" value=\"$row2[7]\" readonly=\"true\"><br>
				</td>
			</tr>";
			echo "<tr>
				<td class=\"formularioTablaTitulo\">DATOS DEL USUARIO</td>
				<td class=\"formularioTablaTitulo\">MANTENIMIENTOS</td>
			</tr>";
			echo "<tr>
				<td class=\"formularioCampoTitulo\">FICHA:<br><input class=\"formularioCampoTexto\" name=\"txtFicha\" type=\"text\" value=\"$row3[2]\">
				<input name=\"btnActualizarUsuario\" title=\"Actualizar\" type=\"button\" value=\"A\"><br>
				NOMBRES:<br><input class=\"formularioCampoTexto\" name=\"txtNombres\" type=\"text\" value=\"$row3[3]\" readonly=\"true\"><br>
				CARGO:<br><input class=\"formularioCampoTexto\" name=\"txtCargo\" type=\"text\" value=\"$row3[5]\" readonly=\"true\"><br>
				EXTENSION:<br><input class=\"formularioCampoTexto\" name=\"txtCargo\" type=\"text\" value=\"$row3[14]\" readonly=\"true\"><br>
				</td>
				<td class=\"formularioCampoTitulo\" valign=top>PREVENTIVO:<br><input class=\"formularioCampoTexto\" name=\"txtPreventivo\" type=\"text\" value=\"NO DISPONIBLE\" readonly=\"true\"><br>
				CORRECTIVO:<br><input class=\"formularioCampoTexto\" name=\"txtCorrectivo\" type=\"text\" value=\"NO DISPONIBLE\" readonly=\"true\"><br>
				</td>
			</tr>";
		echo "</table>";
	echo "</form>";

	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
	echo "<tr>
			<td class=\"formularioTablaTitulo\" colspan=\"5\">COMPONENTES ASOCIADOS</td>
		</tr>";
	if ($resultado2 && $resultado2!=1) {
		$resultado3=$equipo->retornarComponenteAsociados();
	}
	
	if ($resultado3 && $resultado3!=1) {
		$num=mysql_num_rows($resultado3);
		if ($num>0) {
		echo "<tr valign=top class=\"tablaTitulo\">
			<td align=\"left\" class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
			<td valign=top class=\"tablaTitulo\">MARCA</td>
			<td valign=top class=\"tablaTitulo\">MODELO</td>
			<td valign=top class=\"tablaTitulo\">SERIAL</td>
			<td valign=top class=\"tablaTitulo\">ACCI&Oacute;N</td>
			</tr>";
			while ($row=mysql_fetch_array($resultado3)) {
				if ($i%2==0) {
					$clase="tablaFilaPar";
				} else {
					$clase="tablaFilaNone";
				}
				echo "<tr class=\"$clase\">
					<td align=\"left\">$row[0]</td>
					<td>$row[1]</td>
					<td>$row[2]</td>
					<td>$row[3]</td>
					<td align=\"left\">
					<input name=\"btnInformComp\" type=\"button\" value=\"D\"></td>";
				echo "</tr>";
				$i++;
			}
	   } else {
		echo "<tr class=\"$clase\">
					<td align=\"center\" colspan=\"5\">LISTA NO DISPONIBLE</td>";
		echo "</tr>";	
	}
	} else {
		echo "<tr class=\"$clase\">
			<td align=\"center\" colspan=\"5\">LISTA NO DISPONIBLE</td>";
		echo "</tr>";	
	}
	echo "<tr>
		<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"5\"><input name=\"btnAsociar\" type=\"button\" value=\"ASOCIAR\" onclick=\"\">
		<input name=\"btnNuevoComponente\" type=\"button\" value=\"NUEVO COMPONENTE\" onclick=\"location.href='secciones.php?item=135'\">
		<INPUT TYPE=\"button\" NAME=\"printFrame\" VALUE=\"IMPRIMIR\" onClick=\"window.open('../librerias/xmlAsignacionEquipos.php?configuracion=$_POST[txtConfiguracion]')\"></td>
	</tr>";
	echo "</table>";
//onClick=\"parent.print()\">
}
?>