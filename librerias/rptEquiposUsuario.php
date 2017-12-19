<?php
//Reporte de inventario de Equipos por edificio

?>
<script type="text/javascript" src="date-picker.js"></script>
<script type="text/javascript">

    function cambiarSeleccion() {
		document.frmUsuarioEquipos.funcion.value=0;			
		document.frmUsuarioEquipos.submit();
	}
	
	function buscar() {		
		document.frmUsuarioEquipos.funcion.value=0;
		document.frmUsuarioEquipos.validarboton.value=1;
	 	document.frmUsuarioEquipos.submit();
	}
			
	function generarReporte(idCargo) {		
		sitio=document.frmUsuarioEquipos.selSitio.value;
		if (idCargo=='')
		idCargo=document.frmUsuarioEquipos.selCargo.value;
		gerencia=document.frmUsuarioEquipos.selGerencia.value;
		departamento=document.frmUsuarioEquipos.selDepartamento.value;
		division=document.frmUsuarioEquipos.selDivision.value;
		txtNombre=document.frmUsuarioEquipos.txtNombre.value;
		txtApellido=document.frmUsuarioEquipos.txtApellido.value;
		txtFicha=document.frmUsuarioEquipos.txtFicha.value;
		txtCedula=document.frmUsuarioEquipos.txtCedula.value;
				
		window.open('../librerias/rptResumenUsuarioEquipos.php?sitio='+sitio+'&idCargo='+idCargo+'&gerencia='+gerencia+'&departamento='+departamento+'&division='+division+'&txtNombre='+txtNombre+'&txtApellido='+txtApellido+'&txtFicha='+txtFicha+'&txtCedula='+txtCedula);	
	}
	
	 function generarExcel() {
		sitio=document.frmUsuarioEquipos.selSitio.value;	
		idCargo=document.frmUsuarioEquipos.selCargo.value; 					
		gerencia=document.frmUsuarioEquipos.selGerencia.value;
		departamento=document.frmUsuarioEquipos.selDepartamento.value;	
		division=document.frmUsuarioEquipos.selDivision.value;	
		txtNombre=document.frmUsuarioEquipos.txtNombre.value;
		txtApellido=document.frmUsuarioEquipos.txtApellido.value;	
		txtFicha=document.frmUsuarioEquipos.txtFicha.value;
		txtCedula=document.frmUsuarioEquipos.txtCedula.value;
				
		window.open('../librerias/rptResumenUsuarioEquiposExcel.php?sitio='+sitio+'&idCargo='+idCargo+'&idGerencia='+gerencia+'&idDepartamento='+departamento+'&idDivision='+division+'&txtNombre='+txtNombre+'&txtApellido='+txtApellido+'&txtFicha='+txtFicha+'&txtCedula='+txtCedula);
		
	}
	
</script>
<?php
switch ($funcion) {
	case 1:
		break 1;
	case 2:
		break 2;
	default:
		frmUsuarioEquipos();
}

function frmUsuarioEquipos() {
	require_once("formularios.php");
	require_once("conexionsql.php");
    require_once("rptUsuario.php");
    
	$conSitio="Select ID_SITIO,SITIO FROM sitio	ORDER BY  SITIO";
	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--TODOS--","");
	$selSitio=$sitio->retornar();
	
	$conCargo="Select ID_CARGO,CARGO FROM cargo ORDER BY CARGO";
	$cargo= new campoSeleccion("selCargo","formularioCampoSeleccion","$_POST[selCargo]","onChange","cambiarSeleccion()",$conCargo,"--TODOS--","");
	$selCargo=$cargo->retornar();
		
	$conGerencia="Select ID_GERENCIA,GERENCIA FROM gerencia	ORDER BY GERENCIA";
	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","cambiarSeleccion()",$conGerencia,"--GERENCIA--","");
	$selGerencia=$gerencia->retornar();
	
	
	$conDepartamento="SELECT ID_DEPARTAMENTO,DEPARTAMENTO FROM departamento WHERE ID_DIVISION='$_POST[selDivision]' ORDER BY DEPARTAMENTO";
	$departamento= new campoSeleccion("selDepartamento","formularioCampoSeleccion","$_POST[selDepartamento]","","",$conDepartamento,"--DEPARTAMENTO--","");
	$selDepartamento=$departamento->retornar();
	
	$conDivision="SELECT ID_DIVISION, DIVISION FROM division WHERE ID_GERENCIA='$_POST[selGerencia]' ORDER BY DIVISION";
	$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","cambiarSeleccion()",$conDivision,"--DIVISION--","");
	$selDivision=$division->retornar();

	
	$nombre= new campo("txtNombre","text","formularioCampoTexto","$_POST[txtNombre]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtNombre=$nombre->retornar();	
	
    $apellido= new campo("txtApellido","text","formularioCampoTexto","$_POST[txtApellido]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtApellido=$apellido->retornar();	
	
	$ficha= new campo("txtFicha","text","formularioCampoTexto","$_POST[txtFicha]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtFicha=$ficha->retornar();

	$cedula= new campo("txtCedula","text","formularioCampoTexto","$_POST[txtCedula]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtCedula=$cedula->retornar();
	
	$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10");
	$txtFechaInicio=$fechaInicio->retornar();

	$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
	$txtFechaFinal=$fechaFinal->retornar();
	
	
	    echo  "<form name=\"frmUsuarioEquipos\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"validarboton\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"validar\" type=\"hidden\" value=\"0 \">";
		echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
		echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">REPORTE DE EQUIPOS USUARIO</td>
	  	</tr>";
		echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">SELECCIONE EL CAMPO POR EL CUAL QUIERE BUSCAR EL EQUIPO</td>
		</tr>";

				
		echo"<tr>		
	    <td valign=top class=\"formularioCampoTitulo\" >NOMBRE<br><input name=\"txtNombre\" type=\"text\" value=\"$_POST[txtNombre]\" ><br></td>
	    <td valign=top class=\"formularioCampoTitulo\" >APELLIDO<br><input name=\"txtApellido\" type=\"text\" value=\"$_POST[txtApellido]\"><br></td>	    
		</tr>";

		echo"<tr>		
	    <td valign=top class=\"formularioCampoTitulo\" >NUMERO DE FICHA<br><input name=\"txtFicha\" type=\"text\" value=\"$_POST[txtFicha]\"><br></td>	    
		<td valign=top class=\"formularioCampoTitulo\" >NUMERO DE CEDULA<br><input name=\"txtCedula\" type=\"text\" value=\"$_POST[txtCedula]\"><br></td>	    
	    </tr>";
		
		echo"<tr>
		<td valign=top class=\"formularioCampoTitulo\" >GERENCIA<br>$selGerencia</td>
		<td valign=top class=\"formularioCampoTitulo\" >CARGO<br>$selCargo</td>			
		</tr>";
		
		echo"<tr>
		<td valign=top class=\"formularioCampoTitulo\" >DIVISION<br>$selDivision</td>				
		<td valign=top class=\"formularioCampoTitulo\" >SITIO<br>$selSitio</td>				
		</tr>";		
		
		echo"<tr>
		<td valign=top class=\"formularioCampoTitulo\" >DEPARTAMENTO<br>$selDepartamento</td>					
		</tr>";	
		
		echo "<td class=\"formularioTablaBotones\" colspan=\"2\">GENERAR REPORTE 
		     | <a class=enlace href=\"#\" onclick=\"generarExcel()\">EXCEL</a><br>
		<input name=\"btnBuscar\" type=\"button\" value=\"BUSCAR\" onclick=\"buscar()\">		
		<input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=625'\"></td>			
		</tr>";		
		echo "</table>";
		
		
    	if ($_POST[validarboton]==1){
        $rptEquipos = new rptEquipos();        
        
        
    		if ($_POST[selSitio]==100) 
				$_POST[selSitio]="";
		
			if ($_POST[selGerencia]==100) 	
				$_POST[selGerencia]="";
	    	
			if ($_POST[selDepartamento]==100) 	
				$_POST[selDepartamento]="";
				
			if ($_POST[selDivision]==100) 	
				$_POST[selDivision]="";		

			if ($_POST[selCargo]==100) 	
				$_POST[selCargo]="";	
			
	 		$resultado=$rptEquipos->retornarInventarioEquipos($_POST[selSitio],$_POST[selGerencia],$_POST[selCargo],$_POST[selDepartamento],$_POST[selDivision],$_POST[txtFicha],$_POST[txtNombre],$_POST[txtApellido],$_POST[txtCedula],"ID_CARGO");
     
	 		echo "<table width=\"40%\" border=\"0\" align=\"center\">";  		
	 
 			if ($resultado && $resultado!=1) {

    			echo "
				<tr>
				<td valign=top class=\"tablaTitulo\" colspan=\"2\"><b>RESULTADO DE LA BUSQUEDA</b></td>
				</tr>
				<tr>
				<td valign=top class=\"tablaTitulo\"><b>CARGO</b></td>
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
	 				echo "<td align=\"left\"><a class=enlace href=\"#\" onclick=\"generarReporte('$row[4]')\"> $row[5]</a></td>";
	 				echo "<td align=\"center\">$row[15]</td>";
	 				echo "</tr>";
	 				$total=$total+$row[15];
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
