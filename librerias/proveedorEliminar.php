<?php
//verificar marca
require_once "formularios.php";
switch ($funcion) {

	case 1:
		
		if (isset($_POST[selProveedor]) && $_POST[selProveedor]==100) {
			echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: INVENTARIO - ELIMINAR PROVEEDOR</td>
			</tr>";	
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>SELECCIONE UN PROVEEDOR</td>";
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
		formularioSeleccionarProveedor();
		break 1;
	default:
		formularioSeleccionarProveedor();
}
	
	switch ($i) {
				case 1:
					require_once "administracion.php";
					require_once "conexionsql.php";
					require_once "proveedorAdmin.php";
					$user= new proveedor($_POST[selProveedor]);
					
					$resultado=$user-> eliminarProveedor();
					
					switch($resultado) {
						
						case 0:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"selProveedor\" type=\"hidden\" value=\"\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - ELIMINAR PROVEEDOR</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE ELIMINO PROVEEDOR </td>";
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
//FORMULARIO SELECCIONAR MARCA A ELIMINAR

function formularioSeleccionarProveedor() {
require_once "conexionsql.php";
require_once "formularios.php";
$conProveedor= "SELECT ID_PROVEEDOR,PROVEEDOR,CONTACTOS from proveedor WHERE STATUS_ACTIVO = '1' ORDER BY PROVEEDOR ASC";
	//Campo Proveedor
	$proveedor= new campoSeleccion("selProveedor","formularioCampoSeleccion","$_POST[selProveedor]","onChange","",$conProveedor,"--PROVEEDOR--","");
	$selProveedor=$proveedor->retornar();

echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";

	echo "<table class=\"formularioTabla\"align=center width=\"100\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">ELIMINAR PROVEEDOR</td>
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
<tr align=center><td valign=top class=\"formularioCampoTitulo\" ><p align=center >PROVEEDOR<br>$selProveedor<br></tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"submit\" value=\"ELIMINAR\">
			</td>
  		</tr>";
echo "</table>";
echo "</form>";					
} 
?>

