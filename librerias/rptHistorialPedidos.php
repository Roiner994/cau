<?php
//Reporte de Componentes
?>
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
<script type="text/javascript">

    function cambiarSeleccion() {
		document.frmInventarioComponentes.funcion.value=0;			
		document.frmInventarioComponentes.submit();
	}
	
	function buscar() {
		
		document.frmInventarioComponentes.funcion.value=0;
		document.frmInventarioComponentes.validarboton.value=1;
	 	document.frmInventarioComponentes.submit();
	}
	
		
	function generarReporte(idPedido) {		
		idDescripcion=document.frmInventarioComponentes.selDescripcion.value;	
		idMarca=document.frmInventarioComponentes.selMarca.value;		
		idModelo=document.frmInventarioComponentes.selModelo.value;	
		if (idPedido=='')		
		idPedido=document.frmInventarioComponentes.selPedido.value;		 		
		txtSerial=document.frmInventarioComponentes.txtSerial.value;		
		fechaInicio=document.frmInventarioComponentes.txtFechaInicio.value;		
		fechaFinal=document.frmInventarioComponentes.txtFechaFinal.value;		
		
		window.open('../librerias/rptResumenHistorialPedidosComponente.php?idDescripcion='+idDescripcion+'&idMarca='+idMarca+'&idModelo='+idModelo+'&idPedido='+idPedido+'&txtSerial='+txtSerial+'&fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal);	
	}
	
	function generarExcel() {
		idDescripcion=document.frmInventarioComponentes.selDescripcion.value;	
		idMarca=document.frmInventarioComponentes.selMarca.value;		
		idModelo=document.frmInventarioComponentes.selModelo.value;			
		idPedido=document.frmInventarioComponentes.selPedido.value;		 		
		txtSerial=document.frmInventarioComponentes.txtSerial.value;		
		fechaInicio=document.frmInventarioComponentes.txtFechaInicio.value;		
		fechaFinal=document.frmInventarioComponentes.txtFechaFinal.value;		
		
		window.open('../librerias/rptResumenHistorialPedidosComponenteExcel.php?idDescripcion='+idDescripcion+'&idMarca='+idMarca+'&idModelo='+idModelo+'&idPedido='+idPedido+'&txtSerial='+txtSerial+'&fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal);
	}
	
	
	
	
</script>
<?php
switch ($funcion) {
	case 1:
		break 1;
	case 2:
		break 2;
	default:
		frmInventarioComponentes();	
}
function frmInventarioComponentes() {
	require_once("formularios.php");
	require_once("conexionsql.php");
	require_once("rptPedidos.php");
    	
	$conDescripcion="Select descripcion.ID_DESCRIPCION,descripcion.DESCRIPCION,descripcion_propiedad.ID_DESCRIPCION_PROPIEDAD,descripcion_propiedad.DESCRIPCION_PROPIEDAD From descripcion
    Inner Join descripcion_propiedad ON descripcion.ID_DESCRIPCION_PROPIEDAD = descripcion_propiedad.ID_DESCRIPCION_PROPIEDAD Where descripcion.ID_DESCRIPCION_PROPIEDAD != 'DSP0000004' ORDER BY  DESCRIPCION";
	$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion","$_POST[selDescripcion]","onChange","cambiarSeleccion()",$conDescripcion,"--TODOS--","");
	$selDescripcion=$descripcion->retornar();
	
	$conPedido="select pedido.ID_PEDIDO,CONCAT(pedido.ID_PEDIDO,', ',proveedor.PROVEEDOR) AS PROV FROM pedido INNER JOIN proveedor ON (pedido.ID_PROVEEDOR=proveedor.ID_PROVEEDOR) ORDER BY ID_PEDIDO";
    $pedido= new campoSeleccion("selPedido","formularioCampoSeleccion","$_POST[selPedido]","onChange","cambiarPedido()",$conPedido,"--TODOS--","");
	$selPedido=$pedido->retornar();
	
	$conMarca="select descripcion_marca.ID_MARCA, MARCA FROM descripcion_marca INNER JOIN marca ON descripcion_marca.ID_MARCA=marca.ID_MARCA WHERE descripcion_marca.ID_DESCRIPCION ='$_POST[selDescripcion]' ORDER BY MARCA";
    $marca= new campoSeleccion("selMarca","formularioCampoSeleccion","$_POST[selMarca]","onChange","cambiarSeleccion()",$conMarca,"--TODOS--","");
	$selMarca=$marca->retornar();
	
	$conModelo="select ID_MODELO, CONCAT(MODELO,' ',CAP_VEL,' ',UNIDAD) AS MODELO FROM modelo WHERE ID_MARCA='$_POST[selMarca]' AND ID_DESCRIPCION='$_POST[selDescripcion]' ORDER BY MODELO";
	$modelo= new campoSeleccion("selModelo","formularioCampoSeleccion","$_POST[selModelo]","onChange","cambiarModelo()",$conModelo,"--TODOS--","");
	$selModelo=$modelo->retornar();
	
    $configuracion= new campo("txtConfiguracion","text","formularioCampoTexto","$_POST[txtConfiguracion]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtConfiguracion=$configuracion->retornar();
	
	//$activoFijo= new campo("txtActivoFijo","text","formularioCampoTexto","$_POST[txtActivoFijo]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	//$txtActivoFijo=$activoFijo->retornar();

	
	$serial= new campo("txtSerial","text","formularioCampoTexto","$_POST[txtSerial]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtSerial=$serial->retornar();	
	
	
	$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10");
	$txtFechaInicio=$fechaInicio->retornar();

	$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
	$txtFechaFinal=$fechaFinal->retornar();
	
	
	    echo  "<form name=\"frmInventarioComponentes\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"validarboton\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"validar\" type=\"hidden\" value=\"0\">";
		echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
		echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">HISTORIAL DE PEDIDOS POR COMPONENTES </td>
	  	</tr>";
		echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">SELECCIONE EL CAMPO POR EL CUAL QUIERE BUSCAR EL COMPONENTE</td>
		</tr>";
		echo"<tr>
		<td valign=top class=\"formularioCampoTitulo\" >FECHA INICIAL<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmInventarioComponentes.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></td>
		<td valign=top class=\"formularioCampoTitulo\" >FECHA FINAL<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmInventarioComponentes.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></td>
		</tr>";		
		
		echo"<tr>		
		<td valign=top class=\"formularioCampoTitulo\" >SERIAL (Escribirlo completo o los �ltimos d�gitos)<br><input name=\"txtSerial\" type=\"text\" value=\"$_POST[txtSerial]\"></td>
		
		</tr>";
		
		echo "<tr>		
		<td valign=top class=\"formularioCampoTitulo\" >DESCRIPCION<br>$selDescripcion<br></td>		
		<td valign=top class=\"formularioCampoTitulo\" >PEDIDO<br>$selPedido</td>
		</tr>";		
		
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\" >MARCA<br>$selMarca<br></td>	
		</tr>";
		
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\" >MODELO<br>$selModelo<br></td>
		</tr>";
				
	
		echo "<td class=\"formularioTablaBotones\" colspan=\"2\">GENERAR REPORTE 
		 | <a class=enlace href=\"#\" onclick=\"generarExcel()\">EXCEL</a><br>
		<input name=\"btnBuscar\" type=\"button\" value=\"BUSCAR\" onclick=\"buscar()\">
		<input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=630'\"></td>		
		</tr>";
		
		
		echo "</table>";
		if ($_POST[validar]!=1)
    	if ($_POST[validarboton]!=0){
        $rptComponentes= new rptComponentes();        
       
		
	if ($_POST[selMarca]==100) 	
		$_POST[selMarca]="";
		
		
	if ($_POST[selModelo]==100) 	
		$_POST[selModelo]="";
		
		
	if ($_POST[selDescripcion]==100)
		$_POST[selDescripcion]="";
		
		
	if ($_POST[selPedido]==100)
		$_POST[selPedido]="";
		
						
	 $resultado=$rptComponentes->retornarInventarioComponentes($_POST[txtFechaInicio],$_POST[txtFechaFinal],$_POST[selDescripcion],$_POST[txtSerial],$_POST[txtConfiguracion],$_POST[selMarca],$_POST[selModelo],$_POST[selPedido],"ID_PEDIDO",$_POST[selStatusRed],$_POST[selStatusCritico]);
     
      		
	 echo "<table width=\"40%\" border=\"0\" align=\"center\">";  		
	 if ($resultado && $resultado!=1) {

echo "
		<tr>
		<td valign=top class=\"tablaTitulo\" colspan=\"3\"><b>RESULTADO DE LA BUSQUEDA</b></td>
		</tr>
		<tr>
		<td valign=top class=\"tablaTitulo\"><b>PEDIDO</b></td>
		<td valign=top class=\"tablaTitulo\"><b>CANTIDAD</b></td>	
		<td valign=top class=\"tablaTitulo\"><b>PROVEEDOR</b></td>		  
		</tr>";
	 	$total=0;
	 	while ($row=mysql_fetch_array($resultado)) {
	 		if ($i%2==0) {
	 			$clase="tablaFilaPar";
	 		} else{
	 			$clase="tablaFilaNone";
	 		}
	 		echo "<tr class=\"$clase\">";
	 		echo "<td align=\"center\"><a class=enlace href=\"#\" onclick=\"generarReporte('$row[25]')\"> $row[25]</a></td>";
	 		echo "<td align=\"center\">$row[45]</td>";
	 		echo "<td align=\"center\">$row[27]</td>";
	 		echo "</tr>";
	 		$total=$total+$row[45];
	 		$i++;
	 	}

	 	echo "<tr class=\"$clase\">";
	 	echo "<td align=\"left\">TOTAL</td>";
	 	echo "<td align=\"center\"><b>$total</b></td>";
	 	echo "</tr>";

	 } else {
	 	echo "<tr class=\"tablaTitulo\">
		<td valign=top colspan=\"2\">NO HAY RESULTADO
		</td></tr>";
	 }
	 echo "</table>";

  }	
	echo "</form>";	
		
		
	
}


?>
