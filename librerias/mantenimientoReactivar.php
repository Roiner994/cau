<?php
require_once("seguridad.php");
?>
<?php
require_once("conexionsql.php");
$login=$_SESSION["login"];
if ($login!="USS0000004" && $login!="USS0000003" && $login!="USS0000013" && $login!="USS0000031" && $login!="USS0000011" && $login!="USS0000014" && $login!="USS0000071") {
	echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";

	echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
	echo "<br><br><br><br>";
	echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
	echo "<tr>";
	echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
	</tr>";
	echo "<tr>";
	echo "<td valign=top class=\"mensaje\" align=center>LLAMAR A LA EXTENSION 4809 O 5856 PARA REACTIVAR EL MANTENIMIENTO</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
	echo "</tr>";
	echo "</table>";
	echo "</form>";
	exit();			
}
switch ($funcion) {
	case 1:
		$consulta="SELECT ID_MANTENIMIENTO FROM MANTENIMIENTO_PREVENTIVO WHERE CONFIGURACION='$_POST[txtConfiguracion]' order by hora_inicio desc";
		conectarMysql();
		$result=mysql_query($consulta);
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			$idMantenimiento=$row[0];
			$consulta="update mantenimiento_preventivo set status_mantenimiento=1 where id_mantenimiento='$idMantenimiento'";
			$result=mysql_query($consulta);
			if ($result && mysql_affected_rows()>0) {
				
				
				if ($resultEquipoCampo) {
					echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
	
					echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>SE REACTIVO EL MANTENIMIENTO A EL EQUIPO $_POST[txtConfiguracion]</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";				
				} else {
					echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
	
					echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE REACTIVAR MANTENIMIENTO A EL EQUIPO $_POST[txtConfiguracion]</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";				
				}
			} else {
				echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";

				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><b></b>IMPOSIBLE REACTIVAR MANTENIMIENTO A EL A EL EQUIPO $_POST[txtConfiguracion] ESTA EN MANTENIMIENTO</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";				
			}
		}
		mysql_close;
		break 1;
	default:
		frmMantenimiento();
}
function frmMantenimiento() {
	echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"idMantenimiento\" type=\"hidden\" value=\"$_POST[idMantenimiento]\">";
	echo "<table class=\"formularioTabla\"align=center width=\"300\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\">MANTENIMIENTO PREVENTIVO</td>
	</tr>";
	echo "<tr>
	<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">REACTIVAR MANTENIMIENTO PREVENTIVO</td>";
	echo "</tr>
	<tr>
	<td valign=top class=\"formularioCampoTitulo\">
	CONFIGURACION<br>
	<input class=\"formularioCampoTexto\" name=\"txtConfiguracion\" type=\"text\" value=\"$_POST[txtConfiguracion]\">
	</td>
	</tr>";
	echo "<tr>
		<td class=\"formularioTablaBotones\" align=\"center\">
		<input name=\"btnAsociar\" type=\"submit\" value=\"EJECUTAR\"></td>
	</tr>";
	echo "</table>";
	echo "</form>";
}
?>
