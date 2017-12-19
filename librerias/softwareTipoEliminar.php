<?php
//verificar marca
require_once "formularios.php";
switch ($funcion) {

	case 1:
		
		if (isset($_POST[selTipoSoftware]) && $_POST[selTipoSoftware]==100) {
			echo "<form name=\"frmSoftware\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR TIPO DE SOFTWARE</td>
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
					
			$i++;
		}
		break 1;
	case 2:
		formularioSoftwareModificar();
		break 1;
	default:
		formularioSoftwareModificar();
}
	
	switch ($i) {
				case 1:
					require_once "administracion.php";
					require_once "conexionsql.php";
					require_once "softwareAdmin.php";
					$user= new software($_POST[selTipoSoftware]);
					
					$resultado=$user-> eliminarTipoSoftware();
					
					switch($resultado) {
						
						case 0:
							echo "<form name=\"frmSoftware\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - ELIMINAR TIPO DE SOTFWARE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE ELIMINO TIPO DE SOFTWARE </td>";
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
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">ELIMINAR TIPO DE SOFTWARE</td>
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr><tr align=center><td valign=top class=\"formularioCampoTitulo\" ><p align=center >TIPO DE SOFTWARE<br>$selTipoSoftware<br></tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"submit\" value=\"ELIMINAR\">
			</td>
  		</tr>";
echo "</table>";
echo "</form>";					
} 
?>