<script language="javascript">
	function cambiarSeleccion() {
		document.frmDespacho.funcion.value=0;
		document.frmDespacho.submit();
	}
</script>
<?php
switch ($funcion) {
	case 1:
		require_once ("inventarioAdmin.php");
		require_once ("administracion.php");
		require_once "conexionsql.php";
		if (isset($_POST[optInventario]) && count($_POST[optInventario])!=0) {
			$despacho= new inventario("","","","","","","","","","","",$_POST[optInventario]);
			$resultado=$despacho->devolverInventario();
			switch($resultado) {	
				case 0:
					echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"txtSerial\" type=\"hidden\" value=\"\">";
					echo "<input name=\"selUsuarioSistema\" type=\"hidden\" value=\"\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: INVENTARIO - CONTROL DESPACHO</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>SE REINTEGRÓ EL COMPONENTE AL INVENTARIO</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>
					<input name=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\"></td>";
					echo "</tr>";
					echo "</table>";						
					echo "</form>";	
					break 1;
				case 1:
					echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"txtSerial\" type=\"hidden\" value=\"\">";
					echo "<input name=\"selUsuarioSistema\" type=\"hidden\" value=\"\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: INVENTARIO - DEVOLUCION</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>NO SE PUDO REINTEGAR LOS COMPONENTES AL INVENTARIO</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>
					<input name=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\"></td>";
					echo "</tr>";
					echo "</table>";						
					echo "</form>";	
					break 1;
			}
		} else {
					echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"txtSerial\" type=\"hidden\" value=\"\">";
					echo "<input name=\"selUsuarioSistema\" type=\"hidden\" value=\"\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: INVENTARIO - CONTROL DESPACHO</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>NO SELECCION&Oacute; NINGUN COMPONENTE</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>
					<input name=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\"></td>";
					echo "</tr>";
					echo "</table>";						
					echo "</form>";	
		}	
		break 1;
	case 2:
		devolver();
		break 1;
	default:
		devolver();
			
}


function devolver() {
		require_once "formularios.php";
		require_once "conexionsql.php";
		require_once("inventarioAdmin.php");

		
		$conUss="SELECT id_uss, concat(nombre,' ',apellido) as nombres FROM usuario_sistema  where status_activo=1 order by nombres";

		
		$usuarioSistema= new campoSeleccion("selUsuarioSistema","formularioCampoSeleccion","$_POST[selUsuarioSistema]","","",$conUss,"--SELECCIONE--","");
		$selUsuarioSistema=$usuarioSistema->retornar();
//Devolucion de Equipo Despachados
	echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">INVENTARIO - CONTROL DE DESPACHO</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">BUSCAR COMPONENTE</td>";
			echo "<td class=\"formularioTablaTitulo\">DESPACHO</td>
			</tr>";
			echo "<tr>
				<td valign=top class=\"formularioCampoTitulo\">SERIAL<br>
				<input class=\"formularioCampoTexto\" name=\"txtSerial\" type=\"text\" value=$_POST[txtSerial]><br>
				</td>
				<td valign=top class=\"formularioCampoTitulo\">&nbsp;&nbsp;ANALISTA<br>&nbsp;&nbsp;$selUsuarioSistema<br>
				</td>
			</tr>
			<tr>
			<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"buscar\" type=\"button\" value=\"BUSCAR\" onclick=\"cambiarSeleccion()\"></td>
			</tr>
			</table>";
		
		if ($_POST[selUsuarioSistema]=='100') {
			$_POST[selUsuarioSistema]="";	
		}
		$despacho=new inventario("",$_POST[txtSerial],"","","","","","","",$_POST[selUsuarioSistema]);
		$resultado=$despacho->buscarDespachados();
		$total=$despacho->total();
	

			echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
			echo "<tr>
			<td class=\"formularioTablaTitulo\" colspan=\"6\">INVENTARIO - TOTAL: $total </td>
			</tr>";	
			echo "<tr valign=top class=\"tablaTitulo\">
				<td align=\"left\" class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
				<td valign=top class=\"tablaTitulo\">MARCA</td>
				<td valign=top class=\"tablaTitulo\">MODELO</td>
				<td valign=top class=\"tablaTitulo\">SERIAL</td>
				<td valign=top class=\"tablaTitulo\">DESPACHADO</td>
				<td valign=top class=\"tablaTitulo\">OBSERVACION</td>
				</tr>";
				if ($resultado) {
					while ($row=mysql_fetch_array($resultado)) {
						if ($i%2==0) {
							$clase="tablaFilaPar";
						} else {
							$clase="tablaFilaNone";
						}
						echo "<tr class=\"$clase\">
						<td align=\"left\"><input name=\"optInventario\" type=\"radio\" value=\"$row[0]\">$row[3]       </td>
						<td>$row[5]</td>	
						<td>$row[7]</td>
						<td>$row[8]</td>
						<td>$row[12]</td>
						<td>$row[9]</td>
						</tr>";
						$i++;	
					}	
			}
			echo "<tr>
			<td class=\"formularioTablaBotones\" colspan=\"6\">
			<input name=\"DEVOLVER\" type=\"submit\" value=\"DEVOLVER\">
			</td>
			</tr>
			</table>";
		echo "</form>";
}			
?>