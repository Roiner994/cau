<?php
//Buscar Equipos
switch ($funcion) {
	case 1:
		break 1;
	default:
		formularioBuscar();
}


function formularioBuscar() {
	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
//Datos del Buscar.
	
	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">INVENTARIO - BUSCAR</td>
  		</tr>";
		echo "<tr>";
			echo "<td class=\"formularioCampoTitulo\" colspan=\"2\">BUSCAR</td>
  		</tr>";
		echo "<tr>";
			echo "<td class=\"formularioCampoTitulo\" colspan=\"2\"><input name=\"txtBuscar\" type=\"text\"></td>
  		</tr>";
		echo "<tr>";
			echo "<td class=\"formularioCampoTitulo\" colspan=\"2\"><input name=\"txtBuscar\" type=\"button\" value=\"BUSCAR\"></td>
  		</tr>";
		
	echo "</table>";
	echo "</form>";
}


?>