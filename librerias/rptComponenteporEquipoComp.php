<?php
//Reporte de Componentes
?>
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
<script type="text/javascript">

    function cambiarSeleccion() {
		document.frmInventarioComponentesEquipo.funcion.value=0;			
		document.frmInventarioComponentesEquipo.submit();
	}

	function buscar(){
		document.frmInventarioComponentesEquipo.funcion.value=0;
		document.frmInventarioComponentesEquipo.validarboton.value=1;
	 	document.frmInventarioComponentesEquipo.submit();
	}

	function generarReporte(idDescripcion,idConfiguracion){
		if (idDescripcion=='')
		idDescripcion=document.frmInventarioComponentesEquipo.selDescripcion.value;
		
		window.open('../librerias/rptResumenComponenteporEquipoComp.php?idDescripcion='+idDescripcion+'&idConfiguracion='+idConfiguracion);	
	}
	
	function generarEquipo(){
		idDescripcion=document.frmInventarioComponentesEquipo.selDescripcion.value;
		
		window.open('../librerias/rptResumenComponenteporEquipoComp11.php?idDescripcion='+idDescripcion);	
	}

	function generarExcel() {
		idDescripcion=document.frmInventarioComponentesEquipo.selDescripcion.value;

		window.open('../librerias/rptResumenComponenteporEquipoCompExcel.php?idDescripcion='+idDescripcion);
	}
	
	
	
	
</script>
<?php
switch ($funcion) {
	case 1:
		break 1;
	case 2:
		break 2;
	default:
		frmInventarioComponentesEquipo();	
}

function frmInventarioComponentesEquipo() {
	require_once("formularios.php");
	require_once("conexionsql.php");
	require_once("rptComponenteEquipoComp.php");
    	
	$conDescripcion="Select descripcion.ID_DESCRIPCION,descripcion.DESCRIPCION,descripcion_propiedad.ID_DESCRIPCION_PROPIEDAD,descripcion_propiedad.DESCRIPCION_PROPIEDAD From descripcion
    Inner Join descripcion_propiedad ON descripcion.ID_DESCRIPCION_PROPIEDAD = descripcion_propiedad.ID_DESCRIPCION_PROPIEDAD Where descripcion.ID_DESCRIPCION_PROPIEDAD != 'DSP0000004' ORDER BY  DESCRIPCION";
	$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion","$_POST[selDescripcion]","onChange","cambiarSeleccion()",$conDescripcion,"--TODOS--","");
	$selDescripcion=$descripcion->retornar();
	
		
	
	    echo  "<form name=\"frmInventarioComponentesEquipo\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"validarboton\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"validar\" type=\"hidden\" value=\"0\">";
		echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
		echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">REPORTE COMPONENTE POR EQUIPO </td>
	  	</tr>";
		echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">SELECCIONE EL CAMPO POR EL CUAL QUIERE BUSCAR EL COMPONENTE</td>
		</tr>";		
		echo"<tr></tr>";		
		echo "<tr></tr>";		
		echo"<tr>
		<td valign=top class=\"formularioCampoTitulo\" >DESCRIPCION<br>$selDescripcion<br></td>	";         
        echo"<tr></tr>";		
		echo "<tr></tr>";
		echo"<tr></tr>";		
		echo "<tr></tr>";	
		echo "<td class=\"formularioTablaBotones\" colspan=\"2\">GENERAR REPORTE 
		 | <a class=enlace href=\"#\" onclick=\"generarExcel()\">EXCEL</a><br>
		<input name=\"btnBuscar\" type=\"button\" value=\"BUSCAR\" onclick=\"buscar()\">
		<input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=633'\">
		<input name=\"btnEquipos\" type=\"button\" value=\"BUSCAR EQUIPOS\" onclick=\"generarEquipo()\"></td>	
		</td>
		</tr>";
		echo "</table>";
		
    		if ($_POST[validarboton]==1) {
        		$rptComponentes= new rptComponentes(); 


				if ($_POST[selDescripcion]==100)
					$_POST[selDescripcion]="";
					
					
				$resultado=$rptComponentes->retornarInventarioComponentes($_POST[selDescripcion],"componente_id_descripcion");

 				echo "<table width=\"40%\" border=\"0\" align=\"center\">";  
		
	 			if ($resultado && $resultado!=1) {
   						echo "
						<tr>
						<td valign=top class=\"tablaTitulo\" colspan=\"2\"><b>RESULTADO DE LA BUSQUEDA</b></td>
						</tr>
						<tr>
						<td valign=top class=\"tablaTitulo\"><b>CONFIGURACION</b></td>
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
	 						    echo "<td align=\"center\"><a class=enlace href=\"#\" onclick=\"generarReporte('$row[3]','$row[0]')\">$row[0]</a></td>";
	 						    echo "<td align=\"center\">$row[1]</td>";
	 						    echo "</tr>";
	 						    $total=$total+$row[1];
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
