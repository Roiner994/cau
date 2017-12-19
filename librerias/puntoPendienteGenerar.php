<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
require_once("seguridad.php");
?>

<?php
if (isset($_GET[configuracion]) && empty($_GET[configuracion])) {
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";

				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - PUNTOS PENDIENTES</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>NO SE PUDO ENCONTRAR EL EQUIPO</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"CERRAR\" onclick=\"window.close()\"></td>";
				echo "</tr>";
				echo "</table>";			
				echo "</form>";
				exit();
}


switch ($funcion) {
	case 1:
		if (isset($_POST[selTipoPendiente]) && $_POST[selTipoPendiente]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>TIPO DE PUNTO PENDIENTE</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[txtDetallePendiente]) && empty($_POST[txtDetallePendiente])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>DETALLE DEL PUNTO PENDIENTE</b>";
			$i++;
			$sw=1;
		}
		switch($i) {
			case 0:
				require_once("puntoPendienteAdmin.php");
				require_once("administracion.php");
				$login=$_SESSION["login"];
				$pendiente= new puntoPendiente();
				$pendiente->setPuntoPendiente("",$_GET[configuracion]);
				$pendiente->setDetallePuntoPendiente("",$_POST[selTipoPendiente],$_POST[txtDetallePendiente],0,$login);
				$resultado=$pendiente->ingresarPuntoPendiente();
				
				switch ($resultado) {
					case 0:
						echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
		
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO -PUNTOS PENDIENTES</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>SE GUARD&Oacute; EL PUNTO PENDIENTE</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"CERRAR\" onclick=\"window.close()\"></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";						
						break 1;
					case 1:
						echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
		
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO -PUNTOS PENDIENTES</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR EL PUNTO PENDIENTE</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";	
						break 1;	
				}
				break 1;
	
			case 1:
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";

				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO -PUNTOS PENDIENTES</td>
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
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";

				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - PUNTOS PENDIENTES</td>
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
		break 1;
	default:
		frmPendiente($_GET[configuracion]);
		
}
function frmPendiente($configuracion="") {
		require_once("inventarioAdmin.php");
		require_once("formularios.php");
		require_once("puntoPendienteAdmin.php");
		
		
			if (isset($configuracion) && !empty($configuracion)) {	
				$equipoBuscar= new equipo();
				$equipoBuscar->setEquipo($configuracion);	
				$resultado=$equipoBuscar->buscarEquipo();
				if ($resultado && $resultado!=1) {
					$row=mysql_fetch_array($resultado);
					$_POST[txtActivoFijo]=$row[1];
					$idInventario=$row[2];
					$_POST[txtSerial]=$row[3];
					$_POST[txtDescripcion]=$row[5];			
					$_POST[txtMarca]=$row[7];
					$_POST[txtModelo]="$row[9] $row[10] $row[11]";
				}
			}
		
		
			$conTipoPendiente="Select
				tipo_punto_pendiente.ID_TIPO_PENDIENTE,
				tipo_punto_pendiente.NOMBRE_PUNTO_PENDIENTE
				From
				tipo_punto_pendiente
				Order By
				tipo_punto_pendiente.NOMBRE_PUNTO_PENDIENTE Asc";
			
			$tipoPendiente= new campoSeleccion("selTipoPendiente","formularioCampoSeleccion","$_POST[selTipoPendiente]","","",$conTipoPendiente,"--SELECCIONE--","");
			$selTipoPendiente=$tipoPendiente->retornar();	
			echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";		
				echo "<table width=\"400\" border=\"0\" align=\"center\">
				<tr>";
					echo "<td class=\"tituloPagina\" colspan=\"2\" align=\"center\">PUNTO PENDIENTE</td>
				</tr>
				<tr>
				<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\"><br>DATOS DEL EQUIPO</td>
				</tr>
				<tr>
				<td valign=top class=\"formularioCampoTitulo\"><b>CONFIGURACION</b></td>
				<td valign=top class=\"formularioCampoTitulo\"><b>SERIAL</b></td>
				</tr>
				<tr>
				<td valign=top class=\"formularioCampo\">$row[0]</td>
				<td valign=top class=\"formularioCampo\">$row[3]</td>
				</tr>
				<tr>
				<td valign=top class=\"formularioCampoTitulo\"><b>DESCRIPCION / MARCA</b></td>
				<td valign=top class=\"formularioCampoTitulo\"><b>MODELO</b></td>
				</tr>
				<tr>
				<td valign=top class=\"formularioCampo\">$row[5]</td>
				<td valign=top class=\"formularioCampo\">$row[9] $row[10] $row[11]</td>
				</tr>
				<tr>
				<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\"><br>PUNTO PENDIENTE</td>
				</tr>
				<tr>
				<td valign=top class=\"formularioCampoTitulo\" colspan=\"2\"><b>TIPO DE PUNTO PENDIENTE</b></td>
				</tr>
				<tr>
				<td valign=top class=\"formularioCampo\" colspan=\"2\">$selTipoPendiente</td>
				</tr>
				<tr>
				<td valign=top class=\"formularioCampoTitulo\" colspan=\"2\"><b>DETALLE DEL PUNTO PENDIENTE</b></td>
				</tr>
				<tr>
				<td valign=top class=\"formularioCampo\" colspan=\"2\"><textarea class=\"formularioAreaTextoPlanilla\" name=\"txtDetallePendiente\" cols=\"600\" rows=\"2\">$_POST[txtDetallePendiente]</textarea></td>
				</tr>
				<tr>
				<td valign=top class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnGuardar\" type=\"submit\" value=\"GUARDAR\"></td>
				</tr>";
				echo "</table>";

				echo "</form>";
				
				echo "<br><br>";
				echo "<table width=\"600\" border=\"0\" align=\"center\">
				<tr>";
					echo "<td class=\"tituloPagina\" colspan=\"5\" align=\"center\">PUNTOS PENDIENTE ACTUALES</td>
				</tr>";
					
				$puntosPendientes= new puntoPendiente();
				$puntosPendientes->setPuntoPendiente("",$configuracion);
				$puntosPendientes->setDetallePuntoPendiente("","","",0);
				$resultado=$puntosPendientes->retornarPuntosPendientes();	
				if ($resultado && $resultado!=1) {
					echo "<tr valign=top class=\"tablaTitulo\">
					<td align=\"left\" class=\"tablaTitulo\">CONFIGURACION</td>
					<td valign=top class=\"tablaTitulo\">ANALISTA</td>
					<td valign=top class=\"tablaTitulo\">TIPO DE PUNTO PENDIENTE</td>
					<td valign=top class=\"tablaTitulo\">OBSERVACION</td>
					<td valign=top class=\"tablaTitulo\">FECHA</td>
					</tr>";	

					while ($row=mysql_fetch_array($resultado)) {
						if ($i%2==0) {
							$clase="tablaFilaPar";
						} else {
							$clase="tablaFilaNone";
						}
						echo "<tr class=\"$clase\">
							<td align=\"left\">$row[1]</td>
							<td>$row[9] $row[10]</td>
							<td>$row[5]</td>
							<td>$row[6]</td>
							<td>$row[11]</td>
						</tr>";
						$i++;
					}
				}
				echo "</table>";
}

?>