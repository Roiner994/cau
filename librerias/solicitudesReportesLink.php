<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
require_once("seguridad.php");
?>

<?PHP
require_once"alineacion.php";
require_once"formularios.php";
require_once"administracion.php";
require_once"conexionsql.php";
	
switch ($_POST[funcion]) {
	case "1":
	   if ($_POST[selStatus]==100){
				if ($sw==1) {
			    $mensaje=$mensaje."<b>,</b>";
	         	}
		        $mensaje=$mensaje." <b>ESTATUS SOLICITUD</b>";
		        $i++;
		        $sw=1;    
            }
            if ($_POST[observEstatus]==""){
            	if ($sw==1) {
			    $mensaje=$mensaje."<b>,</b>";
	         	}
		        $mensaje=$mensaje." <b>OBSERVACION ESTATUS</b>";
		        $i++;
		        $sw=1;    
            }
            switch($i) {
            	case 0:
            	$_POST[observEstatus]=strtoupper($_POST[observEstatus]);
            	$_POST[observ]=strtoupper($_POST[observ]);
            	conectarMysql();
            	//if ($estuSolicitud!='STA0000001'){
            		//echo "entro cadavez aqui";
            	$conActualizar="UPDATE SOLICITUD_EQUIPO SET ID_STATUS='$_POST[selStatus]',STATUS='$_POST[selStatus]',
            	                       OBSERVACION_SOLICITUD='$_POST[observEstatus]' WHERE ID_SOLICITUD='$idSolicitud'";            	
            	$resultConsulta=mysql_query($conActualizar);
            	$consultar="select solicitud_historico.ID_HISTORICO from solicitud_historico order by solicitud_historico.ID_HISTORICO desc";
            	$idConsecutivo= new consecutivo("IDH", $consultar);
                $IdSolicitud=$idConsecutivo->retornar();            	            	
                $login=$_SESSION["login"];  
                $fechaInicio=getdate();            	                  
                $fechaInicio=$fechaInicio[year]."-".$fechaInicio[mon]."-".$fechaInicio[mday]." ".$fechaInicio[hours].":".$fechaInicio[minutes].":".$fechaInicio[seconds];								
                conectarMysql();
            	$insertarHistorico="insert into solicitud_historico (ID_HISTORICO,ID_SOLICITUD, ID_USS, OBSERVACION, FECHA_HISTORICO) 
            	                    values ('$IdSolicitud','$idSolicitud','$login','$_POST[observEstatus]','$fechaInicio')";            	
            	$resultHistorico=mysql_query($insertarHistorico);            	
            	//}
            	if ($resultConsulta && $insertarHistorico){
				echo "<br><br>";								
			    echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";			    
			    echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			    echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
			    echo "<input name=\"selStatus\" type=\"hidden\" value=\"$_POST[selStatus]\">";
				echo "<input name=\"observEstatus\" type=\"hidden\" value=\"$_POST[observEstatus]\">";									
			    echo "<tr>";
		     	echo "<td align=center>MENSAJE - NUEVAS - SOLICITUDES</td>
				</tr>";
			    echo "<tr>";
		     	echo "<td valign=top class=\"mensaje\" align=center>OPERACIÓN ÉXITOSA</td>";
			    echo "</tr>";
			    echo "<tr>";
			    echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"ACEPTAR\" onClick=\"window.close()\"></td>";
			    echo "</tr>";
			    echo "</table>";			    
				}
				else{
				echo "<br><br>";				
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			    echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";			    
			    echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
			    echo "<tr>";
		     	echo "<td align=center>MENSAJE - NUEVAS - SOLICITUDES</td>
				</tr>";
			    echo "<tr>";
		     	echo "<td valign=top class=\"mensaje\" align=center>OPERACIÓN FALLIDA INTENTELO DE NUEVO</td>";
			    echo "</tr>";
			    echo "<tr>";
			    echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
			    echo "</tr>";
			    echo "</table>";
				}           	   
            	break 1;
            	case 1:
            	echo "<br><br><br><br>";
					echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";					
					echo "<input name=\"ficha\" type=\"hidden\" value=\"$_POST[ficha]\">";
					echo "<input name=\"selStatus\" type=\"hidden\" value=\"$_POST[selStatus]\">";
					echo "<input name=\"observEstatus\" type=\"hidden\" value=\"$_POST[observEstatus]\">";					
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: NUEVAS - SOLICITUDES</td>
							</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>EL CAMPO ".$mensaje. " ESTÁ VACIO</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";	
					break 1;					
            default:
					echo "<br><br><br><br>";
					echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";
					echo "<input name=\"selStatus\" type=\"hidden\" value=\"$_POST[selStatus]\">";
					echo "<input name=\"observEstatus\" type=\"hidden\" value=\"$_POST[observEstatus]\">";										
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: NUEVAS - SOLICITUDES</td>
							</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>LOS CAMPOS ".$mensaje. " ESTAN VACIOS</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";				            	

            }	                                  	     
		break 1;
	case "2":
	datoSolicitud($idSolicitud);	
	break 1;	
	default:
	datoSolicitud($idSolicitud);		   
}

function datoSolicitud($idSolicitud){		
//inicio de tabla
//status_solicitud.id_status ='$estatus' and solicitud_equipo.id_solicitud='$idSolicitud' and gerencia.id_gerencia='$gerencia'
//and division.id_division='$division' and departamento.id_departamento='$departamento' ORDER BY gerencia.gerencia DESC"; 			
 echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";
 echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";     
 
    conectarMysql();			
	$consulta="select id_solicitud, solicitud_equipo.ficha,concat(NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUARIO,descripcion,gerencia,sitio,observacion_solicitud,
	usuario.extension,solicitud_equipo.id_status from solicitud_equipo 
	inner join usuario on solicitud_equipo.ficha=usuario.ficha
	inner join departamento on usuario.id_departamento=departamento.id_departamento  
	inner join division on departamento.id_division= division.id_division 	
	inner join gerencia on gerencia.id_gerencia=gerencia.id_gerencia 	
	inner join descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion 		
	inner join sitio on usuario.id_sitio=sitio.id_sitio 
	inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status	
	where solicitud_equipo.id_solicitud='$idSolicitud'";	
	$result=mysql_query($consulta);
	$row=mysql_fetch_array($result);  
	
//	echo "<title>USUARIO: $row[2]</title>";
	//consulta que muestra los diferentes status que puede tener una solicitud		
	$consultaStatus = "SELECT id_status, des_status FROM status_solicitud where ID_STATUS='STA0000001' OR id_status='STA0000002' ORDER BY status_solicitud.des_status";
	$conSelEstatus= new campoSeleccion("selStatus","formularioCampoSeleccion","$_POST[selStatus]","onChange","",$consultaStatus,"--SELECCIONE--","");
	$selEstatus=$conSelEstatus->retornar();	
	
    //consulta que muestra los diferentes status que puede tener una solicitud			
	$consultaStatus1 = "SELECT id_status, des_status FROM status_solicitud where ID_STATUS='STA0000004' ORDER BY status_solicitud.des_status";
	$conSelEstatus1= new campoSeleccion("selStatus","formularioCampoSeleccion","$_POST[selStatus]","onChange","",$consultaStatus1,"--SELECCIONE--","");
	$selEstatus1=$conSelEstatus1->retornar();		
	
	$fecha=gmdate("d/m/Y");  	
	echo "<table class=\"formularioTabla\" align=center width=\"500\" border=0>"; 
    echo "<td class=\"formularioTablaTitulo\">FECHA: $fecha<br><br>DATOS DE SOLICITUD<td class=formularioTablaSolicitud valign=top align=right><b>SOLICITUD Nº: $row[0]</b></td></tr>";
    echo "<tr>";  
    echo "<input name=\"ficha\" type=\"hidden\" value=\"$_POST[ficha]\">";    
	echo "<input name=\"selStatus\" type=\"hidden\" value=\"$_POST[selStatus]\">";
	echo "<input name=\"observEstatus\" type=\"hidden\" value=\"$_POST[observEstatus]\">";	       
	echo "<td class=\"formularioCampoTitulo\">FICHA<td>
	      <input name=\"ficha\" class=\"formularioCampo\" size=\"65\" maxlength=\"65\" readonly=\"true\" type=\"text\" value=\"$row[1]\"><TR>";	
    echo "<td class=\"formularioCampoTitulo\">USUARIO<td>
	      <input name=\"usuario\" class=\"formularioCampo\" size=\"65\" maxlength=\"65\" readonly=\"true\" type=\"text\" value=\"$row[2]\"><TR>";	
    echo "<td class=\"formularioCampoTitulo\">TELÉFONO<td>
	      <input name=\"telefono\" class=\"formularioCampo\" size=\"65\" maxlength=\"65\" readonly=\"true\" type=\"text\" value=\"$row[7]\"><TR>";
	echo "<td class=\"formularioCampoTitulo\">EQUIPO O COMPONENTE<td>
	      <input name=\"equipo\" class=\"formularioCampo\" size=\"65\" maxlength=\"65\" readonly=\"true\" type=\"text\" value=\"$row[3]\"><TR>";		  
	echo "<td class=\"formularioCampoTitulo\">GERENCIA<td>
	      <input name=\"gerencia\" class=\"formularioCampo\" size=\"65\" maxlength=\"65\" readonly=\"true\" type=\"text\" value=\"$row[4]\"><TR>";		  
	echo "<td class=\"formularioCampoTitulo\">SITIO<td>
	      <input name=\"sitio\" class=\"formularioCampo\" size=\"65\" maxlength=\"65\" readonly=\"true\" type=\"text\" value=\"$row[5]\"><TR>";		  	  
	/*if ($estuSolicitud!='STA0000002'){//RECHAZADO
	    echo "<td class=\"formularioCampoTitulo\">OBSERVACION<td>
	          <textarea name=\"observ\" class=\"formularioCampo\" cols=\"67\" rows=\"3\">$row[6]</textarea><tr>";		
	} */ 
	  	 if (strtoupper($row[8])=='STA0000006'){	  	 	 	  
      echo "<td class=\"formularioCampoTitulo\">ESTATUS SOLICITUD</td>
            <td>$selEstatus</td><tr>";
	  	 }        
	if(strtoupper($row[8])=='STA0000002'){// RECHAZADO
	  $consultaStatus = "SELECT id_status, des_status FROM status_solicitud where ID_STATUS='STA0000001' ORDER BY status_solicitud.des_status";
	  $conSelEstatus= new campoSeleccion("selStatus","formularioCampoSeleccion","$_POST[selStatus]","onChange","",$consultaStatus,"--SELECCIONE--","");
	  $selEstatus=$conSelEstatus->retornar();		  	  
      echo "<td class=\"formularioCampoTitulo\">ESTATUS SOLICITUD</td>
            <td>$selEstatus</td><tr>";
      /*echo "<td class=\"formularioCampoTitulo\">OBSERVACION<td>
	        <textarea name=\"observ\" class=\"formularioCampo\" cols=\"67\" rows=\"3\">$row[6]</textarea><tr>";*/
      echo "<b><td class=\"formularioCampoTitulo\">OBSERVACION ESTATUS</td>"."<td>"; 	
      echo "<textarea name=\"observEstatus\" class=\"formularioCampo\"  cols=\"67\" rows=\"3\"></textarea><tr>";		    				         
      echo "<input=\"status\" tipe=\"hidden\" value=\"$_POST[selStatus]\">";      
	}
	if(strtoupper($row[8])=='STA0000003'){//EN PROCESO
	   $consultaStatus1 = "SELECT id_status, des_status FROM status_solicitud where ID_STATUS='STA0000001' OR id_status='STA0000002' ORDER BY status_solicitud.des_status";
	   $conSelEstatus1= new campoSeleccion("selStatus","formularioCampoSeleccion","$_POST[selStatus]","onChange","",$consultaStatus1,"--SELECCIONE--","");
	   $selEstatus1=$conSelEstatus1->retornar();		  	  
       echo "<td class=\"formularioCampoTitulo\">ESTATUS SOLICITUD</td>
             <td>$selEstatus1</td><tr>";       
	} 
	if(strtoupper($row[8])=='STA0000001'){//APROBADO	  	  
      echo "<td class=\"formularioCampoTitulo\">ESTATUS SOLICITUD</td>
            <td>$selEstatus1</td><tr>";       
	}
   if(strtoupper($row[8])!='STA0000004' && strtoupper($row[8])!='STA0000002'  && strtoupper($row[8])!='STA0000005'){//EJECUTADO O RECHAZADO     
     echo "<b><td class=\"formularioCampoTitulo\">OBSERVACION ESTATUS</td>"."<td>"; 	
     echo "<textarea name=\"observEstatus\" class=\"formularioCampo\"  cols=\"67\" rows=\"3\"></textarea><tr>";		    				         
     echo "<input=\"status\" tipe=\"hidden\" value=\"$_POST[selStatus]\">";
   }    
   if(strtoupper($row[8])=='STA0000001'|| strtoupper($row[8])=='STA0000004' || strtoupper($row[8])=='STA0000002' || strtoupper($row[8])=='STA0000003' || strtoupper($row[8])=='STA0000005' || strtoupper($row[8])=='STA0000006'){	//APROBADO O EJECUTADO O RECHAZADO O EN PROCESO O EJECUTADO SIN PUNTO DE RED O SIN PROCESAR        
	   $conHistorico="select ID_HISTORICO, solicitud_historico.ID_USS, concat(usuario_sistema.NOMBRE,' ',usuario_sistema.APELLIDO)as USUARIO, OBSERVACION, date_format(FECHA_HISTORICO,'%d/%m/%Y HORA:%r') from solicitud_historico
	   INNER JOIN usuario_sistema on solicitud_historico.ID_USS=usuario_sistema.ID_USS WHERE solicitud_historico.id_solicitud='$idSolicitud'";	   	   
	   conectarMysql();
	   $valorHistorico=mysql_query($conHistorico);
	   echo "<b><td class=\"formularioCampoTitulo\">OBSERVACION HISTORICA</td>"; 	
	   while ($arreglo=mysql_fetch_array($valorHistorico)) {	       
	   	   $tem=$tem.$arreglo[2]."  FECHA:".$arreglo[4]."\n".$arreglo[3]."\n"."-----------------------------------------------------------------------------------"."\n";	   		   	   	   		              	  		   
	   }
	   echo "<td><textarea name=\"observHistorico\" class=\"formularioCampo\" cols=\"67\" rows=\"8\" readonly=\"true\">$tem</textarea><tr>";		    				         
   }
   echo"</table></center>";   
   echo "<input=\"status\" tipe=\"hidden\" value=\"$_POST[selStatus]\">";
   echo"</table></center>";
   if(strtoupper($row[8])!='STA0000004' && strtoupper($row[8])!='STA0000002' && strtoupper($row[8])!='STA0000005'){//EJECUTADO O RECHAZADO	  	        
   echo "<CENTER>";
   echo "<TABLE width=\"500\" border=0>      
         <TD class=\"formularioTablaBotones\">   
         <input name=\"btnAlmacenar\" type=\"submit\" class=\"Estilo71\" value=\"ACTUALIZAR\"></td>";  
   echo "</TABLE>";		
   echo "</CENTER>";
   }
   if(strtoupper($row[8])!='STA0000004' && strtoupper($row[8])=='STA0000002'){//EJECUTADO O RECHAZADO	  	        
   echo "<CENTER>";
   echo "<TABLE width=\"500\" border=0>      
         <TD class=\"formularioTablaBotones\">   
         <input name=\"btnAlmacenar\" type=\"submit\" class=\"Estilo71\" value=\"ACTUALIZAR\"></td>";  
   echo "</TABLE>";		
   echo "</CENTER>";
   }
   echo"</form>";	          
}	
?>