<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
require_once("seguridad.php");
?>
<script language="javascript">
function buscarConfiguracion() {
		if (document.frmEquipo.txtConfiguracion.value!="") {
			document.frmEquipo.funcion.value=0;
			document.frmEquipo.cambiarConfiguracion.value=1;
			posicionamientoPantalla();
			document.frmEquipo.submit();
		} else {
			document.frmEquipo.txtSerial.value="";
			document.frmEquipo.txtActivoFijo.value="";
			document.frmEquipo.txtDescripcion.value="";
			document.frmEquipo.txtMarca.value="";
			document.frmEquipo.txtModelo.value="";
		}
	}
</script>

<?php




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
			$mensaje=$mensaje." <b>TRABAJO REALIZADO</b>";
			$i++;
			$sw=1;
		}
		switch($i) {
			case 0:
				require_once("puntoPendienteAdmin.php");
				require_once("administracion.php");
				$login=$_SESSION["login"];
				$pendiente= new puntoPendiente();
				$pendiente->setPuntoPendiente($_POST[selPendiente],$_POST[txtConfiguracion]);
				$pendiente->setDetallePuntoPendiente("",$_POST[selTipoPendiente],$_POST[txtDetallePendiente],0,$login);
				$resultado=$pendiente->actualizarDetallePuntoPendiente();
				
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
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"CERRAR\" onclick=\"location.href='index2.php?item=9'\"></td>";
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
	frmPendiente($_GET[idPendiente]);
		
}
function frmPendiente($idPendiente="") {
        
		require_once "inventarioAdmin.php";
		require_once "formularios.php";
		require_once "puntoPendienteAdmin.php";
		
		$puntosPendientes= new puntoPendiente();
		$puntosPendientes->setPuntoPendiente($idPendiente);
		$puntosPendientes->setDetallePuntoPendiente("","","",0);
		$resultadoPuntoPendiente=$puntosPendientes->retornarPuntosPendientes();	
		if ($resultadoPuntoPendiente && $resultadoPuntoPendiente!=1) {
			$rowPuntoPendiente=mysql_fetch_array($resultadoPuntoPendiente);
			$_POST[selPendiente]=$rowPuntoPendiente[0];
			$_POST[txtConfiguracion]=$rowPuntoPendiente[1];
			$configuracion=$rowPuntoPendiente[1];
			$_POST[selTipoPendiente]=$rowPuntoPendiente[4];
		}		
		
		
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
			echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
			echo "<input name=\"selPendiente\" type=\"hidden\" value=\"$_POST[selPendiente]\">";	
			echo "<input name=\"selTipoPendiente\" type=\"hidden\" value=\"$_POST[selTipoPendiente]\">";	
				echo "<table width=\"400\" border=\"0\" align=\"center\">
				<tr>";
	
					echo "<td class=\"tituloPagina\" colspan=\"2\" align=\"center\">RESOLVER PUNTO PENDIENTE</td>
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
				<td valign=top class=\"formularioCampo\" colspan=\"2\">$rowPuntoPendiente[5]</td>
				</tr>
				<tr>
				<td valign=top class=\"formularioCampoTitulo\" colspan=\"2\"><b>DETALLE DEL PUNTO PENDIENTE</b></td>
				</tr>
				<tr>
				<td valign=top class=\"formularioCampo\" colspan=\"2\">$rowPuntoPendiente[6]</td>
				</tr>
				<tr>
				<td valign=top class=\"formularioCampoTitulo\" colspan=\"2\"><b>TRABAJO REALIZADO</b></td>
				</tr>
				<tr>
				<td valign=top class=\"formularioCampo\" colspan=\"2\"><textarea class=\"formularioAreaTextoPlanilla\" name=\"txtDetallePendiente\" cols=\"600\" rows=\"2\">$_POST[txtDetallePendiente]</textarea></td>
				</tr>
				<tr>
				<td valign=top class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnGuardar\" type=\"submit\" value=\"GUARDAR\"></td>
				</tr>";	
				
				
				
				
								
				
				
				
				echo "</table>";

				echo "</form>";
				
}

?>