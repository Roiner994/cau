<?php
//Reporte de inventario  de Equipos por edificio

?>
<script type="text/javascript" src="date-picker.js"></script>
<script type="text/javascript">

    function cambiarSeleccion() {
		document.frmEquiposPlanta.funcion.value=0;			
		document.frmEquiposPlanta.submit();
	}
	
	function buscar() {
		
		document.frmEquiposPlanta.funcion.value=0;
		document.frmEquiposPlanta.validarboton.value=1;
	 	document.frmEquiposPlanta.submit();
	}
	
		
	function generarReporte(configuracion) {		
		sitio=document.frmEquiposPlanta.selSitio.value;
//		if (configuracion=='')
		idDescripcion=document.frmEquiposPlanta.selDescripcion.value;
		idMarca=document.frmEquiposPlanta.selMarca.value;
		idModelo=document.frmEquiposPlanta.selModelo.value;
		gerencia=document.frmEquiposPlanta.selGerencia.value;		
//		txtConfiguracion=document.frmEquiposPlanta.txtConfiguracion.value;	
		txtActivoFijo=document.frmEquiposPlanta.txtActivoFijo.value;					
		txtSerial=document.frmEquiposPlanta.txtSerial.value;
		txtFicha=document.frmEquiposPlanta.txtFicha.value;		
		fechaInicio=document.frmEquiposPlanta.txtFechaInicio.value;
		fechaFinal=document.frmEquiposPlanta.txtFechaFinal.value;
		
		window.open('../librerias/rptResumenHojasImpresas.php?sitio='+sitio+'&idDescripcion='+idDescripcion+'&idMarca='+idMarca+'&idModelo='+idModelo+'&gerencia='+gerencia+'&configuracion='+configuracion+'&txtActivoFijo='+txtActivoFijo+'&txtSerial='+txtSerial+'&txtFicha='+txtFicha+'&fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal);	
	}
	
	 function generarExcel() {
		sitio=document.frmEquiposPlanta.selSitio.value;
		idDescripcion=document.frmEquiposPlanta.selDescripcion.value;
		idMarca=document.frmEquiposPlanta.selMarca.value;
		idModelo=document.frmEquiposPlanta.selModelo.value;			
		gerencia=document.frmEquiposPlanta.selGerencia.value;
		txtConfiguracion=document.frmEquiposPlanta.txtConfiguracion.value;	
		txtActivoFijo=document.frmEquiposPlanta.txtActivoFijo.value;		
		txtSerial=document.frmEquiposPlanta.txtSerial.value;
		txtFicha=document.frmEquiposPlanta.txtFicha.value;			
		fechaInicio=document.frmEquiposPlanta.txtFechaInicio.value;
		fechaFinal=document.frmEquiposPlanta.txtFechaFinal.value;
		
		window.open('../librerias/rptHojasImpresasExcel.php?sitio='+sitio+'&idDescripcion='+idDescripcion+'&idMarca='+idMarca+'&idModelo='+idModelo+'&gerencia='+gerencia+'&txtConfiguracion='+txtConfiguracion+'&txtActivoFijo='+txtActivoFijo+'&txtSerial='+txtSerial+'&txtFicha='+txtFicha+'&fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal);	
	}
	
</script>
<?php
switch ($funcion) {
	case 1:
		break 1;
	case 2:
		break 2;
	default:
		frmEquiposPlanta();	
}

function frmEquiposPlanta() {
	require_once("formularios.php");
	require_once("conexionsql.php");
    require_once("rptHojasImpresasAdmin.php");
    
	$conSitio="Select ID_SITIO,SITIO FROM sitio	ORDER BY  SITIO";
	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--TODOS--","");
	$selSitio=$sitio->retornar();	
	
	$conGerencia="Select ID_GERENCIA,GERENCIA FROM gerencia	ORDER BY  GERENCIA";
	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","","",$conGerencia,"--TODOS--","");
	$selGerencia=$gerencia->retornar();
	
	$conDescripcion="Select descripcion.ID_DESCRIPCION,descripcion.DESCRIPCION,descripcion_propiedad.ID_DESCRIPCION_PROPIEDAD,descripcion_propiedad.DESCRIPCION_PROPIEDAD From descripcion
    Inner Join descripcion_propiedad ON descripcion.ID_DESCRIPCION_PROPIEDAD = descripcion_propiedad.ID_DESCRIPCION_PROPIEDAD Where ((descripcion.ID_DESCRIPCION_PROPIEDAD = 'DSP0000004') and (id_descripcion = 'DES0000008')) ORDER BY  DESCRIPCION  ";
	$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion","$_POST[selDescripcion]","onChange","cambiarSeleccion()",$conDescripcion,"--TODOS--","");
	$selDescripcion=$descripcion->retornar();
	
	$conMarca="select descripcion_marca.ID_MARCA, MARCA FROM descripcion_marca INNER JOIN marca ON descripcion_marca.ID_MARCA=marca.ID_MARCA WHERE descripcion_marca.ID_DESCRIPCION ='$_POST[selDescripcion]' ORDER BY MARCA";
    $marca= new campoSeleccion("selMarca","formularioCampoSeleccion","$_POST[selMarca]","onChange","cambiarSeleccion()",$conMarca,"--TODOS--","");
	$selMarca=$marca->retornar();
	
	$conModelo="select ID_MODELO, CONCAT(MODELO,' ',CAP_VEL,' ',UNIDAD) AS MODELO FROM modelo WHERE ID_MARCA='$_POST[selMarca]' AND ID_DESCRIPCION='$_POST[selDescripcion]' ORDER BY MODELO";
	$modelo= new campoSeleccion("selModelo","formularioCampoSeleccion","$_POST[selModelo]","onChange","cambiarModelo()",$conModelo,"--TODOS--","");
	$selModelo=$modelo->retornar();
	
	$conEstado="select ID_ESTADO, ESTADO FROM inventario_estado where id_estado in ('EST0000001','EST0000002','EST0000003','EST0000004','EST0000005') ORDER BY ESTADO";
    $estado= new campoSeleccion("selEstado","formularioCampoSeleccion","$_POST[selEstado]","","",$conEstado,"--TODOS--","");
	$selEstado=$estado->retornar();	
	
    $configuracion= new campo("txtConfiguracion","text","formularioCampoTexto","$_POST[txtConfiguracion]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtConfiguracion=$configuracion->retornar();
	
	$activoFijo= new campo("txtActivoFijo","text","formularioCampoTexto","$_POST[txtActivoFijo]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtActivoFijo=$activoFijo->retornar();
	
	$serial= new campo("txtSerial","text","formularioCampoTexto","$_POST[txtSerial]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtSerial=$serial->retornar();

	$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10");
	$txtFechaInicio=$fechaInicio->retornar();

	$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
	$txtFechaFinal=$fechaFinal->retornar();
	
	
	    echo  "<form name=\"frmEquiposPlanta\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"validarboton\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"validar\" type=\"hidden\" value=\"0 \">";
		echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
		echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">INVENTARIO HOJAS IMPRESAS POR EQUIPO</td>
	  	</tr>";
		echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">SELECCIONE EL CAMPO POR EL CUAL QUIERE BUSCAR EL EQUIPO</td>
		</tr>";

		echo"<tr>
		<td valign=top class=\"formularioCampoTitulo\" >FECHA INICIAL<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmEquiposPlanta.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></td>
		<td valign=top class=\"formularioCampoTitulo\" >FECHA FINAL<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmEquiposPlanta.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></td>
		</tr>";	
		
		echo"<tr>		
	    <td valign=top class=\"formularioCampoTitulo\" >CONFIGURACION (Escribirla completa o los últimos dígitos)<br><input name=\"txtConfiguracion\" type=\"text\" value=\"$_POST[txtConfiguracion]\" ><br></td>
	    <td valign=top class=\"formularioCampoTitulo\" >USUARIO (Escribir Nombre o Ficha)<br><input name=\"txtFicha\" type=\"text\" value=\"$_POST[txtFicha]\"><br></td>	    
		</tr>";
		
		echo"<tr>
		<td valign=top class=\"formularioCampoTitulo\" >ACTIVO FIJO (Escribirlo completo o los últimos dígitos)<br><input name=\"txtActivoFijo\" type=\"text\" value=\"$_POST[txtActivoFijo]\"></td>
		<td valign=top class=\"formularioCampoTitulo\" >GERENCIA<br>$selGerencia</td>		
		</tr>";
		
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\" >SERIAL (Escribirlo completo o los últimos dígitos)<br><input name=\"txtSerial\" type=\"text\" value=\"$_POST[txtSerial]\"></td>
		<td valign=top class=\"formularioCampoTitulo\" >SITIO<br>$selSitio</td>		
		</tr>";
		
		echo "<tr>		
		<td valign=top class=\"formularioCampoTitulo\" >DESCRIPCION<br>$selDescripcion<br></td>	
		</tr>";
		
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\" >MARCA<br>$selMarca<br></td>	
		</tr>";
				
		echo"<tr>		
		<td valign=top class=\"formularioCampoTitulo\" >MODELO<br>$selModelo<br></td>						
		</tr>";

		echo "<td class=\"formularioTablaBotones\" colspan=\"2\">GENERAR REPORTE 
		 | <a class=enlace href=\"#\" onclick=\"generarExcel()\">EXCEL</a><br>
		<input name=\"btnBuscar\" type=\"button\" value=\"BUSCAR\" onclick=\"buscar()\">		
		<input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=636'\"></td>			
		</tr>";		
		echo "</table>";


		
    	if ($_POST[validarboton]==1){
        $rptEquipos= new rptEquipos();        
       
        
    if ($_POST[selSitio]==100) 
		$_POST[selSitio]="";
		
	if ($_POST[selGerencia]==100) 	
		$_POST[selGerencia]="";
		
		
	if ($_POST[selMarca]==100) 	
		$_POST[selMarca]="";
		
		
	if ($_POST[selModelo]==100) 	
		$_POST[selModelo]="";
		
		
	if ($_POST[selDescripcion]==100)
		$_POST[selDescripcion]='DES0000008';
	    	
					
	 $resultado=$rptEquipos->retornarInventarioEquipos($_POST[selSitio],$_POST[txtFechaInicio],$_POST[txtFechaFinal],$_POST[selGerencia],$_POST[selDescripcion],$_POST[txtActivoFijo],$_POST[txtFicha],$_POST[txtSerial],$_POST[txtConfiguracion],$_POST[selMarca],$_POST[selModelo],"CONFIGURACION");
     
 	echo "<table width=\"40%\" border=\"0\" align=\"center\">";  		
	 if ($resultado && $resultado!=1) {

   echo "
		<tr>
		<td valign=top class=\"tablaTitulo\" colspan=\"2\"><b>RESULTADO DE LA BUSQUEDA</b></td>
		</tr>
		<tr>
		<td valign=top class=\"tablaTitulo\"><b>DESCRIPCION</b></td>
		<td valign=top class=\"tablaTitulo\"><b>CANTIDAD MANTENIMIENTOS</b></td>		  
		</tr>";
	 	$total=0;
	 	while ($row=mysql_fetch_array($resultado)) {
	 		if ($i%2==0) {
	 			$clase="tablaFilaPar";
	 		} else {
	 			$clase="tablaFilaNone";
	 		}
	 		echo "<tr class=\"$clase\">";
	 		echo "<td align=\"left\"><a class=enlace href=\"#\" onclick=\"generarReporte('$row[1]')\"> $row[1]</a></td>";
	 		echo "<td align=\"center\">$row[45]</td>";
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
