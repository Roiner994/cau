<?php
require_once "libreriaScript.php";
require_once "alineacion.php";
require_once "formularios.php";
require_once "conexionsql.php";
require_once "administracion.php";
echo "<link rel=\"STYLESHEET\" type=\"text/css\" href=\"../site/estilos.css\">";
conectarMysql();
$ficha;
$gerencia;
$division;
$departamento; 

$consulta="select  distinct solicitud_equipo.id_solicitud,descripcion.descripcion,des_status,motivo_solicitud,observacion_solicitud,solicitud_equipo.id_status,solicitud_equipo.ficha,status_solicitud.id_status  
           from solicitud_equipo  
           inner join motivo_solicitud on solicitud_equipo.id_motivo_solicitud=motivo_solicitud.id_motivo_solicitud 
           inner join descripcion on solicitud_equipo.id_descripcion =descripcion.id_descripcion  
           inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status 
           where solicitud_equipo.ficha='$ficha' order by solicitud_equipo.id_solicitud desc";	  
             $result=mysql_query($consulta);		     
	 	     $resultado=mysql_num_rows($result);
	         $rs=mysql_query($busca);			                                 
           if ($resultado>0){           		 			  	          						   
		                 $encabezado= "<table align=center> 	
				         <td class=\"formularioTablaTitulo\"colspan=\"6\">SOLICITUDES CARGADAS</td></tr>    	
					     <tr class=\"tablaTitulo\">	
					     <td align=\"left\" class=\"tablaTitulo\">SOLICITUD</td>
					     <td align=\"left\" class=\"tablaTitulo\">EQUIPO</td>
					     <td align=\"left\" class=\"tablaTitulo\">MOTIVO SOLICITUD</td>					     
					     <td align=\"left\" class=\"tablaTitulo\">STATUS SOLICITUD</td>
					     <td align=\"left\" class=\"tablaTitulo\">OBSERVACION</td>					     
					     </tr>";		                 	               
	               echo $encabezado;	              	              	   	               	             
	          while($row1=mysql_fetch_array($result)){	     	
	                if ($i%2==0)
				        $clase="tablaFilaPar";			  
			        else 
				        $clase="tablaFilaNone";		  
		            echo "<tr class=\"$clase\">		                  
				          <td><a href=\"#\"  onclick=window.open(\"../librerias/Solicitudes.php?ficha=$row1[6]&idSolicitud=$row1[0]&estatus=$row1[5]&gerencia=$gerencia&division=$division&departamento=$departamento&estuSolicitud=$row1[7]\",\"\",'width=540,height=600,scrollbars=1,top=200,left=350') <input type=hidden title=\"Ver el detalle de la solicitud\">$row1[0]</a></td>
				          <td>$row1[1]</td>
				          <td>$row1[3]</td>
				          <td>$row1[2]</td>
				          <td>$row1[4]</td>				          					          			          
	                </tr>";	 	    	     		  
		            $i++;
	          }	          
		    }				      
	      //}	   
?>