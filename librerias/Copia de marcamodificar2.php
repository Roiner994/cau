<?php
switch($funcion) {
	case 1:
		break 1;
	case 2:
		break 1;
	default:
		formulariomarcaModificar2();			
}

function formulariomarcaModificar2() {
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
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">MODIFICAR MARCA</td>
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
<tr align=center><td valign=top class=\"formularioCampoTitulo\" ><p align=left >MARCA<br>$selMarca<br></tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"MODIFICAR\" onclick=\"location.href='secciones.php?item=137'\">
			</td>
  		</tr>";
echo "</table>";
echo "</form>";					
} 
?>