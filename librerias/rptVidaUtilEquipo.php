<?php
//Reporte de inventario  de Equipos por edificio

?>
<script type="text/javascript" src="date-picker.js"></script>
<script type="text/javascript">

    function cambiarSeleccion() {
		document.frmInventarioEquipos.funcion.value=0;			
		document.frmInventarioEquipos.submit();
	}
	
	function buscar() {
		
		document.frmInventarioEquipos.funcion.value=0;
		document.frmInventarioEquipos.validarboton.value=1;
	 	document.frmInventarioEquipos.submit();
	}
	
		
	function generarReporte(idDescripcion) {
		
		
		sitio=document.frmInventarioEquipos.selSitio.value;
		if (idDescripcion=='')
		idDescripcion=document.frmInventarioEquipos.selDescripcion.value; 		
		idMarca=document.frmInventarioEquipos.selMarca.value;	
		idModelo=document.frmInventarioEquipos.selModelo.value;			
		idPedido=document.frmInventarioEquipos.selPedido.value;		 		
		idEstado=document.frmInventarioEquipos.selEstado.value;			
		gerencia=document.frmInventarioEquipos.selGerencia.value;		
		txtConfiguracion=document.frmInventarioEquipos.txtConfiguracion.value;		
		txtActivoFijo=document.frmInventarioEquipos.txtActivoFijo.value;		
		txtSerial=document.frmInventarioEquipos.txtSerial.value;	
		txtFicha=document.frmInventarioEquipos.txtFicha.value;		
		red=document.frmInventarioEquipos.selStatusRed.value;		
		critico=document.frmInventarioEquipos.selStatusCritico.value;
		usuarioEspecializado=document.frmInventarioEquipos.selStatusUsuarioEspecializado.value;		
		SP=document.frmInventarioEquipos.selSP.value;	
		correctivo=document.frmInventarioEquipos.selCorrectivo.value;
		encontrado=document.frmInventarioEquipos.selEncontrado.value;
		uso=document.frmInventarioEquipos.selUso.value;
		equipodisponible=document.frmInventarioEquipos.selDisponible.value;
		soActualizado=document.frmInventarioEquipos.selSoActualizado.value;
		antivirusActualizado=document.frmInventarioEquipos.selAntivirusActualizado.value;
		fechaInicio=document.frmInventarioEquipos.txtFechaInicio.value;		
		fechaFinal=document.frmInventarioEquipos.txtFechaFinal.value;		
		window.open('../librerias/rptResumenInventarios.php?sitio='+sitio+'&idDescripcion='+idDescripcion+'&idGerencia='+gerencia+'&idMarca='+idMarca+'&idModelo='+idModelo+'&idPedido='+idPedido+'&idEstado='+idEstado+'&txtConfiguracion='+txtConfiguracion+'&txtActivoFijo='+txtActivoFijo+'&txtSerial='+txtSerial+'&txtFicha='+txtFicha+'&red='+red+'&critico='+critico+'&usuarioEspecializado='+usuarioEspecializado+'&SP='+SP+'&correctivo='+correctivo+'&encontrado='+encontrado+'&uso='+uso+'&equipodisponible='+equipodisponible+'&soActualizado='+soActualizado+'&antivirusActualizado='+antivirusActualizado+'&fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal);	
	}
	
	 function generarExcel() {
		sitio=document.frmInventarioEquipos.selSitio.value;
		idDescripcion=document.frmInventarioEquipos.selDescripcion.value;	
		idMarca=document.frmInventarioEquipos.selMarca.value;		
		idModelo=document.frmInventarioEquipos.selModelo.value;			
		idPedido=document.frmInventarioEquipos.selPedido.value;		 		
		idEstado=document.frmInventarioEquipos.selEstado.value;			
		gerencia=document.frmInventarioEquipos.selGerencia.value;		
		txtConfiguracion=document.frmInventarioEquipos.txtConfiguracion.value;
		txtActivoFijo=document.frmInventarioEquipos.txtActivoFijo.value;	
		txtSerial=document.frmInventarioEquipos.txtSerial.value;		
		txtFicha=document.frmInventarioEquipos.txtFicha.value;
		red=document.frmInventarioEquipos.selStatusRed.value;	
		SP=document.frmInventarioEquipos.selSP.value;	
		correctivo=document.frmInventarioEquipos.selCorrectivo.value;
		encontrado=document.frmInventarioEquipos.selEncontrado.value;
		uso=document.frmInventarioEquipos.selUso.value;
		equipodisponible=document.frmInventarioEquipos.selDisponible.value;
		soActualizado=document.frmInventarioEquipos.selSoActualizado.value;
		antivirusActualizado=document.frmInventarioEquipos.selAntivirusActualizado.value;
		critico=document.frmInventarioEquipos.selStatusCritico.value;		
		fechaInicio=document.frmInventarioEquipos.txtFechaInicio.value;		
		fechaFinal=document.frmInventarioEquipos.txtFechaFinal.value;
		window.open('../librerias/rptResumenEquiposVidaUtilExcel.php?sitio='+sitio+'&idDescripcion='+idDescripcion+'&idGerencia='+gerencia+'&idMarca='+idMarca+'&idModelo='+idModelo+'&idPedido='+idPedido+'&idEstado='+idEstado+'&txtConfiguracion='+txtConfiguracion+'&txtActivoFijo='+txtActivoFijo+'&txtSerial='+txtSerial+'&txtFicha='+txtFicha+'&red='+red+'&critico='+critico+'&SP='+SP+'&correctivo='+correctivo+'&encontrado='+encontrado+'&uso='+uso+'&equipodisponible='+equipodisponible+'&soActualizado='+soActualizado+'&antivirusActualizado='+antivirusActualizado+'&fechaInicio='+fechaInicio+'&fechaFinal='+fechaFinal);

		
	}
	
</script>
<?php
switch ($funcion) {
	case 1:
		break 1;
	case 2:
		break 2;
	default:
		frmInventarioEquipos();	
}
function frmInventarioEquipos() {
	require_once("formularios.php");
	require_once("conexionsql.php");
    require_once("rptAdmin.php");
    
	$conSitio="Select ID_SITIO,SITIO FROM sitio	ORDER BY  SITIO";
	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--TODOS--","");
	$selSitio=$sitio->retornar();
	
	
	$conGerencia="Select ID_GERENCIA,GERENCIA FROM gerencia	ORDER BY  GERENCIA";
	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","","",$conGerencia,"--TODOS--","");
	$selGerencia=$gerencia->retornar();
	
	
	$conDescripcion="Select descripcion.ID_DESCRIPCION,descripcion.DESCRIPCION,descripcion_propiedad.ID_DESCRIPCION_PROPIEDAD,descripcion_propiedad.DESCRIPCION_PROPIEDAD From descripcion
    Inner Join descripcion_propiedad ON descripcion.ID_DESCRIPCION_PROPIEDAD = descripcion_propiedad.ID_DESCRIPCION_PROPIEDAD Where descripcion.ID_DESCRIPCION_PROPIEDAD = 'DSP0000004' ORDER BY  DESCRIPCION  ";
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
	
	$conEstado="select ID_ESTADO, ESTADO FROM inventario_estado where id_estado in ('EST0000001','EST0000002','EST0000003','EST0000004','EST0000005','EST0000006') ORDER BY ESTADO";
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
	
	
	    echo  "<form name=\"frmInventarioEquipos\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"validarboton\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"validar\" type=\"hidden\" value=\"0 \">";
		echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
		echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">REPORTE DE VIDA UTIL DE EQUIPOS </td>
	  	</tr>";
		echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">SELECCIONE EL CAMPO POR EL CUAL QUIERE BUSCAR EL EQUIPO</td>
		</tr>";
	
		echo"<tr>
		<td valign=top class=\"formularioCampoTitulo\" >FECHA INICIAL<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmInventarioEquipos.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></td>
		<td valign=top class=\"formularioCampoTitulo\" >FECHA FINAL<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmInventarioEquipos.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></td>
		</tr>";	
		
		echo"<tr>		
	    <td valign=top class=\"formularioCampoTitulo\" >CONFIGURACION (Escribirla completa o los �ltimos d�gitos)<br><input name=\"txtConfiguracion\" type=\"text\" value=\"$_POST[txtConfiguracion]\" ><br></td>
	    <td valign=top class=\"formularioCampoTitulo\" >USUARIO (Escribir Nombre o Ficha)<br><input name=\"txtFicha\" type=\"text\" value=\"$_POST[txtFicha]\"><br></td>	    
		</tr>";
		
		echo"<tr>
		<td valign=top class=\"formularioCampoTitulo\" >ACTIVO FIJO (Escribirlo completo o los �ltimos d�gitos)<br><input name=\"txtActivoFijo\" type=\"text\" value=\"$_POST[txtActivoFijo]\"></td>
		<td valign=top class=\"formularioCampoTitulo\" >GERENCIA<br>$selGerencia</td>		
		</tr>";
		
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\" >SERIAL (Escribirlo completo o los �ltimos d�gitos)<br><input name=\"txtSerial\" type=\"text\" value=\"$_POST[txtSerial]\"></td>
		<td valign=top class=\"formularioCampoTitulo\" >SITIO<br>$selSitio</td>		
		</tr>";
		
		echo "<tr>		
		<td valign=top class=\"formularioCampoTitulo\" >DESCRIPCION<br>$selDescripcion<br></td>		
		<td valign=top class=\"formularioCampoTitulo\" >PEDIDO<br>$selPedido</td>
		</tr>";
		
		
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\" >MARCA<br>$selMarca<br></td>	
		<td valign=top class=\"formularioCampoTitulo\" >ESTADO<br>$selEstado<br></td>		
		</tr>";
				
		echo"<tr>		
		<td valign=top class=\"formularioCampoTitulo\" >MODELO<br>$selModelo<br></td>		
		
		<td valign=top class=\"formularioCampoTitulo\" >RED<br><select name=\"selStatusRed\" class=\"formularioCampoSeleccion\">";
         switch ($_POST[selStatusRed]) {
	        case '100':
	         echo "<option selected value=\"100\">--TODOS--</option>";
	         echo "<option value=\"1\"> NO CONECTADO A RED</option>";
	         echo "<option value=\"0\">CONECTADO A RED</option>";
	         break 1;
	        case '0':
	         echo "<option value=\"100\">--TODOS--</option>";
	         echo "<option value=\"1\"> NO CONECTADO A RED</option>";	     
	         echo "<option selected value=\"0\">CONECTADO A RED</option>";
	        break 1;
	        case '1':
	         echo "<option value=\"100\">--TODOS--</option>";
	         echo "<option selected value=\"1\"> NO CONECTADO A RED</option>";
	         echo "<option value=\"0\">CONECTADO A RED</option>";
	        break;                                                                             
	       default:	   
	        echo "<option selected value=\"100\">--TODOS--</option>";
	        echo "<option value=\"1\"> NO CONECTADO A RED</option>";
	        echo "<option value=\"0\">CONECTADO A RED</option>";	    
        }
         echo "</select></td>
				
		</tr>";
				
		echo"<tr>		
	   <td valign=top class=\"formularioCampoTitulo\" >CRITICO<br><select name=\"selStatusCritico\" class=\"formularioCampoSeleccion\">";
          switch ($_POST[selStatusCritico]) {
	       case '100':
	        echo "<option selected value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\"> NO CRITICO</option>";
	        echo "<option value=\"1\">CRITICO</option>";
	       break 1;
	       case '0':
	        echo "<option value=\"100\">--TODOS--</option>";
	        echo "<option selected value=\"0\">NO CRITICO</option>";	     
	        echo "<option value=\"1\">CRITICO</option>";
	       break 1;
	       case '1':
	        echo "<option value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\"> NO CRITICO</option>";
	        echo "<option selected value=\"1\">CRITICO</option>";   
	       break;
	       default:	   
	        echo "<option selected value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\"> NO CRITICO</option>";
	        echo "<option value=\"1\">CRITICO</option>";	    
         }
        echo "</select></td>
     
		<td valign=top class=\"formularioCampoTitulo\" >USUARIO ESPECIALIZADO<br><select name=\"selStatusUsuarioEspecializado\" class=\"formularioCampoSeleccion\">";
          switch ($_POST[selStatusUsuarioEspecializado]) {
	       case '100':
	        echo "<option selected value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\"> NO ES USUARIO ESPECIALIZADO</option>";
	        echo "<option value=\"1\">USUARIO ESPECIALIZADO</option>";
	       break 1;
	       case '0':
	        echo "<option value=\"100\">--TODOS--</option>";
	        echo "<option selected value=\"0\"> NO ES USUARIO ESPECIALIZADO</option>";	     
	        echo "<option value=\"1\">USUARIO ESPECIALIZADO</option>";
	       break 1;
	      case '1':
	        echo "<option value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\">  NO ES USUARIO ESPECIALIZADO</option>";
	        echo "<option selected value=\"1\">USUARIO ESPECIALIZADO</option>";   
	      break;
	      default:	   
	        echo "<option selected value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\">  NO ES USUARIO ESPECIALIZADO</option>";
	        echo "<option value=\"1\">USUARIO ESPECIALIZADO</option>";	    
         }
        echo "</select>	</td></tr>

		<tr>
        <td valign=top class=\"formularioCampoTitulo\" >SERVICE PACK<br><select name=\"selSP\" class=\"formularioCampoSeleccion\">";
          switch ($_POST[selSP]) {
	       case '100':
	        echo "<option selected value=\"100\">--TODOS--</option>";
	        echo "<option value=\"1\">SP1</option>";
	        echo "<option value=\"2\">SP2</option>";
	        echo "<option value=\"3\">SP3</option>";
	       break 1;
	       case '1':
	        echo "<option value=\"100\">--TODOS--</option>";
	        echo "<option selected value=\"1\">SP1</option>";
	        echo "<option value=\"2\">SP2</option>";
	        echo "<option value=\"3\">SP3</option>";
	       break 1;
	      case '2':
	        echo "<option value=\"100\">--TODOS--</option>";
	        echo "<option value=\"1\">SP1</option>";
	        echo "<option selected value=\"2\">SP2</option>";
	        echo "<option value=\"3\">SP3</option>";
	      break;
	      case '3':
	        echo "<option value=\"100\">--TODOS--</option>";
	        echo "<option value=\"1\">SP1</option>";
	        echo "<option value=\"2\">SP2</option>";
	        echo "<option selected value=\"3\">SP3</option>";
	      break;
	      default:	   
	        echo "<option selected value=\"100\">--TODOS--</option>";
	        echo "<option value=\"1\">SP1</option>";
	        echo "<option value=\"2\">SP2</option>";
	        echo "<option value=\"3\">SP3</option>";
         }
//begin**20-04-09*************************************************************************
        echo "</select></td>
        <td valign=top class=\"formularioCampoTitulo\" >CORRECTIVO<br><select name=\"selCorrectivo\" class=\"formularioCampoSeleccion\">";
          switch ($_POST[selCorrectivo]) {
	       case '100':
	        echo "<option selected value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\">SIN CORRECTIVO</option>";
			echo "<option value=\"1\">CORRECTIVO</option>";
	       break 1;
	       case '0':
	        echo "<option value=\"100\">--TODOS--</option>";
			echo "<option selected value=\"0\">SIN CORRECTIVO</option>";
	        echo "<option value=\"1\">CORRECTIVO</option>";
	       break 1;
	       case '1':
	        echo "<option value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\">SIN CORRECTIVO</option>";
	        echo "<option selected value=\"1\">CORRECTIVO</option>";
			break 1;
	      default:	   
	        echo "<option selected value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\">SIN CORRECTIVO</option>";
	        echo "<option value=\"1\">CORRECTIVO</option>";
         }
        echo "</select></td> 
			</tr>
		<tr>";
		
	echo "<td valign=top class=\"formularioCampoTitulo\" >ENCONTRADO<br><select name=\"selEncontrado\" class=\"formularioCampoSeleccion\">";
          switch ($_POST[selEncontrado]) {
	       case '100':
	        echo "<option selected value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\">ENCONTRADO</option>";
			echo "<option value=\"1\">NO ENCONTRADO</option>";
	       break 1;
	       case '0':
	        echo "<option value=\"100\">--TODOS--</option>";
			echo "<option selected value=\"0\">ENCONTRADO</option>";
	        echo "<option value=\"1\">NO ENCONTRADO</option>";
	       break 1;
	       case '1':
	        echo "<option value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\">ENCONTRADO</option>";
	        echo "<option selected value=\"1\">NO ENCONTRADO</option>";
			break 1;
	      default:	   
	        echo "<option selected value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\">ENCONTRADO</option>";
	        echo "<option value=\"1\">NO ENCONTRADO</option>";
         }
        echo "</select></td>";
	
    echo "<td valign=top class=\"formularioCampoTitulo\" >USO<br><select name=\"selUso\" class=\"formularioCampoSeleccion\">";
          switch ($_POST[selUso]) {
	       case '100':
	        echo "<option selected value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\">EN USO</option>";
			echo "<option value=\"1\">SIN USO</option>";
	       break 1;
	       case '0':
	        echo "<option value=\"100\">--TODOS--</option>";
			echo "<option selected value=\"0\">EN USO</option>";
	        echo "<option value=\"1\">SIN USO</option>";
	       break 1;
	       case '1':
	        echo "<option value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\">EN USO</option>";
	        echo "<option selected value=\"1\">SIN USO</option>";
			break 1;
	      default:	   
	        echo "<option selected value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\">EN USO</option>";
	        echo "<option value=\"1\">SIN USO</option>";
         }
        echo "</select></td>
				</tr>";
		
		echo "<tr>
        <td valign=top class=\"formularioCampoTitulo\" >DISPONIBLE<br><select name=\"selDisponible\" class=\"formularioCampoSeleccion\">";
          switch ($_POST[selDisponible]) {
	       case '100':
	        echo "<option selected value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\">DISPONIBLE</option>";
			echo "<option value=\"1\">NO DISPONIBLE</option>";
	       break 1;
	       case '0':
	        echo "<option value=\"100\">--TODOS--</option>";
			echo "<option selected value=\"0\">DISPONIBLE</option>";
	        echo "<option value=\"1\">NO DISPONIBLE</option>";
	       break 1;
	       case '1':
	        echo "<option value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\">DISPONIBLE</option>";
	        echo "<option selected value=\"1\">NO DISPONIBLE</option>";
			break 1;
	      default:	   
	        echo "<option selected value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\">DISPONIBLE</option>";
	        echo "<option value=\"1\">NO DISPONIBLE</option>";
         }
        echo "</select></td>";
		echo "
        <td valign=top class=\"formularioCampoTitulo\" >SISTEMA OPERATIVO<br><select name=\"selSoActualizado\" class=\"formularioCampoSeleccion\">";
          switch ($_POST[selSoActualizado]) {
	       case '100':
	        echo "<option selected value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\">ACTUALIZADO</option>";
			echo "<option value=\"1\">NO ACTUALIZADO</option>";
	       break 1;
	       case '0':
	        echo "<option value=\"100\">--TODOS--</option>";
			echo "<option selected value=\"0\">ACTUALIZADO</option>";
	        echo "<option value=\"1\">NO ACTUALIZADO</option>";
	       break 1;
	       case '1':
	        echo "<option value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\">ACTUALIZADO</option>";
	        echo "<option selected value=\"1\">NO ACTUALIZADO</option>";
			break 1;
	      default:	   
	        echo "<option selected value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\">ACTUALIZADO</option>";
	        echo "<option value=\"1\">NO ACTUALIZADO</option>";
         }
        echo "</select></td>
		</tr>";
		echo "
		<tr>
        <td valign=top class=\"formularioCampoTitulo\" >ANTIVIRUS<br><select name=\"selAntivirusActualizado\" class=\"formularioCampoSeleccion\">";
          switch ($_POST[selAntivirusActualizado]) {
	       case '100':
	        echo "<option selected value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\">ACTUALIZADO</option>";
			echo "<option value=\"1\">NO ACTUALIZADO</option>";
	       break 1;
	       case '0':
	        echo "<option value=\"100\">--TODOS--</option>";
			echo "<option selected value=\"0\">ACTUALIZADO</option>";
	        echo "<option value=\"1\">NO ACTUALIZADO</option>";
	       break 1;
	       case '1':
	        echo "<option value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\">ACTUALIZADO</option>";
	        echo "<option selected value=\"1\">NO ACTUALIZADO</option>";
			break 1;
	      default:	   
	        echo "<option selected value=\"100\">--TODOS--</option>";
	        echo "<option value=\"0\">ACTUALIZADO</option>";
	        echo "<option value=\"1\">NO ACTUALIZADO</option>";
         }
        echo "</select></td>
		</tr>";
//end**20-04-09*************************************************************************
		echo "<td class=\"formularioTablaBotones\" colspan=\"2\">GENERAR REPORTE 
		 | <a class=enlace href=\"#\" onclick=\"generarExcel()\">EXCEL</a><br>
		<input name=\"btnBuscar\" type=\"button\" value=\"BUSCAR\" onclick=\"buscar()\">		
		<input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=156'\"></td>			
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
		$_POST[selDescripcion]="";
		
		
	if ($_POST[selPedido]==100)
		$_POST[selPedido]="";
		
		
	if ($_POST[selEstado]==100)
		$_POST[selEstado]=""; 
		
		
	if ($_POST[selStatusRed]==100)
		$_POST[selStatusRed]=""; 
		
			
	if ($_POST[selStatusCritico]==100)	
		$_POST[selStatusCritico]=""; 	
	    
	if ($_POST[selStatusUsuarioEspecializado]==100)	
		$_POST[selStatusUsuarioEspecializado]=""; 	
		
	if ($_POST[selSP]==100)	
		$_POST[selSP]=""; 
	
	if ($_POST[selCorrectivo]==100)	
		$_POST[selCorrectivo]="";
	
	if ($_POST[selEncontrado]==100)	
		$_POST[selEncontrado]="";  

	if ($_POST[selUso]==100)	
		$_POST[selUso]="";		
		
	if ($_POST[selDisponible]==100)	
		$_POST[selDisponible]="";	
	
	if ($_POST[selSoActualizado]==100)	
		$_POST[selSoActualizado]="";	
	
	if ($_POST[selAntivirusActualizado]==100)	
		$_POST[selAntivirusActualizado]="";
					
	 $resultado=$rptEquipos->retornarInventarioEquipos($_POST[selSitio],$_POST[txtFechaInicio],$_POST[txtFechaFinal],$_POST[selGerencia],$_POST[selDescripcion],$_POST[txtFicha],$_POST[txtSerial],$_POST[txtConfiguracion],$_POST[txtActivoFijo],$_POST[selMarca],$_POST[selModelo],$_POST[selPedido],$_POST[selEstado],"ID_DESCRIPCION",$_POST[selStatusRed],$_POST[selStatusCritico],$_POST[selStatusUsuarioEspecializado],$_POST[selSP],$_POST[selCorrectivo],$_POST[selEncontrado],$_POST[selUso],$_POST[selDisponible],$_POST[selSoActualizado],$_POST[selAntivirusActualizado]);
     
 	echo "<table width=\"40%\" border=\"0\" align=\"center\">";  		
	 if ($resultado && $resultado!=1) {

   echo "
		<tr>
		<td valign=top class=\"tablaTitulo\" colspan=\"2\"><b>RESULTADO DE LA BUSQUEDA</b></td>
		</tr>
		<tr>
		<td valign=top class=\"tablaTitulo\"><b>DESCRIPCION</b></td>
		<td valign=top class=\"tablaTitulo\"><b>CANTIDAD</b></td>		  
		</tr>";
	 	$total=0;
	 	while ($row=mysql_fetch_array($resultado)) {
	 		if ($i%2==0) {
	 			$clase="tablaFilaPar";
	 		} else {
	 			$clase="tablaFilaNone";
	 		}
	 		echo "<tr class=\"$clase\">";
	 		echo "<td align=\"left\"><a class=enlace href=\"#\" onclick=\"generarReporte('$row[9]')\"> $row[10]</a></td>";
	 		echo "<td align=\"center\">$row[93]</td>";
	 		echo "</tr>";
	 		$total=$total+$row[93];
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
