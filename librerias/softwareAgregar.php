<?php
//AGREGAR TIPO SOFTWARE

require_once "formularios.php";

switch($funcion) {
		case '1':
			$sw=0;
			$mensaje="";
			if (isset($_POST[txtSoftware]) && empty($_POST[txtSoftware])) {
				if ($sw==1) {
					$mensaje=$mensaje."<b>,</b>";
				}
				$mensaje=$mensaje." <b>SOFTWARE</b>";
				$i++;
				$sw=1; 
		 }
			 if (isset($_POST[selTipoSoftware]) && $_POST[selTipoSoftware]==100) {
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
					
					$user= new software($_POST[selTipoSoftware],"","","",$_POST[txtSoftware],1);
					$resultado=$user->ingresarSoftware();
					switch($resultado) {
						case 1:
							echo "<form name=\"frmSoftware\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
							echo "<input name=\"txtSoftware\" type=\"hidden\" value=\"$_POST[txtSoftware]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - NUEVO  DE SOFTWARE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR, SOFWARE DUPLICADO</td>";
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
							echo "<form name=\"frmSoftware\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"txtSoftware\" type=\"hidden\" value=\"$_POST[txtSoftware]\">";
							echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
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
							<input name=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\">
							</td>";
							echo "</tr>";
							echo "</table>";						
							echo "</form>";	
							break 1;
							
				}
				break 1;
			    case 1:
					echo "<form name=\"frmSoftware\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
					echo "<input name=\"txtSoftware\" type=\"hidden\" value=\"$_POST[txtTipoSoftware]\">";
					echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVO SOFTWARE</td>
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
					echo "<form name=\"frmSoftware\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
					echo "<input name=\"txtSoftware\" type=\"hidden\" value=\"$_POST[txtSoftware]\">";
					echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVO SOFTWARE</td>
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
			formularioSoftware();
			break 1;
		default:
			formularioSoftware();
	}   			
?>

 <?php
//FORMULARIO INGRESAR MODELO
function formularioSoftware() {
	require_once "formularios.php";
	require_once "conexionsql.php";
	
	//CAMPO TIPO DE SOFTWARE		
	$conTipoSoftware= "SELECT ID_TIPO_SOFTWARE,TIPO_SOFTWARE from tipo_software WHERE STATUS_ACTIVO = '1' ORDER BY tipo_software ASC";
	$tipoSoftware= new campoSeleccion("selTipoSoftware","formularioCampoSeleccion","$_POST[selTipoSoftware]","onChange","",$conTipoSoftware,"--SELECCIONE--","");
	$selTipoSoftware=$tipoSoftware->retornar();
	
	//CAMPO SOFTWARE
	$conSoftware= "SELECT ID_SOFTWARE,SOFTWARE from software WHERE ESTATUS_ACTIVO = '1' ORDER BY software ASC";		
	echo "<form name=\"frmModelo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
	echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
	echo "<input name=\"txtSoftware\" type=\"hidden\" value=\"$_POST[txtSoftware]\">";	
	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">ADMINCAU - NUEVO SOFTWARE</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">INGRESAR SOFTWARE</td>
  				</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">TIPO DE SOFTWARE<br>
			$selTipoSoftware<br>			
			SOFTWARE<br><textarea name=\"txtSoftware\" cols=\"35\" rows=\"3\"></textarea><br></td>
		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=140'\"><input name=\"Limpiar\" type=\"submit\" value=\"GUARDAR\"></td>
  				</tr>";
				/*echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=140'\"></td>
  				
			</tr>";*/
	echo "</table>";
	echo "</form>";	
}
?>
