<?php
require_once("../librerias/seguridad.php");
?>
<?php
switch ($funcion) {
	case 1:
		if ($_POST[txtNuevo]==$_POST[txtConfirmacion]) {
			require_once  "usuarioSistemaAdmin.php";
			require_once "conexionsql.php";
			if (!empty($_POST[txtNuevo])) {
				$acceso= new usuarioSistema("",$_POST[txtUser],$_POST[txtNuevo]);
				$resultado=$acceso->cambiarClave();
				switch ($resultado) {
					case 0:
						echo "<form name=\"frmCambioPassword\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";				
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: CAMBIO DE PASSWORD</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>SE CAMBIO SU PASSWORD EXITOSAMENTE</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>
						<input name=\"btnAceptar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php'\">
						</td>";
						echo "</tr>";
						echo "</table>";						
						echo "</form>";	

						break 1;
					case 1:
						echo "<form name=\"frmCambioPassword\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";				
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: CAMBIO DE PASSWORD</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>NO SE PUDO CAMBIAR EL PASSWORD</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>
						<input name=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\">
						</td>";
						echo "</tr>";
						echo "</table>";						
						echo "</form>";
						break 1;
					}
			} else {
				echo "<form name=\"frmCambioPassword\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";				
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: CAMBIO DE PASSWORD</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>NO SE PUDO CAMBIAR EL PASSWORD. LOS CAMPOS EST&Aacute;N VAC&Iacute;O</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>
				<input name=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\">
				</td>";
				echo "</tr>";
				echo "</table>";						
				echo "</form>";				
			}
		} else {
				echo "<form name=\"frmCambioPassword\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";				
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: CAMBIO DE PASSWORD</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>NO SE PUDO CAMBIAR EL PASSWORD. LA CLAVE DE CONFIRMACION NO COINCIDE CON LA NUEVA CLAVE</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>
				<input name=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\">
				</td>";
				echo "</tr>";
				echo "</table>";						
				echo "</form>";				
		}
			break 1;
	case 2:
		cambiarPassword();
		break 1;
	default:
		cambiarPassword();
}
function cambiarPassword() {
	require_once "formularios.php";
	require_once ("usuarioSistemaAdmin.php");
	$login=$_SESSION["login"];
	$usuario= new usuarioSistema($login);
	$resultado=$usuario->retornarUsuario();
	if ($resultado && $resultado!=1) {
		$row=mysql_fetch_array($resultado);
		$_POST[txtUser]=$row[3];	
	}
	$password= new campo("txtNuevo","password","$clase","$_POST[txtNuevo]","30","30","","");
	$txtPassword=$password->retornar();
	$confirmacion= new campo("txtConfirmacion","password","$clase","$_POST[txtConfirmacion]","30","30","","");
	$txtConfirmacion=$confirmacion->retornar();
	echo "<form name=\"frmCambioPassword\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"400\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\">USUARIO SISTEMA - CAMBIAR PASSWORD</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">DATOS DEL USUARIO</td>
  				</tr>";
		echo "<tr>";
			echo "<td valign=top class=\"formularioCampoTitulo\">LOGIN:<br><input name=\"txtUser\" type=\"text\" value=\"$_POST[txtUser]\" readonly=\"true\"><br></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td valign=top class=\"formularioCampoTitulo\">NUEVO PASSWORD:<br>$txtPassword<br></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td valign=top class=\"formularioCampoTitulo\">CONFIRMAR PASSWORD:<br>$txtConfirmacion<br></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td valign=top class=\"formularioTablaBotones\"><input name=\"btn\" type=\"submit\" value=\"ACEPTAR\"></td>";
		echo "</tr>";
		echo "</table>";
	echo "</form>";
}
?>