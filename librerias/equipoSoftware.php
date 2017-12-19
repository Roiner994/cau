


<?php
switch ($funcion) {
	case 1:
		break 1;
	default:
		equipoSoftware();	
}

function equipoSoftware() {
//Relacion de Equipos con Software
echo "<br>Relacion de Equipos con Software<br>";
	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">EQUIPO - INFORMACI&Oacute;N</td>
  				</tr>";


			echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\"  colspan=\"2\">DATOS DEL EQUIPO</td>
			</tr>";
			echo "<tr>
				<td valign=top class=\"formularioCampoTitulo\">CONFIGURACION:<br><input class=\"formularioCampoTexto\" name=\"txtConfiguracion\" type=\"text\" value=\"$_POST[txtConfiguracion]\" onKeyPress=\"if (event.keyCode==13) buscarConfiguracion();\">
				<input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"C\" onclick=\"buscarConfiguracion()\" ><br>
				SERIAL:<br><input class=\"formularioCampoTexto\" name=\"txtSerial\" type=\"text\" value=\"$_POST[txtSerial]\" readonly=\"true\"><br>
				MARCA:<br><input class=\"formularioCampoTexto\" name=\"txtMarca\" type=\"text\" value=\"$_POST[txtMarca]\" readonly=\"true\"><br>
				</td>
				<td valign=top class=\"formularioCampoTitulo\">ACTIVO FIJO:<br><input class=\"formularioCampoTexto\" name=\"txtActivoFijo\" type=\"text\" value=\"$_POST[txtActivoFijo]\" readonly=\"true\"><br>
				DESCRIPCION:<br><input class=\"formularioCampoTexto\" name=\"txtDescripcion\" type=\"text\" value=\"$_POST[txtDescripcion]\" readonly=\"true\"><br>
				MODELO:<br><input class=\"formularioCampoTexto\" name=\"txtModelo\" type=\"text\" value=\"$_POST[txtModelo]\" readonly=\"true\"><br>
				</td>

			</tr>";
		echo "</table><BR>";
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
	echo "<tr>
			<td class=\"formularioTablaTitulo\" colspan=\"5\">COMPONENTES ASOCIADOS</td>
		</tr>";
	echo "</table>";
}

?>