<style type="text/css">
.Estilo10 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #FFFFFF;
	background:#006699;
}
.Estilo70 {color:  #FF0000; 	font-size:11px; font-family: Arial, Helvetica, sans-serif;}
.Estilo71 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #000000;
}
.Estilo74 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #ffffff;
}	
</style>
<?PHP


include "../librerias/conexionsql.php";
include "../librerias/formularios.php";
include "../librerias/administracion.php";
?>
<script>

	function BuscarFecha() {
	
		var indiceFecha = document.frmSolicitudFecha.selFecha.selectedIndex;
		var valorFecha = document.frmSolicitudFecha.selFecha.options[indiceFecha].value;
		
		var indiceFecha1 = document.frmSolicitudFecha.selFecha1.selectedIndex;
		var valorFecha1 = document.frmSolicitudFecha.selFecha1.options[indiceFecha1].value;					
							
		var ruta="SolicitudFecha.php?"+"IdFecha="+valorFecha+"&IdFecha1="+valorFecha1;
		if (valorFecha!=100) {
			window.location=ruta;
		}
	}
	function ValidarCampos() {
			
		var indiceFecha = document.frmSolicitudFecha.selFecha.selectedIndex;
		var valorFecha = document.frmSolicitudFecha.selFecha.options[indiceFecha].value;
		
		
		var MENSAJE="EL CAMPO ";
		var val=0;
		
		
		if (valorFecha=='100') {
			val=1;
		}
		
		if (val==1) {
			window.alert("SELECCIONE UN CAMPO");
		}
		else {
			document.frmSolicitudFecha.submit();
		}
	}	
</script>
<?php
function fecha(){
 //inicio de tabla 
    
    echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"0\">".
    "<TD bgColor=\"#FFFFFF\">".
    "<FONT face=\"Verdana\" size=\"1\">".
    "<td class=\"Estilo71\" <b>SOLICITUDES APROBADAS POR INSTALAR</td></b></td>".
    "</FONT></TD></TABLE>";
    echo "<CENTER>
	<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\">    
    <TR vAlign=\"top\">
    <TD bgColor=\"#FFFFFF\" class=\"Estilo71\">
    <FONT face=\"Verdana\" size=\"1\">
    <b>FECHA-INICIAL:</b></FONT></TD>
    <TD align=\"left\" bgColor=\"#FFFFFF\">
    <FONT face=\"Verdana\" size=\"1\">
	<input type=\"text\" name=\"fecha\" onkeypress=\"return fecha(event)\">
	FORMATO: dd/mm/aaaa";		
	/*conectarMysql();
	$consultaFecha = "select distinct fecha_i from solicitud_equipo";	
	$RsFecha=mysql_query($consultaFecha);*/		
    //echo "<form name=\"frmSolicitud\" method=\"post\" action=\"ReporteEdificio.php\">";   	      
   
	/*while ($row=mysql_fetch_array($RsFecha)) {
	   
		if ($row[0]==$IdFecha) {
			echo "<option selected value=$row[0]>$row[0]</option>";	
		}
		else {
			echo "<option value=$row[0]>$row[0]</option>";
		}
	}
	echo "</select>";
	echo"<tr>";
	$RsFecha=mysql_query($consultaFecha);*/	
    echo "<TR vAlign=\"top\">
    <TD bgColor=\"#FFFFFF\" class=\"Estilo71\" >
    <FONT face=\"Verdana\" size=\"1\">
    <b>FECHA-FINAL:</b></FONT></TD>
    <TD align=\"left\" bgColor=\"#FFFFFF\">
    <FONT face=\"Verdana\" size=\"1\">
	<input type=\"text\" name=\"fecha1\" onkeypress=\"return fecha(event)\">
	FORMATO: dd/mm/aaaa";	
	/*while ($row=mysql_fetch_array($RsFecha)) {
		if ($row[0]==$IdFecha1) {
			echo "<option selected value=$row[0]>$row[0]</option>";	
		}
		else {
			echo "<option value=$row[0]>$row[0]</option>";
		}
	}
	echo "</select>";*/
	echo "</table></center>";
	echo"<tr>";
	echo "<CENTER>";
	echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\">";    
    echo "<TR vAlign=\"top\">";
    echo "<TD bgColor=\"#FFFFFF\" class=\"Estilo71\" >";
    echo "<FONT face=\"Verdana\" size=\"1\">";	  
    echo "<form name=\"frmSolicitudesAprobadas\" method=\"post\" action=\"ReporteEdificio.php\">";	
	echo "<input name=\"btnAlmacenar\" type=\"submit\" value=\"Buscar\">";
    echo "<table><center></form>";	
	//mysql_close();
}
fecha(); 
?>
</body>
</html> 