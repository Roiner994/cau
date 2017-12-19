<?php
//Detalle del Equipo

  
  

?>
<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
require_once("membrete.php");
require_once("conexionsql.php");
require_once("rptAdmin.php");
require_once("inventarioadmin.php");
require_once("mantenimientoAdmin.php");
require_once("puntoPendienteAdmin.php");

$rptequipo= new rptEquipos();
$resultadoEquipo=$rptequipo->retornarInventarioEquipos("","","","","","","",$_GET[configuracion]);




if ($resultadoEquipo && $resultadoEquipo!=1) {
	$rowEquipo=mysql_fetch_array($resultadoEquipo);	
}

$equipoBuscar= new equipo();
$equipoBuscar->setEquipo($_GET[configuracion]);
$resultado=$equipoBuscar->buscarEquipo();
$componenteAsociado=$equipoBuscar->buscarComponentesAsociados();


$equipoUbicacion=$equipoBuscar->buscarUbicacion(1);


$equipoMantenimiento= new mantenimiento();
$equipoMantenimiento->setDatosMantenimiento("",$_GET[configuracion]);
$resultadoMantenimiento=$equipoMantenimiento->buscarMantenimiento();

	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"top\" type=\"hidden\" value=\"\">";
	
	
	echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"4\">DETALLE DEL EQUIPO</td>
  	</tr>";
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"4\">DATOS DEL EQUIPO</td><td class=\"formularioTablaTitulo\"></td>
	</tr>";	
	echo "<tr valign=top class=\"tablaTitulo\">
	<td align=\"left\" class=\"campoTitulo\">CONFIGURACI&Oacute;N: <b class=\"campo\">$_GET[configuracion]</td>
	<td valign=top class=\"campoTitulo\">ACTIVO FIJO: <b class=\"campo\">$rowEquipo[1]</b></td>
	<td valign=top class=\"campoTitulo\">SERIAL:<b class=\"campo\"> $rowEquipo[8]</td>
	<td valign=top class=\"campoTitulo\">DESCRIPCI&Oacute;N:<b class=\"campo\"> $rowEquipo[10]</td>
	</tr>";
	echo "<tr valign=top class=\"tablaTitulo\">
	<td align=\"left\" class=\"campoTitulo\">MARCA: <b class=\"campo\">$rowEquipo[13]</td>
	<td valign=top class=\"campoTitulo\">MODELO: <b class=\"campo\">$rowEquipo[15] $rowEquipo[16] $rowEquipo[17]</td>
	<td valign=top class=\"campoTitulo\">PRODUCT NUMBER:<b class=\"campo\"> $rowEquipo[19]</td>
	<td valign=top class=\"campoTitulo\">CT: <b class=\"campo\">$rowEquipo[21]</td>
	</tr>";
	echo "<tr valign=top class=\"tablaTitulo\">
	<td align=\"left\" class=\"campoTitulo\">FRU: <b class=\"campo\">$rowEquipo[18]</td>
	<td valign=top class=\"campoTitulo\">SPARE NUMBER:<b class=\"campo\"> $rowEquipo[20]</td>
	<td valign=top class=\"campoTitulo\">PEDIDO:<b class=\"campo\"> $rowEquipo[22]</td>
	<td valign=top class=\"campoTitulo\">PROVEEDOR:<b class=\"campo\"> $rowEquipo[24]</td>
	</tr>";	
	echo "<tr valign=top class=\"tablaTitulo\">
	<td align=\"left\" class=\"campoTitulo\">ESTADO:<b class=\"campo\"> $rowEquipo[46]</td>
	<td valign=top class=\"campoTitulo\">CONECTADO A RED:<b class=\"campo\"> "; 
	if($rowEquipo[4]==1)
		echo "NO";
	else 
		echo "SI";
		
	echo "</td>
	<td valign=top class=\"campoTitulo\">USUARIO ESPECIALIZADO:<b class=\"campo\">"; 
		if($rowEquipo[6]==1)
		echo "SI";
	else 
		echo "NO";
 
	echo"</td>
	<td valign=top class=\"campoTitulo\">EQUIPO CRITICO:<b class=\"campo\">";
		if($rowEquipo[5]==1)
		echo "SI";
	else 
		echo "NO";
	
	echo "</td>
	</tr>";
	
	echo "</table>";
	echo "<br>";
	echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"4\">COMPONENTES ASOCIADOS AL EQUIPO</td><td class=\"formularioTablaTitulo\"></td>
	</tr>";

	if ($componenteAsociado && $componenteAsociado!=1) {
		echo "<tr valign=top class=\"tablaTitulo\">
			<td align=\"left\" class=\"campoTitulo\">DESCRIPCI&Oacute;N<b class=\"campo\"></td>
			<td valign=top class=\"campoTitulo\">MARCA<b class=\"campo\"></td>
			<td valign=top class=\"campoTitulo\">MODELO<b class=\"campo\"></td>
			<td valign=top class=\"campoTitulo\">SERIAL<b class=\"campo\"></td>
			</tr>";
			while ($rowComponentesAsociados=mysql_fetch_array($componenteAsociado)) {
				if ($i%2==0) {
					$clase="tablaFilaPar";
				} else {
					$clase="tablaFilaNone";
				}
				echo "<tr class=\"$clase\">
					<td align=\"left\"><a class=enlace href=\"componenteDetalle.php?idInventario=$rowComponentesAsociados[2]\">$rowComponentesAsociados[5]</td>
					<td>$rowComponentesAsociados[7]</td>
					<td>$rowComponentesAsociados[9] $rowComponentesAsociados[10] $rowComponentesAsociados[11]</td>
					<td>$rowComponentesAsociados[3]</td>
				</tr>";
				$i++;
			}
	   } else {
		echo "<tr class=\"$clase\">
					<td align=\"center\" colspan=\"5\">LISTA NO DISPONIBLE</td>";
		echo "</tr>";	
	}	
	echo "</table>";
	
	echo "<br>";
	echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";
	
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"4\">USUARIO</td><td class=\"formularioTablaTitulo\"></td>
	</tr>";
	echo "<tr valign=top class=\"tablaTitulo\">
	<td align=\"left\" class=\"campoTitulo\"><b>FICHA</td>
	<td valign=top class=\"campoTitulo\">USUARIO </td>
	<td valign=top class=\"campoTitulo\">CARGO</td>
	<td valign=top class=\"campoTitulo\">EXTENSI&Oacute;N</td>
	</tr>";	
	echo "<tr valign=top class=\"tablaTitulo\">
	<td align=\"left\" class=\"campoTitulo\"><b class=\"campo\"> $rowEquipo[47]</td>
	<td valign=top class=\"campoTitulo\"> <b class=\"campo\">$rowEquipo[49] $rowEquipo[50]</td>
	<td valign=top class=\"campoTitulo\"><b class=\"campo\"> $rowEquipo[52]</td>
	<td valign=top class=\"campoTitulo\"><b class=\"campo\">$rowEquipo[53]</td>
	</tr>";	
	echo "</table>";

	echo "<br>";
	echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";	
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"4\">UBICACION</td><td class=\"formularioTablaTitulo\"></td>
	</tr>";
	echo "<tr valign=top class=\"tablaTitulo\">
	<td align=\"left\" class=\"campoTitulo\"><b>EDIFICIO</td>
	<td valign=top class=\"campoTitulo\">GERENCIA</td>
	<td valign=top class=\"campoTitulo\">DIVISI&Oacute;N</td>
	<td valign=top class=\"campoTitulo\">DEPARTAMENTO</td>
	</tr>";	
	
	if ($equipoUbicacion && $equipoUbicacion!=1) {
		$rowUbicacion=mysql_fetch_array($equipoUbicacion);
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			$fechaUbicacion=substr($rowUbicacion[15],8,2)."/".substr($rowUbicacion[15],5,2)."/".substr($rowUbicacion[15],0,4);	
			echo "<tr valign=top class=\"tablaTitulo\" title=\"$rowUbicacion[10] Fecha: $fechaUbicacion\">
			<td align=\"left\" class=\"$clase\"><b class=\"campo\">$rowUbicacion[3]</b></td>
			<td valign=top class=\"$clase\"><b class=\"campo\">$rowUbicacion[5]</b></td>
			<td valign=top class=\"$clase\"><b class=\"campo\">$rowUbicacion[7]</b></td>
			<td valign=top class=\"$clase\"><b class=\"campo\">$rowUbicacion[9]</b></td>
			</tr>";
			$i++;		
	}
	echo "</table>";
	echo "<br>";
	echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"4\">MANTENIMIENTOS PREVENTIVOS</td><td class=\"formularioTablaTitulo\"></td>
	</tr>";

	if ($resultadoMantenimiento && $resultadoMantenimiento!=1) {
		echo "<tr valign=top class=\"tablaTitulo\">
			<td align=\"left\" class=\"campoTitulo\">MANTENIMIENTO<b class=\"campo\"></td>
			<td valign=top class=\"campoTitulo\">USUARIO<b class=\"campo\"></td>
			<td valign=top class=\"campoTitulo\">EDIFICIO<b class=\"campo\"></td>
			<td valign=top class=\"campoTitulo\">FECHA Y HORA<b class=\"campo\"></td>
			<td valign=top class=\"campoTitulo\">PLANILLA DE MANTENIMIENTO<b class=\"campo\"></td>
			</tr>";
			while ($rowMantenimiento=mysql_fetch_array($resultadoMantenimiento)) {
				if ($i%2==0) {
					$clase="tablaFilaPar";
				} else {
					$clase="tablaFilaNone";
				}
				echo "<tr class=\"$clase\">
					<td align=\"left\"><a class=enlace href=\"mantenimientodetalle.php?idMantenimiento=$rowMantenimiento[0]\">$rowMantenimiento[0]</td>
					<td>$rowMantenimiento[19] $rowMantenimiento[20]</td>
					<td>$rowMantenimiento[31]</td>					
					<td>$rowMantenimiento[33]</td>";
					if($rowMantenimiento[45]=='')
						echo "<td ><a class=enlace href=\"#\" onclick=\"window.open('../librerias/planillaMantenimientoCargar.php?configuracion=$rowMantenimiento[0]','','width=550,height=250,status=no,resizable=no,top=200,left=500');\">CARGAR PLANILLA</a>     </td>";
					else
						echo "<td ><a class=enlace href=\"#\" onclick=\"window.open('../librerias/planillas_asignacion.php?url=$rowMantenimiento[45]');\"> DESCARGAR </a>  <a class=none>  &nbsp;  </a>  <a class=enlace href=\"#\" onclick=\"window.open('../librerias/planillaMantenimientoCargar.php?configuracion=$rowMantenimiento[0]','','width=550,height=250,status=no,resizable=no,top=200,left=500');\">ACT</a></td>";
				
				echo "</tr>";
				$i++;
			}
	   } else {
		echo "<tr class=\"$clase\">
					<td align=\"center\" colspan=\"4\">LISTA NO DISPONIBLE</td>";
		echo "</tr>";	
	}	
	echo "</table>";
	echo "<br>";
	echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"4\">PUNTOS PENDIENTES</td><td class=\"formularioTablaTitulo\"></td>
	</tr>";
	
				$puntosPendientes= new puntoPendiente();
				$puntosPendientes->setPuntoPendiente("",$_GET[configuracion]);
				$puntosPendientes->setDetallePuntoPendiente("","","",0);
				$resultadoPendiente=$puntosPendientes->retornarPuntosPendientes();	
				if ($resultadoPendiente && $resultadoPendiente!=1) {
					echo "<tr valign=top class=\"tablaTitulo\">
					<td valign=top class=\"tablaTitulo\">ANALISTA</td>
					<td valign=top class=\"tablaTitulo\">TIPO DE PUNTO PENDIENTE</td>
					<td valign=top class=\"tablaTitulo\">OBSERVACION</td>
					<td valign=top class=\"tablaTitulo\">FECHA</td>
					</tr>";	

					while ($rowPendiente=mysql_fetch_array($resultadoPendiente)) {
						if ($i%2==0) {
							$clase="tablaFilaPar";
						} else {
							$clase="tablaFilaNone";
						}
						echo "<tr class=\"$clase\">
							<td>$rowPendiente[9] $row[10]</td>
							<td>$rowPendiente[5]</td>
							<td>$rowPendiente[6]</td>
							<td>$rowPendiente[11]</td>
						</tr>";
						$i++;
					}
				} else {
					echo "<tr valign=top class=\"tablaTitulo\">
					<td align=\"center\" colspan=\"4\">NO TIENE PUNTOS PENDIENTES</td>
					</tr>";						
				
				}
	echo "</table>";
	echo "<br>";
	echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"4\">ASIGNACIONES</td><td class=\"formularioTablaTitulo\"></td>
	</tr>";
	
				$asignacion= new despachoEquipo();
				$asignacion->setDetalleDespacho("",$_GET[configuracion]);
				$resultadoAsignacion=$asignacion->buscarDespachoEquipos();	
				if ($resultadoAsignacion && $resultadoAsignacion!=1) {
					echo "<tr valign=top class=\"tablaTitulo\">
					<td valign=top class=\"tablaTitulo\">USUARIO</td>
					<td valign=top class=\"tablaTitulo\">GERENCIA</td>
					<td valign=top class=\"tablaTitulo\">EDIFICIO</td>
					<td valign=top class=\"tablaTitulo\">FECHA</td>
					</tr>";	
					while ($rowAsignacion=mysql_fetch_array($resultadoAsignacion)) {
						if ($i%2==0) {
							$clase="tablaFilaPar";
						} else {
							$clase="tablaFilaNone";
						}
						$fechaAsignacion=substr($rowAsignacion[44],8,2)."/".substr($rowAsignacion[44],5,2)."/".substr($rowAsignacion[44],0,4);
						echo "<tr class=\"$clase\">
							<td>$rowAsignacion[7] $rowAsignacion[8]</td>
							<td>$rowAsignacion[38]</td>
							<td>$rowAsignacion[36]</td>
							<td>$fechaAsignacion</td>
						</tr>";
						$i++;
					}
				} else {
					echo "<tr valign=top class=\"tablaTitulo\">
					<td align=\"center\" colspan=\"4\">NO TIENE ASIGNACIONES</td>
					</tr>";						
				
				}	
	
	echo "</table>";
	echo "<br>";
	echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"4\">HISTORIAL DEL EQUIPO</td>
  	</tr>";
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"4\">COMPONENTES</td><td class=\"formularioTablaTitulo\"></td>
	</tr>";
	
$componenteAsociado=$equipoBuscar->buscarComponentesAsociados('p');	
	if ($componenteAsociado && $componenteAsociado!=1) {
		echo "<tr valign=top class=\"tablaTitulo\">
			<td align=\"left\" class=\"campoTitulo\">DESCRIPCI&Oacute;N<b class=\"campo\"></td>
			<td valign=top class=\"campoTitulo\">MARCA<b class=\"campo\"></td>
			<td valign=top class=\"campoTitulo\">MODELO<b class=\"campo\"></td>
			<td valign=top class=\"campoTitulo\">SERIAL<b class=\"campo\"></td>
			</tr>";
			while ($rowComponentesAsociados=mysql_fetch_array($componenteAsociado)) {
				if ($i%2==0) {
					$clase="tablaFilaPar";
				} else {
					$clase="tablaFilaNone";
				}
				echo "<tr class=\"$clase\">
					<td align=\"left\"><a class=enlace href=\"componenteDetalle.php?idInventario=$rowComponentesAsociados[2]\">$rowComponentesAsociados[5]</td>
					<td>$rowComponentesAsociados[7]</td>
					<td>$rowComponentesAsociados[9] $rowComponentesAsociados[10] $rowComponentesAsociados[11]</td>
					<td>$rowComponentesAsociados[3]</td>
				</tr>";
				$i++;
			}
	   } else {
		echo "<tr class=\"$clase\">
					<td align=\"center\" colspan=\"4\">NO TIENE HISTORIAL DE REEMPLAZO DE COMPONENTES</td>";
		echo "</tr>";	
	}
	echo "</table>";

	
	echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"4\">USUARIO</td><td class=\"formularioTablaTitulo\"></td>
	</tr>";
$buscarUsuario=$equipoBuscar->buscarUsuario(0);	
	if ($buscarUsuario && $buscarUsuario!=1) {
		echo "<tr valign=top class=\"tablaTitulo\">
			<td align=\"left\" class=\"campoTitulo\">FICHA<b class=\"campo\"></td>
			<td valign=top class=\"campoTitulo\">USUARIO<b class=\"campo\"></td>
			<td valign=top class=\"campoTitulo\">EXTENSION<b class=\"campo\"></td>
			<td valign=top class=\"campoTitulo\">UBICACION<b class=\"campo\"></td>
			</tr>";
			while ($rowUsuario=mysql_fetch_array($buscarUsuario)) {
				if ($i%2==0) {
					$clase="tablaFilaPar";
				} else {
					$clase="tablaFilaNone";
				}
				echo "<tr class=\"$clase\">
					<td align=\"left\">$rowUsuario[5]</td>
					<td>$rowUsuario[6] $rowUsuario[7]</td>
					<td>$rowUsuario[10]</td>
					<td>$rowUsuario[12]</td>
				</tr>";
				$i++;
			}
	   } else {
		echo "<tr class=\"$clase\">
					<td align=\"center\" colspan=\"4\">NO TIENE HISTORIAL DE CAMBIOS DE USUARIO</td>";
		echo "</tr>";	
	}
	echo "</table>";

	echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";	
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"4\">UBICACION</td><td class=\"formularioTablaTitulo\"></td>
	</tr>";
$buscarUbicacion=$equipoBuscar->buscarUbicacion(0);	
	if ($buscarUbicacion && $buscarUbicacion!=1) {
		echo "<tr valign=top class=\"tablaTitulo\">
			<td align=\"left\" class=\"campoTitulo\">EDIFICIO<b class=\"campo\"></td>
			<td valign=top class=\"campoTitulo\">GERENCIA<b class=\"campo\"></td>
			<td valign=top class=\"campoTitulo\">DIVISION<b class=\"campo\"></td>
			<td valign=top class=\"campoTitulo\">DEPARTAMENTO<b class=\"campo\"></td>
			</tr>";
			while ($rowUbicacion=mysql_fetch_array($buscarUbicacion)) {
				if ($i%2==0) {
					$clase="tablaFilaPar";
				} else {
					$clase="tablaFilaNone";
				}
				echo "<tr class=\"$clase\" title=\"$rowUbicacion[10]\">
					<td align=\"left\">$rowUbicacion[3]</td>
					<td>$rowUbicacion[5]</td>
					<td>$rowUbicacion[7]</td>
					<td>$rowUbicacion[9]</td>
				</tr>";
				$i++;
			}
	   } else {
			echo "<tr class=\"$clase\">
					<td align=\"center\" colspan=\"4\">LISTA NO DISPONIBLE</td>";
			echo "</tr>";	
		}
	
	
	echo "</table>";
	
	///nueva seccion
	
	
	
	echo "<br>";
	echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"3\">HISTORIAL DEL EQUIPO</td>
  	</tr>";	
  	
  	echo "<tr valign=top class=\"tablaTitulo\">
		<td align=\"left\" class=\"campoTitulo\"><b>FECHA DE ASOCIACION DEL EQUIPO</td>
		<td align=\"left\" class=\"campoTitulo\"><b>FECHA DE CREACION DE LA PLANILLA</td>
		<td align=\"left\" class=\"campoTitulo\"><b>PLANILLA</td>
		</tr>";	
	
	
	
	
	$query="SELECT DATE_FORMAT(planillas_asignacion.FECHA_CREACION,'%d/%m/%Y'),DATE_FORMAT(planillas_asignacion.FECHA_ASOCIACION_EQUIPO,'%d/%m/%Y'),SUBSTRING_INDEX(SUBSTRING_INDEX(planillas_asignacion.ID_PLANILLA_ASIGNACION,';',2),';',-1),planillas_asignacion.ID_PLANILLA_ASIGNACION
			FROM planillas_asignacion
			WHERE planillas_asignacion.CONFIGURACION='$_GET[configuracion]'";
	
	
	
	conectarMySql();
	$resultado=mysql_query($query);
	if($resultado &&  mysql_num_rows($resultado)){
		while($row=mysql_fetch_array($resultado))	
			echo "<tr valign=top class=\"tablaTitulo\">		
				<td align=\"left\" class=\"$clase\"><b class=\"campo\">$row[0]</td>	
				<td align=\"left\" class=\"$clase\"><b class=\"campo\">$row[1]</td>	
				<td align=\"left\" class=\"$clase\"><b class=\"campo\"><a class=enlace href=\"planillas_asignacion.php?url=$row[3]\">$row[2]</a></td>
				</tr>";
	}	
	echo "</table>";
	
	
	
	
	
	
	
	
?>
