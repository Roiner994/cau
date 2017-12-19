<?php
switch($funcion) {
	case 1:
		if (isset($_POST[txtNumPedido]) && empty($_POST[txtNumPedido])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>N° PEDIDO</b>";
			$i++;
			$sw=1;
		}	
		if (isset($_POST[selProveedor]) &&  $_POST[selProveedor]==100) {
			
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>PROVEEDOR</b>";
			$i++;
			$sw=1;
		}	
		if (isset($_POST[txtFechaInicial]) && empty($_POST[txtFechaInicial])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>FECHA GARANTIA INICIAL</b>";
			$i++;
			$sw=1;
		}	
		if (isset($_POST[txtFechaFinal]) && empty($_POST[txtFechaFinal])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>FECHA GARANTIA FINAL</b>";
			$i++;
			$sw=1;
		}	
		
		switch ($i) {
				case 0:
					require_once "administracion.php";
					require_once "conexionsql.php";
					require_once "pedidoAdmin.php";
					$user= new pedido($_POST[txtNumPedido],$_POST[selProveedor],$_POST[txtFechaInicial],"",$_POST[txtFechaFinal]);
					$resultado=$user->ingresarPedido();
					switch($resultado) {
						case 1:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"txtNumPedido\" type=\"hidden\" value=\"$_POST[txtNumPedido]\">";
							echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
							echo "<input name=\"txtFechaInicial\" type=\"hidden\" value=\"$_POST[txtFechaInicial]\">";
							echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
							
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - NUEVO PEDIDO</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR, PEDIDO DUPLICADO</td>";
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
							echo "<input name=\"txtNumPedido\" type=\"hidden\" value=\"$_POST[txtNumPedido]\">";
							echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
							echo "<input name=\"txtFechaInicial\" type=\"hidden\" value=\"$_POST[txtFechaInicial]\">";
							echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
						
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - NUEVA PEDIDO</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO NUEVO PEDIDO</td>";
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
					echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
					echo "<input name=\"txtNumPedido\" type=\"hidden\" value=\"$_POST[txtNumPedido]\">";
					echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
					echo "<input name=\"txtFechaInicial\" type=\"hidden\" value=\"$_POST[txtFechaInicial]\">";
					echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";

					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: INVENTARIO - NUEVO PEDIDO</td>
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
					echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
					echo "<input name=\"txtNumPedido\" type=\"hidden\" value=\"$_POST[txtNumPedido]\">";
					echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
					echo "<input name=\"txtFechaInicial\" type=\"hidden\" value=\"$_POST[txtFechaInicial]\">";
					echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: INVENTARIO - NUEVO PROVEEDOR</td>
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
			formularioPedido();
			break 1;
		default:
			formularioPedido();	
}
?>

<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
<?php
//FORMULARIO PEDIDO
function formularioPedido() {
	require_once "formularios.php";
	require_once "conexionsql.php";
	//CAMPO PEDIDO
	$numPedido= new campo("txtNumPedido","text","formularioCampoTexto","$_POST[txtNumPedido]","20","20","","");
	$txtNumPedido=$numPedido->retornar();
	
	//CAMPO PROVEEDOR
	$conProveedor= "SELECT ID_PROVEEDOR,PROVEEDOR from proveedor WHERE STATUS_ACTIVO = '1' ORDER BY PROVEEDOR ASC";
	$proveedor= new campoSeleccion("selProveedor","formularioCampoSeleccion","$_POST[selProveedor]","onChange","",$conProveedor,"--PROVEEDOR--","");
	$selProveedor=$proveedor->retornar();
	
	//CAMPO FECHA GARANTIA
	$fechaiGarantia= new campo("txtFechaInicial","text","formularioCampoTexto","$_POST[txtFechaInicial]","30","30","","");
	$txtFechaInicial=$fechaiGarantia->retornar();	

	$fechafGarantia= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","30","30","","");
	$txtFechaFinal=$fechafGarantia->retornar();	
	
	echo "<form name=\"frmPedido\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";

	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">INVENTARIO - NUEVO PEDIDO</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">INGRESAR PEDIDO</td>
  				</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">PEDIDO<br>
			$txtPedido<br>
			N° PEDIDO<br>$txtNumPedido<br>
			PROVEEDOR<br>$selProveedor<br>
			FECHA INICIO GARANTIA<br>$txtFechaInicial<a href=\"javascript:show_calendar('frmPedido.txtFechaInicial');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\"></a><br>
			FECHA FINAL GARANTIA<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmPedido.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\"></a><br></td>
			
		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=17'\"><input name=\"Limpiar\" type=\"submit\" value=\"GUARDAR\"></td>
  				</tr>";
	echo "</table>";
	echo "</form>";	
}
?>
