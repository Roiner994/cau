<?php
//Reporte de un Mantenimiento
?>
<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
require_once("administracion.php");
require_once("mantenimientoAdmin.php");
require_once("puntoPendienteAdmin.php");

$mantenimiento = new mantenimiento($idMantenimiento);
$resultado=$mantenimiento->retornaMantenimientos();
if ($resultado && $resultado!=1) {
	$row=mysql_fetch_array($resultado);
}
		$fecha=substr($row[33],0,10);

		echo "<table width=\"75%\" border=\"0\" align=\"center\">
		<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"3\" align=\"center\">DETALLE DEL MANTENIMIENTO PREVENTIVO</td>
		</tr>
		<tr>
		<td valign=top class=\"formularioTablaTitulo\" colspan=\"3\"><br>DATOS DEL MANTENIMIENTO</td>
		</tr>		
		<tr>
		<td valign=top class=\"formularioCampoTitulo\"><b>ID MANTENIMIENTO</b></td>
		<td valign=top class=\"formularioCampoTitulo\"><b>TECNICO QUE REALIZO EL MANTENIMIENTO</b></td>
		<td valign=top class=\"formularioCampoTitulo\"><b>FECHA</b></td>
		</tr>		
		<tr>
		<td valign=top class=\"formularioCampo\">$row[0]</td>
		<td valign=top class=\"formularioCampo\">$row[16] $row[17]</td>
		<td valign=top class=\"formularioCampo\">$fecha</td>
		</tr>
		<tr>
		<td valign=top class=\"formularioTablaTitulo\" colspan=\"3\"><br>DATOS DEL EQUIPO<br></td>
		</tr>
		<tr>
		<td valign=top class=\"formularioCampoTitulo\"><b>CONFIGURACION</b></td>
		<td valign=top class=\"formularioCampoTitulo\"><b>ACTIVO FIJO</b></td>
		<td valign=top class=\"formularioCampoTitulo\"><b>SERIAL</b></td>
		</tr>		
		<tr>
		<td valign=top class=\"formularioCampo\">$row[1]</td>
		<td valign=top class=\"formularioCampo\">$row[2]</td>
		<td valign=top class=\"formularioCampo\">$row[6]</td>
		</tr>		
		<tr>
		<td valign=top class=\"formularioCampoTitulo\"><b>DESCRIPCION</b></td>
		<td valign=top class=\"formularioCampoTitulo\"><b>MARCA</b></td>
		<td valign=top class=\"formularioCampoTitulo\"><b>MODELO</b></td>
		</tr>
		<tr>
		<td valign=top class=\"formularioCampo\">$row[8]</td>
		<td valign=top class=\"formularioCampo\">$row[10]</td>
		<td valign=top class=\"formularioCampo\">$row[12] $row[13] $row[14]</td>
		</tr>
		<tr>
		<td valign=top class=\"formularioTablaTitulo\" colspan=\"3\"><br>TRABAJO QUE SE REALIZO<br></td>
		</tr>
		<tr>
		<td valign=top class=\"formularioCampoTitulo\" colspan=\"3\"><b>SISTEMA OPERATIVO ACTUALIZADO</b></td>
		</tr>
		<tr>
		<td valign=top class=\"formularioCampo\" colspan=\"3\"><br>";
			if (strtoupper($row[36])==1)
				echo "NO";
			else 
				echo "SI";
			echo "</td>
		</tr>
		<tr>
		<td valign=top class=\"formularioCampoTitulo\" colspan=\"3\"><b>ANTIVIRUS ACTUALIZADO</b></td>
		</tr>
		<tr>
		<td valign=top class=\"formularioCampo\" colspan=\"3\"><br>";
			if (strtoupper($row[37])==1)
				echo "NO";
			else 
				echo "SI";
			echo "</td>
		</tr>		
		
		<tr>
		<td valign=top class=\"formularioCampoTitulo\" colspan=\"3\"><b>DESCRIPCION DEL TRABAJO REALIZADO</b></td>
		</tr>
		<tr>
		<td valign=top class=\"formularioCampo\" colspan=\"3\"><br>".strtoupper($row[38])."</td>
		</tr>
		<tr>
		<td valign=top class=\"formularioCampoTitulo\" colspan=\"3\"><BR><b>OBSERVACIONES HECHAS</b><BR></td>
		</tr>";
		
		if (!empty($ow[39])) {
			
			echo "
			<tr>
			<td valign=top class=\"formularioCampo\" colspan=\"3\"><br>".strtoupper($row[39])."</td>
			</tr>";
		} else {
			echo "
			<tr>
			<td valign=top class=\"formularioCampo\" colspan=\"3\"><br>NO SE REALIZÓ NINGUNA OBSERVACION</td>
			</tr>";
			
		}
	
		
		echo "</table>";
		
				echo "<br><br>";
				echo "<table width=\"600\" border=\"0\" align=\"center\">
				<tr>";
					echo "<td class=\"tituloPagina\" colspan=\"5\" align=\"center\">PUNTOS PENDIENTE ACTUALES</td>
				</tr>";
				$puntosPendientes= new puntoPendiente();
				$puntosPendientes->setPuntoPendiente("",$row[1]);
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
				} else {
					echo "<tr valign=top class=\"tablaTitulo\">
					<td align=\"left\" class=\"tablaFilaNone\">NO TIENE PUNTOS PENDIENTES</td>
					</tr>";						
				
				}
				echo "</table>";			


?>