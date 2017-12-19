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

	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";

	echo "<table class=\"formularioTabla\"align=center width=\"500\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">INGRESAR NUEVA MARCA</td>
  				</tr>";
		echo "<tr>";
			echo "<td align=center></td>
  				</tr>
		<tr align=center>
<td valign=top class=\"formularioCampoTitulo\" ><p align=center >MARCA<br>
<input name=\"txtMarca\" type=\"text\" size=\"20\" maxlength=\"20\"></p></td></tr>
<tr><td align=center><input name=\"btn\" type=\"button\" value=\"MODIFICAR\" onClick=\"()\"><br></td>
</tr>";
echo "</table>";
echo "</form>";	
//echo "<tr>";
			//echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">INGRESAR NUEVA MARCA</td>
  				//</tr>
//echo "<tr>";
			//echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='secciones.php?item=130'\"><input name=\"Limpiar\" type=\"submit\" value=\"GUARDAR\"></td>
  				//</tr>";
} 
?>