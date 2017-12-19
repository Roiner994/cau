<?php
//VERIFICAR PROVEEDOR
require_once "formularios.php";
switch ($funcion) {

	case 1:
		
		if (isset($_POST[selProveedor]) && $_POST[selProveedor]==100) {
			echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
			echo "<input name=\"txtProveedor\" type=\"hidden\" value=\"$_POST[txtProveedor]\">";
			echo "<input name=\"txtContactos\" type=\"hidden\" value=\"$_POST[txtContactos]\">";
			echo "<input name=\"txtDireccion\" type=\"hidden\" value=\"$_POST[txtDireccion]\">";
			echo "<input name=\"txtCorreo\" type=\"hidden\" value=\"$_POST[txtCorreo]\">";
			echo "<input name=\"txtTelefono\" type=\"hidden\" value=\"$_POST[txtTelefono]\">";
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR PROVEEDOR</td>
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
			formularioProveedorModificar();	
		}
		break 1;
	case 2:
		$sw=0;
		$mensaje="";
		if (isset($_POST[txtProveedor]) && empty($_POST[txtProveedor])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>PROVEEDOR</b>";
			$i++;
			$sw=1;
		}	
		
switch ($i) {
				case 0:
					require_once "administracion.php";
					require_once "conexionsql.php";
					require_once "proveedorAdmin.php";
					$user= new proveedor($_POST[selProveedor],$_POST[txtProveedor],$_POST[txtContactos],$_POST[txtDireccion],$_POST[txtCorreo],$_POST[txtTelefono],1);
					$resultado=$user->modificarProveedor();
					switch($resultado) {
						case 2:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
							echo "<input name=\"txtProveedor\" type=\"hidden\" value=\"$_POST[txtProveedor]\">";
							echo "<input name=\"txtContactos\" type=\"hidden\" value=\"$_POST[txtContactos]\">";
							echo "<input name=\"txtDireccion\" type=\"hidden\" value=\"$_POST[txtDireccion]\">";
							echo "<input name=\"txtCorreo\" type=\"hidden\" value=\"$_POST[txtCorreo]\">";
							echo "<input name=\"txtTelefono\" type=\"hidden\" value=\"$_POST[txtTelefono]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR PROVEEDOR</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR, PROVEEDOR DUPLICADO</td>";
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
							echo "<input name=\"txtProveedor\" type=\"hidden\" value=\"$_POST[txtProveedor]\">";
							echo "<input name=\"txtContactos\" type=\"hidden\" value=\"$_POST[txtContactos]\">";
							echo "<input name=\"txtDireccion\" type=\"hidden\" value=\"$_POST[txtDireccion]\">";
							echo "<input name=\"txtCorreo\" type=\"hidden\" value=\"$_POST[txtCorreo]\">";
							echo "<input name=\"txtTelefono\" type=\"hidden\" value=\"$_POST[txtTelefono]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR PROVEEDOR</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE MODIFICO PROVEEDOR</td>";
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
					echo "<input name=\"txtProveedor\" type=\"hidden\" value=\"$_POST[txtProveedor]\">";
					echo "<input name=\"txtContactos\" type=\"hidden\" value=\"$_POST[txtContactos]\">";
					echo "<input name=\"txtDireccion\" type=\"hidden\" value=\"$_POST[txtDireccion]\">";
					echo "<input name=\"txtCorreo\" type=\"hidden\" value=\"$_POST[txtCorreo]\">";
					echo "<input name=\"txtTelefono\" type=\"hidden\" value=\"$_POST[txtTelefono]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR PROVEEDOR</td>
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
					echo "<input name=\"txtProveedor\" type=\"hidden\" value=\"$_POST[txtProveedor]\">";
					echo "<input name=\"txtContactos\" type=\"hidden\" value=\"$_POST[txtContactos]\">";
					echo "<input name=\"txtDireccion\" type=\"hidden\" value=\"$_POST[txtDireccion]\">";
					echo "<input name=\"txtCorreo\" type=\"hidden\" value=\"$_POST[txtCorreo]\">";
					echo "<input name=\"txtTelefono\" type=\"hidden\" value=\"$_POST[txtTelefono]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR PROVEEDOR</td>
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
		formularioSeleccionarProveedor();
		break 1;
	default:
		formularioSeleccionarProveedor();
}


?>




<?php
//FORMULARIO SELECCIONAR
function formularioSeleccionarProveedor() {
require_once "conexionsql.php";
require_once "formularios.php";
$conProveedor= "SELECT ID_PROVEEDOR,PROVEEDOR,CONTACTOS,DIRECCION,CORREO,TELEFONO,STATUS_ACTIVO from proveedor WHERE STATUS_ACTIVO = '1' ORDER BY PROVEEDOR ASC";
	//Campo Proveedor
	$proveedor= new campoSeleccion("selProveedor","formularioCampoSeleccion","$_POST[selProveedor]","onChange","",$conProveedor,"--PROVEEDOR--","");
	$selProveedor=$proveedor->retornar();

echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";

	echo "<table class=\"formularioTabla\"align=center width=\"100\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">MODIFICAR PROVEEDOR</td>
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
<tr align=center><td valign=top class=\"formularioCampoTitulo\" ><p align=center >PROVEEDOR<br>$selProveedor<br></tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"submit\" value=\"MODIFICAR\">
			</td>
  		</tr>";
echo "</table>";
echo "</form>";					
} 
?>

<?php
//FORMULARIO MODIFICAR PROVEEDOR
function formularioProveedorModificar() {
	require_once "formularios.php";
	require_once "conexionsql.php";
	$conProveedor= "SELECT ID_PROVEEDOR,PROVEEDOR,CONTACTOS,DIRECCION,CORREO,TELEFONO 
					from proveedor WHERE ID_PROVEEDOR='$_POST[selProveedor]'";

conectarMysql();
$result=mysql_query($conProveedor);
$row=mysql_fetch_array($result);
$_POST[txtProveedor]=$row[1];
$_POST[txtContactos]=$row[2];
$_POST[txtDireccion]=$row[3];
$_POST[txtCorreo]=$row[4];
$_POST[txtTelefono]=$row[5];


	
	$proveedor= new campo("txtProveedor","text","formularioCampoTexto","$_POST[txtProveedor]","30","30","","");
	$txtProveedor=$proveedor->retornar();
	
	$contactos= new campo("txtContactos","text","formularioCampoTexto","$_POST[txtContactos]","30","30","","");
	$txtContactos=$contactos->retornar();	

	$direccion= new campo("txtDireccion","text","formularioCampoTexto","$_POST[txtDireccion]","65","65","","");
	$txtDireccion=$direccion->retornar();	

	$correo= new campo("txtCorreo","text","formularioCampoTexto","$_POST[txtCorreo]","65","65","","");
	$txtCorreo=$correo->retornar();	
	
	$telefono= new campo("txtTelefono","text","formularioCampoTexto","$_POST[txtTelefono]","30","30","","");
	$txtTelefono=$telefono->retornar();	

	
	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
	echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";

	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">INVENTARIO - MODIFICAR PROVEEDOR</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">DATOS DEL PROVEEDOR</td>
  				</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">PROVEEDOR<br>
			$txtProveedor<br>
			CONTACTOS<br>$txtContactos<br>
			DIRECCION<br>$txtDireccion<br>
			CORREO ELECTRONICO<br>$txtCorreo<br>
			TELEFONO<br>$txtTelefono<br></td>
		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=11'\"><input name=\"Limpiar\" type=\"submit\" value=\"GUARDAR\"></td>
  				</tr>";
	echo "</table>";
	echo "</form>";	
}
?>		 

