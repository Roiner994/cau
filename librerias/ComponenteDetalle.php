<?php
//DETALLE DE LOS COMPONENTES
?>
<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
require_once("membrete.php");
require_once("conexionsql.php");
require_once("rptAdmin.php");
require_once("inventarioAdmin.php");


$rptcomponente= new componente();
$rptcomponente->setInventario($_GET[idInventario]);
$resultadoComponentes=$rptcomponente->buscarComponentes();
if ($resultadoComponentes && $resultadoComponentes!=1) {
	$rowComponente=mysql_fetch_array($resultadoComponentes);
}

$configuracionAsociada= new equipo();
$configuracionAsociada->setInventario($_GET[idInventario]);

$resultadoConfiguracion=$configuracionAsociada->buscarComponentesAsociados();
if ($resultadoConfiguracion && $resultadoConfiguracion!=1) {
	$rowConfiguracion=mysql_fetch_array($resultadoConfiguracion);
}
	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"top\" type=\"hidden\" value=\"\">";
	
	
	
	echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"4\">DETALLE DEL COMPONENTE</td>
  	</tr>";
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"4\">DATOS DEL COMPONENTE</td><td class=\"formularioTablaTitulo\"></td>
	</tr>";	
	echo "<tr valign=top class=\"tablaTitulo\">	
	<td valign=top class=\"campoTitulo\">SERIAL:<b class=\"campo\"> $rowComponente[1]</td>
	<td valign=top class=\"campoTitulo\">DESCRIPCI&Oacute;N:<b class=\"campo\"> $rowComponente[3]</td>
	<td align=\"left\" class=\"campoTitulo\">MARCA: <b class=\"campo\">$rowComponente[5]</td>
	<td valign=top class=\"campoTitulo\">MODELO: <b class=\"campo\">$rowComponente[7] $rowComponente[8] $rowComponente[9]</td>
	</tr>";
	echo "<tr valign=top class=\"tablaTitulo\">	
	<td valign=top class=\"campoTitulo\">PRODUCT NUMBER:<b class=\"campo\"> $rowComponente[11]</td>
	<td valign=top class=\"campoTitulo\">CT: <b class=\"campo\">$rowComponente[13]</td>
	<td align=\"left\" class=\"campoTitulo\">FRU: <b class=\"campo\">$rowComponente[10]</td>
	<td valign=top class=\"campoTitulo\">SPARE NUMBER:<b class=\"campo\"> $rowComponente[12]</td>
	</tr>";
	echo "<tr valign=top class=\"tablaTitulo\">	
	<td valign=top class=\"campoTitulo\">PEDIDO:<b class=\"campo\"> $rowComponente[25]</td>
	<td valign=top class=\"campoTitulo\">PROVEEDOR:<b class=\"campo\"> $rowComponente[27]</td>
	<td align=\"left\" class=\"campoTitulo\">ESTADO:<b class=\"campo\"> $rowComponente[42]</td>	
	<td align=\"left\" class=\"campoTitulo\">CONFIGURACION: <b class=\"campo\"><a class=enlace href=\"EquipoDetalle.php?configuracion=$rowConfiguracion[1]\">$rowConfiguracion[1]</a></td>	
	</tr>";	
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
	<td align=\"left\" class=\"campoTitulo\"><b class=\"campo\"> $rowComponente[34]</td>
	<td valign=top class=\"campoTitulo\"> <b class=\"campo\">$rowComponente[35] $rowComponente[36]</td>
	<td valign=top class=\"campoTitulo\"><b class=\"campo\"> $rowComponente[38]</td>
	<td valign=top class=\"campoTitulo\"><b class=\"campo\">$rowComponente[39]</td>
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
	echo "<tr valign=top class=\"tablaTitulo\">
	<td align=\"left\" class=\"campoTitulo\"><b class=\"campo\">$rowComponente[21]</b></td>
	<td valign=top class=\"campoTitulo\"><b class=\"campo\">$rowComponente[15]</b></td>
	<td valign=top class=\"campoTitulo\"><b class=\"campo\">$rowComponente[17]</b></td>
	<td valign=top class=\"campoTitulo\"><b class=\"campo\">$rowComponente[19]</b></td>
	</tr>";	
	echo "</table>";
	echo "<br>";

	$componenteGarantia=new componente();
	$componenteGarantia->setInventario($_GET[idInventario]);
	
	$resultadoComponenteGarantia=$componenteGarantia->buscarComponentesGarantia();
	
	if ($resultadoComponenteGarantia && $resultadoComponenteGarantia!=1) {
		$rowGarantia=mysql_fetch_array($resultadoComponenteGarantia);
	
		echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";
		echo "<tr>";	
		echo "<td class=\"formularioTablaTitulo\" colspan=\"4\">EQUIPO ASOCIADO EN GARANTIA</td><td class=\"formularioTablaTitulo\"></td>
		</tr>";
		echo "<tr valign=top class=\"tablaTitulo\">
		<td align=\"left\" class=\"campoTitulo\"><b>CONFIGURACION</td>
		<td align=\"left\" class=\"campoTitulo\"><b>SERIAL</td>	
		<td align=\"left\" class=\"campoTitulo\"><b>DESCRIPCION</td>
		<td align=\"left\" class=\"campoTitulo\"><b>MARCA / MODELO</td>	
		</tr>";	
		echo "<tr valign=top class=\"tablaTitulo\">
		<td align=\"left\" class=\"campoTitulo\"><b class=\"campo\"><a class=enlace href=\"EquipoDetalle.php?configuracion=$rowGarantia[0]\">$rowGarantia[0]</a></td>
		<td align=\"left\" class=\"campoTitulo\"><b class=\"campo\">$rowGarantia[3]</td>	
		<td align=\"left\" class=\"campoTitulo\"><b class=\"campo\">$rowGarantia[5]</td>
		<td align=\"left\" class=\"campoTitulo\"><b class=\"campo\">$rowGarantia[7] $rowGarantia[9] $rowGarantia[10] $rowGarantia[11]</td>	
		</tr>";		
		echo "</table>";
	}
	
echo "<br>";
	echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"4\">HISTORIAL DEL COMPONENTE</td>
  	</tr>";	
	
	echo "<tr>";	
	echo "<td class=\"formularioTablaTitulo\" colspan=\"4\">EQUIPOS ASOCIADOS</td><td class=\"formularioTablaTitulo\"></td>
	</tr>";


	$equipoBuscar= new equipo();
	$equipoBuscar->setInventario($_GET[idInventario]);
	$equiposAsociados=$equipoBuscar->buscarComponentesAsociados('p');

	if ($equiposAsociados && $equiposAsociados!=1) {
		echo "<tr valign=top class=\"tablaTitulo\">
		<td align=\"left\" class=\"campoTitulo\"><b>CONFIGURACION</td>
		<td align=\"left\" class=\"campoTitulo\"><b>SERIAL</td>	
		<td align=\"left\" class=\"campoTitulo\"><b>DESCRIPCION</td>
		<td align=\"left\" class=\"campoTitulo\"><b>MARCA / MODELO</td>	
		</tr>";	
		while ($rowEquipos=mysql_fetch_array($equiposAsociados)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}			
			$equipo= new equipo();
			$equipo->setEquipo($rowEquipos[1]);
			$resultado=$equipo->buscarEquipo();
			
			$rowEquipos=mysql_fetch_array($resultado);

			echo "<tr valign=top class=\"tablaTitulo\">
			<td align=\"left\" class=\"$clase\"><b class=\"campo\"><a class=enlace href=\"EquipoDetalle.php?configuracion=$rowEquipos[0]\">$rowEquipos[0]</a></td>
			<td align=\"left\" class=\"$clase\"><b class=\"campo\">$rowEquipos[3]</td>	
			<td align=\"left\" class=\"$clase\"><b class=\"campo\">$rowEquipos[5]</td>
			<td align=\"left\" class=\"$clase\"><b class=\"campo\">$rowEquipos[7] $rowEquipos[9] $rowEquipos[10] $rowEquipos[11]</td>	
			</tr>";		
			
		}
	} else {
		echo "<tr class=\"$clase\">
		<td align=\"center\" colspan=\"4\">NO TIENE HIST&Oacute;RICO DE EQUIPOS</td>";
		echo "</tr>";
	}
		
	echo "</table>";	
	
	
	
	
	
	
	echo "<br>";
	echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"3\">HISTORIAL DEL COMPONENTE</td>
  	</tr>";	
  	
  	echo "<tr valign=top class=\"tablaTitulo\">
		<td align=\"left\" class=\"campoTitulo\"><b>FECHA DE ASOCIACION DEL COMPONENTE</td>
		<td align=\"left\" class=\"campoTitulo\"><b>FECHA DE CREACION DE PLANILLA</td>	
		<td align=\"left\" class=\"campoTitulo\"><b>PLANILLA</td>		
		</tr>";	
	
	
	
	
	$query="SELECT DATE_FORMAT(planillas_componente.FECHA_CREACION,'%d/%m/%Y'),DATE_FORMAT(planillas_componente.FECHA_ASOCIACION_COMPONENTE,'%d/%m/%Y'),SUBSTRING_INDEX(SUBSTRING_INDEX(planillas_componente.ID_PLANILLA_COMPONENTE,';',2),';',-1),planillas_componente.ID_PLANILLA_COMPONENTE
	 FROM planillas_componente,inventario 
	 WHERE planillas_componente.SERIAL=inventario.SERIAL AND inventario.ID_INVENTARIO='$_GET[idInventario]'
	";	
	
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
