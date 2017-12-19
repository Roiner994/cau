<?php
 include "../librerias/conexionsql.php";
 include "../librerias/formato.php";
 include "../librerias/formularios.php";
 
// inicio("GERENCIA");
 estilos();
 encabezado("SOLICITUDES DE LA GERENCIA");
 conectarMysql(); 
 


function buscar_gerencia($valor_busqueda,$valor_busqueda2){ 
     conectarMysql(); 
	 $Consulta="select count(solicitud_equipo.id_descripcion) from solicitud_equipo inner join descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join departamento on ubicacion.id_departamento=departamento.id_departamento where descripcion.id_descripcion='$valor_busqueda' and departamento.id_departamento='$valor_busqueda2'";
	 
	 $ConsultaEquipo="select descripcion.id_descripcion,descripcion,departamento,id_solicitud from solicitud_equipo inner join descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join departamento on ubicacion.id_departamento=departamento.id_departamento where descripcion.id_descripcion='$valor_busqueda' and departamento.id_departamento='$valor_busqueda2'";  	 	 	
	 
	 $result1=mysql_query($ConsultaEquipo);			   	 	
     $result=mysql_query($Consulta);	
	 		 	  	  	 	 	  
	  inicioTabla();    
	  if($row1=mysql_fetch_array($result)){	    
		 if($row=mysql_fetch_array($result1));{
	  equiposEncontrados($row1[0],$row[1],$row[2]);        	               
	  }	
	}  
	  	    
mysql_close();
}
buscar_gerencia( $_POST["selEquipo"],$_POST["selDepartamento"]);

function inicioTabla() {
	echo "<table width=\"300\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">".
	"<tr bgcolor=\"#0000FF\" class=\"Estilo10\">".
	"<th width=\"180\" bgcolor=\"#CC0000\" scope=\"col\">CANTIDAD DE SOLICITUDES ECHAS A ESTE EQUIPO</th>".
	"<th width=\"180\" bgcolor=\"#CC0000\" scope=\"col\">EQUIPO</th>".
	"<th width=\"180\" bgcolor=\"#CC0000\" scope=\"col\">DEPARTAMENTO</th>";
	echo "</tr>";

}

function equiposEncontrados($Equipo,$EquipoSol,$Departamento) {
	echo "<tr>";	
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo14\">$Equipo</td>";	
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo14\">$EquipoSol</td>";	
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo14\">$Departamento</td>";		
	echo "</tr>";
}

  echo "<table border=0 align='center'>\n";
  echo "<form action=\"Index.php\" method=\"post\" name=\"formulariovolver\">";
  echo "<input name=\"Volver\" aling=\"center\" type=\"submit\" value=\"Volver\">";
  echo "</form>";
fin();		
?>
