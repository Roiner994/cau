<?php
include "../librerias/conexionsql.php";
include "../librerias/formato.php";
include "../librerias/administracion.php";
echo "<html>";
echo "<head>";
echo "<title>Departamento</title>";
?>
<script>
	function BuscarDepartamento() {
	
		var indiceDepartamento = document.frmBuscarDepartamento.selDepartamento.selectedIndex;
		var valorDepartamento = document.frmBuscarDepartamento.selDepartamento.options[indiceDepartamento].value;
		
							
		var ruta="BuscarDepartamento.php?"+"IdDepartamento="+valorDepartamento;
		if (valorDepartamento!=100) {
			window.location=ruta;
		}
	}
	function ValidarCampos() {
			
		var indiceDepartamento = document.frmBuscarDepartamento.selDepartamento.selectedIndex;
		var valorDepartamento = document.frmBuscarDepartamento.selDepartamento.options[indiceDepartamento].value;
		
		
		var MENSAJE="EL CAMPO ";
		var val=0;
		
		
		if (valorDepartamento=='100') {
			val=1;
		}
		
		if (val==1) {
			window.alert("SELECCIONE UN CAMPO");
		}
		else {
			document.frmBuscarDepartamento.submit();
		}
	}	
</script>
<?php 
//Formulario para ingresar los Equipos
echo "</head>";
echo "<body>"; 
 //TITULO DE LA PAGINA ACTUAL
 estilos();
 $titulo="Departamento";
 inicio($titulo);
 //TITULO DEL ENCABEZADO
 $encabezado="CONSULTAR SOLICITUDES";
 encabezado($encabezado); 

 //inicio de tabla
  echo "<table border=0 align='center'>\n";
//  $valor_busqueda=$_POST["oculta"];  
       
  
	conectarMysql();
	$consultaDepartamento = "SELECT id_departamento, departamento FROM departamento";	
	$RsDepartamento=mysql_query($consultaDepartamento);
	
	
	
    echo "<form name=\"frmBuscarDepartamento\" method=\"post\" action=\"ConsultarDepartamento.php\">";
   	  
	 echo "<tr>";
     echo "<b><td><H4 align='left'>Departamento</b></td>"."<td>"; 	
	 echo "<select name=\"selDepartamento\"  class=\"Estilo13\" >";
	 echo "<option value=\"100\">-Departamentos-</option>";
	while ($row=mysql_fetch_array($RsDepartamento)) {
		if ($row[0]==$IdDepartamento) {
			echo "<option selected value=$row[0]>$row[1]</option>";	
		}
		else {
			echo "<option value=$row[0]>$row[1]</option>";
		}
	}
	echo "</select>";
	
	 echo"<tr>";
    echo "<td><H4 align='left'></td>"."<td>"; 
	echo "<input name=\"btnAlmacenar\" type=\"button\" value=\"Buscar\" onClick=\"ValidarCampos()\">";
    mysql_close();
?>