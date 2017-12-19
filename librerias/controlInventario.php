<?php
//Disponibilidad de Equipos y Componentes

switch($funcion) {
	case 1:
		frmPrincipal();
		break 1;
	case 2:
	
		break 1;
	case 3:
		break 1;
	default:
		frmPrincipal();
}

function frmAgruparPorDescripcion() {
	echo "<tr valign=top class=\"tablaTitulo\">
	<td align=\"left\" class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
	<td valign=top class=\"tablaTitulo\">CANTIDAD</td>
	</tr>";
	echo "<tr valign=top class=\"tablaTitulo\">
	<td align=\"left\" class=\"tablaTitulo\"></td>
	<td valign=top class=\"tablaTitulo\">CANTIDAD</td>
	</tr>";
	
	echo "</table>";
}
function frmPrincipal() {
	echo "<form name=\"frmInventario\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\">CONTROL INVENTARIO</td>
  				</tr>";
		echo "<tr>";
			echo "<td valign=top class=\"formularioCampoTitulo\">AGRUPAR POR:<br>
			<select name=\"ordernarPor\" onchange=\"submit()\">
				<option value=\"100\">--SELECCIONE--</option>
				<option value=\"1\">DESCRIPCION</option>
				<option value=\"2\">MARCA</option>
				<option value=\"3\">MODELO</option>
			</select></td>
			</tr>
		</table>";
require_once('inventarioAdmin.php');
require_once('conexionsql.php');
require_once('administracion.php');		
		switch ($_POST[ordernarPor]) {
			case 1:
				$invent= new inventario();
				$invent->setAgrupar('inventario.id_descripcion');
				$resultado=$invent->retornarInventarioCantidad();
				$total=$invent->total();
				echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
				echo "<tr>
				<td class=\"formularioTablaTitulo\" colspan=\"4\">CANTIDAD COMPONENTES</td>
				</tr>";				
				if ($resultado && $resultado!=1) {
					echo "<tr valign=top class=\"tablaTitulo\">
					<td align=\"left\" class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
					<td valign=top class=\"tablaTitulo\">CANTIDAD</td>

					</tr>";
					while ($row=mysql_fetch_array($resultado)) {
						if ($i%2==0) {
							$clase="tablaFilaPar";
						} else {
							$clase="tablaFilaNone";
						}
						echo "<tr class=\"$clase\">
						<td align=\"left\">$row[1]</td>
						<td>$row[6]</td>						
						</tr>";
						$i++;	
					}	
				}
				echo "</table>";
				break 1;
			case 2:
				$invent= new inventario();
				$invent->setAgrupar('inventario.id_descripcion, inventario.id_marca');
				$resultado=$invent->retornarInventarioCantidad();
				echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
				echo "<tr>
				<td class=\"formularioTablaTitulo\" colspan=\"4\">CANTIDAD COMPONENTES:</td>
				</tr>";				

				if ($resultado && $resultado!=1) {
					echo "<tr valign=top class=\"tablaTitulo\">
					<td align=\"left\" class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
					<td valign=top class=\"tablaTitulo\">MARCA</td>
					<td valign=top class=\"tablaTitulo\">CANTIDAD</td>

					</tr>";
					while ($row=mysql_fetch_array($resultado)) {
						if ($i%2==0) {
							$clase="tablaFilaPar";
						} else {
							$clase="tablaFilaNone";
						}
						echo "<tr class=\"$clase\">
						<td align=\"left\">$row[1]</td>
						<td>$row[3]</td>
						<td>$row[6]</td>
						</tr>";
						$i++;	
					}	
				}
				echo "</table>";
				break 1;
			case 3:
				$invent= new inventario();
				$invent->setAgrupar('inventario.id_descripcion, inventario.id_marca, inventario.id_modelo');
				$resultado=$invent->retornarInventarioCantidad();
				echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
				echo "<tr>
				<td class=\"formularioTablaTitulo\" colspan=\"4\">CANTIDAD COMPONENTES</td>
				</tr>";				
				if ($resultado && $resultado!=1) {
					echo "<tr valign=top class=\"tablaTitulo\">
					<td align=\"left\" class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
					<td valign=top class=\"tablaTitulo\">MARCA</td>
					<td valign=top class=\"tablaTitulo\">MODELO</td>
					<td valign=top class=\"tablaTitulo\">CANTIDAD</td>

					</tr>";
					while ($row=mysql_fetch_array($resultado)) {
						if ($i%2==0) {
							$clase="tablaFilaPar";
						} else {
							$clase="tablaFilaNone";
						}
						echo "<tr class=\"$clase\">
						<td align=\"left\">$row[1]</td>
						<td>$row[3]</td>
						<td>$row[5]</td>
						<td>$row[6]</td>
						</tr>";
						$i++;	
					}	
				}
				echo "</table>";
				break 1;
			
		}		
	echo "</form>";
	
	
}

?>