<?php
//ReporteGarantia
?>
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
 <script language="javascript">
	function cambiarSeleccion() {
		document.frmGarantia.funcion.value=0;
	 	document.frmGarantia.submit();
	}
	function cambiarProveedor() {
		document.frmGarantia.selStatus.value=100;
	 	document.frmGarantia.funcion.value=0;
	 	document.frmGarantia.submit();
	}
	function buscar() {
		document.frmGarantia.funcion.value=0;
	 	document.frmGarantia.submit();
	}
	function generarSalida() {
		document.frmGarantia.funcion.value=1;
	 	document.frmGarantia.submit();
	}
	function cambiarFueraPlanta() {
		document.frmGarantia.funcion.value=2;
	 	document.frmGarantia.submit();
	}
	function imprimirSalidas() {
		document.frmGarantia.funcion.value=4;
	 	document.frmGarantia.submit();
	}
	function generarExcel() {
		proveedor=document.frmGarantia.selProveedor.value;
		descripcion=document.frmGarantia.selDescripcion.value;
		estado=document.frmGarantia.selStatus.value;
		serial=document.frmGarantia.txtSerial.value;
		fechaInicio=document.frmGarantia.txtFechaInicio.value;		
		fechaFinal=document.frmGarantia.txtFechaFinal.value;		
		window.open('../librerias/rptGarantiaExcel.php?proveedor='+proveedor+'&descripcion='+descripcion+'&estado='+estado+'&serial='+serial+'&fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal);	
	}
	
</script>
<?php
switch ($funcion) {
	case 1:
		require_once("garantiaAdmin.php");	
		$garantia= new garantia();
		$garantia->setGarantia($_POST[chkGarantia],"","","STG0000002");
		$resultado=$garantia->cambiarStatusGarantia();
		
		switch ($resultado) {
			case 0:
				if (isset($_POST[chkGarantia]) && !empty($_POST[chkGarantia])) {
					$aLista=$_POST['chkGarantia'];
					$valores="'".implode(',',$aLista)."'";
					$valores=str_replace(',','\',\'',$valores);
					echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
					echo "<input name=\"selStatus\" type=\"hidden\" value=\"$_POST[selStatus]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: GARANTIA - CAMBIAR ESTADO</td>
							</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>SE CAMBIO EL ESTADO DE REPORTADO A SALIDA.</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnLimpiar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php?item=506'\">
					<input name=\"btnLimpiar\" type=\"button\" value=\"IMPRIMIR\" onclick=window.open(\"../librerias/xmlSalidaEquipos.php?valores=$valores\")></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";
				}
				break 1;
			case 1:
					echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
					echo "<input name=\"selStatus\" type=\"hidden\" value=\"$_POST[selStatus]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: GARANTIA - CAMBIAR ESTADO</td>
							</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>NO SE PUDO CAMBIAR EL ESTADO</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnLimpiar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php?item=506'\"></td>
  						</tr>";
					echo "</table>";
					echo "</form>";
				break 1;	
		}
		break 1;
	case 2:
		require_once("garantiaAdmin.php");	
		$garantia= new garantia();
		$garantia->setGarantia($_POST[chkGarantia],"","","STG0000003");
		$resultado=$garantia->cambiarStatusGarantia();
		switch ($resultado) {
			case 0:							
				echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
				echo "<input name=\"selStatus\" type=\"hidden\" value=\"$_POST[selStatus]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: GARANTIA - CAMBIAR ESTADO</td>
						</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>SE CAMBIO EL ESTADO DE SALIDA A FUERA DE PLANTA.</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnLimpiar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php?item=506'\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";
				break 1;
			case 1:
				echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
				echo "<input name=\"selStatus\" type=\"hidden\" value=\"$_POST[selStatus]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: GARANTIA - CAMBIAR ESTADO</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>NO SE PUDO CAMBIAR EL ESTADO</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnLimpiar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php?item=506'\"></td>
					</tr>";
				echo "</table>";
				echo "</form>";			
				break 1;
		}
		break 1;
		case 3:

		break 1;
		case 4:
			if (isset($_POST[chkGarantia]) && !empty($_POST[chkGarantia])) {
				$aLista=$_POST['chkGarantia'];
				$valores="'".implode(',',$aLista)."'";
				$valores=str_replace(',','\',\'',$valores);
				echo "<script language=\"javascript\"> window.open(\"../librerias/xmlSalidaEquipos.php?valores=$valores\") </script>";
			}
			frmGarantia();
		break 1;
	default:
		frmGarantia();	
}

function frmGarantia() {
	require_once "conexionsql.php";
	require_once "formularios.php";
	require_once("garantiaAdmin.php");
	$conProveedor="Select distinct
		proveedor.ID_PROVEEDOR,
		proveedor.PROVEEDOR
		From
		garantia
		Inner Join detalle_garantia ON garantia.ID_GARANTIA = detalle_garantia.ID_GARANTIA
		Inner Join inventario ON garantia.ID_INVENTARIO = inventario.ID_INVENTARIO
		Inner Join pedido ON inventario.ID_PEDIDO = pedido.ID_PEDIDO
		Inner Join proveedor ON pedido.ID_PROVEEDOR = proveedor.ID_PROVEEDOR
		Where
		detalle_garantia.STATUS_ACTIVO = '1'
		Order By
		proveedor.PROVEEDOR Asc";
	
	$conEstadoGarantia="Select distinct
		garantia_estado.ID_GARANTIA_ESTADO,
		garantia_estado.GARANTIA_ESTADO
		From
		garantia
		Inner Join detalle_garantia ON garantia.ID_GARANTIA = detalle_garantia.ID_GARANTIA
		Inner Join inventario ON garantia.ID_INVENTARIO = inventario.ID_INVENTARIO
		Inner Join pedido ON inventario.ID_PEDIDO = pedido.ID_PEDIDO
		Inner Join proveedor ON pedido.ID_PROVEEDOR = proveedor.ID_PROVEEDOR
		Inner Join garantia_estado ON detalle_garantia.ID_GARANTIA_ESTADO = garantia_estado.ID_GARANTIA_ESTADO
		Where
		detalle_garantia.STATUS_ACTIVO = '1' AND
		proveedor.ID_PROVEEDOR = '$_POST[selProveedor]'
		Order By
		proveedor.PROVEEDOR Asc";
	
	$conDescripcion= "select distinct descripcion_id_descripcion,descripcion_descripcion from vistagarantia  where id_proveedor like '%$_POST[selProveedor]' order by  descripcion_descripcion";
	//Campo Proveedor
	$proveedor= new campoSeleccion("selProveedor","formularioCampoSeleccion","$_POST[selProveedor]","onChange","cambiarProveedor()",$conProveedor,"--SELECCIONE--","");
	$selProveedor=$proveedor->retornar();	
	
	//CAMPO STATUS
	$status= new campoSeleccion("selStatus","formularioCampoSeleccion","$_POST[selStatus]","onChange","cambiarSeleccion()",$conEstadoGarantia,"--SELECCIONE--","");
	$selStatus=$status->retornar();
	//CAMPO SERIAL
	$serial= new campo("txtSerial","text","formularioCampoTexto","$_POST[txtSerial]","30","30","onKeyPress","if (event.keyCode==13) buscar();");
	$txtSerial=$serial->retornar();

	//Campo Descripcion
	$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion","$_POST[selDescripcion]","onChange","cambiarSeleccion()",$conDescripcion,"--TODOS--","");
	$selDescripcion=$descripcion->retornar();	
	
//**********************************************************************************************************************************************************************
//**********************************************************************************************************************************************************************
	$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10");
	$txtFechaInicio=$fechaInicio->retornar();

	$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
	$txtFechaFinal=$fechaFinal->retornar();
//**********************************************************************************************************************************************************************
//**********************************************************************************************************************************************************************
	
	echo "<form name=\"frmGarantia\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"estado\" type=\"hidden\" value=\"$_POST[estado]\">";
	
	echo "<table class=\"formularioTabla\"align=center width=\"580\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"2\">GARANTIA</td>
  				</tr>";
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">EQUIPOS Y COMPONENTES EN GARANTIA</td>
	</tr>";
	echo"<tr>
		<td valign=top class=\"formularioCampoTitulo\" >FECHA INICIAL<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmGarantia.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></td>
		<td valign=top class=\"formularioCampoTitulo\" >FECHA FINAL<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmGarantia.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></td>
		</tr>";	
	echo "<tr>
	<td valign=top class=\"formularioCampoTitulo\">PROVEEDOR<br>$selProveedor<br>
	ESTATUS GARANTIA<br>$selStatus<br>
	SERIAL<br>$txtSerial<br></td><td valign=\"top\" class=\"formularioCampoTitulo\">DESCRIPCION<BR>$selDescripcion</td>
</tr>";
	echo "<tr>";
	echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=506'\">
	<input name=\"Limpiar\" type=\"button\" value=\"BUSCAR\" onClick=\"buscar()\">
	<a class=enlace href=\"#\" onclick=\"generarExcel()\">EXCEL</a></td>
	
  				
			</tr>";
	echo "</table>";
	
	$garantia=new garantia();
	if($_POST[selStatus]==100)
		$_POST[selStatus]="";
	if ($_POST[selProveedor]==100)
		$_POST[selProveedor]="";
		
	if ($_POST[selDescripcion]==100)
		$_POST[selDescripcion]="";
		
	$resultado=$garantia->retornarEquiposReportados($_POST[selStatus],$_POST[selProveedor],$_POST[txtSerial],$_POST[selDescripcion],$_POST[txtFechaInicio],$_POST[txtFechaFinal]);
	if ($resultado && $resultado!=1) {
		echo "<table width=\"70%\" border=\"0\" align=\"center\">
		<tr>
		<td valign=top class=\"tablaTitulo\" colspan=\"7\"><b></b></td>
		</tr>
		<tr>
		<td valign=top class=\"tablaTitulo\"><b>SERIAL</b></td>
		<td valign=top class=\"tablaTitulo\"><b>DESCRIPCI&Oacute;N</b></td>		  
		<td valign=top class=\"tablaTitulo\"><b>MARCA</b></td>
		<td valign=top class=\"tablaTitulo\"><b>MODELO</b></td>
		<td valign=top class=\"tablaTitulo\"><b>PROVEEDOR</b></td>
		<td valign=top class=\"tablaTitulo\"><b>ESTADO</b></td>
		<td valign=top class=\"tablaTitulo\"><b>CONFIGURACION</b></td>
		<td valign=top class=\"tablaTitulo\"><b>FECHA_ASOCIACION</b></td>
		</tr>";

		while ($row=mysql_fetch_array($resultado)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">";
			echo "<td align=\"left\">";
			if (!empty($_POST[selStatus]) && $_POST[selStatus]!="STG0000004" && $_POST[selStatus]!="STG0000003")
				echo "<input name=\"chkGarantia[]\" type=\"checkbox\" value=\"$row[0]\">";
			if ($_POST[selStatus]=='STG0000003') {
				if ($row[11]=="DSP0000004") 
					echo "<a class=enlace href=\"index2.php?item=505&serial=$row[8]\">$row[8]</td>";
				else
					echo "<a class=enlace href=\"index2.php?item=504&serial=$row[8]\">$row[8]</td>";
			} else {
				echo "$row[8]</td>";
			}
			echo "<td>$row[10]</td>
				<td>$row[13]</td>
				<td>$row[15] $row[16] $row[17]</td>
				<td>$row[26]</td>
				<td>$row[5]</td>
				<td>$row[32] $row[43]</td>
				<td>".substr($row[2],8,2)."/".substr($row[2],5,2)."/".substr($row[2],0,4)."</td>
				</tr>";
			$i++;	
		}
		switch ($_POST[selStatus]) {
			case "STG0000001":
					echo "<tr>
					<td valign=top class=\"tablaTitulo\" colspan=\"7\">
					<input name=\"btnSalida\" type=\"button\" value=\"GENERAR SALIDA\" onclick=\"generarSalida()\">
					</td>
					</tr>";
			break 1;
			case "STG0000002":
					echo "<tr>
					<td valign=top class=\"tablaTitulo\" colspan=\"7\">
					<input name=\"btnSalida\" type=\"button\" value=\"FUERA DE PLANTA\" onclick=\"cambiarFueraPlanta()\">
					<input name=\"btnSalida\" type=\"button\" value=\"IMPRIMIR SALIDAS\" onclick=\"imprimirSalidas()\">
					</td>
					</tr>";
			break 1;
				
		}
		echo "</table>";	
	}
	echo "</form>";
	


}
?>