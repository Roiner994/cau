<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<script>
function buscarFicha(){
    if (window.event.keyCode==13){	    	
       //if (document.frmSolicitudesNuevas.ficha.value!="") {
		   document.frmSolicitudesNuevas.funcion.value=0;
	       document.frmSolicitudesNuevas.submit();
	   //}
    }
    if (window.event.keyCode==8){	
    	document.frmSolicitudesNuevas.funcion.value=0;
	    document.frmSolicitudesNuevas.submit();
    }        	
    var key=window.event.keyCode;//codigo de tecla. 
    if (key < 48 || key > 57){//si no es numero  
       window.event.keyCode=0;//anula la entrada de texto. 
    }   
}
</script>
<?php
require_once "formularios.php";
require_once "conexionsql.php";
switch ($_POST[funcion]) {	
   case "1":	        
			if ($_POST[ficha]=="" && $_POST[selSolicitud]==100){							
				if ($sw==1) {
			    $mensaje=$mensaje."<b>,</b>";
	         	}
		        $mensaje=$mensaje." <b>FICHA, Nº DE SOLICITUD</b>";
		        $i++;		     
		        $sw=1;    
            }    
            
	switch($i) {		
      case 0:                      
        if ($_POST[ficha]!="" && $_POST[selSolicitud]!=100){							
	        conectarMysql();              	                  
	        $consulta="DELETE FROM SOLICITUD_EQUIPO WHERE SOLICITUD_EQUIPO.ID_SOLICITUD='$_POST[selSolicitud]'";         
	        $result=mysql_query($consulta);	 	        
	        
	        	echo "<br><br>";
                  echo "<form name=\"frmSolicitudesNuevas\" method=\"post\" action=\"\">";                  				  				  
			      echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			      echo "<tr>";
				  echo "<td align=center>MENSAJE: ELIMINAR - SOLICITUD</td></tr>";
				  echo "<tr>";
				  echo"<td valign=top class=\"mensaje\">OPERACION ÉXITOSA</td>";
				  echo "<tr><td align=\"center\"><input name=\"btnSi\" type=\"submit\" value=\"ACEPTAR\"></td>
				  </table></form>";
			break 1;	  	                      } 
        if ($_POST[ficha]=="" && $_POST[selSolicitud]!=100){							
	        conectarMysql();              	                  
	        $consulta="DELETE FROM SOLICITUD_EQUIPO WHERE SOLICITUD_EQUIPO.ID_SOLICITUD='$_POST[selSolicitud]'";         
	        $result=mysql_query($consulta);	
	        echo "<br><br>";
                  echo "<form name=\"frmSolicitudesNuevas\" method=\"post\" action=\"\">";                  				  				  
			      echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			      echo "<tr>";
				  echo "<td align=center>MENSAJE: ELIMINAR - SOLICITUD</td></tr>";
				  echo "<tr>";
				  echo"<td valign=top class=\"mensaje\">OPERACION ÉXITOSA</td>";
				  echo "<tr><td align=\"center\"><input name=\"btnSi\" type=\"submit\" value=\"ACEPTAR\"></td>
				  </table></form>";	
			break 1;	         
        }                   
        conectarMysql();    
	    $con="SELECT SOLICITUD_EQUIPO.FICHA,CONCAT(USUARIO.NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUASRIO FROM SOLICITUD_EQUIPO
				INNER JOIN DESCRIPCION ON SOLICITUD_EQUIPO.ID_DESCRIPCION=DESCRIPCION.ID_DESCRIPCION
				INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA WHERE USUARIO.FICHA ='$_POST[ficha]'
				ORDER BY SOLICITUD_EQUIPO.ID_SOLICITUD";	    
        $conResult=mysql_query($con);                             
        if ($conResult && mysql_num_rows($conResult)>0 && $_POST[selSolicitud]==100){
        	echo "<br><br>";
                  echo "<form name=\"frmSolicitudesNuevas\" method=\"post\" action=\"\">"; 
                  echo "<input name=\"ficha\" type=\"hidden\" value=\"$_POST[ficha]\">";                 				  				  
			      echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			      echo "<tr>";
				  echo "<td align=center>MENSAJE: ELIMINAR - SOLICITUD</td></tr>";
				  echo "<tr>";
				  echo"<td valign=top class=\"mensaje\">EL CAMPO <b>Nº DE SOLICITUD</b> NO DEBE ESTAR VACIO</td>";
				  echo "<tr><td align=\"center\"><input name=\"btnSi\" type=\"submit\" value=\"ACEPTAR\"></td>
				  </table></form>";	
			break 1;	  			
        }
        else {
        	echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			        echo "<tr>";
					echo "<br><br><br><br>";
					echo "<form name=\"frmSolicitudesNuevas\" method=\"post\" action=\"\">";					
					echo "<input name=\"selSolicitud\" type=\"hidden\" value=\"$_POST[selSolicitud]\">";					
					echo "<tr>";
					echo "<td align=center>MENSAJE:ELIMINAR - SOLICITUDES</td>
							</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>EL USUARIO CON FICHA:<B>$_POST[ficha]</B> NO TIENE SOLICITUDES</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";					
					break 1;
         	
         }	                		        	      				
      case 1:       echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			        echo "<tr>";
					echo "<br><br><br><br>";
					echo "<form name=\"frmSolicitudesNuevas\" method=\"post\" action=\"\">";
					echo "<input name=\"ficha\" type=\"hidden\" value=\"$_POST[ficha]\">";
					echo "<input name=\"selSolicitud\" type=\"hidden\" value=\"$_POST[selSolicitud]\">";					
					echo "<tr>";
					echo "<td align=center>MENSAJE:ELIMINAR - SOLICITUDES</td>
							</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>LOS CAMPOS ".$mensaje. " ESTAN VACIOS</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";					
					break 1;
						
	}
	break 1;	
default:
  eliminarSolicitud();									            	                                                       
}
?>

<?php
 function eliminarSolicitud(){
	 echo "<form name=\"frmSolicitudesNuevas\" method=\"post\" action=\"\">"; 
	 echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">"; 
	 echo "<table class=\"formularioTabla\"align=center width=\"500\" border=0>"; 
	 echo "<td class=\"tituloPagina\" colspan=\"2\">SOLICITUDES</td></tr>";
	 echo "<tr>";
	 echo "<td class=\"formularioTablaTitulo\">ELIMINAR SOLICITUD</td></tr>"; 
	 echo "<td valign=top class=\"formularioCampoTitulo\">FICHA<br>"; 
	 $consulta="SELECT ID_SOLICITUD,CONCAT(SOLICITUD_EQUIPO.ID_SOLICITUD,' ',USUARIO.NOMBRE_USUARIO,' ',USUARIO.APELLIDO_USUARIO,' [ ',DESCRIPCION.DESCRIPCION,' ] ')
	            FROM SOLICITUD_EQUIPO
				INNER JOIN DESCRIPCION ON SOLICITUD_EQUIPO.ID_DESCRIPCION=DESCRIPCION.ID_DESCRIPCION
				INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA WHERE USUARIO.FICHA LIKE '%$_POST[ficha]'
				ORDER BY SOLICITUD_EQUIPO.ID_SOLICITUD";
	 $solicitud= new campoSeleccion("selSolicitud","formularioCampoSeleccion","$_POST[selSolicitud]","onChange","",$consulta,"--SELECCIONE--","");
	 $selSolicitud=$solicitud->retornar();     
	 echo"<input name=\"ficha\" type=\"text\" class=\"formularioCampo\" size=\"10\" maxlength=\"\" value=\"$_POST[ficha]\" onKeyPress=\"buscarFicha()\"> INTRODUZCA LA FICHA Y PRESIONE [ENTER]<BR>      
	       Nº DE SOLICITUD<br>$selSolicitud";
	 echo "<table align=\"center\" width=\"500\">	          
		   <td class=\"formularioTablaBotones\" align=\"center\"><input name=\"boton\" type=\"submit\" value=\"ELIMINAR SOLICITUD\">
	  	   </td></table>";   
	 echo "</table></form>";	
} 
?>  		
