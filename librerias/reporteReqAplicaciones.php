<?php
session_start();
$Acceso=array ("PRV0000001","PRV0000002");
switch ($_SESSION[authUser]) {
	case '0':
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";
		exit();
		break 1;
	case '1':
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";
		exit();
		break 1;
	default:
	require_once  "../librerias/usuarioSistemaAdmin.php";
	require_once "../librerias/conexionsql.php";
	$acceso= new usuarioSistema("",$_SESSION['userName'],$_SESSION['userPass']);
	$resultado= $acceso->validar();
	switch ($resultado) {
		case 1:
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";		
			exit();
			break 1;
		case 2:
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";	
			exit();
			break 1;
		default:
			foreach($Acceso as $valor) {
				if ($_SESSION['authUser']!=$valor) {
					$sw=1;
				} else {
					$sw=0;
					break 1;
				}
			}
			if ($sw==1) {
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";	
				exit();
			}
	}
}

?>

<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
 <script language="javascript">
	function cambiarSeleccion() {
		document.frmGarantia.funcion.value=1;
		document.frmGarantia.submit();
	}
	function buscarSerial() {
		if (document.frmComponente.txtSerial.value!="") {
			document.frmComponente.funcion.value=3;
			document.frmComponente.submit();
		}
	}
	function Letras(e) { 
		tecla = (document.all) ? e.keyCode : e.which; 
		if (tecla==8) return true; //Tecla de retroceso (para poder borrar) 
    		patron ="/[0-9/]/"; // Solo acepta letras 
			te = String.fromCharCode(tecla); 
    	return patron.test(te); 
	}

	function Num(e){ 
    tecla = (document.all) ? e.keyCode : e.which; 
    if (tecla==8) return true; //Tecla de retroceso (para poder borrar) 
    patron =/[0-9]/; // Solo numeros  
	te = String.fromCharCode(tecla); 
    return patron.test(te); 
    }
    
    function fuera() {
		document.frmRequrimientoAplicaciones.funcion.value=2;
		document.frmRequrimientoAplicaciones.submit();
    }    
    function entrarDenuevo() {
		 document.frmRequrimientoAplicaciones.funcion.value=3;
		 document.frmRequrimientoAplicaciones.submit();
}
function buscarTotal() {
		document.frmRequrimientoAplicaciones.funcion.value=4;
		document.frmRequrimientoAplicaciones.submit();
	}

</script>


<?php
//REPORTES DE GARANTIA
require_once "administracion.php";
require_once "garantiaAdmin.php";
require_once "conexionsql.php";
require_once "formularios.php";

switch($funcion) {	
	case 1:			
	if (isset($_POST[txtFechaInicio]) && empty($_POST[txtFechaInicio])) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje."<b>FECHA INICIAL</b>";
		$i++;
		$sw=1;
	}
	if (isset($_POST[txtFechaFinal]) && empty($_POST[txtFechaFinal])) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje."<b>FECHA FINAL</b>";
		$i++;
		$sw=1;
	}
	switch($i) {		
		case 0:	
		echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";				
		$arregloFecha1=array("$_POST[txtFechaInicio]");				 			
		$arregloFecha2=array("$_POST[txtFechaFinal]");	
		////////////////////////////////////	
		$anno1=substr($arregloFecha1[0],6,4); 	  	   
		$mes1=substr($arregloFecha1[0],3,2);
		$dia1=substr($arregloFecha1[0],0,2);
		////////////////////////////////////
		$anno2=substr($arregloFecha2[0],6,4); 		  	   
		$mes2=substr($arregloFecha2[0],3,2);
		$dia2=substr($arregloFecha2[0],0,2);
		////////////////////////////////////		
		if ($anno2 > $anno1){			
			  formularioRequerimientoSoftware();
			  if ($_POST[selGerencia]==100 and $_POST[selDivision]==100){			 	
			 	  $_POST[selGerencia]="";
			 	  $_POST[selDivision]="";			 				 	 
				  conectarMysql();
				  $fechaI=substr($_POST[txtFechaInicio],6,4)."-". substr($_POST[txtFechaInicio],3,2)."-". substr($_POST[txtFechaInicio],0,2);
				  $fechaF=substr($_POST[txtFechaFinal],6,4)."-". substr($_POST[txtFechaFinal],3,2)."-". substr($_POST[txtFechaFinal],0,2);			 			
		          $consulta="select distinct gerencia.gerencia,gerencia.id_gerencia,division.division,requerimiento_aplicaciones.id_division,
			                 count(requerimiento_aplicaciones.id_migracion) as total,migracion.migracion,requerimiento_aplicaciones.REQUERIMIENTO_APLICACION from requerimiento_aplicaciones
					 	 	 inner join division on requerimiento_aplicaciones.id_division=division.id_division	
							 inner join gerencia on division.id_gerencia=gerencia.id_gerencia
							 inner join migracion on requerimiento_aplicaciones.id_migracion=migracion.id_migracion							
							 WHERE gerencia.id_gerencia like ('%$_POST[selGerencia]') and division.id_division like ('%$_POST[selDivision]') and requerimiento_aplicaciones.fecha_inicio
							 between '$fechaI' and '$fechaF' group by gerencia.gerencia,requerimiento_aplicaciones.id_migracion,requerimiento_aplicaciones.REQUERIMIENTO_APLICACION order by gerencia.gerencia";		         
		          $result=mysql_query($consulta);
		          $resultado=mysql_num_rows($result);
		          if($resultado>0){
		             echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";					
					 echo "<tr valign=top class=\"tablaTitulo\">
					   	   <td align=\"left\" class=\"tablaTitulo\">GERENCIA</td>																					
						   <td valign=top class=\"tablaTitulo\">APLICACI�N</td>							
						   <td valign=top class=\"tablaTitulo\">PLATAFORMA</td>
						   <td valign=top class=\"tablaTitulo\">TOTAL</td>
						   </tr>";
		          while ($row = mysql_fetch_array($result)) {	         		         	         									
			        	 if ($i%2==0) {
						 	 $clase="tablaFilaPar";
						 }
						 else {
						 	 $clase="tablaFilaNone";
						 }
						 	echo "<tr class=\"$clase\">
						  	      <td align=\"left\">$row[0]</td>
						  	      <td>$row[6]</td>																
								  <td>$row[5]</td>
								  <td>$row[4]</td>							
								  </tr>";
								  $i++;
		          }					          		         
		           echo "<td class=\"formularioTablaBotones\" colspan=\"5\"><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"entrarDenuevo()\">
		           <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfReportRequerimientoAplicaciones.php?gerencia=$_POST[selGerencia]&tipo=$_POST[selEstHardware]&fechaI=$fechaI&fechaF=$fechaF\")></td>";							 	
			      }
			      else{
				     echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";						
				     echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				     echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				     echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				     echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";								    
				     echo "<input name=\"txtCantidad\" type=\"hidden\" value=\"$_POST[txtCantidad]\">";									
				     echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
				     echo "<tr>";
		     	     echo "<td align=center>MENSAJE - REQUERIMIENTO - APLICACIONES</td>
				           </tr>";
			         echo "<tr>";
		     	     echo "<td valign=top class=\"mensaje\" align=center>NO EXISTEN REGISTROS EN EL RANGO DE FECHAS</td>";
			         echo "</tr>";
			         echo "<tr>";
			         echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
			         echo "</tr>";
			         echo "</table>";		 	  
			      }						 	
			    }
			    else{
			    if( $_POST[selDivision]==100){			 			 	
			        $_POST[selDivision]="";	
			    }    			 
			    conectarMysql();
			    $fechaI=substr($_POST[txtFechaInicio],6,4)."-". substr($_POST[txtFechaInicio],3,2)."-". substr($_POST[txtFechaInicio],0,2);
			    $fechaF=substr($_POST[txtFechaFinal],6,4)."-". substr($_POST[txtFechaFinal],3,2)."-". substr($_POST[txtFechaFinal],0,2);			 			
	            $consulta="select distinct gerencia.gerencia,gerencia.id_gerencia,division.division,requerimiento_aplicaciones.id_division,
		                   count(requerimiento_aplicaciones.id_migracion) as total,migracion.MIGRACION,requerimiento_aplicaciones.REQUERIMIENTO_APLICACION from requerimiento_aplicaciones
					   	   inner join division on requerimiento_aplicaciones.id_division=division.id_division	
						   inner join gerencia on division.id_gerencia=gerencia.id_gerencia
						   inner join migracion on requerimiento_aplicaciones.id_migracion=migracion.id_migracion						
						   WHERE gerencia.id_gerencia like ('%$_POST[selGerencia]') and division.id_division like ('%$_POST[selDivision]') and requerimiento_aplicaciones.fecha_inicio
						   between '$fechaI' and '$fechaF' group by gerencia.gerencia,division.division,requerimiento_aplicaciones.id_migracion,requerimiento_aplicaciones.REQUERIMIENTO_APLICACION";		     	         
	            $result=mysql_query($consulta);
	            $resultado=mysql_num_rows($result);
	            if($resultado>0){
	               echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";					
				   echo "<tr valign=top class=\"tablaTitulo\">
					 	 <td align=\"left\" class=\"tablaTitulo\">GERENCIA</td>
						 <td valign=top class=\"tablaTitulo\">DIVISION</td>												
						 <td valign=top class=\"tablaTitulo\">APLICACI�N</td>						
						 <td valign=top class=\"tablaTitulo\">PLATAFORMA</td>						
						 <td valign=top class=\"tablaTitulo\">TOTAL</td>
						 </tr>";
	            while ($row = mysql_fetch_array($result)) {	         		         	         									
						if ($i%2==0) {
							$clase="tablaFilaPar";
						} 
						else {
							$clase="tablaFilaNone";
						}
						echo "<tr class=\"$clase\">
						      <td align=\"left\">$row[0]</td>
							  <td>$row[2]</td>
							  <td>$row[6]</td>							
							  <td>$row[5]</td>
							  <td>$row[4]</td>
							  </tr>";
						      $i++;
	            }	                   	         
	             echo "<td class=\"formularioTablaBotones\" colspan=\"5\"><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"entrarDenuevo()\">
	             <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfReportRequerimientoAplicaciones.php?gerencia=$_POST[selGerencia]&division=$_POST[selDivision]&tipo=$_POST[selEstHardware]&fechaI=$fechaI&fechaF=$fechaF\")></td>";							 	
			    }
			    else{			 	
				 	echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";						
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				    echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
					echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";					
					echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
					echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				    				
				    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
				    echo "<tr>";
			     	echo "<td align=center>MENSAJE: REQUERIMIENTOS - APLICACIONES</td>
					      </tr>";
				    echo "<tr>";
			     	echo "<td valign=top class=\"mensaje\" align=center>NO EXISTEN REGISTROS EN EL RANGO DE FECHAS</td>";
				    echo "</tr>";
				    echo "<tr>";
				    echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				    echo "</tr>";
				    echo "</table>";		 	
			   }
			 
			 }			
		mysql_close();	
		//hasta aqui cuando  el a�o1 es mayor al a�o2 pendiente 			
		}
		else if ($anno2 == $anno1){		
			 if ($mes2 > $mes1){
			 	 if ($_POST[selGerencia]==100 and $_POST[selDivision]==100){			 	
			 	     $_POST[selGerencia]="";
			 	     $_POST[selDivision]="";			 	
			 	     formularioRequerimientoSoftware();
				     conectarMysql();
				     $fechaI=substr($_POST[txtFechaInicio],6,4)."-". substr($_POST[txtFechaInicio],3,2)."-". substr($_POST[txtFechaInicio],0,2);
				     $fechaF=substr($_POST[txtFechaFinal],6,4)."-". substr($_POST[txtFechaFinal],3,2)."-". substr($_POST[txtFechaFinal],0,2);			 			
		             $consulta="select distinct gerencia.gerencia,gerencia.id_gerencia,division.division,requerimiento_aplicaciones.id_division,
			                    count(requerimiento_aplicaciones.ID_MIGRACION) as total,migracion.ID_MIGRACION,migracion.MIGRACION,requerimiento_aplicaciones.REQUERIMIENTO_APLICACION
			                    from requerimiento_aplicaciones
							    inner join division on requerimiento_aplicaciones.id_division=division.id_division	
							    inner join gerencia on division.id_gerencia=gerencia.id_gerencia
							    inner join migracion on requerimiento_aplicaciones.id_migracion=migracion.id_migracion							
							    WHERE gerencia.id_gerencia like ('%$_POST[selGerencia]') and division.id_division like ('%$_POST[selDivision]') and requerimiento_aplicaciones.fecha_inicio
							    between '$fechaI' and '$fechaF' group by gerencia.gerencia,requerimiento_aplicaciones.id_migracion";		        
		             $result=mysql_query($consulta);
		             $resultado=mysql_num_rows($result);
		             if($resultado>0){
		                echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";					
						echo "<tr valign=top class=\"tablaTitulo\">
						  	  <td align=\"left\" class=\"tablaTitulo\">GERENCIA</td>																					
							  <td valign=top class=\"tablaTitulo\">PLATAFORMA</td>							
							  <td valign=top class=\"tablaTitulo\">TOTAL</td>
							  </tr>";
		             while ($row = mysql_fetch_array($result)) {	         		         	         									
							if ($i%2==0) {
								$clase="tablaFilaPar";
							} 
							else {
								$clase="tablaFilaNone";
							}
							echo "<tr class=\"$clase\">
							<td align=\"left\">$row[0]</td>															
							<td>$row[6]</td>
							<td>$row[4]</td>							
							</tr>";
							$i++;
		             }	          		         
		              echo "<td class=\"formularioTablaBotones\" colspan=\"5\"><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"entrarDenuevo()\">
		                    <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfReportRequerimientoAplicaciones.php?gerencia=$_POST[selGerencia]&tipo=$_POST[selEstHardware]&fechaI=$fechaI&fechaF=$fechaF\")></td>";							 	
			         }
			         else{
					    echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";						
					    echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					    echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
					    echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";					
					    echo "<input name=\"selEstHardware\" type=\"hidden\" value=\"$_POST[selEstHardware]\">";
					    echo "<input name=\"txtCantidad\" type=\"hidden\" value=\"$_POST[txtCantidad]\">";									
					    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
					    echo "<tr>";
				     	echo "<td align=center>MENSAJE - REQUERIMIENTO - SOFTWARE</td>
						</tr>";
					    echo "<tr>";
				     	echo "<td valign=top class=\"mensaje\" align=center>NO EXISTEN REGISTROS EN EL RANGO DE FECHAS</td>";
					    echo "</tr>";
					    echo "<tr>";
					    echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
					    echo "</tr>";
					    echo "</table>";		 	  
			         }			  			 	
			 }
			 else {
			      if( $_POST[selDivision]==100){			 			 	
			          $_POST[selDivision]="";	
			      }    
			      formularioRequerimientoSoftware();
				  conectarMysql();
				  $fechaI=substr($_POST[txtFechaInicio],6,4)."-". substr($_POST[txtFechaInicio],3,2)."-". substr($_POST[txtFechaInicio],0,2);
				  $fechaF=substr($_POST[txtFechaFinal],6,4)."-". substr($_POST[txtFechaFinal],3,2)."-". substr($_POST[txtFechaFinal],0,2);			 			
		          $consulta="select distinct gerencia.gerencia,gerencia.id_gerencia,division.division,requerimiento_aplicaciones.id_division,
			                 count(requerimiento_aplicaciones.id_migracion) as total,migracion.MIGRACION,requerimiento_aplicaciones.REQUERIMIENTO_APLICACION from requerimiento_aplicaciones
					    	 inner join division on requerimiento_aplicaciones.id_division=division.id_division	
						     inner join gerencia on division.id_gerencia=gerencia.id_gerencia
						     inner join migracion on requerimiento_aplicaciones.id_migracion=migracion.id_migracion						
						     WHERE gerencia.id_gerencia like ('%$_POST[selGerencia]') and division.id_division like ('%$_POST[selDivision]') and requerimiento_aplicaciones.fecha_inicio
						     between '$fechaI' and '$fechaF' group by gerencia.gerencia,division.division,requerimiento_aplicaciones.id_migracion,requerimiento_aplicaciones.REQUERIMIENTO_APLICACION";		     	         	         
	              $result=mysql_query($consulta);
	              $resultado=mysql_num_rows($result);
	              if($resultado>0){
	                 echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";					
					 echo "<tr valign=top class=\"tablaTitulo\">
						   <td align=\"left\" class=\"tablaTitulo\">GERENCIA</td>
						   <td valign=top class=\"tablaTitulo\">DIVISION</td>
                           <td valign=top class=\"tablaTitulo\">APLICACI�N</td>						   													
						   <td valign=top class=\"tablaTitulo\">PLATAFORMA</td>						
						   <td valign=top class=\"tablaTitulo\">TOTAL</td>
						   </tr>";
	                 while ($row = mysql_fetch_array($result)) {	         		         	         									
					 	    if ($i%2==0) {
							    $clase="tablaFilaPar";
						    }
						    else {
							    $clase="tablaFilaNone";
						    } 
						    echo "<tr class=\"$clase\">
						          <td align=\"left\">$row[0]</td>
								  <td>$row[2]</td>							
								  <td>$row[6]</td>
								  <td>$row[5]</td>
								  <td>$row[4]</td>
								  </tr>";
								  $i++;
	                 }
	                  mysql_close();	          	         
	                  echo "<td class=\"formularioTablaBotones\" colspan=\"5\"><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"entrarDenuevo()\">
	                  <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfReportRequerimientoAplicaciones.php?gerencia=$_POST[selGerencia]&division=$_POST[selDivision]&tipo=$_POST[selEstHardware]&fechaI=$fechaI&fechaF=$fechaF\")></td>";							 	
			       }
			       else{			 	
			 	       echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";						
					   echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					   echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					   echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
					   echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";					
					   echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
					   echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				    				
					   echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
					   echo "<tr>";
				       echo "<td align=center>MENSAJE: REQUERIMIENTOS - APLICACIONES</td>
					         </tr>";
					   echo "<tr>";
				       echo "<td valign=top class=\"mensaje\" align=center>NO EXISTEN REGISTROS EN EL RANGO DE FECHAS</td>";
					   echo "</tr>";
					   echo "<tr>";
					   echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
					   echo "</tr>";
					   echo "</table>";		 	
			       }  
			 
			    }			
			}
			//hasta el anno1 igual al anno2 y el mes1 mayor al mes2
            if ($mes2==$mes1){
			    if ($dia1 <= $dia2) {			 	
			        if ($_POST[selGerencia]==100 and $_POST[selDivision]==100){			 	
			 	        $_POST[selGerencia]="";
			 	        $_POST[selDivision]="";			 	
			 	        formularioRequerimientoSoftware();
				        conectarMysql();
						$fechaI=substr($_POST[txtFechaInicio],6,4)."-". substr($_POST[txtFechaInicio],3,2)."-". substr($_POST[txtFechaInicio],0,2);
						$fechaF=substr($_POST[txtFechaFinal],6,4)."-". substr($_POST[txtFechaFinal],3,2)."-". substr($_POST[txtFechaFinal],0,2);			 			
				        $consulta="select distinct gerencia.gerencia,gerencia.id_gerencia,division.division,requerimiento_aplicaciones.id_division,
			                       count(requerimiento_aplicaciones.ID_MIGRACION) as total,migracion.ID_MIGRACION,migracion.MIGRACION,requerimiento_aplicaciones.REQUERIMIENTO_APLICACION
					               from requerimiento_aplicaciones
								   inner join division on requerimiento_aplicaciones.id_division=division.id_division	
								   inner join gerencia on division.id_gerencia=gerencia.id_gerencia
								   inner join migracion on requerimiento_aplicaciones.id_migracion=migracion.id_migracion							
								   WHERE gerencia.id_gerencia like ('%$_POST[selGerencia]') and division.id_division like ('%$_POST[selDivision]') and requerimiento_aplicaciones.fecha_inicio
								   between '$fechaI' and '$fechaF' group by gerencia.gerencia,requerimiento_aplicaciones.id_migracion,requerimiento_aplicaciones.requerimiento_aplicacion";				       		        				        	        
		                $result=mysql_query($consulta);
		                $resultado=mysql_num_rows($result);
		                if($resultado>0){
		                   echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";					
						   echo "<tr valign=top class=\"tablaTitulo\">
							     <td align=\"left\" class=\"tablaTitulo\">GERENCIA</td>																					
							     <td valign=top class=\"tablaTitulo\">PLATAFORMA</td>
							     <td valign=top class=\"tablaTitulo\">APLICACI�N</td>							
							     
							     </tr>";
		                while ($row = mysql_fetch_array($result)) {	         		         	         									
						 	   if ($i%2==0) {
								   $clase="tablaFilaPar";
							   }
							   else {
								   $clase="tablaFilaNone";
							   }
						  echo "<tr class=\"$clase\">
							    <td align=\"left\">$row[0]</td>															
							    <td>$row[6]</td>
							    <td>$row[7]</td>							
							    </tr>";
							    $i++;
		                 }	          		         
		                 echo "<td class=\"formularioTablaBotones\" colspan=\"5\"><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"entrarDenuevo()\">
		                       <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfReportRequerimientoAplicaciones.php?gerencia=$_POST[selGerencia]&tipo=$_POST[selEstHardware]&fechaI=$fechaI&fechaF=$fechaF\")></td>";							 	
			             }
			             else{
						    echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";						
						    echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						    echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
						    echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";					
						    echo "<input name=\"selEstHardware\" type=\"hidden\" value=\"$_POST[selEstHardware]\">";
						    echo "<input name=\"txtCantidad\" type=\"hidden\" value=\"$_POST[txtCantidad]\">";									
						    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
						    echo "<tr>";
					     	echo "<td align=center>MENSAJE - REQUERIMIENTO - SOFTWARE</td>
							</tr>";
						    echo "<tr>";
					     	echo "<td valign=top class=\"mensaje\" align=center>NO EXISTEN REGISTROS EN EL RANGO DE FECHAS</td>";
						    echo "</tr>";
						    echo "<tr>";
						    echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
						    echo "</tr>";
						    echo "</table>";		 	  
			              }			  			 	
			 }
			    else {
			    if( $_POST[selDivision]==100){			 			 	
			        $_POST[selDivision]="";	
			    }    
			    formularioRequerimientoSoftware();
			    conectarMysql();
			    $fechaI=substr($_POST[txtFechaInicio],6,4)."-". substr($_POST[txtFechaInicio],3,2)."-". substr($_POST[txtFechaInicio],0,2);
			    $fechaF=substr($_POST[txtFechaFinal],6,4)."-". substr($_POST[txtFechaFinal],3,2)."-". substr($_POST[txtFechaFinal],0,2);			 			
	            $consulta="select distinct gerencia.gerencia,gerencia.id_gerencia,division.division,requerimiento_aplicaciones.id_division,
		                   count(requerimiento_aplicaciones.id_migracion) as total,migracion.MIGRACION,requerimiento_aplicaciones.REQUERIMIENTO_APLICACION from requerimiento_aplicaciones
					       inner join division on requerimiento_aplicaciones.id_division=division.id_division	
						   inner join gerencia on division.id_gerencia=gerencia.id_gerencia
						   inner join migracion on requerimiento_aplicaciones.id_migracion=migracion.id_migracion						
						   WHERE gerencia.id_gerencia like ('%$_POST[selGerencia]') and division.id_division like ('%$_POST[selDivision]') and requerimiento_aplicaciones.fecha_inicio
						   between '$fechaI' and '$fechaF' group by gerencia.gerencia,division.division,requerimiento_aplicaciones.id_migracion,requerimiento_aplicaciones.REQUERIMIENTO_APLICACION";		     	         	         
	            $result=mysql_query($consulta);
	            $resultado=mysql_num_rows($result);
	            if($resultado>0){
	               echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";					
				   echo "<tr valign=top class=\"tablaTitulo\">
					  	 <td align=\"left\" class=\"tablaTitulo\">GERENCIA</td>
					 	 <td valign=top class=\"tablaTitulo\">DIVISION</td>	
					 	 <td valign=top class=\"tablaTitulo\">APLICACI�N</td>												
						 <td valign=top class=\"tablaTitulo\">PLATAFORMA</td>						
						 <td valign=top class=\"tablaTitulo\">TOTAL</td>
						 </tr>";
	            while ($row = mysql_fetch_array($result)) {	         		         	         									
					   if ($i%2==0) {
						   $clase="tablaFilaPar";
					   } 
					   else {
						   $clase="tablaFilaNone";						
					   }
					   echo "<tr class=\"$clase\">
						     <td align=\"left\">$row[0]</td>
						     <td>$row[2]</td>
						     <td>$row[6]</td>							
						     <td>$row[5]</td>
						     <td>$row[4]</td>
						     </tr>";
						     $i++;
	            }
		         mysql_close();	          	         
		         echo "<td class=\"formularioTablaBotones\" colspan=\"5\"><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"entrarDenuevo()\">
		         <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfReportRequerimientoAplicaciones.php?gerencia=$_POST[selGerencia]&division=$_POST[selDivision]&tipo=$_POST[selEstHardware]&fechaI=$fechaI&fechaF=$fechaF\")></td>";							 	
			    }
			 else{			 	
			 	echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";						
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			    echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";					
				echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
				echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				    				
			    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			    echo "<tr>";
		     	echo "<td align=center>MENSAJE: REQUERIMIENTOS - APLICACIONES</td>
				</tr>";
			    echo "<tr>";
		     	echo "<td valign=top class=\"mensaje\" align=center>NO EXISTEN REGISTROS EN EL RANGO DE FECHAS</td>";
			    echo "</tr>";
			    echo "<tr>";
			    echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
			    echo "</tr>";
			    echo "</table>";		 	
			  }
			 
			}			
	 }			 			 
			 else { echo "<br><br>";
			        echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";						
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				    echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
					echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";															
					echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
					echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				    
				    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
				    echo "<tr>";
			     	echo "<td align=center>MENSAJE: REQUERIMIENTOS - APLICACIONES</td>
					</tr>";
				    echo "<tr>";
			     	echo "<td valign=top class=\"mensaje\" align=center>ERROR EN EL RANGO DE FECHAS</td>";
				    echo "</tr>";
				    echo "<tr>";
				    echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				    echo "</tr>";
				    echo "</table></form>";
			  }												           				
	      }
		
		  if ($mes2<$mes1){			     
			 echo "<br><br>";	
		     echo "<form name=\"frmRequrimientoHardware\" method=\"post\" action=\"\">";			
			 echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		     echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
			 echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";					
			 echo "<input name=\"selEstHardware\" type=\"hidden\" value=\"$_POST[selEstHardware]\">";
			 echo "<input name=\"txtCantidad\" type=\"hidden\" value=\"$_POST[txtCantidad]\">";										
		     echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
		     echo "<tr>";
	     	 echo "<td align=center>MENSAJE - REQUERIMIENTO - HARDWARE</td>
			       </tr>";
		     echo "<tr>";
	     	 echo "<td valign=top class=\"mensaje\" align=center>ERROR EN EL RANGO DE FECHAS</td>";
		     echo "</tr>";
		     echo "<tr>";
		     echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
		     echo "</tr>";
		     echo "</table><form>";
		 }								     			        
		} 
		else {      echo "<br><br>";	
		            echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";			
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
					echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";					
					echo "<input name=\"selEstHardware\" type=\"hidden\" value=\"$_POST[selEstHardware]\">";
					echo "<input name=\"txtCantidad\" type=\"hidden\" value=\"$_POST[txtCantidad]\">";					
					echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
				    echo "<tr>";
			     	echo "<td align=center>MENSAJE: REQUERIMIENTOS - APLICACIONES</td>
					</tr>";
				    echo "<tr>";
			     	echo "<td valign=top class=\"mensaje\" align=center>ERROR EN EL RANGO DE FECHAS</td>";
				    echo "</tr>";
				    echo "<tr>";
				    echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				    echo "</tr>";
				    echo "</table><form>";
		}														        				
		break 1;
		case 1:
		echo "<br><br><br><br>";
		echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";		
		echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
		echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";		
		echo "<input name=\"selEstHardware\" type=\"hidden\" value=\"$_POST[selEstHardware]\">";
		echo "<input name=\"txtCantidad\" type=\"hidden\" value=\"$_POST[txtCantidad]\">";		
		echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
		echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: REQUERIMIENTOS - APLICACIONES</td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>EL CAMPO ".$mensaje. " EST� VACIO</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
		echo "</tr>";
		echo "</table><from>";			
		break 1;
		default:
		echo "<br><br><br><br>";
		echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";		
		echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";		
		echo "<input name=\"selEstHardware\" type=\"hidden\" value=\"$_POST[selEstHardware]\">";
		echo "<input name=\"txtCantidad\" type=\"hidden\" value=\"$_POST[txtCantidad]\">";		
		echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
		echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				
		echo "<table class=\"mensajeTitulo\" align=center width=\"510\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: REQUERIMIENTOS - APLICACIONES</td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>LOS CAMPOS ".$mensaje. " ESTAN VACIOS</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
		echo "</tr>";
		echo "</table><form>";			
	}
	echo "</form>";	
	break 1;				
	case 2:
	exit();
	break 1;
	case 3:
	 formularioRequerimientoSoftware();
	break 1;
	case 4:
	 formularioRequerimientoSoftware();
	totalGerencias();
	break 1;
	default:
	 formularioRequerimientoSoftware();		
}

?>
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
<?php

function totalGerencias(){
	conectarMysql();
	 echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";
	 echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";		
	 if (isset($_POST[txtFechaInicio]) && empty($_POST[txtFechaInicio])) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje."<b>FECHA INICIAL</b>";
		$i++;
		$sw=1;
	}
	if (isset($_POST[txtFechaFinal]) && empty($_POST[txtFechaFinal])) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje."<b>FECHA FINAL</b>";
		$i++;
		$sw=1;
	}
	switch($i) {		
	case 0:	
	    $fechaI=substr($_POST[txtFechaInicio],6,4)."-". substr($_POST[txtFechaInicio],3,2)."-". substr($_POST[txtFechaInicio],0,2);
	    $fechaF=substr($_POST[txtFechaFinal],6,4)."-". substr($_POST[txtFechaFinal],3,2)."-". substr($_POST[txtFechaFinal],0,2);			 				
	 $consulta="select distinct count(requerimiento_aplicaciones.id_migracion) as total,migracion.MIGRACION,requerimiento_aplicaciones.REQUERIMIENTO_APLICACION
	            from requerimiento_aplicaciones
				inner join division on requerimiento_aplicaciones.id_division=division.id_division
				inner join gerencia on division.id_gerencia=gerencia.id_gerencia
				inner join migracion on requerimiento_aplicaciones.id_migracion=migracion.id_migracion				
				WHERE gerencia.id_gerencia like ('%') and division.id_division like ('%')				
				and requerimiento_aplicaciones.fecha_inicio between '$fechaI'
				and '$fechaF'
				group by requerimiento_aplicaciones.id_migracion,requerimiento_aplicaciones.REQUERIMIENTO_APLICACION";	 	 	
	$result=mysql_query($consulta);
	         $resultado=mysql_num_rows($result);
	         if($resultado>0){	               
	         echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";					
					echo "<tr valign=top class=\"tablaTitulo\">						
						<td valign=top class=\"tablaTitulo\">PLATAFORMA</td> 						
						<td valign=top class=\"tablaTitulo\">APLICACI�N</td>
						<td valign=top class=\"tablaTitulo\">TOTAL</td>
						</tr>";
	         while ($row = mysql_fetch_array($result)) {	         		         	         									
						if ($i%2==0) {
							$clase="tablaFilaPar";
						} else {
							$clase="tablaFilaNone";
						}
						echo "<tr class=\"$clase\">						
						<td>$row[1]</td>
						<td>$row[2]</td>
						<td>$row[0]</td>						
						</tr>";
						$i++;
	         }		         
		     echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
		     echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";							 			 
		     $fechaI=substr($_POST[txtFechaInicio],6,4)."-". substr($_POST[txtFechaInicio],3,2)."-". substr($_POST[txtFechaInicio],0,2);
		     $fechaF=substr($_POST[txtFechaFinal],6,4)."-". substr($_POST[txtFechaFinal],3,2)."-". substr($_POST[txtFechaFinal],0,2);			 			          	        
	           echo "<td class=\"formularioTablaBotones\" colspan=\"5\"><input name=\"btnCancelar\"  type=\"submit\" value=\"CANCELAR\">
	           <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfReportRequerimientoAplicaciones.php?gerencia=$_POST[selGerencia]&division=$_POST[selDivision]&fechaI=$fechaI&fechaF=$fechaF\")></td>";							 	
	         }
	         else{
			    echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";						
			    echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			    echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
			    echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";								    
			    echo "<input name=\"txtCantidad\" type=\"hidden\" value=\"$_POST[txtCantidad]\">";									
			    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			    echo "<tr>";
		     	    echo "<td align=center>MENSAJE - REQUERIMIENTO - SOFTWARE</td>
				</tr>";
			    echo "<tr>";
		     	    echo "<td valign=top class=\"mensaje\" align=center>NO EXISTEN REGISTROS EN EL RANGO DE FECHAS<br>�<br>ERROR EN EL RANGO DE FECHAS</td>";
			    echo "</tr>";
			    echo "<tr>";
			    echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
			    echo "</tr>";
			    echo "</table>";		 	  
			  }			  	
	      mysql_close();		 
		break 1;	 
	case 1:
		echo "<br><br><br><br>";
		echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";		
		echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";		
		echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
		echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: REQUERIMIENTOS - APLICACIONES</td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>EL CAMPO ".$mensaje. " EST� VACIO</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
		echo "</tr>";
		echo "</table><from>";			
		break 1;
		default:
		echo "<br><br><br><br>";
		echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";				
		echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
		echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				
		echo "<table class=\"mensajeTitulo\" align=center width=\"510\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: REQUERIMIENTOS - APLICACIONES</td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>LOS CAMPOS ".$mensaje. " ESTAN VACIOS</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
		echo "</tr>";
		echo "</table><form>";			
	}				
}

//FUNCION MOSTRAR REQUERIMIENTOS
function formularioRequerimientoSoftware() {
require_once "conexionsql.php";
require_once "formularios.php";
$conGerencia= "SELECT distinct gerencia.ID_GERENCIA,gerencia.GERENCIA FROM GERENCIA
			   INNER JOIN division on gerencia.id_gerencia=division.id_gerencia
			   INNER JOIN requerimiento_aplicaciones on division.id_division=requerimiento_aplicaciones.id_division";
$conDivision="SELECT distinct division.ID_DIVISION,DIVISION FROM DIVISION 
              INNER JOIN requerimiento_aplicaciones on division.id_division=requerimiento_aplicaciones.id_division WHERE ID_GERENCIA='$_POST[selGerencia]'";
$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","entrarDenuevo()",$conGerencia,"TODOS","");
$selGerencia=$gerencia->retornar();
$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","entrarDenuevo()",$conDivision,"TODOS","");
$selDivision=$division->retornar();	
$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10","","");
$txtFechaInicio=$fechaInicio->retornar();		
$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
$txtFechaFinal=$fechaFinal->retornar();		
echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"580\" border=\"0\">";
	echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">REPORTE REQUERIMIENTO DE APLICACIONES</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">REQUERIMIENTO DE APLICACIONES</td>
			
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>  
<td valign=top class=\"formularioCampoTitulo\" >GERENCIA<br>$selGerencia<br>DIVISION<br>$selDivision<br></td>
<td valign=top class=\"formularioCampoTitulo\" >
FECHA INICIAL<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmRequrimientoAplicaciones.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\"></a><br>
FECHA FINAL<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmRequrimientoAplicaciones.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\"></a><br>
</td>
</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnBuscar\" title=\"Buscar requerimiento en la base de dato\" type=\"submit\" value=\"BUSCAR\">
																	 <input name=\"btnBuscarTotal\" title=\"Buscar todos los requerimiento en la base de dato\" type=\"button\" value=\"TOTAL GERENCIAS\"  onclick=\"buscarTotal()\">
			                                                         <input name=\"Limpiar\" title=\"Cancelar requerimiento\" type=\"button\" value=\"CANCELAR\" onclick=\"fuera()\"></td>
  				</tr>";
echo "</table>";
echo "</form>";
}
?>