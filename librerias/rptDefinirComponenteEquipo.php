<?php
//Reporte de inventario  de Equipos por edificio

?>
<script type="text/javascript" src="date-picker.js"></script>
<script type="text/javascript">

    function cambiarSeleccion() {
		document.frmComponenteEquipos.funcion.value=0;			
		document.frmComponenteEquipos.submit();
	}
	
	
	function generarReporteCoponente() {		
		
		window.open('index2.php?item=631');			
	}
		
	function generarReporteComponentesEquipos() {		
		
		window.open('index2.php?item=633');	
	}
	
	 
	
</script>
<?php
switch ($funcion) {
	case 1:
		break 1;
	case 2:
		break 2;
	default:
		frmComponenteEquipos();	
}
function frmComponenteEquipos() {
	require_once("formularios.php");
	require_once("conexionsql.php");
    
	    echo  "<form name=\"frmComponenteEquipos\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"validarboton\" type=\"hidden\" value=\"1\">";
		echo "<input name=\"validar\" type=\"hidden\" value=\"0 \">";
		echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
		echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">COMPONENTE POR EQUIPO</td>
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
		<input name=\"btnBuscar\" type=\"button\" value=\"EQUIPOS S/COMPONENTES\" onclick=\"generarReporteCoponente()\">		
		<input name=\"btnLimpiar\" type=\"button\" value=\"EQUIPOS C/COMPONENTE\" onclick=\"generarReporteComponentesEquipos()\"></td>			
		</tr>";		
		echo "</table>";
				
	echo "</form>";	

}


?>
