<?php
require_once("seguridad.php");
?>	
		
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>

<style type="text/css">
.tipoLetras {
	font-family:"Arial";
	text-align:center;
	font-size: 7px;
	font-weight: bold;	
	color: #000000;
}	
</style> 
<?php
require_once "alineacion.php";
require_once "formularios.php";
require_once "conexionsql.php";
require_once "administracion.php";
require_once "usuarioSistemaAdmin.php";

echo "<title>BUSCAR USUARIO</title>";
?>
<script language="javascript">	
	function cambiarSeleccion() {
	 document.frmSolicitudes.funcion.value=0;			  
	 document.frmSolicitudes.submit();
    }
    function buscarFicha() {
	document.frmSolicitudes.funcion.value=0;
	document.frmSolicitudes.submit();
    }      
    function no() {
	document.frmSolicitudes.funcion.value=6;	
	document.frmSolicitudes.submit();	
    }      
    //Función para almacenar en el campo de texto solo numeros 
    /*function soloNumero(){ 
    var key=window.event.keyCode;//codigo de tecla. 
    if (key < 48 || key > 57){//si no es numero  
       window.event.keyCode=0;//anula la entrada de texto. 
    }
    }*/     
    
    function valorIntroducido() {
	   
	    if (document.frmSolicitudes.selUsuario.value!=""){	
		    ruta=document.frmSolicitudes.selUsuario.value;
	   	    window.open("../librerias/datosUsuario.php?ficha="+ ruta,"",'width=640,height=600,scrollbars=1,top=200,left=350');	
	    }
    } 
    function cicloNuevo() {
	document.frmSolicitudes.funcion.value=2;	
	document.frmSolicitudes.submit();	
    }                  
</script>

<?php
//SE PASA POR ESTE SWITCH CADA VEZ QUE SE REALIZA UN SUBMIT EN LA PAGINA
switch ($_POST[funcion]) {	              	           					
	  case "1":	   	       		    		
	     case 1:	
	if (isset($_POST[txtFechaInicio]) && empty($_POST[txtFechaInicio])) {		
		if ($sw==1) {			
			$mensaje=$mensaje."<b>,</b>";
		}		
		$mensaje=$mensaje."<b>FECHA INICIAL</b>";
		$i++;
		$sw=1;
	}
	if (isset($_POST[txtFechaFinal]) && empty($_POST[txtFechaFinal])){		
		if ($sw==1) {			
			$mensaje=$mensaje."<b>,</b>";
		}		
		$mensaje=$mensaje."<b>FECHA FINAL</b>";
		$i++;
		$sw=1;
	}	
	switch($i) {
		case 0:
		busca();
		$txtFechaInicio=$_POST[txtFechaInicio];$txtFechaFinal=$_POST[txtFechaFinal];
		$resultadoFecha=compara_Rango_Fechas($txtFechaInicio,$txtFechaFinal);
        if ($resultadoFecha==0){        	        	
        	conectarMysql();
		    $fechaI=substr($_POST[txtFechaInicio],6,4)."-". substr($_POST[txtFechaInicio],3,2)."-". substr($_POST[txtFechaInicio],0,2);
			$fechaF=substr($_POST[txtFechaFinal],6,4)."-". substr($_POST[txtFechaFinal],3,2)."-". substr($_POST[txtFechaFinal],0,2);
			
			//////////////////////////////CUANDO LA GERENCIA ES DIFERENTE DE 100 //////////////////////////////
			//////////////////////////////EL SITIO ES DIFERENTE DE 100 ////////////////////////////////////////
			//////////////////////////////Y LA SOLICITUD ES IGUAL A 100 ///////////////////////////////////////
			
			if ($_POST[selGerencia]!=100 && $_POST[selSitio]!=100 && $_POST[selEstatuSolicitud]==100) {					
									
				$consulta="SELECT ID_SOLICITUD, SOLICITUD_EQUIPO.FICHA,CONCAT(USUARIO. NOMBRE_USUARIO, ' ',USUARIO. APELLIDO_USUARIO) AS USUARIO, USUARIO.EXTENSION,
                                  SOLICITUD_EQUIPO.ID_DESCRIPCION,DESCRIPCION.DESCRIPCION,SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD, MOTIVO_SOLICITUD.MOTIVO_SOLICITUD,SOLICITUD_EQUIPO.ID_STATUS,
                                  STATUS_SOLICITUD.DES_STATUS,ID_USS, FECHA_I, FECHA_M, OBSERVACION_SOLICITUD,GERENCIA,DIVISION,DEPARTAMENTO,SITIO
			                      FROM SOLICITUD_EQUIPO
								  INNER JOIN DESCRIPCION ON SOLICITUD_EQUIPO.ID_DESCRIPCION=DESCRIPCION.ID_DESCRIPCION
								  INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA
								  INNER JOIN STATUS_SOLICITUD ON SOLICITUD_EQUIPO.ID_STATUS=STATUS_SOLICITUD.ID_STATUS
								  INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
								  INNER JOIN MOTIVO_SOLICITUD ON SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD=MOTIVO_SOLICITUD.ID_MOTIVO_SOLICITUD
								  INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
								  INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
								  INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA 
								  WHERE SITIO.ID_SITIO LIKE '%$_POST[selSitio]' AND SOLICITUD_EQUIPO.FECHA_I BETWEEN '$fechaI' and '$fechaF'";        	        	
        	$result=mysql_query($consulta);
			$resultado=mysql_num_rows($result);
			$conEstatuSolicitud="SELECT DISTINCT STATUS_SOLICITUD.ID_STATUS,DES_STATUS FROM STATUS_SOLICITUD
                                 INNER JOIN SOLICITUD_EQUIPO ON STATUS_SOLICITUD. ID_STATUS=SOLICITUD_EQUIPO.ID_STATUS
                                 INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA
                                 INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
                                 INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
                                 INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
                                 INNER JOIN GERENCIA ON GERENCIA.ID_GERENCIA=DIVISION.ID_GERENCIA
                                 WHERE SITIO.ID_SITIO LIKE '%$_POST[selSitio]'";
            $estatusSolicitud= new campoSeleccion("selEstatuSolicitud","formularioCampoSeleccion","$_POST[selEstatuSolicitud]","onChange","cambiarSeleccion()",$conEstatuSolicitud,"--TODOS--","");
            $selEstatuSolicitud=$estatusSolicitud->retornar();  

			if($resultado>0){
			   echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
			   echo "<tr valign=top class=\"tablaTitulo\">
	                 <td align=\"left\" class=\"tablaTitulo\">SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">FICHA</td>
			         <td valign=top class=\"tablaTitulo\">USUARIO</td>
			         <td valign=top class=\"tablaTitulo\">EXTENSION</td>
			         <td valign=top class=\"tablaTitulo\">DESCRIPCION</td>
			         <td valign=top class=\"tablaTitulo\">MOTIVO SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">ESTATUS SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">GERENCIA</td>
			         <td valign=top class=\"tablaTitulo\">UBICACION</td>
			         <td valign=top class=\"tablaTitulo\">OBSERVACION</td>
								 </tr>";
							while ($row = mysql_fetch_array($result)) {
								if ($i%2==0) {
									$clase="tablaFilaPar";
								}
								else {
									$clase="tablaFilaNone";
								}
								echo "<tr class=\"$clase\">
						             <td align=\"left\"><a title=\"D Ver el detalle de la solicitud\" href=\"#\" onclick=window.open(\"../librerias/solicitudesReportesLink.php?idSolicitud=$row[0]\",\"\",'width=540,height=600,scrollbars=1,top=200,left=350')>$row[0]</a></td>
						             <td>$row[1]</td>	
						             <td>$row[2]</td>
						             <td>$row[3]</td>
						             <td>$row[5]</td>
						             <td>$row[7]</td>
						             <td>$row[9]</td>
						             <td>$row[14]</td>
						             <td>$row[17]</td>
						             <td>$row[13]</td>
						             </tr>";
								$i++;
							}
							echo "<tr><td class=\"formularioTablaBotones\" colspan=\"10\"><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"cicloNuevo()\">
	                                <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfSolicitudesTodas.php?gerencia=$_POST[selGerencia]&sitio=$_POST[selSitio]&estatus=$_POST[selEstatuSolicitud]&usuario=$_POST[selUsuario]&fechaI=$fechaI&fechaF=$fechaF\")></td><tr>";							 	
						}
				else {						
						 echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";							
						 echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";							
						 echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						 echo "<tr>";
						 echo "<td align=center>MENSAJE - REPORTE - SOLICITUDES</td></tr>";
						 echo "<tr>";
						 echo "<td valign=top class=\"mensaje\" align=center>NO EXISTEN REGISTROS EN EL RANGO DE FECHAS</td>";
						 echo "</tr>";
						 echo "<tr>";
						 echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
						 echo "</tr>";	
					}			
			  echo "</table>";							
			}
///////////////////////////////////////////////////////// FIN DE LA CONDICION 1 //////////////////////////////////////////////////////////////							

            //////////////////////////////CUANDO LA GERENCIA ES DIFERENTE DE 100 //////////////////////////////
			//////////////////////////////EL SITIO ES IGUAL DE 100 ////////////////////////////////////////////
			//////////////////////////////Y LA SOLICITUD ES IGUAL A 100 ///////////////////////////////////////
			
			if ($_POST[selGerencia]!=100 && $_POST[selSitio]==100 && $_POST[selEstatuSolicitud]==100) {					
																		
				$consulta="SELECT ID_SOLICITUD, SOLICITUD_EQUIPO.FICHA,CONCAT(USUARIO. NOMBRE_USUARIO, ' ',USUARIO. APELLIDO_USUARIO) AS USUARIO, USUARIO.EXTENSION,
                              SOLICITUD_EQUIPO.ID_DESCRIPCION,DESCRIPCION.DESCRIPCION,SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD, MOTIVO_SOLICITUD.MOTIVO_SOLICITUD,SOLICITUD_EQUIPO.ID_STATUS,
                              STATUS_SOLICITUD.DES_STATUS,ID_USS, FECHA_I, FECHA_M, OBSERVACION_SOLICITUD,GERENCIA,DIVISION,DEPARTAMENTO,SITIO
                        FROM SOLICITUD_EQUIPO
						INNER JOIN DESCRIPCION ON SOLICITUD_EQUIPO.ID_DESCRIPCION=DESCRIPCION.ID_DESCRIPCION
						INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA
						INNER JOIN STATUS_SOLICITUD ON SOLICITUD_EQUIPO.ID_STATUS=STATUS_SOLICITUD.ID_STATUS
						INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
						INNER JOIN MOTIVO_SOLICITUD ON SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD=MOTIVO_SOLICITUD.ID_MOTIVO_SOLICITUD
						INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
						INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
						INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA 
						WHERE GERENCIA.ID_GERENCIA LIKE'%$_POST[selGerencia]' AND SOLICITUD_EQUIPO.FECHA_I BETWEEN '$fechaI' and '$fechaF'
						ORDER BY SOLICITUD_EQUIPO.ID_SOLICITUD DESC";        	        	
        	$result=mysql_query($consulta);
			$resultado=mysql_num_rows($result);
			$conEstatuSolicitud="SELECT DISTINCT STATUS_SOLICITUD.ID_STATUS,DES_STATUS FROM STATUS_SOLICITUD
                                 INNER JOIN SOLICITUD_EQUIPO ON STATUS_SOLICITUD. ID_STATUS=SOLICITUD_EQUIPO.ID_STATUS
                                 INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA                                 
                                 INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
                                 INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
                                 INNER JOIN GERENCIA ON GERENCIA.ID_GERENCIA=DIVISION.ID_GERENCIA
                                 WHERE GERENCIA.ID_GERENCIA LIKE '%$_POST[selGerencia]'";			
            $estatusSolicitud= new campoSeleccion("selEstatuSolicitud","formularioCampoSeleccion","$_POST[selEstatuSolicitud]","onChange","cambiarSeleccion()",$conEstatuSolicitud,"--TODOS--","");
            $selEstatuSolicitud=$estatusSolicitud->retornar();  

			if($resultado>0){
			   echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
			   echo "<tr valign=top class=\"tablaTitulo\">
	                 <td align=\"left\" class=\"tablaTitulo\">SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">FICHA</td>
			         <td valign=top class=\"tablaTitulo\">USUARIO</td>
			         <td valign=top class=\"tablaTitulo\">EXTENSION</td>
			         <td valign=top class=\"tablaTitulo\">DESCRIPCION</td>
			         <td valign=top class=\"tablaTitulo\">MOTIVO SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">ESTATUS SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">GERENCIA</td>			        
			         <td valign=top class=\"tablaTitulo\">OBSERVACION</td>
								 </tr>";
							while ($row = mysql_fetch_array($result)) {
								if ($i%2==0) {
									$clase="tablaFilaPar";
								}
								else {
									$clase="tablaFilaNone";
								}
								echo "<tr class=\"$clase\">
						             <td align=\"left\"><a title=\"E Ver el detalle de la solicitud\" href=\"#\" onclick=window.open(\"../librerias/solicitudesReportesLink.php?idSolicitud=$row[0]\",\"\",'width=540,height=600,scrollbars=1,top=200,left=350')>$row[0]</a></td>
						             <td>$row[1]</td>	
						             <td>$row[2]</td>
						             <td>$row[3]</td>
						             <td>$row[5]</td>
						             <td>$row[7]</td>
						             <td>$row[9]</td>
						             <td>$row[14]</td>						            
						             <td>$row[13]</td>
						             </tr>";
								$i++;
							}							 
							echo "<tr><td class=\"formularioTablaBotones\" colspan=\"10\"><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"cicloNuevo()\">
	                                <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfSolicitudesTodas.php?gerencia=$_POST[selGerencia]&sitio=$_POST[selSitio]&estatus=$_POST[selEstatuSolicitud]&usuario=$_POST[selUsuario]&fechaI=$fechaI&fechaF=$fechaF\")></td></tr>";							 	
						}
					else {						
						    echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";							
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";							
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE - REPORTE - SOLICITUDES</td></tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>NO EXISTEN REGISTROS EN EL RANGO DE FECHAS</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
							echo "</tr>";												
					}	
					echo "</table>";	
			}
			
///////////////////////////////////////////////////////// FIN DE LA CONDICION 2 //////////////////////////////////////////////////////////////

            //////////////////////////////CUANDO LA GERENCIA ES DIFERENTE DE 100 //////////////////////////////
			//////////////////////////////EL SITIO ES IGUAL DE 100 ////////////////////////////////////////////
			//////////////////////////////Y LA SOLICITUD ES DIFERENTE DE 100 //////////////////////////////////


			if ($_POST[selGerencia]!=100 && $_POST[selSitio]==100 && $_POST[selEstatuSolicitud]!=100) {					
				$consulta="SELECT ID_SOLICITUD, SOLICITUD_EQUIPO.FICHA,CONCAT(USUARIO. NOMBRE_USUARIO, ' ',USUARIO. APELLIDO_USUARIO) AS USUARIO, USUARIO.EXTENSION,
                              SOLICITUD_EQUIPO.ID_DESCRIPCION,DESCRIPCION.DESCRIPCION,SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD, MOTIVO_SOLICITUD.MOTIVO_SOLICITUD,SOLICITUD_EQUIPO.ID_STATUS,
                              STATUS_SOLICITUD.DES_STATUS,ID_USS, FECHA_I, FECHA_M, OBSERVACION_SOLICITUD,GERENCIA,DIVISION,DEPARTAMENTO,SITIO
                        FROM SOLICITUD_EQUIPO
						INNER JOIN DESCRIPCION ON SOLICITUD_EQUIPO.ID_DESCRIPCION=DESCRIPCION.ID_DESCRIPCION
						INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA
						INNER JOIN STATUS_SOLICITUD ON SOLICITUD_EQUIPO.ID_STATUS=STATUS_SOLICITUD.ID_STATUS
						INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
						INNER JOIN MOTIVO_SOLICITUD ON SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD=MOTIVO_SOLICITUD.ID_MOTIVO_SOLICITUD
						INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
						INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
						INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA 
						WHERE GERENCIA.ID_GERENCIA LIKE'%$_POST[selGerencia]' AND STATUS_SOLICITUD.ID_STATUS LIKE '%$_POST[selEstatuSolicitud]' AND SOLICITUD_EQUIPO.FECHA_I BETWEEN '$fechaI' and '$fechaF'
						ORDER BY SOLICITUD_EQUIPO.ID_SOLICITUD DESC";        	        	
        	$result=mysql_query($consulta);
			$resultado=mysql_num_rows($result);
			$conEstatuSolicitud="SELECT DISTINCT STATUS_SOLICITUD.ID_STATUS,DES_STATUS FROM STATUS_SOLICITUD
                                 INNER JOIN SOLICITUD_EQUIPO ON STATUS_SOLICITUD. ID_STATUS=SOLICITUD_EQUIPO.ID_STATUS
                                 INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA                                 
                                 INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
                                 INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
                                 INNER JOIN GERENCIA ON GERENCIA.ID_GERENCIA=DIVISION.ID_GERENCIA
                                 WHERE GERENCIA.ID_GERENCIA LIKE '%$_POST[selGerencia]'";			
            $estatusSolicitud= new campoSeleccion("selEstatuSolicitud","formularioCampoSeleccion","$_POST[selEstatuSolicitud]","onChange","cambiarSeleccion()",$conEstatuSolicitud,"--TODOS--","");
            $selEstatuSolicitud=$estatusSolicitud->retornar();  

			if($resultado>0){
			   echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
			   echo "<tr valign=top class=\"tablaTitulo\">
	                 <td align=\"left\" class=\"tablaTitulo\">SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">FICHA</td>
			         <td valign=top class=\"tablaTitulo\">USUARIO</td>
			         <td valign=top class=\"tablaTitulo\">EXTENSION</td>
			         <td valign=top class=\"tablaTitulo\">DESCRIPCION</td>
			         <td valign=top class=\"tablaTitulo\">MOTIVO SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">ESTATUS SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">GERENCIA</td>			        
			         <td valign=top class=\"tablaTitulo\">OBSERVACION</td>
								 </tr>";
							while ($row = mysql_fetch_array($result)) {
								if ($i%2==0) {
									$clase="tablaFilaPar";
								}
								else {
									$clase="tablaFilaNone";
								}
								echo "<tr class=\"$clase\">
						             <td align=\"left\"><a title=\"F Ver el detalle de la solicitud\" href=\"#\" title=\"Ver el detalle de la solicitud\" onclick=window.open(\"../librerias/solicitudesReportesLink.php?idSolicitud=$row[0]\",\"\",'width=540,height=600,scrollbars=1,top=200,left=350')>$row[0]</a></td>
						             <td>$row[1]</td>	
						             <td>$row[2]</td>
						             <td>$row[3]</td>
						             <td>$row[5]</td>
						             <td>$row[7]</td>
						             <td>$row[9]</td>
						             <td>$row[14]</td>						            
						             <td>$row[13]</td>
						             </tr>";
								$i++;
							}
							echo "<tr><td class=\"formularioTablaBotones\" colspan=\"10\"><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"cicloNuevo()\">
	                                <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfSolicitudesTodas.php?gerencia=$_POST[selGerencia]&sitio=$_POST[selSitio]&estatus=$_POST[selEstatuSolicitud]&fechaI=$fechaI&fechaF=$fechaF\")></td></tr>";							 	
						}
					else {						
						    echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";							
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";							
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE - REPORTE - SOLICITUDES</td></tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>NO EXISTEN REGISTROS EN EL RANGO DE FECHAS</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
							echo "</tr>";													
					}	
				echo "</table>";	
			}
			
			
////////////////////////////////////////////////////////// FIN DE LA CONDICION 3 //////////////////////////////////////////////////////////////

            //////////////////////////////CUANDO LA GERENCIA ES IGUAL DE 100 //////////////////////////////
			//////////////////////////////EL SITIO ES IGUAL DE 100 ////////////////////////////////////////////
			//////////////////////////////Y LA SOLICITUD ES DIFERENTE A VACIO /////////////////////////////////

			if ($_POST[selGerencia]==100 && $_POST[selSitio]==100 && $_POST[selEstatuSolicitud]!=100) {	
									
				$consulta="SELECT ID_SOLICITUD, SOLICITUD_EQUIPO.FICHA,CONCAT(USUARIO. NOMBRE_USUARIO, ' ',USUARIO. APELLIDO_USUARIO) AS USUARIO, USUARIO.EXTENSION,
                           SOLICITUD_EQUIPO.ID_DESCRIPCION,DESCRIPCION.DESCRIPCION,SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD, MOTIVO_SOLICITUD.MOTIVO_SOLICITUD,SOLICITUD_EQUIPO.ID_STATUS,
                           STATUS_SOLICITUD.DES_STATUS,ID_USS, FECHA_I, FECHA_M, OBSERVACION_SOLICITUD,GERENCIA,DIVISION,DEPARTAMENTO,SITIO
                        FROM SOLICITUD_EQUIPO
						INNER JOIN DESCRIPCION ON SOLICITUD_EQUIPO.ID_DESCRIPCION=DESCRIPCION.ID_DESCRIPCION
						INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA
						INNER JOIN STATUS_SOLICITUD ON SOLICITUD_EQUIPO.ID_STATUS=STATUS_SOLICITUD.ID_STATUS
						INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
						INNER JOIN MOTIVO_SOLICITUD ON SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD=MOTIVO_SOLICITUD.ID_MOTIVO_SOLICITUD
						INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
						INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
						INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA 
						WHERE STATUS_SOLICITUD.ID_STATUS LIKE '%$_POST[selEstatuSolicitud]' AND SOLICITUD_EQUIPO.FECHA_I BETWEEN '$fechaI' and '$fechaF'";        	        	
        	
				echo $consulta;
				$result=mysql_query($consulta);
			$resultado=mysql_num_rows($result);			
			if($resultado>0){
			   echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
			   echo "<tr valign=top class=\"tablaTitulo\">
	                 <td align=\"left\" class=\"tablaTitulo\">SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">FICHA</td>
			         <td valign=top class=\"tablaTitulo\">USUARIO</td>
			         <td valign=top class=\"tablaTitulo\">EXTENSION</td>
			         <td valign=top class=\"tablaTitulo\">DESCRIPCION</td>
			         <td valign=top class=\"tablaTitulo\">MOTIVO SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">ESTATUS SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">GERENCIA</td>			        
			         <td valign=top class=\"tablaTitulo\">OBSERVACION</td>
								 </tr>";
							while ($row = mysql_fetch_array($result)) {
								if ($i%2==0) {
									$clase="tablaFilaPar";
								}
								else {
									$clase="tablaFilaNone";
								}
								echo "<tr class=\"$clase\">
						             <td align=\"left\"><a title=\"G Ver el detalle de la solicitud\" href=\"#\"  onclick=window.open(\"../librerias/solicitudesReportesLink.php?idSolicitud=$row[0]\",\"\",'width=540,height=600,scrollbars=1,top=200,left=350')>$row[0]</a></td>
						             <td>$row[1]</td>	
						             <td>$row[2]</td>
						             <td>$row[3]</td>
						             <td>$row[5]</td>
						             <td>$row[7]</td>
						             <td>$row[9]</td>
						             <td>$row[14]</td>						            
						             <td>$row[13]</td>
						             </tr>";
								$i++;
							}
							$con="select id_status,des_status from status_solicitud where id_status='$_POST[selEstatuSolicitud]'";													
							$conest=mysql_query($con);
							$registro=mysql_fetch_array($conest);	
							if ($registro[1]=='EN PROCESO'){$registro[1]="EN_PROCESO";}
							else{$registro[1];}	
							if ($registro[1]=='SIN PROCESAR'){$registro[1]="SIN_PROCESAR";}
							else{$registro[1];}				
							
							echo "<tr class=formularioTablaBotones><td align=left colspan=10>TOTAL DE SOLICITUDES $registro[1]: $i</td></tr>";					     				 				   					     				     
							echo "<td class=\"formularioTablaBotones\" colspan=\"10\"><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"cicloNuevo()\">
	                              <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfSolicitudesTodas.php?gerencia=$_POST[selGerencia]&sitio=$_POST[selSitio]&estatus=$_POST[selEstatuSolicitud]&fechaI=$fechaI&fechaF=$fechaF&totalSolicitud=$i&valor=$registro[1]\")></td></tr>";							 	
						}
					else {						
						    echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";							
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";							
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE - REPORTE - SOLICITUDES</td></tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>NO EXISTEN REGISTROS EN EL RANGO DE FECHAS</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
							echo "</tr>";												
					}	
				echo "</table>";		
			}
						
////////////////////////////////////////////////////////// FIN DE LA CONDICION 4 //////////////////////////////////////////////////////////////

            //////////////////////////////CUANDO LA GERENCIA ES IGUAL A 100 //////////////////////////////
			//////////////////////////////EL SITIO ES DIFERENTE DE 100 ///////////////////////////////////
			//////////////////////////////Y ESTATUS DE SOLICITUD ES DIFERENTE DE 100  ////////////////////

			if ($_POST[selGerencia]==100 && $_POST[selSitio]!=100 && $_POST[selEstatuSolicitud]==100) {	
									
				$consulta="SELECT ID_SOLICITUD, SOLICITUD_EQUIPO.FICHA,CONCAT(USUARIO. NOMBRE_USUARIO, ' ',USUARIO. APELLIDO_USUARIO) AS USUARIO, USUARIO.EXTENSION,
                              SOLICITUD_EQUIPO.ID_DESCRIPCION,DESCRIPCION.DESCRIPCION,SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD, MOTIVO_SOLICITUD.MOTIVO_SOLICITUD,SOLICITUD_EQUIPO.ID_STATUS,
                              STATUS_SOLICITUD.DES_STATUS,ID_USS, FECHA_I, FECHA_M, OBSERVACION_SOLICITUD,GERENCIA,DIVISION,DEPARTAMENTO,SITIO
                        FROM SOLICITUD_EQUIPO
						INNER JOIN DESCRIPCION ON SOLICITUD_EQUIPO.ID_DESCRIPCION=DESCRIPCION.ID_DESCRIPCION
						INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA
						INNER JOIN STATUS_SOLICITUD ON SOLICITUD_EQUIPO.ID_STATUS=STATUS_SOLICITUD.ID_STATUS
						INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
						INNER JOIN MOTIVO_SOLICITUD ON SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD=MOTIVO_SOLICITUD.ID_MOTIVO_SOLICITUD
						INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
						INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
						INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA 
						WHERE SITIO.ID_SITIO LIKE '%$_POST[selSitio]' AND SOLICITUD_EQUIPO.FECHA_I BETWEEN '$fechaI' and '$fechaF'";        	        	
        	$result=mysql_query($consulta);
			$resultado=mysql_num_rows($result);			
			if($resultado>0){
			   echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
			   echo "<tr valign=top class=\"tablaTitulo\">
	                 <td align=\"left\" class=\"tablaTitulo\">SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">FICHA</td>
			         <td valign=top class=\"tablaTitulo\">USUARIO</td>
			         <td valign=top class=\"tablaTitulo\">EXTENSION</td>
			         <td valign=top class=\"tablaTitulo\">DESCRIPCION</td>
			         <td valign=top class=\"tablaTitulo\">MOTIVO SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">ESTATUS SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">GERENCIA</td>			        
			         <td valign=top class=\"tablaTitulo\">UBICACION</td>			        
			         <td valign=top class=\"tablaTitulo\">OBSERVACION</td>
								 </tr>";
							while ($row = mysql_fetch_array($result)) {
								if ($i%2==0) {
									$clase="tablaFilaPar";
								}
								else {
									$clase="tablaFilaNone";
								}
								echo "<tr class=\"$clase\">
						             <td align=\"left\"><a title=\"H Ver el detalle de la solicitud\" href=\"#\" onclick=window.open(\"../librerias/solicitudesReportesLink.php?idSolicitud=$row[0]\",\"\",'width=540,height=600,scrollbars=1,top=200,left=350')>$row[0]</a></td>
						             <td>$row[1]</td>	
						             <td>$row[2]</td>
						             <td>$row[3]</td>
						             <td>$row[5]</td>
						             <td>$row[7]</td>
						             <td>$row[9]</td>
						             <td>$row[14]</td>
						             <td>$row[17]</td>								            
						             <td>$row[13]</td>
						             </tr>";
								$i++;
							}
							echo "<tr><td class=\"formularioTablaBotones\" colspan=\"10\"><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"cicloNuevo()\">
	                                <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfSolicitudesTodas.php?gerencia=$_POST[selGerencia]&sitio=$_POST[selSitio]&estatus=$_POST[selEstatuSolicitud]&fechaI=$fechaI&fechaF=$fechaF\")></td></tr>";							 	
						}
					else {						
						    echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";							
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";							
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE - REPORTE - SOLICITUDES</td></tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>NO EXISTEN REGISTROS EN EL RANGO DE FECHAS</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
							echo "</tr>";													
					}	
					echo "</table>";
			}
						
////////////////////////////////////////////////////////// FIN DE LA CONDICION 5 //////////////////////////////////////////////////////////////


            //////////////////////////////CUANDO LA GERENCIA ES IGUAL DE 100 //////////////////////////////
			//////////////////////////////EL SITIO ES DIFERENTE DE 100 ////////////////////////////////////			

			if ($_POST[selGerencia]==100 && $_POST[selSitio]!=100 && $_POST[selEstatuSolicitud]!=100){						
						
				$consulta="SELECT ID_SOLICITUD, SOLICITUD_EQUIPO.FICHA,CONCAT(USUARIO. NOMBRE_USUARIO, ' ',USUARIO. APELLIDO_USUARIO) AS USUARIO, USUARIO.EXTENSION,
                              SOLICITUD_EQUIPO.ID_DESCRIPCION,DESCRIPCION.DESCRIPCION,SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD, MOTIVO_SOLICITUD.MOTIVO_SOLICITUD,SOLICITUD_EQUIPO.ID_STATUS,
                              STATUS_SOLICITUD.DES_STATUS,ID_USS, FECHA_I, FECHA_M, OBSERVACION_SOLICITUD,GERENCIA,DIVISION,DEPARTAMENTO,SITIO
                        FROM SOLICITUD_EQUIPO
						INNER JOIN DESCRIPCION ON SOLICITUD_EQUIPO.ID_DESCRIPCION=DESCRIPCION.ID_DESCRIPCION
						INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA
						INNER JOIN STATUS_SOLICITUD ON SOLICITUD_EQUIPO.ID_STATUS=STATUS_SOLICITUD.ID_STATUS
						INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
						INNER JOIN MOTIVO_SOLICITUD ON SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD=MOTIVO_SOLICITUD.ID_MOTIVO_SOLICITUD
						INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
						INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
						INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA 
						WHERE SITIO.ID_SITIO LIKE '%$_POST[selSitio]' AND STATUS_SOLICITUD.ID_STATUS LIKE '%$_POST[selEstatuSolicitud]' AND SOLICITUD_EQUIPO.FECHA_I BETWEEN '$fechaI' and '$fechaF'";        	        	
        	$result	=mysql_query($consulta);
			$resultado=mysql_num_rows($result);
			$conEstatuSolicitud="SELECT DISTINCT STATUS_SOLICITUD.ID_STATUS,DES_STATUS FROM STATUS_SOLICITUD
                                 INNER JOIN SOLICITUD_EQUIPO ON STATUS_SOLICITUD. ID_STATUS=SOLICITUD_EQUIPO.ID_STATUS
                                 INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA
                                 INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
                                 INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
                                 INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
                                 INNER JOIN GERENCIA ON GERENCIA.ID_GERENCIA=DIVISION.ID_GERENCIA
                                 WHERE SITIO.ID_SITIO='$_POST[selSitio]'";
            $estatusSolicitud= new campoSeleccion("selEstatuSolicitud","formularioCampoSeleccion","$_POST[selEstatuSolicitud]","onChange","cambiarSeleccion()",$conEstatuSolicitud,"--TODOS--","");
            $selEstatuSolicitud=$estatusSolicitud->retornar();  

			if($resultado>0){
			   echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
			   echo "<tr valign=top class=\"tablaTitulo\">
	                 <td align=\"left\" class=\"tablaTitulo\">SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">FICHA</td>
			         <td valign=top class=\"tablaTitulo\">USUARIO</td>
			         <td valign=top class=\"tablaTitulo\">EXTENSION</td>
			         <td valign=top class=\"tablaTitulo\">DESCRIPCION</td>
			         <td valign=top class=\"tablaTitulo\">MOTIVO SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">ESTATUS SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">GERENCIA</td>
			         <td valign=top class=\"tablaTitulo\">UBICACION</td>
			         <td valign=top class=\"tablaTitulo\">OBSERVACION</td>
								 </tr>";
							while ($row = mysql_fetch_array($result)) {
								if ($i%2==0) {
									$clase="tablaFilaPar";
								}
								else {
									$clase="tablaFilaNone";
								}
								echo "<tr class=\"$clase\">
						             <td align=\"left\"><a title=\"A Ver el detalle de la solicitud\" href=\"#\" onclick=window.open(\"../librerias/solicitudesReportesLink.php?idSolicitud=$row[0]\",\"\",'width=540,height=600,scrollbars=1,top=200,left=350')>$row[0]</a></td>
						             <td>$row[1]</td>	
						             <td>$row[2]</td>
						             <td>$row[3]</td>
						             <td>$row[5]</td>
						             <td>$row[7]</td>
						             <td>$row[9]</td>
						             <td>$row[14]</td>
						             <td>$row[17]</td>
						             <td>$row[13]</td>
						             </tr>";
								$i++;
							}
							echo "<tr><td class=\"formularioTablaBotones\" colspan=\"10\"><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"cicloNuevo()\">
	                                <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfSolicitudesTodas.php?gerencia=$_POST[selGerencia]&sitio=$_POST[selSitio]&estatus=$_POST[selEstatuSolicitud]&fechaI=$fechaI&fechaF=$fechaF\")></td></tr>";							 	
						}
				else {						
						    echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";							
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";							
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE - REPORTE - SOLICITUDES</td></tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>NO EXISTEN REGISTROS EN EL RANGO DE FECHAS</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
							echo "</tr>";													
					}			
			echo "</table>";		
			}
////////////////////////////////////////////////////////// FIN DE LA CONDICION 5 //////////////////////////////////////////////////////////////
			
			//////////////////////////////CUANDO LA GERENCIA ES DIFERENTE DE 100 //////////////////////////////
			//////////////////////////////EL SITIO ES DIFERENTE DE 100 ////////////////////////////////////////
			//////////////////////////////Y LA SOLICITUD ES DIFERENTE DE 100 //////////////////////////////////

			if($_POST[selEstatuSolicitud]!=100 && $_POST[selGerencia]!=100 && $_POST[selSitio]!=100){	
				conectarMysql();																										
				$consulta="SELECT ID_SOLICITUD, SOLICITUD_EQUIPO.FICHA,CONCAT(USUARIO. NOMBRE_USUARIO, ' ',USUARIO. APELLIDO_USUARIO) AS USUARIO, USUARIO.EXTENSION,
                              SOLICITUD_EQUIPO.ID_DESCRIPCION,DESCRIPCION.DESCRIPCION,SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD, MOTIVO_SOLICITUD.MOTIVO_SOLICITUD,SOLICITUD_EQUIPO.ID_STATUS,
                              STATUS_SOLICITUD.DES_STATUS,ID_USS, FECHA_I, FECHA_M, OBSERVACION_SOLICITUD,GERENCIA,DIVISION,DEPARTAMENTO,SITIO
                        FROM SOLICITUD_EQUIPO
						INNER JOIN DESCRIPCION ON SOLICITUD_EQUIPO.ID_DESCRIPCION=DESCRIPCION.ID_DESCRIPCION
						INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA
						INNER JOIN STATUS_SOLICITUD ON SOLICITUD_EQUIPO.ID_STATUS=STATUS_SOLICITUD.ID_STATUS
						INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
						INNER JOIN MOTIVO_SOLICITUD ON SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD=MOTIVO_SOLICITUD.ID_MOTIVO_SOLICITUD
						INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
						INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
						INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA 
						WHERE SOLICITUD_EQUIPO.ID_STATUS LIKE '%$_POST[selEstatuSolicitud]' AND GERENCIA.ID_GERENCIA LIKE '%$_POST[selGerencia]' AND SITIO.ID_SITIO LIKE '%$_POST[selSitio]' AND SOLICITUD_EQUIPO.FECHA_I BETWEEN '$fechaI' and '$fechaF'";        	        					
        	$result=mysql_query($consulta);
			$resultado=mysql_num_rows($result);
			if($resultado>0){
			   echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
			   echo "<tr valign=top class=\"tablaTitulo\">
	                 <td align=\"left\" class=\"tablaTitulo\">SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">FICHA</td>
			         <td valign=top class=\"tablaTitulo\">USUARIO</td>
			         <td valign=top class=\"tablaTitulo\">EXTENSION</td>
			         <td valign=top class=\"tablaTitulo\">DESCRIPCION</td>
			         <td valign=top class=\"tablaTitulo\">MOTIVO SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">ESTATUS SOLICITUD</td>			        
			         <td valign=top class=\"tablaTitulo\">GERENCIA</td>
			         <td valign=top class=\"tablaTitulo\">UBICACION</td>
			         <td valign=top class=\"tablaTitulo\">OBSERVACION</td>
								 </tr>";
							while ($row = mysql_fetch_array($result)) {
								if ($i%2==0) {
									$clase="tablaFilaPar";
								}
								else {
									$clase="tablaFilaNone";
								}
								echo "<tr class=\"$clase\">
						             <td align=\"left\"><a title=\"B Ver el detalle de la solicitud\" href=\"#\" onclick=window.open(\"../librerias/solicitudesReportesLink.php?idSolicitud=$row[0]\",\"\",'width=540,height=600,scrollbars=1,top=200,left=350')>$row[0]</a></td>
						             <td>$row[1]</td>	
						             <td>$row[2]</td>
						             <td>$row[3]</td>
						             <td>$row[5]</td>
						             <td>$row[7]</td>
						             <td>$row[9]</td>
						             <td>$row[14]</td>
						             <td>$row[17]</td>
						             <td>$row[13]</td>
						             </tr>";
								$i++;
							}
							echo "<tr><td class=\"formularioTablaBotones\" colspan=\"10\"><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"cicloNuevo()\">
	                              <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfSolicitudesTodas.php?gerencia=$_POST[selGerencia]&sitio=$_POST[selSitio]&estatus=$_POST[selEstatuSolicitud]&usuario=$_POST[selUsuario]&fechaI=$fechaI&fechaF=$fechaF\")></td></tr>";							 	
						}
					else {						
						    echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";							
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";							
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE - REPORTE - SOLICITUDES</td></tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>NO EXISTEN REGISTROS EN EL RANGO DE FECHAS</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
							echo "</tr>";												
					}					
					echo "</table>";		
			}
////////////////////////////////////////////////////////// FIN DE LA CONDICION 6 //////////////////////////////////////////////////////////////			

            //////////////////////////////CUANDO EL USUARIO ES DIFERENTE DE VACIO //////////////////////////////			
						
			if ($_POST[selUsuario]!="" && $_POST[selGerencia]==100 && $_POST[selSitio]==100 && $_POST[selEstatuSolicitud]==100){
				$consulta="SELECT ID_SOLICITUD, SOLICITUD_EQUIPO.FICHA,CONCAT(USUARIO. NOMBRE_USUARIO, ' ',USUARIO. APELLIDO_USUARIO) AS USUARIO, USUARIO.EXTENSION,
                              SOLICITUD_EQUIPO.ID_DESCRIPCION,DESCRIPCION.DESCRIPCION,SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD, MOTIVO_SOLICITUD.MOTIVO_SOLICITUD,SOLICITUD_EQUIPO.ID_STATUS,
                              STATUS_SOLICITUD.DES_STATUS,ID_USS, FECHA_I, FECHA_M, OBSERVACION_SOLICITUD,GERENCIA,DIVISION,DEPARTAMENTO,SITIO
                        FROM SOLICITUD_EQUIPO
						INNER JOIN DESCRIPCION ON SOLICITUD_EQUIPO.ID_DESCRIPCION=DESCRIPCION.ID_DESCRIPCION
						INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA
						INNER JOIN STATUS_SOLICITUD ON SOLICITUD_EQUIPO.ID_STATUS=STATUS_SOLICITUD.ID_STATUS
						INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
						INNER JOIN MOTIVO_SOLICITUD ON SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD=MOTIVO_SOLICITUD.ID_MOTIVO_SOLICITUD
						INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
						INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
						INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA 
						WHERE SOLICITUD_EQUIPO.FICHA  LIKE '%$_POST[selUsuario]%' OR CONCAT(USUARIO. NOMBRE_USUARIO, ' ',USUARIO. APELLIDO_USUARIO) LIKE '%$_POST[selUsuario]%' AND SOLICITUD_EQUIPO.FECHA_I BETWEEN '$fechaI' and '$fechaF'";        	        	
        	$result=mysql_query($consulta);
			$resultado=mysql_num_rows($result);
			if($resultado>0){
			   echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
			   echo "<tr valign=top class=\"tablaTitulo\">
	                 <td align=\"left\" class=\"tablaTitulo\">SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">FICHA</td>
			         <td valign=top class=\"tablaTitulo\">USUARIO</td>
			         <td valign=top class=\"tablaTitulo\">EXTENSION</td>
			         <td valign=top class=\"tablaTitulo\">DESCRIPCION</td>
			         <td valign=top class=\"tablaTitulo\">MOTIVO SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">ESTATUS SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">GERENCIA</td>
			         <td valign=top class=\"tablaTitulo\">UBICACION</td>
			         <td valign=top class=\"tablaTitulo\">OBSERVACION</td>
								 </tr>";
							while ($row = mysql_fetch_array($result)) {
								if ($i%2==0) {
									$clase="tablaFilaPar";
								}
								else {
									$clase="tablaFilaNone";
								}
								echo "<tr class=\"$clase\">
						             <td align=\"left\"><a title=\"C Ver el detalle de la solicitud\" href=\"#\" onclick=window.open(\"../librerias/solicitudesReportesLink.php?idSolicitud=$row[0]\",\"\",'width=540,height=600,scrollbars=1,top=200,left=350')>$row[0]</a></td>
						             <td>$row[1]</td>	
						             <td>$row[2]</td>
						             <td>$row[3]</td>
						             <td>$row[5]</td>
						             <td>$row[7]</td>
						             <td>$row[9]</td>
						             <td>$row[14]</td>
						             <td>$row[17]</td>
						             <td>$row[13]</td>
						             </tr>";
								$i++;
							}                           						  													
							echo "<tr><td class=\"formularioTablaBotones\" colspan=\"10\"><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"cicloNuevo()\">	                         
	                                <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfSolicitudesTodas.php?gerencia=$_POST[selGerencia]&sitio=$_POST[selSitio]&estatus=$_POST[selEstatuSolicitud]&usuario=$_POST[selUsuario]&fechaI=$fechaI&fechaF=$fechaF\")></td></tr>";							 	
						}
				else { 
					echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";							
				    echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";							
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE - REPORTE - SOLICITUDES</td>
				    	  </tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>NO EXISTEN REGISTROS EN EL RANGO DE FECHAS<br>Ó<br>EL NUMERO DE FICHA: <b>$_POST[selUsuario]</b> NO EXISTE</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
					echo "</tr>";											
					}			
				echo "</table>";				
			}
			
////////////////////////////////////////////////////////// FIN DE LA CONDICION 7 //////////////////////////////////////////////////////////////			

            //////////////////////////////CUANDO LA GERENCIA ES IGUAL DE 100 //////////////////////////////        
			//////////////////////////////EL SITIO ES IGUAL DE 100 ////////////////////////////////////////
			//////////////////////////////Y LA SOLICITUD ES IGUAL A 100 ///////////////////////////////////
			//////////////////////////////USUARIO ES IGUAL A VACIO ////////////////////////////////////////

		if ($_POST[selGerencia]==100 && $_POST[selSitio]==100 && $_POST[selEstatuSolicitud]==100 &&	$_POST[selUsuario]==""){
			
										
			$_POST[selGerencia]=""; $_POST[selSitio]=""; $_POST[selEstatuSolicitud]="";
        	$consulta="SELECT ID_SOLICITUD, SOLICITUD_EQUIPO.FICHA,CONCAT(USUARIO. NOMBRE_USUARIO, ' ',USUARIO. APELLIDO_USUARIO) AS USUARIO, USUARIO.EXTENSION,
                              SOLICITUD_EQUIPO.ID_DESCRIPCION,DESCRIPCION.DESCRIPCION,SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD, MOTIVO_SOLICITUD.MOTIVO_SOLICITUD,SOLICITUD_EQUIPO.ID_STATUS,
                              STATUS_SOLICITUD.DES_STATUS,ID_USS, FECHA_I, FECHA_M, OBSERVACION_SOLICITUD,GERENCIA,DIVISION,DEPARTAMENTO,SITIO
                        FROM SOLICITUD_EQUIPO
						INNER JOIN DESCRIPCION ON SOLICITUD_EQUIPO.ID_DESCRIPCION=DESCRIPCION.ID_DESCRIPCION
						INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA
						INNER JOIN STATUS_SOLICITUD ON SOLICITUD_EQUIPO.ID_STATUS=STATUS_SOLICITUD.ID_STATUS
						INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
						INNER JOIN MOTIVO_SOLICITUD ON SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD=MOTIVO_SOLICITUD.ID_MOTIVO_SOLICITUD
						INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
						INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
						INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA 
						WHERE SOLICITUD_EQUIPO.FECHA_I BETWEEN '$fechaI' and '$fechaF' ORDER BY SOLICITUD_EQUIPO.ID_SOLICITUD DESC";  
        	
        	$totalSolicitudes="SELECT STATUS_SOLICITUD.DES_STATUS,COUNT(SOLICITUD_EQUIPO.ID_SOLICITUD) AS TOTAL FROM SOLICITUD_EQUIPO
							   INNER JOIN STATUS_SOLICITUD ON SOLICITUD_EQUIPO.ID_STATUS=STATUS_SOLICITUD.ID_STATUS
							   WHERE SOLICITUD_EQUIPO.FECHA_I BETWEEN '$fechaI' AND '$fechaF'
							   GROUP BY SOLICITUD_EQUIPO.ID_STATUS";        	        	     	        	
        	conectarMysql();
        	$result=mysql_query($consulta);
			$resultado=mysql_num_rows($result);
			if($resultado>0){
			   echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
			   echo "<tr valign=top class=\"tablaTitulo\">
	                 <td align=\"left\" class=\"tablaTitulo\">SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">FICHA</td>
			         <td valign=top class=\"tablaTitulo\">USUARIO</td>
			         <td valign=top class=\"tablaTitulo\">EXTENSION</td>
			         <td valign=top class=\"tablaTitulo\">DESCRIPCION</td>
			         <td valign=top class=\"tablaTitulo\">MOTIVO SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">ESTATUS SOLICITUD</td>
			         <td valign=top class=\"tablaTitulo\">GERENCIA</td>
			         <td valign=top class=\"tablaTitulo\">UBICACION</td>
			         <td valign=top class=\"tablaTitulo\">OBSERVACION</td>
								 </tr>";
							while ($row = mysql_fetch_array($result)) {
								if ($i%2==0) {
									$clase="tablaFilaPar";
								}
								else {
									$clase="tablaFilaNone";
								}
								echo "<tr class=\"$clase\">
						             <td align=\"left\"><a href=\"#\" onclick=window.open(\"../librerias/solicitudesReportesLink.php?idSolicitud=$row[0]\",\"\",'width=540,height=600,scrollbars=1,top=200,left=350')>$row[0]</a></td>
						             <td>$row[1]</td>	
						             <td>$row[2]</td>
						             <td>$row[3]</td>
						             <td>$row[5]</td>
						             <td>$row[7]</td>
						             <td>$row[9]</td>
						             <td>$row[14]</td>
						             <td>$row[17]</td>
						             <td>$row[13]</td>
						             </tr>";
								$i++;
							}				
				$toSolicitudes=mysql_query($totalSolicitudes);
			    $total=mysql_num_rows($toSolicitudes);			   
			    if($total>0){
			    	 echo "<table class=\"formularioTabla\"align=center border=\"0\">";
			         echo "<tr valign=top class=\"tablaTitulo\">
	                 <td align=\"left\" class=\"tablaTitulo\">APROBADO</td>
			         <td valign=top class=\"tablaTitulo\">EJECUTADO</td>
			         <td valign=top class=\"tablaTitulo\">EN PROCESO</td>
			         <td valign=top class=\"tablaTitulo\">RECHAZADO</td>
			         <td valign=top class=\"tablaTitulo\">SIN PROCESAR</td></tr>";	
			         
			        while ($arreglo = mysql_fetch_array($toSolicitudes)) {			        				        				        	
			        	   
			        	   if($arreglo[0]=='APROBADO'){			        	         
			        	      $aprobado=$arreglo[1];
			        	      substr($arreglo[1],0,1);			        	   	 
			        	      
			        	   }
			        	   if($arreglo[0]=='EJECUTADO'){
			        	      $ejecutado=$arreglo[1];
			        	      substr($arreglo[1],0,1);			        	   	 
			        	   }
			        	   if($arreglo[0]=='EN PROCESO'){
			        	      $enProceso=$arreglo[1];
			        	      substr($arreglo[1],0,1);			        	   	 
			        	   }			        				        	   
			        	   if($arreglo[0]=='RECHAZADO'){
			        	   	 $rechazado=$arreglo[1];
			        	   	 substr($arreglo[1],0,1);			        	   	 
			        	   }			        	
			        	   if($arreglo[0]=='SIN PROCESAR'){
			        	   	 $sinProcesar=$arreglo[1];
			        	   	 substr($arreglo[1],0,1);			        	   	 
			        	   }   			        	   
			        	   $acumulado=$acumulado+$arreglo[1];			        	   			        				        	  	  	   			        	 							     		    										   				     
                    }                            
                              echo "<tr class=\"$clase\">						   
						         <td align=\"center\">$aprobado</td>
						         <td>$ejecutado</td>	
						         <td>$enProceso</td>
						         <td>$rechazado</td>
						         <td>$sinProcesar</td>						         
						         </tr>";	
                      
                      		echo "<tr class=formularioTablaBotones><td align=left>TOTAL DE SOLICITUDES: $acumulado</td></tr>";					     				 				   					     				     
			     }			     																																															 
				echo "<tr><td class=\"formularioTablaBotones\" colspan=\"10\"><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"cicloNuevo()\">
	                  <input name=\"btnReporte\" type=\"button\" value=\"IMPRIMIR\"onclick=window.open(\"../librerias/pdfSolicitudesTodas.php?gerencia=$_POST[selGerencia]&sitio=$_POST[selSitio]&estatus=$_POST[selEstatuSolicitud]&fechaI=$fechaI&fechaF=$fechaF&totalSolicitudes=$acumulado&aprob=$aprobado&ejecutado=$ejecutado&enProceso=$enProceso&rechazado=$rechazado&sinProcesar=$sinProcesar\")>
	                  </td></tr></table>";							 	
			}
					else { 
						echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";							
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";							
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE - REPORTE - SOLICITUDES</td>
								   </tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>NO EXISTEN REGISTROS EN EL RANGO DE FECHAS</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
							echo "</tr>";													
					}	
				echo "</table>";	
          }
          
////////////////////////////////////////////////////////// FIN DE LA CONDICION 8 //////////////////////////////////////////////////////////////			       

     }
        //COPIAR DESDE AQUI AL OTRO ARCHIVO BUENO MANANA      
        if ($resultadoFecha==2){
            echo "<br><br>";
			echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";
		      echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		      echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";		
		      echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";		
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";			
			echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE - REPORTE - SOLICITUDES</td>
			       </tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>LA FECHA INICIAL <b>$_POST[txtFechaInicio]</b> NO ES VALIDA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
			echo "</tr>";
			echo "</table><form>";  
              
        }

        if ($resultadoFecha==3){
            echo "<br><br>";
			echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";
		      echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		      echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
		      echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";				
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";			
			echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE - REPORTE - SOLICITUDES</td>
			       </tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>LA FECHA FINAL <b>$_POST[txtFechaFinal]</b> NO ES VALIDA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
			echo "</tr>";
			echo "</table><form>";  
              
        } 
              
        if ($resultadoFecha==4){
            echo "<br><br>";
			echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";
		    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		    echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";		
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";			
			echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE - REPORTE - SOLICITUDES</td>
			       </tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>LAS FECHAS <b>$_POST[txtFechaInicio], $_POST[txtFechaFinal]</b> NO SON VALIDAS</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
			echo "</tr>";
			echo "</table><form>";  
              
        }               
        
        if ($resultadoFecha==5){
            echo "<br><br>";
			echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";
		    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		    echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";		
			echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";			
			echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE - REPORTE - SOLICITUDES</td>
			       </tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>LA FECHA FINAL: <b>$_POST[txtFechaFinal]</b>
			       NO PUEDE SER MENOR A LA FECHA INICIAL: <b>$_POST[txtFechaInicio]</b></td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
			echo "</tr>";
			echo "</table><form>";  
              
        }    
		break 1;
		case 1:
		echo "<br><br><br><br>";
		echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";
		echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
		echo "<input name=\"selEstatuSolicitud\" type=\"hidden\" value=\"$_POST[selEstatuSolicitud]\">";		
		echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
		echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";		
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: REPORTE - SOLICITUDES</td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>EL CAMPO ".$mensaje. " ESTÁ VACIO</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
		echo "</tr>";
		echo "</table>";			
		break 1;
		default:
		echo "<br><br><br><br>";
		echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">";
		echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
		echo "<input name=\"selEstatuSolicitud\" type=\"hidden\" value=\"$_POST[selEstatuSolicitud]\">";		
		echo "<input name=\"selUsuario\" type=\"hidden\" value=\"$_POST[selUsuario]\">";		
		echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
		echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";		
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: REPORTE - SOLICITUDES</td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>LOS CAMPOS ".$mensaje. " ESTAN VACIOS</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
		echo "</tr>";
		echo "</table>";			
	}	
	break 1;		   				  
	  case "2":	  
	   busca(); 		       		    		
	  break 1;					  
	  case "6":
	  exit();	  	  
	  break 1;
	  default:	
	   busca(); 
} 
function busca(){	

$conGerencia="SELECT DISTINCT GERENCIA.ID_GERENCIA,GERENCIA FROM GERENCIA
              INNER JOIN DIVISION ON GERENCIA.ID_GERENCIA=DIVISION.ID_GERENCIA
              INNER JOIN DEPARTAMENTO ON DIVISION.ID_DIVISION=DEPARTAMENTO.ID_DIVISION
              INNER JOIN USUARIO ON DEPARTAMENTO.ID_DEPARTAMENTO=USUARIO.ID_DEPARTAMENTO
              INNER JOIN SOLICITUD_EQUIPO ON USUARIO.FICHA=SOLICITUD_EQUIPO.FICHA
              ORDER BY GERENCIA.ID_GERENCIA";
$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","cambiarSeleccion()",$conGerencia,"--TODOS--","");
$selGerencia=$gerencia->retornar();

//PARA VALIDACION DE ESTO DEL SITIO QUE PASE A 100 CUANDO LA GERENCIA ES IGUAL A 100 
if ($_POST[selGerencia]==100 && $_POST[conEstatuSolicitud]==100){echo $_POST[selSitio]=100;}	
/////////////////////////////


if ($_POST[selGerencia]!=100){
	if($_POST[selUsuario]!=""){ $_POST[selUsuario]="";}		
$conSitio="SELECT DISTINCT SITIO.ID_SITIO,SITIO FROM SITIO
           INNER JOIN USUARIO ON SITIO.ID_SITIO=USUARIO.ID_SITIO
           INNER JOIN SOLICITUD_EQUIPO ON USUARIO.FICHA=SOLICITUD_EQUIPO.FICHA
           INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
           INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
           INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA WHERE GERENCIA.ID_GERENCIA='$_POST[selGerencia]'
           ORDER BY SITIO.SITIO";
$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","onChange","cambiarSeleccion()",$conSitio,"--TODOS--","");
$selSitio=$sitio->retornar();

$conEstatuSolicitud="SELECT DISTINCT STATUS_SOLICITUD.ID_STATUS,DES_STATUS FROM STATUS_SOLICITUD
                     INNER JOIN SOLICITUD_EQUIPO ON STATUS_SOLICITUD. ID_STATUS=SOLICITUD_EQUIPO.ID_STATUS
                     INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA                                 
                     INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
                     INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
                     INNER JOIN GERENCIA ON GERENCIA.ID_GERENCIA=DIVISION.ID_GERENCIA
                     WHERE GERENCIA.ID_GERENCIA LIKE '%$_POST[selGerencia]'";
$estatusSolicitud= new campoSeleccion("selEstatuSolicitud","formularioCampoSeleccion","$_POST[selEstatuSolicitud]","onChange","cambiarSeleccion()",$conEstatuSolicitud,"--TODOS--","");
$selEstatuSolicitud=$estatusSolicitud->retornar(); 
}

if ($_POST[selGerencia]==100){	
	$conSitio="SELECT DISTINCT SITIO.ID_SITIO,SITIO FROM SITIO
               INNER JOIN USUARIO ON SITIO.ID_SITIO=USUARIO.ID_SITIO
               INNER JOIN SOLICITUD_EQUIPO ON USUARIO.FICHA=SOLICITUD_EQUIPO.FICHA";
    $sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","onChange","cambiarSeleccion()",$conSitio,"--TODOS--","");
    $selSitio=$sitio->retornar();
    
    $conEstatuSolicitud="SELECT DISTINCT STATUS_SOLICITUD.ID_STATUS,DES_STATUS FROM STATUS_SOLICITUD
                         INNER JOIN SOLICITUD_EQUIPO ON STATUS_SOLICITUD. ID_STATUS=SOLICITUD_EQUIPO.ID_STATUS
                         INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA                                 
                         INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
                         INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
                         INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
                         INNER JOIN GERENCIA ON GERENCIA.ID_GERENCIA=DIVISION.ID_GERENCIA
                         WHERE SITIO.ID_SITIO LIKE '%$_POST[selSitio]'";    
    $estatusSolicitud= new campoSeleccion("selEstatuSolicitud","formularioCampoSeleccion","$_POST[selEstatuSolicitud]","onChange","cambiarSeleccion()",$conEstatuSolicitud,"--TODOS--","");
    $selEstatuSolicitud=$estatusSolicitud->retornar(); 	
}	

if ($_POST[selGerencia]==100 && $_POST[selSitio]==100){	
	
	$conEstatuSolicitud="SELECT DISTINCT STATUS_SOLICITUD.ID_STATUS,DES_STATUS FROM STATUS_SOLICITUD
                         INNER JOIN SOLICITUD_EQUIPO ON STATUS_SOLICITUD. ID_STATUS=SOLICITUD_EQUIPO.ID_STATUS
                         INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA                                 
                         INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
                         INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
                         INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
                         INNER JOIN GERENCIA ON GERENCIA.ID_GERENCIA=DIVISION.ID_GERENCIA";                         
    $estatusSolicitud= new campoSeleccion("selEstatuSolicitud","formularioCampoSeleccion","$_POST[selEstatuSolicitud]","onChange","cambiarSeleccion()",$conEstatuSolicitud,"--TODOS--","");
    $selEstatuSolicitud=$estatusSolicitud->retornar(); 	
    
    $conSitio="SELECT DISTINCT SITIO.ID_SITIO,SITIO FROM SITIO
               INNER JOIN USUARIO ON SITIO.ID_SITIO=USUARIO.ID_SITIO
               INNER JOIN SOLICITUD_EQUIPO ON USUARIO.FICHA=SOLICITUD_EQUIPO.FICHA";
    $sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","onChange","cambiarSeleccion()",$conSitio,"--TODOS--","");
    $selSitio=$sitio->retornar();    
}

if ($_POST[selGerencia]=="" && $_POST[conEstatuSolicitud]==""){
	$conSitio="SELECT DISTINCT SITIO.ID_SITIO,SITIO FROM SITIO
		       INNER JOIN USUARIO ON SITIO.ID_SITIO=USUARIO.ID_SITIO
		       INNER JOIN SOLICITUD_EQUIPO ON USUARIO.FICHA=SOLICITUD_EQUIPO.FICHA
		       ORDER BY SITIO.SITIO";   
   $sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","onChange","cambiarSeleccion()",$conSitio,"--TODOS--","");
   $selSitio=$sitio->retornar();
}	


if ($_POST[selGerencia]!=100 && $_POST[selSitio]!=100){	
	$conEstatuSolicitud="SELECT DISTINCT STATUS_SOLICITUD.ID_STATUS,DES_STATUS FROM STATUS_SOLICITUD
                         INNER JOIN SOLICITUD_EQUIPO ON STATUS_SOLICITUD. ID_STATUS=SOLICITUD_EQUIPO.ID_STATUS
                         INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA                                 
                         INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
                         INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
                         INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
                         INNER JOIN GERENCIA ON GERENCIA.ID_GERENCIA=DIVISION.ID_GERENCIA
                         WHERE SITIO.ID_SITIO LIKE '%$_POST[selSitio]'";    
    $estatusSolicitud= new campoSeleccion("selEstatuSolicitud","formularioCampoSeleccion","$_POST[selEstatuSolicitud]","onChange","cambiarSeleccion()",$conEstatuSolicitud,"--TODOS--","");
    $selEstatuSolicitud=$estatusSolicitud->retornar(); 
}    

$consultaUsuario="SELECT SOLICITUD_EQUIPO.FICHA,CONCAT(USUARIO.NOMBRE_USUARIO,' ',USUARIO.APELLIDO_USUARIO) FROM SOLICITUD_EQUIPO
                 INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA";
$usuario= new campoSeleccion("selUsuario","formularioCampoSeleccion","$_POST[selUsuario]","onChange","cambiarSeleccion()",$consultaUsuario,"--TODOS--","");
$selUsuario=$usuario->retornar();

$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10","","");
$txtFechaInicio=$fechaInicio->retornar();
$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
$txtFechaFinal=$fechaFinal->retornar();

 echo "<form name=\"frmSolicitudes\" method=\"post\" action=\"\">"; 
 echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
 echo "<input name=\"seleccion\" type=\"hidden\" value=\"0\">";
 echo "<table class=\"formularioTabla\"align=center width=\"600\" border=0>"; 
 echo "<td class=\"tituloPagina\" colspan=\"2\">REPORTES</td></tr>";
 echo "<tr>";
 echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">REPORTE DE SOLICITUDES</td></tr>"; 
 echo "<td class=\"formularioCampoTitulo\" valign=top>GERENCIA<br>$selGerencia<br>EDIFICIO<br>$selSitio<br>ESTATUS SOLICITUD<br>$selEstatuSolicitud</td><br>
       <td class=\"formularioCampoTitulo\">USUARIO (FICHA, NOMBRE)<br>
       <input name=\"selUsuario\" type=\"text\" class=\"formularioCampoTitulo\" size=28 value=\"$_POST[selUsuario]\">       
       
       <input name=\"buscar\" type=\"button\" onclick=\"valorIntroducido()\" title=\"Buscar Usuario\" value=\"B\"><br>       
       FECHA INICIAL<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmSolicitudes.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\"></a><br>
       FECHA FINAL<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmSolicitudes.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\"></a><br>
       </td><br>";              
 echo "<table align=\"center\" width=\"500\">	          
	   <td class=\"formularioTablaBotones\" align=\"center\"><input name=\"boton\" type=\"submit\" value=\"BUSCAR\">
  	   </td></table>";   
 echo "</form>";		
}        				
?>        