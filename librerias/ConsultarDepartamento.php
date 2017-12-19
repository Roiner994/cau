<?php
 include "../librerias/conexionsql.php";
 include "../librerias/formato.php";
 include "../librerias/formularios.php";
 
 inicio("DEPARTAMENTO");
 estilos();
 encabezado("SOLICITUDES DE DEPARTAMENTOS");
 conectarMysql(); 
 $valor_busqueda =$_POST["selDepartamento"]; 

function buscar_departamento($valor_busqueda){ 
     conectarMysql();   
	 $cuentaConsulta="SELECT  count(id_solicitud) as total from solicitud_equipo inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where gerencia.id_gerencia='$valor_busqueda'";
	  
	 $cuentaConsulta1="SELECT  count(solicitud_equipo.id_status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where solicitud_equipo.id_status='S000000001' and gerencia.id_gerencia='$valor_busqueda'"; 
	 $cuentaConsulta2="SELECT  count(solicitud_equipo.id_status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where solicitud_equipo.id_status='S000000002' and gerencia.id_gerencia='$valor_busqueda'";
	 $cuentaConsulta3="SELECT  count(solicitud_equipo.id_status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where solicitud_equipo.id_status='S000000003' and gerencia.id_gerencia='$valor_busqueda'";
	 $cuentaConsulta4="SELECT  count(solicitud_equipo.id_status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where solicitud_equipo.id_status='S000000004' and gerencia.id_gerencia='$valor_busqueda'";
	 $cuentaConsulta5="SELECT  count(solicitud_equipo.id_status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where solicitud_equipo.id_status='S000000005' and gerencia.id_gerencia='$valor_busqueda'";
	 
    $consulta= "select id_solicitud,descripcion,departamento,fecha_i from solicitud_equipo inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion inner join departamento on ubicacion.id_departamento=departamento.id_departamento where  departamento.id_departamento='$valor_busqueda'";		
           
     echo "<table width=\"00\" border=\"0\">";
     echo "<tr>";	 
	 $result=mysql_query($consulta);		
	 $row1=mysql_fetch_array($result);	 
	 echo "<td>&nbsp;<span class=\"Estilo1\"><b>DEPARTAMENTO:<b>&nbsp;</span></td>";
	 echo "<td>&nbsp;<span class=\"Estilo3\">".$row1[2]."&nbsp;</span></td>";	 	 	 
	 echo "</tr>";	 
	 
	 $result=mysql_query($consulta);	
	 inicioTabla();  
	  while($row1=mysql_fetch_array($result)){	
	    
	     equiposEncontrados($row1[0],$row1[1],$row1[3]);    	      
	  }			  
	  echo "</table>";
	  
	  $result=mysql_query($cuentaConsulta);	
	  $result1=mysql_query($cuentaConsulta1);
	  $result2=mysql_query($cuentaConsulta2);
	  $result3=mysql_query($cuentaConsulta3);
	  $result4=mysql_query($cuentaConsulta4); 
	  $result5=mysql_query($cuentaConsulta5); 			
	  inicioTabla1();	
	   if($row=mysql_fetch_array($result)){	      
		  if($row1=mysql_fetch_array($result1)){		    
		    if($row2=mysql_fetch_array($result2)){		      
			   if($row3=mysql_fetch_array($result3)){			     
			      if($row4=mysql_fetch_array($result4)){
                   	if($row5=mysql_fetch_array($result5)){ 
			      }
			   }
		    }
		  }
		 } 
		   equiposEncontrados1($row[0],$row1[0],$row2[0],$row3[0],$row4[0],$row5[0]);	
	   }	
	   echo "</table>";	  	    
mysql_close();
}
buscar_departamento( $_POST["selDepartamento"]);

function inicioTabla() {
	echo "<table width=\"800\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">".
	"<tr bgcolor=\"#0000FF\" class=\"Estilo10\">".
	"<th width=\"180\" bgcolor=\"#CC0000\" scope=\"col\">SOLICITUD</th>".
	"<th width=\"180\" bgcolor=\"#CC0000\" class=\"Estilo10\" scope=\"col\">EQUIPO</th>".
	"<th width=\"180\" bgcolor=\"#CC0000\" scope=\"col\">FECHA</th>";
	echo "</tr>";

}

function equiposEncontrados($Solicitud,$Equipo,$Fecha) {
	echo "<tr>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo14\">$Solicitud</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo14\">$Equipo</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo14\">$Fecha</td>";
	echo "</tr>";
}

function inicioTabla1() {
	echo "<table width=\"800\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">".
	"<tr bgcolor=\"#0000FF\" class=\"Estilo10\">".
	"<th width=\"180\" bgcolor=\"#CC0000\" scope=\"col\">TOTAL DE SOLICITUD</th>".
	"<th width=\"180\" bgcolor=\"#CC0000\" scope=\"col\">SOLICITUD APROBADA</th>".
	"<th width=\"180\" bgcolor=\"#CC0000\" scope=\"col\">SOLICITUD EN PROCESO</th>".
	"<th width=\"180\" bgcolor=\"#CC0000\" scope=\"col\">SOLICITUD RECHAZADA</th>".
	"<th width=\"180\" bgcolor=\"#CC0000\" scope=\"col\">SOLICITUD EJECUTADA</th>";
	"<th width=\"180\" bgcolor=\"#CC0000\" scope=\"col\">SOLICITUD EJECUTADA(PENDIENTE/PTO DE RED)</th>";
	echo "</tr>";

}

function equiposEncontrados1($Solicitud,$Aprobada,$EnProceso,$Rechazada,$Ejecutada,$Ejecutada2) {
	echo "<tr>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo14\">$Solicitud</td>";	
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo14\">$Aprobada</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo14\">$EnProceso</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo14\">$Rechazada</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo14\">$Ejecutada</td>";
		echo "<td align=\"center\" valign=\"middle\" class=\"Estilo14\">$Ejecutada2</td>";
	echo "</tr>";
}

  echo "<table border=0 align='center'>\n";
  echo "<form action=\"Index.php\" method=\"post\" name=\"formulariovolver\">";
  echo "<input name=\"Volver\" aling=\"center\" type=\"submit\" value=\"Volver\">";
  echo "</form>";
?>
