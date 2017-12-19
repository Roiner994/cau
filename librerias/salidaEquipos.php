<?php
require_once "formularios.php";
switch ($funtion) {
	case 1:
			formularioSeleccionarProveedor();
			break 1;
		default:
			formularioSeleccionarProveedor();
}	
?>




<?php
//SALIDA DE EQUIPOS

//FORMULARIO SELECCIONAR
function formularioSeleccionarProveedor() {
require_once "conexionsql.php";
require_once "formularios.php";
//require_once "proveedorAdmin";
$conProveedor= "SELECT ID_PROVEEDOR,PROVEEDOR,CONTACTOS from proveedor WHERE STATUS_ACTIVO = '1' ORDER BY PROVEEDOR ASC";
	//Campo Proveedor
	$proveedor= new campoSeleccion("selProveedor","formularioCampoSeleccion","$_POST[selProveedor]","onChange","",$conProveedor,"--PROVEEDOR--","");
	$selProveedor=$proveedor->retornar();

echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";

	echo "<table class=\"formularioTabla\"align=center width=\"300\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">GARANTIA - SALIDA DE EQUIPO</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">SALIDA DE EQUIPOS</td>
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
<tr align=center><td valign=top class=\"formularioCampoTitulo\" ><p align=center >PROVEEDOR<br>$selProveedor<br></tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='secciones.php?item=14'\"><input name=\"Limpiar\" type=\"submit\" value=\"GENERAR SALIDA\"></td>
			</td>
  		</tr>";
echo "</table>";
echo "</form>";					
}


?>