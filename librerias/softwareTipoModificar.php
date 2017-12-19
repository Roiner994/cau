
<?php
//verificar TIPO DE SOFTWARE
require_once "formularios.php";
switch ($funcion) {

	case 1:
		
		if (isset($_POST[selTipoSoftware]) && $_POST[selTipoSoftware]==100) {
			echo "<form name=\"frmtipoSoftware\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
			echo "<input name=\"txtTipoSoftware\" type=\"hidden\" value=\"$_POST[txtTipoSoftware]\">";
			echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR SOFTWARE</td>
			</tr>";	
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>SELECCIONE UN TIPO DE SOFTWARE</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";	
			echo "</form>";	
		} else {
			formularioTipoSoftwareModificar();		
		}
		break 1;
	case 2:
		$sw=0;
		$mensaje="";
		if (isset($_POST[txtTipoSoftware]) && empty($_POST[txtTipoSoftware])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>MODIFICAR TIPO DE SOFTWARE</b>";
			$i++;
			$sw=1;
		}
	
	switch ($i) {
				case 0:
					require_once "administracion.php";
					require_once "conexionsql.php";
					require_once "softwareAdmin.php";					
					$user= new software($_POST[selTipoSoftware],$_POST[txtTipoSoftware]);
					$resultado=$user-> modificarTipoSoftware();
					switch($resultado) {
						case 2:
							echo "<form name=\"frmtipoSoftware\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
							echo "<input name=\"txtTipoSoftware\" type=\"hidden\" value=\"$_POST[txtTipoSoftware]\">";
							echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR TIPO DE SOFTWARE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR, TIPO DE SOFTWARE DUPLICADO</td>";
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
							echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
							echo "<input name=\"txtTipoSoftware\" type=\"hidden\" value=\"$_POST[txtTipoSoftware]\">";
							echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR TIPO DE SOFTWARE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE MODIFICO TIPO DE SOFTWARE</td>";
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
							echo "<form name=\"frmtipoSoftware\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
							echo "<input name=\"txtTipoSoftware\" type=\"hidden\" value=\"$_POST[txtTipoSoftware]\">";
							echo "<input name=\"selTipoSoftware\" type=\"text\" value=\"$_POST[selTipoSoftware]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMMINCAU - MODIFICAR TIPO DE SOFTWARE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE </td>";
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
					echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMMINCAU - MODIFICAR TIPO DE SOFTWARE</td>
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
					echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMMINCAU - MODIFICAR TIPO DE SOFTWARE</td>
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
	case 3:
		 formularioSoftwareModificar();
		break 1;
	default:
		 formularioSoftwareModificar();
}

?>

<?php
//FORMULARIO MODIFICAR TIPO DE SOFTWARE
function formularioTipoSoftwareModificar() {
require_once "conexionsql.php";
require_once "formularios.php";
$conSoftware= "SELECT ID_TIPO_SOFTWARE,TIPO_SOFTWARE from tipo_software WHERE ID_TIPO_SOFTWARE='$_POST[selTipoSoftware]' ";
conectarMysql();

$result= mysql_query($conSoftware);
$row=mysql_fetch_array($result);
$_POST[txtTipoSoftware]=$row[1];


	$tipoSoftware= new campo("txtTipoSoftware","text","$clase","$_POST[txtTipoSoftware]","30","30");
	$txtTipoSoftware=$tipoSoftware->retornar();	
	echo "<form name=\"frmtipoSoftware\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
	echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">ADMINCAU - TIPO SOFTWARE INGRESAR</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">MODIFICAR TIPO SOFTWARE</td>
  				</tr>
		<tr align center><td valign=top class=\"formularioCampoTitulo\">TIPO DE SOFTWARE<br>$txtTipoSoftware<br></td></tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\"><input name=\"btnmarca\" type=\"submit\" onClick=\"\" value=\"INGRESAR\"></td>
  				</tr>";
	echo "</table>";
	echo "</form>";	
	
    }
?>		 


<?php
//FORMULARIO SELECCIONAR MODIFICAR MARCA
function formularioSoftwareModificar() {
require_once "conexionsql.php";
require_once "formularios.php";
$conSoftware= "SELECT ID_TIPO_SOFTWARE,TIPO_SOFTWARE from tipo_software WHERE STATUS_ACTIVO = '1' ORDER BY tipo_software ASC";
	//Campo  tipo de software
	$tipoSoftware= new campoSeleccion("selTipoSoftware","formularioCampoSeleccion","$_POST[selTipoSoftware]","onChange","",$conSoftware,"--SELECCIONE--","");
	$selTipoSoftware=$tipoSoftware->retornar();

echo "<form name=\"frmSoftware\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";

	echo "<table class=\"formularioTabla\"align=center width=\"100\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">MODIFICAR TIPO DE SOFTWARE</td>
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr><tr align=center><td valign=top class=\"formularioCampoTitulo\" ><p align=center >TIPO DE SOFTWARE<br>$selTipoSoftware<br></tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"submit\" value=\"MODIFICAR\">
			</td>
  		</tr>";
echo "</table>";
echo "</form>";					
} 
?>