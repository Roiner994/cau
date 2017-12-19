<?php
//Reporte de inventario  de Equipos por edificio

?>
<script type="text/javascript" src="date-picker.js"></script>
<script type="text/javascript">

    function cambiarSeleccion() {
		document.frmInventarioEquipos.funcion.value=0;			
		document.frmInventarioEquipos.submit();
	}
	
	
	function generarReporteEquipos() {		
		
		window.open('index2.php?item=629');			
	}
		
	function generarReporteComponentes() {		
		
		window.open('index2.php?item=630');	
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
    
	
	
	    echo  "<form name=\"frmInventarioEquipos\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"validarboton\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"validar\" type=\"hidden\" value=\"0 \">";
		echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
		echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">HISTORIAL PEDIDOS</td>
	  	</tr>";
		
		echo "<tr>";
		echo "<td></td>
	  	</tr>";
		
		echo "<tr>";
		echo "<td></td>
	  	</tr>";
		
		echo "<td align=\"center\" class=\"formularioTablaTitulo\" colspan=\"2\">HAGA CLICK EN UNO DE LOS BOTONES PARA REALIZAR LA BUSQUEDA</td>
		</tr>";
		
		echo "<tr>";
		echo "<td></td>
	  	</tr>";
		
		echo "<tr>";
		echo "<td></td>
	  	</tr>";
		
		echo "<tr>";
		echo "<td></td>
	  	</tr>";
		
		echo "<tr>";
		echo "<td></td>
	  	</tr>";
		
		echo "<td class=\"formularioTablaBotones\" colspan=\"2\">GENERAR REPORTE 
		 <br>
		<input name=\"btnBuscar\" type=\"button\" value=\"BUSCAR POR EQUIPO\" onclick=\"generarReporteEquipos()\">		
		<input name=\"btnLimpiar\" type=\"button\" value=\"BUSCAR POR COMPONENTE\" onclick=\"generarReporteComponentes()\"></td>			
		</tr>";		
		echo "</table>";


		
	echo "</form>";	

}


?>
