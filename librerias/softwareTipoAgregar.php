<?php
//AGREGAR TIPO SOFTWARE

require_once "formularios.php";

switch($funcion) {
		case '1':
			$sw=0;
			$mensaje="";
			if (isset($_POST[txtTipoSoftware]) && empty($_POST[txtTipoSoftware])) {
				if ($sw==1) {
					$mensaje=$mensaje."<b>,</b>";
				}
				$mensaje=$mensaje." <b>TIPO DE SOFTWARE</b>";
				$i++;
				$sw=1; 
		 }
		 switch ($i) {
				case 0:
					require_once "administracion.php";
					require_once "conexionsql.php";
					require_once "softwareAdmin.php";
					
					$user= new software("",$_POST[txtTipoSoftware],'1');
					$resultado=$user->ingresarTipoSoftware();
					switch($resultado) {
						case 1:
							echo "<form name=\"frmtipoSoftware\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"txtTipoSoftware\" type=\"hidden\" value=\"$_POST[txtTipoSoftware]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - NUEVO TIPO DE SOFTWARE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR, TIPO DE SOFWARE DUPLICADO</td>";
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
							echo "<form name=\"frmtipoSoftware\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"txtTipoSoftware\" type=\"hidden\" value=\"$_POST[txtTipoSoftware]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - NUEVO SOFTWARE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO NUEVO SOFTWARE</td>";
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
					echo "<form name=\"frmtipoSoftware\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
					echo "<input name=\"txtTipoSoftware\" type=\"hidden\" value=\"$_POST[txtTipoSoftware]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: INVENTARIO - NUEVA MARCA</td>
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
					echo "<form name=\"frmtipoSoftware\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
					echo "<input name=\"txtTipoSoftware\" type=\"hidden\" value=\"$_POST[txtTipoSoftware]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVO TIPO SOFTWARE</td>
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
			formularioTipoSoftware();
			break 1;
		default:
			formularioTipoSoftware();
	}   			
?>
<?php			
//FORMULARIO NUEVA MARCA
function formularioTipoSoftware() {
require_once "conexionsql.php";
require_once "formularios.php";
$conSoftware= "SELECT ID_TIPO_SOFTWARE,TIPO_SOFTWARE from tipo_software WHERE STATUS_ACTIVO = '1' ORDER BY tipo_software ASC";

	$tipoSoftware= new campo("txtTipoSoftware","text","$clase","$_POST[txtTipoSoftware]","30","30");
	$txtTipoSoftware=$tipoSoftware->retornar();	
	echo "<form name=\"frmtipoSoftware\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">TIPO SOFTWARE</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">NUEVO TIPO SOFTWARE</td>
  				</tr>
		<tr align center><td valign=top class=\"formularioCampoTitulo\">TIPO DE SOFTWARE<br>$txtTipoSoftware<br></td></tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\"><input name=\"btnmarca\" type=\"submit\" onClick=\"\" value=\"INGRESAR\"></td>
  				</tr>";
	echo "</table>";
	echo "</form>";	
	
    } 
?>