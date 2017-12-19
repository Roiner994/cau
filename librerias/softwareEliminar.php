<?php
//verificar SOFTWARE
require_once "formularios.php";
switch ($funcion) {

	case 1:
		
		if (isset($_POST[selSoftware]) && $_POST[selSoftware]==100) {
			echo "<form name=\"frmSoftware\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			echo "<input name=\"selSoftware\" type=\"hidden\" value=\"$_POST[selSoftware]\">";
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: ADMINCAU -ELIMINAR SOFTWARE</td>
			</tr>";	
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>SELECCIONE UN SOFTWARE</td>";
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
		formularioSoftwareEliminar() ;
		break 1;
	default:
		formularioSoftwareEliminar() ;
}
	
	switch ($i) {
				case 1:
					require_once "administracion.php";
					require_once "conexionsql.php";
					require_once "softwareAdmin.php";
					$user= new software("","","",$_POST[selSoftware]);
					
					$resultado=$user-> eliminarSoftware();
					
					switch($resultado) {
						
						case 0:
							echo "<form name=\"frmSoftware\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"selSoftware\" type=\"hidden\" value=\"$_POST[selSoftware]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - ELIMINAR SOTFWARE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE ELIMINO SOFTWARE </td>";
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
//FORMULARIO SELECCIONAR MODIFICAR SOFTWARE
function formularioSoftwareEliminar() {
require_once "conexionsql.php";
require_once "formularios.php";
$conSoftware= "SELECT ID_SOFTWARE,SOFTWARE from software WHERE ESTATUS_ACTIVO = '1' ORDER BY software ASC";
	//Campo  tipo de software
	$software= new campoSeleccion("selSoftware","formularioCampoSeleccion","$_POST[selSoftware]","onChange","",$conSoftware,"--SELECCIONE--","");
	$selSoftware=$software->retornar();

echo "<form name=\"frmSoftware\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"selSoftware\" type=\"hidden\" value=\"$_POST[selSoftware]\">";

	echo "<table class=\"formularioTabla\"align=center width=\"100\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">ELIMINAR SOFTWARE</td>
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr><tr align=center><td valign=top class=\"formularioCampoTitulo\" ><p align=center >SOFTWARE<br>$selSoftware<br></tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"submit\" value=\"ELIMINAR\">
			</td>
  		</tr>";
echo "</table>";
echo "</form>";					
} 
?>