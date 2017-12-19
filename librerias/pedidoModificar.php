<?php
require_once "formularios.php";
switch ($funcion) {

	case 1:
		
		if (isset($_POST[selPedido]) && $_POST[selPedido]==100) {
			echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
			echo "<input name=\"txtNumPedido\" type=\"hidden\" value=\"$_POST[txtNumPedido]\">";
			echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
			echo "<input name=\"txtFechaInicial\" type=\"hidden\" value=\"$_POST[txtFechaInicial]\">";
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR PEDIDO</td>
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
			formularioPedido();	
		}
		break 1;


	case 2:
		$i=0;
		if (isset($_POST[txtNumPedido]) && empty($_POST[txtNumPedido])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>N° PEDIDO</b>";
			$i++;
			$sw=1;
		}	
		if (isset($_POST[selProveedor]) && empty($_POST[selProveedor])) {
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
			$mensaje=$mensaje." <b>FECHA INICIAL DE GARANTIA</b>";
			$i++;
			$sw=1;
		}
	
		switch ($i) {
				case 0:
					require_once "administracion.php";
					require_once "conexionsql.php";
					require_once "pedidoAdmin.php";
					$user= new pedido($_POST[txtNumAnterior],$_POST[selProveedor],$_POST[txtFechaInicial],$_POST[txtNumPedido],$_POST[txtFechaFinal]);
					$resultado=$user->modificarPedido();
					switch($resultado) {
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
							echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
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
							echo "<td valign=top class=\"mensaje\" align=center>SE ACTUALIZO PEDIDO</td>";
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
					echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
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
					echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
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
			formularioSeleccionarPedido();
			break 1;
		default:
			formularioSeleccionarPedido();	
}
?>



<?php
//FORMULARIO SELECCIONAR 
function formularioSeleccionarPedido() {
require_once "conexionsql.php";
require_once "formularios.php";
$conPedido="SELECT pedido.ID_PEDIDO,CONCAT(pedido.ID_PEDIDO,', ',proveedor.PROVEEDOR) AS PROV FROM pedido INNER JOIN proveedor ON (pedido.ID_PROVEEDOR=proveedor.ID_PROVEEDOR) ORDER BY ID_PEDIDO";
	//CAMPO PEDIDO
	$pedido= new campoSeleccion("selPedido","formularioCampoSeleccion","$_POST[selPedido]","onChange","",$conPedido,"--PEDIDO--","");
	$selPedido=$pedido->retornar();

echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";

	echo "<table class=\"formularioTabla\"align=center width=\"100\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">MODIFICAR PEDIDO</td>
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
<tr align=center><td valign=top class=\"formularioCampoTitulo\" ><p align=center >PEDIDO<br>$selPedido<br></tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnModificar\" type=\"submit\" value=\"MODIFICAR\">
			</td>
  		</tr>";
echo "</table>";
echo "</form>";					
} 
?>


<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
<?php
//FORMULARIO PEDIDO

function formularioPedido() {
	
	require_once "formularios.php";
	require_once "conexionsql.php";
	
	$conPedido= "SELECT ID_PEDIDO,ID_PROVEEDOR,FECHAI_GARANTIA,FECHAF_GARANTIA from pedido WHERE ID_PEDIDO='$_POST[selPedido]'";
conectarMysql();
$result= mysql_query($conPedido);
$row=mysql_fetch_array($result);
$_POST[txtNumPedido]=$row[0];
$_POST[txtNumAnterior]=$row[0];
$_POST[selProveedor]=$row[1];

$fecha=substr($row[2],8,2).'/'.substr($row[2],5,2).'/'.substr($row[2],0,4);
$_POST[txtFechaInicial]=$fecha;

$fecha=substr($row[3],8,2).'/'.substr($row[3],5,2).'/'.substr($row[3],0,4);
$_POST[txtFechaFinal]=$fecha;
	
	
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
	echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
	echo "<input name=\"txtNumAnterior\" type=\"hidden\" value=\"$_POST[txtNumAnterior]\">";
	echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";

	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">INVENTARIO - MODIFICAR PEDIDO</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">MODIFICAR PEDIDO</td>
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
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=17'\"><input name=\"Limpiar\" type=\"submit\" value=\"MODIFICAR\"></td>
  				</tr>";
	echo "</table>";
	echo "</form>";	
}
?>		 