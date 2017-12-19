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
		document.frmRequrimientoSistemaInformacion.funcion.value=2;
		document.frmRequrimientoSistemaInformacion.submit();
    }    
    function entrarDenuevo() {
		 document.frmRequrimientoSistemaInformacion.funcion.value=3;
		 document.frmRequrimientoSistemaInformacion.submit();
}
function buscarTotal() {
		document.frmRequrimientoSistemaInformacion.funcion.value=4;
		document.frmRequrimientoSistemaInformacion.submit();
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
		echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";				
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
		         $consulta="select distinct gerencia.gerencia,gerencia.id_gerencia,division.division,requerimiento_sistema_informacion.id_division,
			                requerimiento_sistema_informacion.id_software,tipo_software.tipo_software,software.software,sum(requerimiento_sistema_informacion.cantidad)
			                from requerimiento_sistema_informacion
							inner join division on requerimiento_sistema_informacion.id_division=division.id_division	
							inner join gerencia on division.id_gerencia=gerencia.id_gerencia
							inner join software on requerimiento_sistema_informacion.id_software=software.id_software
							inner join tipo_software on software.id_tipo_software=tipo_software.id_tipo_software
							WHERE gerencia.id_gerencia like ('%$_POST[selGerencia]') and division.id_division like ('%$_POST[selDivision]') and requerimiento_sistema_informacion.fecha_inicial
							between '$fechaI' and '$fechaF' group by gerencia.gerencia,requerimiento_sistema_informacion.id_software";		         
		         $result=mysql_query($consulta);
		         $resultado=mysql_num_rows($result);
		         if($resultado>0){
		         echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";					
						echo "<tr valign=top class=\"tablaTitulo\">
							<td align=\"left\" class=\"tablaTitulo\">GERENCIA</td>							
							<td valign=top class=\"tablaTitulo\">SISTEMA DE INFORMACIÓN</td>							
							<td valign=top class=\"tablaTitulo\">CANTIDAD</td>
							</tr>";
		         while ($row = mysql_fetch_array($result)) {	         		         	         									
							if ($i%2==0) {
								$clase="tablaFilaPar";
							} else {
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
		         <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfReportRequerimientoSistemaInformacion.php?gerencia=$_POST[selGerencia]&tipo=$_POST[selEstHardware]&fechaI=$fechaI&fechaF=$fechaF\")></td>";							 	
			  }
			  else{			 	
			 	echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";						
				echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";			     
			      echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";					
				echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
				echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				    				
			      echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			      echo "<tr>";
		     	      echo "<td align=center>MENSAJE: REQUERIMIENTO - SISTEMA DE INFORMACIÓN</td>
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
	         $consulta="select distinct gerencia.gerencia,gerencia.id_gerencia,division.division,requerimiento_sistema_informacion.id_division,
		                requerimiento_sistema_informacion.id_software,tipo_software.tipo_software,software.software,sum(requerimiento_sistema_informacion.cantidad)
		                from requerimiento_sistema_informacion
						inner join division on requerimiento_sistema_informacion.id_division=division.id_division	
						inner join gerencia on division.id_gerencia=gerencia.id_gerencia
						inner join software on requerimiento_sistema_informacion.id_software=software.id_software
						inner join tipo_software on software.id_tipo_software=tipo_software.id_tipo_software
						WHERE gerencia.id_gerencia like ('%$_POST[selGerencia]') and division.id_division like ('%$_POST[selDivision]') and requerimiento_sistema_informacion.fecha_inicial
						between '$fechaI' and '$fechaF' group by gerencia.gerencia,division.division,requerimiento_sistema_informacion.id_software";		     	         
	         $result=mysql_query($consulta);
	         $resultado=mysql_num_rows($result);
	         if($resultado>0){
	         echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";					
					echo "<tr valign=top class=\"tablaTitulo\">
						<td align=\"left\" class=\"tablaTitulo\">GERENCIA</td>
						<td valign=top class=\"tablaTitulo\">DIVISION</td>
						<td valign=top class=\"tablaTitulo\">SISTEMA DE INFORMACIÓN</td>						
						<td valign=top class=\"tablaTitulo\">CANTIDAD</td>
						</tr>";
	         while ($row = mysql_fetch_array($result)) {	         		         	         									
						if ($i%2==0) {
							$clase="tablaFilaPar";
						} else {
							$clase="tablaFilaNone";
						}
						echo "<tr class=\"$clase\">
						<td align=\"left\">$row[0]</td>
						<td>$row[2]</td>	
						<td>$row[6]</td>
						<td>$row[7]</td>
						</tr>";
						$i++;
	         }	                   	         
	         echo "<td class=\"formularioTablaBotones\" colspan=\"5\"><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"entrarDenuevo()\">
	         <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfReportRequerimientoSistemaInformacion.php?gerencia=$_POST[selGerencia]&division=$_POST[selDivision]&tipo=$_POST[selEstHardware]&fechaI=$fechaI&fechaF=$fechaF\")></td>";							 	
		   }		   
			 else{			 	
			 	echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";						
				echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";
			    echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";
			    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";					
				echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
				echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				    				
			    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			    echo "<tr>";
		     	echo "<td align=center>MENSAJE: REQUERIMIENTO - SISTEMA DE INFORMACIÓN</td>
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
		//hasta aqui cuando  el año1 es mayor al año2 pendiente	 			
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
		         $consulta="select distinct gerencia.gerencia,gerencia.id_gerencia,division.division,requerimiento_sistema_informacion.id_division,
			                requerimiento_sistema_informacion.id_software,tipo_software.tipo_software,software.software,sum(requerimiento_sistema_informacion.cantidad)
			                from requerimiento_sistema_informacion
							inner join division on requerimiento_sistema_informacion.id_division=division.id_division	
							inner join gerencia on division.id_gerencia=gerencia.id_gerencia
							inner join software on requerimiento_sistema_informacion.id_software=software.id_software
							inner join tipo_software on software.id_tipo_software=tipo_software.id_tipo_software
							WHERE gerencia.id_gerencia like ('%$_POST[selGerencia]') and division.id_division like ('%$_POST[selDivision]') and requerimiento_sistema_informacion.fecha_inicial
							between '$fechaI' and '$fechaF' group by gerencia.gerencia,requerimiento_sistema_informacion.id_software";
		         
		         $result=mysql_query($consulta);
		         $resultado=mysql_num_rows($result);
		         if($resultado>0){
		         echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";					
						echo "<tr valign=top class=\"tablaTitulo\">
							<td align=\"left\" class=\"tablaTitulo\">GERENCIA</td>							
							<td valign=top class=\"tablaTitulo\">SISTEMA DE INFORMACIÓN</td>							
							<td valign=top class=\"tablaTitulo\">CANTIDAD</td>
							</tr>";
		         while ($row = mysql_fetch_array($result)) {	         		         	         									
							if ($i%2==0) {
								$clase="tablaFilaPar";
							} else {
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
		         <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfReportRequerimientoSistemaInformacion.php?gerencia=$_POST[selGerencia]&tipo=$_POST[selEstHardware]&fechaI=$fechaI&fechaF=$fechaF\")></td>";							 	
		       }
		       else{			 	
			 	echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";						
				echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";
			      echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";
			      echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";					
				echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
				echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				    				
			      echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			      echo "<tr>";
		        	echo "<td align=center>MENSAJE: REQUERIMIENTO - SISTEMA DE INFORMACIÓN</td>
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
	         $consulta="select distinct gerencia.gerencia,gerencia.id_gerencia,division.division,requerimiento_sistema_informacion.id_division,
		                requerimiento_sistema_informacion.id_software,tipo_software.tipo_software,software.software,sum(requerimiento_sistema_informacion.cantidad)
		                from requerimiento_sistema_informacion
						inner join division on requerimiento_sistema_informacion.id_division=division.id_division	
						inner join gerencia on division.id_gerencia=gerencia.id_gerencia
						inner join software on requerimiento_sistema_informacion.id_software=software.id_software
						inner join tipo_software on software.id_tipo_software=tipo_software.id_tipo_software
						WHERE gerencia.id_gerencia like ('%$_POST[selGerencia]') and division.id_division like ('%$_POST[selDivision]') and requerimiento_sistema_informacion.fecha_inicial
						between '$fechaI' and '$fechaF' group by gerencia.gerencia,division.division,requerimiento_sistema_informacion.id_software";	         		     	         
	         $result=mysql_query($consulta);
	         $resultado=mysql_num_rows($result);
	         if($resultado>0){
	         echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";					
					echo "<tr valign=top class=\"tablaTitulo\">
						<td align=\"left\" class=\"tablaTitulo\">GERENCIA</td>
						<td valign=top class=\"tablaTitulo\">DIVISION</td>
						<td valign=top class=\"tablaTitulo\">SISTEMA DE INFORMACIÓN</td>						
						<td valign=top class=\"tablaTitulo\">CANTIDAD</td>
						</tr>";
	         while ($row = mysql_fetch_array($result)) {	         		         	         									
						if ($i%2==0) {
							$clase="tablaFilaPar";
						} else {
							$clase="tablaFilaNone";
						}
						echo "<tr class=\"$clase\">
						<td align=\"left\">$row[0]</td>
						<td>$row[2]</td>	
						<td>$row[6]</td>
						<td>$row[7]</td>
						</tr>";
						$i++;
	         }
	         mysql_close();	          	         
	         echo "<td class=\"formularioTablaBotones\" colspan=\"5\"><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"entrarDenuevo()\">
	         <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfReportRequerimientoSistemaInformacion.php?gerencia=$_POST[selGerencia]&division=$_POST[selDivision]&tipo=$_POST[selEstHardware]&fechaI=$fechaI&fechaF=$fechaF\")></td>";							 	
			 }
			 else{			 	
			 	echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";						
				echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";
			    echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";
			    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";					
				echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
				echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				    				
			    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			    echo "<tr>";
		     	echo "<td align=center>MENSAJE: REQUERIMIENTO - SISTEMA DE INFORMACIÓN</td>
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
		 if ($mes2==$mes1){
			 if ($dia1 <= $dia2) {			 	
			 if ($_POST[selGerencia]==100 and $_POST[selDivision]==100){			 	
			 	$_POST[selGerencia]="";
			 	$_POST[selDivision]="";			 	
			 	 formularioRequerimientoSoftware();
				 conectarMysql();
				 $fechaI=substr($_POST[txtFechaInicio],6,4)."-". substr($_POST[txtFechaInicio],3,2)."-". substr($_POST[txtFechaInicio],0,2);
				 $fechaF=substr($_POST[txtFechaFinal],6,4)."-". substr($_POST[txtFechaFinal],3,2)."-". substr($_POST[txtFechaFinal],0,2);			 			
		         $consulta="select distinct gerencia.gerencia,gerencia.id_gerencia,division.division,requerimiento_sistema_informacion.id_division,
			                requerimiento_sistema_informacion.id_software,tipo_software.tipo_software,software.software,sum(requerimiento_sistema_informacion.cantidad)
			                from requerimiento_sistema_informacion
							inner join division on requerimiento_sistema_informacion.id_division=division.id_division	
							inner join gerencia on division.id_gerencia=gerencia.id_gerencia
							inner join software on requerimiento_sistema_informacion.id_software=software.id_software
							inner join tipo_software on software.id_tipo_software=tipo_software.id_tipo_software
							WHERE gerencia.id_gerencia like ('%$_POST[selGerencia]') and division.id_division like ('%$_POST[selDivision]') and requerimiento_sistema_informacion.fecha_inicial
							between '$fechaI' and '$fechaF' group by gerencia.gerencia,requerimiento_sistema_informacion.id_software";
		         
		         $result=mysql_query($consulta);
		         $resultado=mysql_num_rows($result);
		         if($resultado>0){
		         echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";					
						echo "<tr valign=top class=\"tablaTitulo\">
							<td align=\"left\" class=\"tablaTitulo\">GERENCIA</td>							
							<td valign=top class=\"tablaTitulo\">SISTEMA DE INFORMACIÓN</td>							
							<td valign=top class=\"tablaTitulo\">CANTIDAD</td>
							</tr>";
		         while ($row = mysql_fetch_array($result)) {	         		         	         									
							if ($i%2==0) {
								$clase="tablaFilaPar";
							} else {
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
		         <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfReportRequerimientoSistemaInformacion.php?gerencia=$_POST[selGerencia]&tipo=$_POST[selEstHardware]&fechaI=$fechaI&fechaF=$fechaF\")></td>";							 	
		       }
		       else{			 	
			 	echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";						
				echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";
			      echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";
			      echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";					
				echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
				echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				    				
			      echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			      echo "<tr>";
		        	echo "<td align=center>MENSAJE: REQUERIMIENTO - SISTEMA DE INFORMACIÓN</td>
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
	         $consulta="select distinct gerencia.gerencia,gerencia.id_gerencia,division.division,requerimiento_sistema_informacion.id_division,
		                requerimiento_sistema_informacion.id_software,tipo_software.tipo_software,software.software,sum(requerimiento_sistema_informacion.cantidad)
		                from requerimiento_sistema_informacion
						inner join division on requerimiento_sistema_informacion.id_division=division.id_division	
						inner join gerencia on division.id_gerencia=gerencia.id_gerencia
						inner join software on requerimiento_sistema_informacion.id_software=software.id_software
						inner join tipo_software on software.id_tipo_software=tipo_software.id_tipo_software
						WHERE gerencia.id_gerencia like ('%$_POST[selGerencia]') and division.id_division like ('%$_POST[selDivision]') and requerimiento_sistema_informacion.fecha_inicial
						between '$fechaI' and '$fechaF' group by gerencia.gerencia,division.division,requerimiento_sistema_informacion.id_software";	         		     	         
	         $result=mysql_query($consulta);
	         $resultado=mysql_num_rows($result);
	         if($resultado>0){
	         echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";					
					echo "<tr valign=top class=\"tablaTitulo\">
						<td align=\"left\" class=\"tablaTitulo\">GERENCIA</td>
						<td valign=top class=\"tablaTitulo\">DIVISION</td>
						<td valign=top class=\"tablaTitulo\">SISTEMA DE INFORMACIÓN</td>						
						<td valign=top class=\"tablaTitulo\">CANTIDAD</td>
						</tr>";
	         while ($row = mysql_fetch_array($result)) {	         		         	         									
						if ($i%2==0) {
							$clase="tablaFilaPar";
						} else {
							$clase="tablaFilaNone";
						}
						echo "<tr class=\"$clase\">
						<td align=\"left\">$row[0]</td>
						<td>$row[2]</td>	
						<td>$row[6]</td>
						<td>$row[7]</td>
						</tr>";
						$i++;
	         }
	         mysql_close();	          	         
	         echo "<td class=\"formularioTablaBotones\" colspan=\"5\"><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"entrarDenuevo()\">
	         <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfReportRequerimientoSistemaInformacion.php?gerencia=$_POST[selGerencia]&division=$_POST[selDivision]&tipo=$_POST[selEstHardware]&fechaI=$fechaI&fechaF=$fechaF\")></td>";							 	
			 }
			 else{			 	
			 	echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";						
				echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";
			    echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";
			    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";					
				echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
				echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				    				
			    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			    echo "<tr>";
		     	echo "<td align=center>MENSAJE: REQUERIMIENTO - SISTEMA DE INFORMACIÓN</td>
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
			 }			 			 
			 else { echo "<br><br>";
			        echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";						
					echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";				   
				    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
					echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";															
					echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
					echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				    
				    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
				    echo "<tr>";
			     	echo "<td align=center>MENSAJE: REQUERIMIENTO - SISTEMA DE INFORMACIÓN</td>
					</tr>";
				    echo "<tr>";
			     	echo "<td valign=top class=\"mensaje\" align=center>ERROR EN EL RANGO DE FECHAS</td>";
				    echo "</tr>";
				    echo "<tr>";
				    echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				    echo "</tr>";
				    echo "</table></form>";}												           				
		     }
		     if ($mes2<$mes1){
		     	    echo "<br><br>";	
		     	    echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";			
					echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";
				    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
					echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";										
					echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
					echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				    
				    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
				    echo "<tr>";
			     	echo "<td align=center>MENSAJE: REQUERIMIENTO - SISTEMA DE INFORMACIÓN</td>
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
		            echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";			
					echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";
				    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
					echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";					
					echo "<input name=\"selEstHardware\" type=\"hidden\" value=\"$_POST[selEstHardware]\">";
					echo "<input name=\"txtCantidad\" type=\"hidden\" value=\"$_POST[txtCantidad]\">";					
					//echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
					//echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";			    
				    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
				    echo "<tr>";
			     	echo "<td align=center>MENSAJE: REQUERIMIENTO - SISTEMA DE INFORMACIÓN</td>
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
		echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";		
		echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
		echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";		
		echo "<input name=\"selEstHardware\" type=\"hidden\" value=\"$_POST[selEstHardware]\">";
		echo "<input name=\"txtCantidad\" type=\"hidden\" value=\"$_POST[txtCantidad]\">";		
		echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
		echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				
		echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: REQUERIMIENTO - SISTEMA DE INFORMACIÓN</td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>EL CAMPO ".$mensaje. " ESTÁ VACIO</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
		echo "</tr>";
		echo "</table><from>";			
		break 1;
		default:
		echo "<br><br><br><br>";
		echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";		
		echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";		
		echo "<input name=\"selEstHardware\" type=\"hidden\" value=\"$_POST[selEstHardware]\">";
		echo "<input name=\"txtCantidad\" type=\"hidden\" value=\"$_POST[txtCantidad]\">";		
		echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
		echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				
		echo "<table class=\"mensajeTitulo\" align=center width=\"510\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: REQUERIMIENTO - SISTEMA DE INFORMACIÓN</td>
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
	 echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";
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
	 $consulta="select distinct requerimiento_sistema_informacion.id_software,software.software,
                sum(requerimiento_sistema_informacion.cantidad) from requerimiento_sistema_informacion
				inner join division on requerimiento_sistema_informacion.id_division=division.id_division
				inner join gerencia on division.id_gerencia=gerencia.id_gerencia
				inner join software on requerimiento_sistema_informacion.id_software=software.id_software
				inner join tipo_software on software.id_tipo_software=tipo_software.id_tipo_software				
				WHERE gerencia.id_gerencia like ('%') and division.id_division like ('%')				
				and requerimiento_sistema_informacion.fecha_inicial between '$fechaI'
				and '$fechaF'
				group by requerimiento_sistema_informacion.id_software,tipo_software.id_tipo_software";	 	
	$result=mysql_query($consulta);
	         $resultado=mysql_num_rows($result);
	         if($resultado>0){
	         echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";					
					echo "<tr valign=top class=\"tablaTitulo\">												
						<td valign=top class=\"tablaTitulo\">SISTEMA DE INFORMACIÓN</td> 						
						<td valign=top class=\"tablaTitulo\">CANTIDAD</td>
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
						</tr>";
						$i++;
	         }		         
		     echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
		     echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";							 			 
		     $fechaI=substr($_POST[txtFechaInicio],6,4)."-". substr($_POST[txtFechaInicio],3,2)."-". substr($_POST[txtFechaInicio],0,2);
		     $fechaF=substr($_POST[txtFechaFinal],6,4)."-". substr($_POST[txtFechaFinal],3,2)."-". substr($_POST[txtFechaFinal],0,2);			 			          	        
	           echo "<td class=\"formularioTablaBotones\" colspan=\"5\"><input name=\"btnCancelar\"  type=\"submit\" value=\"CANCELAR\">
	           <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfReportRequerimientoSistemaInformacion.php?gerencia=$_POST[selGerencia]&division=$_POST[selDivision]&fechaI=$fechaI&fechaF=$fechaF\")></td>";							 	
		  }
		else{			 	
		    echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";						
		    echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";
		    echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";
		    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		    echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";					
		    echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
		    echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				    				
		    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
		    echo "<tr>";
		    echo "<td align=center>MENSAJE: REQUERIMIENTO - SISTEMA DE INFORMACIÓN</td>
				</tr>";
		    echo "<tr>";
		    echo "<td valign=top class=\"mensaje\" align=center>NO EXISTEN REGISTROS EN EL RANGO DE FECHAS<br>Ó<br>ERROR EN EL RANGO DE FECHAS</td>";
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
		echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";		
		echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";		
		echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
		echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				
		echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: REQUERIMIENTO - SISTEMA DE INFORMACIÓN</td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>EL CAMPO ".$mensaje. " ESTÁ VACIO</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
		echo "</tr>";
		echo "</table><from>";			
		break 1;
		default:
		echo "<br><br><br><br>";
		echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";				
		echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
		echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";				
		echo "<table class=\"mensajeTitulo\" align=center width=\"510\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: REQUERIMIENTO - SISTEMA DE INFORMACIÓN</td>
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
			   INNER JOIN requerimiento_sistema_informacion on division.id_division=requerimiento_sistema_informacion.id_division";
$conDivision="SELECT distinct division.ID_DIVISION,DIVISION FROM DIVISION 
              INNER JOIN requerimiento_sistema_informacion on division.id_division=requerimiento_sistema_informacion.id_division WHERE ID_GERENCIA='$_POST[selGerencia]'";
$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","entrarDenuevo()",$conGerencia,"TODOS","");
$selGerencia=$gerencia->retornar();
$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","entrarDenuevo()",$conDivision,"TODOS","");
$selDivision=$division->retornar();	
$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10","","");
$txtFechaInicio=$fechaInicio->retornar();		
$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
$txtFechaFinal=$fechaFinal->retornar();		
echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"580\" border=\"0\">";
	echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">REPORTE REQUERIMIENTO SISTEMA INFORMACIÓN</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">REQUERIMIENTO SISTEMA DE INFORMACIÓN </td>
			
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>  
<td valign=top class=\"formularioCampoTitulo\" >GERENCIA<br>$selGerencia<br>DIVISION<br>$selDivision<br></td>
<td valign=top class=\"formularioCampoTitulo\" >
FECHA INICIAL<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmRequrimientoSistemaInformacion.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\"></a><br>
FECHA FINAL<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmRequrimientoSistemaInformacion.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\"></a><br>
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