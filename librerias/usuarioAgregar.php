<script>
	function cambiarSeleccion() {
		document.frmUsuario.funcion.value=2;
		document.frmUsuario.submit();
	}

</script>
<?php
//Modulo Usuario Agregar
require_once "formularios.php";
switch($funcion) {
		case '1':
			$sw=0;
			$mensaje="";
			if (isset($_POST[txtFicha]) && empty($_POST[txtFicha])) {
				if ($sw==1) {
					$mensaje=$mensaje."<b>,</b>";
				}
				$mensaje=$mensaje." <b>FICHA</b>";
				$i++;
				$sw=1;  
			}
			if (isset($_POST[txtCedula]) && empty($_POST[txtCedula])) {
				if ($sw==1) {
					$mensaje=$mensaje."<b>,</b>";
				}
				$mensaje=$mensaje." <b>CEDULA</b>";
				$i++;
				$sw=1;
			}
			if (isset($_POST[txtNombres])  && empty($_POST[txtNombres])) {
				if ($sw==1) {
					$mensaje=$mensaje."<b>,</b>";
				}
				$mensaje=$mensaje." <b>NOMBRES</b>";
				$i++;
				$sw=1;
			}
			if (isset($_POST[txtApellidos])  && empty($_POST[txtApellidos])) {
				if ($sw==1) {
					$mensaje=$mensaje."<b>,</b>";
				}
				$mensaje=$mensaje." <b>APELLIDO</b>";
				$i++;
				$sw=1;
			}
			if (isset($_POST[selCargo]) && $_POST[selCargo]==100) {
				if ($sw==1) {
					$mensaje=$mensaje."<b>,</b>";
				}
				$mensaje=$mensaje." <b>CARGO</b>";
				$i++;
				$sw=1;
			}
			if (isset($_POST[selSitio]) && $_POST[selSitio]==100) {
				if ($sw==1) {
					$mensaje=$mensaje."<b>,</b>";
				}
				$mensaje=$mensaje." <b>UBICACION</b>";
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
			if (isset($_POST[txtEmail])  && empty($_POST[txtEmail])) {
				if ($sw==1) {
					$mensaje=$mensaje."<b>,</b>";
				}
				$mensaje=$mensaje." <b>CORREO</b>";
				$i++;
				$sw=1;
			}

			switch ($i) {
				case 0:
					require_once "administracion.php";
					require_once "conexionsql.php";
					require_once "usuarioAdmin.php";
					$user= new usuario($_POST[txtFicha],$_POST[txtCedula],$_POST[txtNombres],$_POST[txtApellidos],$_POST[selCargo],$_POST[selGerencia],$_POST[selDivision],$_POST[selDepartamento],$_POST[selSitio],$_POST[txtExtension],"","",$_POST[txtEmail]);
					$resultado=$user->ingresar();
					switch($resultado) {
						case 1:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtFicha]\">";
							echo "<input name=\"txtCedula\" type=\"hidden\" value=\"$_POST[txtCedula]\">";
							echo "<input name=\"txtNombres\" type=\"hidden\" value=\"$_POST[txtNombres]\">";
							echo "<input name=\"txtApellidos\" type=\"hidden\" value=\"$_POST[txtApellidos]\">";
							echo "<input name=\"selCargo\" type=\"hidden\" value=\"$_POST[selCargo]\">";
							echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
							echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
							echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
							echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
							echo "<input name=\"txtExtension\" type=\"hidden\" value=\"$_POST[txtExtension]\">";
							echo "<input name=\"txtEmail\" type=\"hidden\" value=\"$_POST[txtEmail]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - NUEVO USUARIO</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR, CEDULA DUPLICADA</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>
							<input name=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\">
							</td>";
							echo "</tr>";
							echo "</table>";						
							echo "</form>";	
							break 1;
						case 2:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtFicha]\">";
							echo "<input name=\"txtCedula\" type=\"hidden\" value=\"$_POST[txtCedula]\">";
							echo "<input name=\"txtNombres\" type=\"hidden\" value=\"$_POST[txtNombres]\">";
							echo "<input name=\"txtApellidos\" type=\"hidden\" value=\"$_POST[txtApellidos]\">";
							echo "<input name=\"selCargo\" type=\"hidden\" value=\"$_POST[selCargo]\">";
							echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
							echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
							echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
							echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
							echo "<input name=\"txtExtension\" type=\"hidden\" value=\"$_POST[txtExtension]\">";
							echo "<input name=\"txtEmail\" type=\"hidden\" value=\"$_POST[txtEmail]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - NUEVO USUARIO</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR, FICHA DUPLICADA</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>
							<input name=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\">
							</td>";
							echo "</tr>";
							echo "</table>";						
							echo "</form>";	
							break 1;
						case 0:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"txtFicha\" type=\"hidden\" value=\"\">";
							echo "<input name=\"txtCedula\" type=\"hidden\" value=\"\">";
							echo "<input name=\"txtNombres\" type=\"hidden\" value=\"\">";
							echo "<input name=\"txtApellidos\" type=\"hidden\" value=\"\">";
							echo "<input name=\"selCargo\" type=\"hidden\" value=\"\">";
							echo "<input name=\"selSitio\" type=\"hidden\" value=\"\">";
							echo "<input name=\"selGerencia\" type=\"hidden\" value=\"\">";
							echo "<input name=\"selDivision\" type=\"hidden\" value=\"\">";
							echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"\">";
							echo "<input name=\"selExtension\" type=\"hidden\" value=\"\">";
							echo "<input name=\"txtEmail\" type=\"hidden\" value=\"\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - NUEVO USUARIO</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO EL NUEVO USUARIO</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>
							<input name=\"btnSalir\" type=\"button\" value=\"SALIR\" onclick=\"location.href='index2.php?item=1000'\">
							</td>";
							echo "</tr>";
							echo "</table>";						
							echo "</form>";	
							break 1;
						case 3:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"txtFicha\" type=\"hidden\" value=\"\">";
							echo "<input name=\"txtCedula\" type=\"hidden\" value=\"\">";
							echo "<input name=\"txtNombres\" type=\"hidden\" value=\"\">";
							echo "<input name=\"txtApellidos\" type=\"hidden\" value=\"\">";
							echo "<input name=\"selCargo\" type=\"hidden\" value=\"\">";
							echo "<input name=\"selSitio\" type=\"hidden\" value=\"\">";
							echo "<input name=\"selGerencia\" type=\"hidden\" value=\"\">";
							echo "<input name=\"selDivision\" type=\"hidden\" value=\"\">";
							echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"\">";
							echo "<input name=\"selExtension\" type=\"hidden\" value=\"\">";
							echo "<input name=\"txtEmail\" type=\"hidden\" value=\"\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - NUEVO USUARIO</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR EL USUARIO</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>
							<input name=\"btnSalir\" type=\"button\" value=\"SALIR\" onclick=\"location.href='index2.php?item=1000'\">
							</td>";
							echo "</tr>";
							echo "</table>";						
							echo "</form>";	
							break 1;
					}
					break 1;
				case 1:
					echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
					echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtFicha]\">";
					echo "<input name=\"txtCedula\" type=\"hidden\" value=\"$_POST[txtCedula]\">";
					echo "<input name=\"txtNombres\" type=\"hidden\" value=\"$_POST[txtNombres]\">";
					echo "<input name=\"txtApellidos\" type=\"hidden\" value=\"$_POST[txtApellidos]\">";
					echo "<input name=\"selCargo\" type=\"hidden\" value=\"$_POST[selCargo]\">";
					echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
					echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
					echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
					echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
					echo "<input name=\"txtExtension\" type=\"hidden\" value=\"$_POST[txtExtension]\">";
					echo "<input name=\"txtEmail\" type=\"hidden\" value=\"$_POST[txtEmail]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVO USUARIO</td>
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
					echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
					echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtFicha]\">";
					echo "<input name=\"txtCedula\" type=\"hidden\" value=\"$_POST[txtCedula]\">";
					echo "<input name=\"txtNombres\" type=\"hidden\" value=\"$_POST[txtNombres]\">";
					echo "<input name=\"txtApellidos\" type=\"hidden\" value=\"$_POST[txtApellidos]\">";
					echo "<input name=\"selCargo\" type=\"hidden\" value=\"$_POST[selCargo]\">";
					echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
					echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
					echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
					echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
					echo "<input name=\"txtExtension\" type=\"hidden\" value=\"$_POST[txtExtension]\">";
					echo "<input name=\"txtEmail\" type=\"hidden\" value=\"$_POST[txtEmail]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVO USUARIO</td>
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
				frmUsuario();
				break 1;
		default:
			frmUsuario();
	}
//Formulario para Agregar un Nuevo Usuario
	function frmUsuario() {
	if (isset($_POST[selGerencia]) && $_POST[selGerencia]==100) {
			$_POST[selDivision]=100;
			$_POST[selDepartamento]=100;
	}
	require_once "conexionsql.php";
		$conCargo="select id_cargo,cargo from cargo where status_activo=1 order by cargo ";
		$conSitio="select id_sitio,sitio from sitio where status_activo=1 order by sitio";
		$conGerencia="select id_gerencia,gerencia from gerencia where status_activo=1 order by gerencia";
		$conDivision="select id_division,division from division where id_gerencia='$_POST[selGerencia]' and status_activo=1 order by division";
		$conDepartamento="select id_departamento, departamento from departamento where id_division='$_POST[selDivision]' and status_activo=1 ORDER BY departamento";

		$ficha= new campo("txtFicha","text","formularioCampoTexto","$_POST[txtFicha]","8","8","onKeyPress","if (event.keyCode > 47 && event.keyCode > 58) event.returnValue = false;");
		$txtFicha=$ficha->retornar();

		$cedula= new campo("txtCedula","text","formularioCampoTexto","$_POST[txtCedula]","8","8","onKeyPress","if (event.keyCode > 47 && event.keyCode > 58) event.returnValue = false;");
		$txtCedula=$cedula->retornar();

		$nombres= new campo("txtNombres","text","formularioCampoTexto","$_POST[txtNombres]","30","30");
		$txtNombres=$nombres->retornar();

		$apellidos= new campo("txtApellidos","text","formularioCampoTexto","$_POST[txtApellidos]","30","30");
		$txtApellidos=$apellidos->retornar();

		$cargo= new campoSeleccion("selCargo","formularioCampoSeleccion","$_POST[selCargo]","","",$conCargo,"--CARGO--","");
		$selCargo=$cargo->retornar();

		$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--UBICACION--","");
		$selSitio=$sitio->retornar();

		$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","cambiarSeleccion()",$conGerencia,"--GERENCIA--","");
		$selGerencia=$gerencia->retornar();		

		$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","cambiarSeleccion()",$conDivision,"--DIVISION--","");
		$selDivision=$division->retornar();

		$departamento= new campoSeleccion("selDepartamento","formularioCampoSeleccion","$_POST[selDepartamento]","onChange","cambiarSeleccion()",$conDepartamento,"--DEPARTAMENTO--","");
		$selDepartamento=$departamento->retornar();		

		$extension= new campo("txtExtension","text","formularioCampoTexto","$_POST[txtExtension]","30","30");
		$txtExtension=$extension->retornar();
		
		$email= new campo("txtEmail","text","formularioCampoTexto","$_POST[txtEmail]","30","50");
		$txtEmail=$email->retornar();
		
	echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";

	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">ADMINCAU - NUEVO USUARIO</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">DATOS DEL USUARIO</td>
  				</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">FICHA<br>
			$txtFicha<br>
			CEDULA<br>$txtCedula<br>
			NOMBRES<br>$txtNombres<br>
			APELLIDOS<br>$txtApellidos<br>
			CARGO<br>$selCargo<br>
			UBICACION<br>$selSitio<br>
			GERENCIA<br>$selGerencia<br>
			DIVISION<br>$selDivision<br>
			DEPARTAMENTO<br>$selDepartamento<br>
			EXTENSION<br>$txtExtension<br>
			CORREO<br>$txtEmail<br>
			</td>
		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=23'\">
			<input name=\"btnGuardar\" type=\"submit\" value=\"GUARDAR\"></td>
  				</tr>";
	echo "</table>";
	echo "</form>";	
	
	}
?>
