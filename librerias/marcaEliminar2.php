<?php
//verificar marca
require_once "formularios.php";
switch ($funcion) {

	case 1:
		
		if (isset($_POST[selMarca]) && $_POST[selMarca]==100) {
			echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtMarca]\">";
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR MARCA</td>
			</tr>";	
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>SELECCIONE UNA MARCA</td>";
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
		formularioMarcaModificar2();
		break 1;
	default:
		formularioMarcaModificar2();
}
	
	switch ($i) {
				case 1:
					require_once "administracion.php";
					require_once "conexionsql.php";
					require_once "marcaAdmin.php";
					$user= new marca($_POST[selMarca]);
					
					$resultado=$user-> marcaEliminar1();
					
					switch($resultado) {
						
						case 0:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"txtMarca\" type=\"hidden\" value=\"\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - ELIMINAR MARCA</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE ELIMINO MARCA </td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>
							<input name=\"btnSalir\" type=\"button\" value=\"SALIR\" onclick=\"location.href='secciones.php?item=1000'\">
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
function formularioMarcaModificar2() {
require_once "conexionsql.php";
require_once "formularios.php";
$conMarca= "SELECT ID_MARCA,MARCA from marca WHERE STATUS_ACTIVO = '1' ORDER BY MARCA ASC";
	//Campo Marca
	$marca= new campoSeleccion("selMarca","formularioCampoSeleccion","$_POST[selMarca]","onChange","",$conMarca,"--MARCA--","");
	$selMarca=$marca->retornar();

echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";

	echo "<table class=\"formularioTabla\"align=center width=\"100\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">ELIMINAR MARCA</td>
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
<tr align=center><td valign=top class=\"formularioCampoTitulo\" ><p align=center >MARCA<br>$selMarca<br></tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"submit\" value=\"ELIMINAR\">
			</td>
  		</tr>";
echo "</table>";
echo "</form>";					
} 
?>