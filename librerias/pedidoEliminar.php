<?php
//VERIFICAR PEDIDO
require_once "formularios.php";
switch ($funcion) {

	case 1:
		
		if (isset($_POST[selPedido]) && $_POST[selPedido]==100) {
			echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: INVENTARIO - ELIMINAR PEDIDO</td>
			</tr>";	
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>SELECCIONE UN PEDIDO</td>";
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
		formularioSeleccionarPedido();
		break 1;
	default:
		formularioSeleccionarPedido();
}
	
	switch ($i) {
				case 1:
					require_once "administracion.php";
					require_once "conexionsql.php";
					require_once "pedidoAdmin.php";
					$user= new pedido($_POST[selPedido]);
					
					$resultado=$user-> eliminarPedido();
					
					switch($resultado) {
						
						case 0:
							echo "<form name=\"frmPedid\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"selPedido\" type=\"hidden\" value=\"\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - ELIMINAR PEDIDO</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE ELIMINO PEDIDO </td>";
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
//FORMULARIO SELECCIONAR 
function formularioSeleccionarPedido() {
require_once "conexionsql.php";
require_once "formularios.php";
$conPedido= "SELECT ID_PEDIDO,ID_PEDIDO from pedido  ORDER BY ID_PEDIDO ASC";
	//CAMPO PEDIDO
	$pedido= new campoSeleccion("selPedido","formularioCampoSeleccion","$_POST[selPedido]","onChange","",$conPedido,"--PEDIDO--","");
	$selPedido=$pedido->retornar();

echo "<form name=\"frmPedido\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";

	echo "<table class=\"formularioTabla\"align=center width=\"100\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">ELIMINAR PEDIDO</td>
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
<tr align=center><td valign=top class=\"formularioCampoTitulo\" ><p align=center >PEDIDO<br>$selPedido<br></tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnModificar\" type=\"submit\" value=\"ELIMINAR\">
			</td>
  		</tr>";
echo "</table>";
echo "</form>";					
} 
?>

