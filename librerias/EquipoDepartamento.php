<?php
include "../librerias/conexionsql.php";
include "../librerias/formato.php";
include "../librerias/administracion.php";
echo "<html>";
echo "<head>";
echo "<title>Gerencia</title>";
?>
<script>
	function BuscarEquipo() {
	
		var indiceEquipo = document.frmEquipoDepartamento.selEquipo.selectedIndex;
		var valorEquipo = document.frmEquipoDepartamento.selEquipo.options[indiceEquipo].value;
		
		var indiceDepartamento = document.frmEquipoDepartamento.selDepartamento.selectedIndex;
		var valorDepartamento = document.frmEquipoDepartamento.selGerencia.options[indiceDepartamento].value;
		
							
		var ruta="EquipoDepartamento.php?"+"IdEquipo="+valorEquipo+"IdDepartamento="+valorDepartamento;
		if (valorEquipo!=100) {
			window.location=ruta;
		}
	}
	function ValidarCampos() {
			
		var indiceEquipo = document.frmEquipoDepartamento.selEquipo.selectedIndex;
		var valorEquipo = document.frmEquipoDepartamento.selEquipo.options[indiceEquipo].value;
		
		var indiceDepartamento = document.frmEquipoDepartamento.selDepartamento.selectedIndex;
		var valorDepartamento = document.frmEquipoDepartamento.selDepartamento.options[indiceDepartamento].value;
		
		
		var MENSAJE="EL CAMPO ";
		var val=0;
		
		
		if (valorEquipo=='100') {
			val=1;
		}
		
		
		if (valorDepartamento=='100') {
			val=1;
		}
		
		if (val==1) {
			window.alert("SELECCIONE UN CAMPO");
		}
		else {
			document.frmEquipoDepartamento.submit();
		}
	}	
</script>
<?php
//Formulario para ingresar los Equipos
echo "</head>";
echo "<body>"; 
 //TITULO DE LA PAGINA ACTUAL
 estilos();
 $titulo="Equipos";
 inicio($titulo);
 //TITULO DEL ENCABEZADO
 $encabezado="CONSULTAR EQUIPOS";
 encabezado($encabezado); 

 //inicio de tabla
  echo "<table border=0 align='center'>\n";
//  $valor_busqueda=$_POST["oculta"];  
       
  
	conectarMysql();
	$consultaEquipo = "SELECT id_descripcion, descripcion FROM descripcion";
	$consultaDepartamento = "SELECT id_departamento, departamento FROM departamento";	
	
	$RsDepartamento=mysql_query($consultaDepartamento);	
	$RsEquipo=mysql_query($consultaEquipo);
	
	
	
    echo "<form name=\"frmEquipoDepartamento\" method=\"post\" action=\"ConsultarEquipoDepartamento.php\">";
   	  
	 echo"<tr>";
     echo "<b><td><H4 align='left'>Equipos</b></td>"."<td>"; 	
	 echo "<select name=\"selEquipo\"  class=\"Estilo13\" >";
	 echo "<option value=\"100\">-EQUIPOS-</option>";
	while ($row=mysql_fetch_array($RsEquipo)) {
		if ($row[0]==$IdEquipo) {
			echo "<option selected value=$row[0]>$row[1]</option>";	
		}
		else {
			echo "<option value=$row[0]>$row[1]</option>";
		}
	}
	echo "</select>";
	
	echo"<tr>";
     echo "<b><td><H4 align='left'>Departamento</b></td>"."<td>"; 	
	 echo "<select name=\"selDepartamento\"  class=\"Estilo13\" >";
	 echo "<option value=\"100\">-GERENCIAS-</option>";
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
	   	
	echo "</td>";    
    echo"</tr>";
    echo"</table>";
	echo "</form>";	
	echo "</body>";
	echo "</html>";	
	mysql_close();
?>
