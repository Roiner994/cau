<?php
require_once("seguridad.php");
?>

<style type="text/css">
<!--.Estilo10 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #FFFFFF;
	background:#CC6600;
}
.Estilo70 {color:  #FF0000; 	font-size:11px; font-family: Arial, Helvetica, sans-serif;}
.Estilo71 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #000000;
}!-->
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

echo "<html>";
echo "<head>";
echo "<title>BUSCAR USUARIO</title>";
?>
<script>	
	function cambiarSeleccion() {
	 document.frmSolicitudesNuevas.funcion.value=0;	
	 document.frmSolicitudesNuevas.seleccion.value=1; 	 
	 document.frmSolicitudesNuevas.submit();
    }
    function buscarFicha(){
    if (window.event.keyCode==13){	    	
       if (document.frmSolicitudesNuevas.ficha.value!="") {
		   document.frmSolicitudesNuevas.funcion.value=0;
	       document.frmSolicitudesNuevas.submit();
	   }
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
    function onClick() {     	   	    
		   document.frmSolicitudesNuevas.funcion.value=0;
	       document.frmSolicitudesNuevas.submit();    	  	    
    }      
    function no() {
	document.frmSolicitudesNuevas.funcion.value=6;	
	document.frmSolicitudesNuevas.submit();	
    }      
    //Función para almacenar en el campo de texto solo numeros 
    function soloNumero(){ 
    var key=window.event.keyCode;//codigo de tecla. 
    if (key < 48 || key > 57){//si no es numero  
       window.event.keyCode=0;//anula la entrada de texto. 
    }
    }           
</script>
<?php
//SE PASA POR ESTE SWITCH CADA VEZ QUE SE REALIZA UN SUBMIT EN LA PAGINA
switch ($_POST[funcion]) {
	    case "1":	        
			if ($_POST[ficha]==""){
				if ($sw==1) {
			    $mensaje=$mensaje."<b>,</b>";
	         	}
		        $mensaje=$mensaje." <b>FICHA</b>";
		        $i++;
		        $sw=1;    
            }
            if ($_POST[selEquipoComponente]=="100"){
            	if ($sw==1) {
			    $mensaje=$mensaje."<b>,</b>";
	         	}
		        $mensaje=$mensaje." <b>EQUIPOS O COMPONENTES</b>";
		        $i++;
		        $sw=1;    
            }	
                      
            if ($_POST[selMotivo]=="100"){
            	if ($sw==1) {
			    $mensaje=$mensaje."<b>,</b>";
	         	}
		        $mensaje=$mensaje." <b>MOTIVO SOLICITUD</b>";
		        $i++;
		        $sw=1;    
            }	
            if ($_POST[txtObservacion]==""){
            	if ($sw==1) {
			    $mensaje=$mensaje."<b>,</b>";
	         	}
		        $mensaje=$mensaje." <b>	OBSERVACION</b>";
		        $i++;
		        $sw=1;    
            }
            if (isset($_POST[selSitio]) && $_POST[selSitio]==100) {
				if ($sw==1) {
					$mensaje=$mensaje."<b>,</b>";
				}
				$mensaje=$mensaje." <b>UBICACION</b>";
				$i++;
				$sw=1;
			}
			if (isset($_POST[selGerencia]) && $_POST[selGerencia]==100) {
				if ($sw==1) {
					$mensaje=$mensaje."<b>,</b>";
				}
				$mensaje=$mensaje." <b>GERENCIA</b>";
				$i++;
				$sw=1;
			}
			if (isset($_POST[selDivision]) && $_POST[selDivision]==100) {
				if ($sw==1) {	
					$mensaje=$mensaje."<b>,</b>";
				}
				$mensaje=$mensaje." <b>DIVISION</b>";
				$i++;
				$sw=1;
			}
			if (isset($_POST[selDepartamento]) && $_POST[selDepartamento]==100) {
				if ($sw==1) {
					$mensaje=$mensaje."<b>,</b>";
				}
				$mensaje=$mensaje." <b>DEPARTAMENTO</b>";
				$i++;
				$sw=1;
			}	            
            switch($i) {
            	case 0:            	                  
                  $login=$_SESSION["login"];                     
            	  $consulta="SELECT ID_SOLICITUD FROM solicitud_equipo ORDER BY ID_SOLICITUD DESC";
                  $idConsecutivo= new consecutivo("SOL", $consulta);
                  $IdSolicitud=$idConsecutivo->retornar();
            	  $fechaInicio=getdate();            	  
	              $fechaInicio=$fechaInicio[year]."-".$fechaInicio[mon]."-".$fechaInicio[mday]." ".$fechaInicio[hours].":".$fechaInicio[minutes].":".$fechaInicio[seconds];								
	              $_POST[txtObservacion]=strtoupper($_POST[txtObservacion]);	              
	              $sql = "INSERT INTO solicitud_equipo(ID_SOLICITUD, FICHA, CENTRO_COSTO, ID_DESCRIPCION, ID_MOTIVO_SOLICITUD, 
	                                                   ID_STATUS, STATUS, ID_USS, FECHA_I, FECHA_M, OBSERVACION_SOLICITUD) 
                          VALUES('$IdSolicitud','$_POST[ficha]','','$_POST[selEquipoComponente]','$_POST[selMotivo]','STA0000003', 'STA0000003','$login','$fechaInicio','$fechaInicio','$_POST[txtObservacion]')";
                  $result=mysql_query($sql);
                  $consulta1="UPDATE usuario set ID_CARGO='$_POST[selCargo]',ID_DEPARTAMENTO='$_POST[selDepartamento]',ID_SITIO='$_POST[selSitio]',EXTENSION='$_POST[txtExtension]' 
                              WHERE FICHA='$_POST[ficha]'";                 
                  mysql_query($consulta1);
                  $consultar="select solicitud_historico.ID_HISTORICO from solicitud_historico order by solicitud_historico.ID_HISTORICO desc";
            	  $idConsecutivo= new consecutivo("IDH", $consultar);
                  $idSolicitud=$idConsecutivo->retornar();            	
                  $insertarHistorico="insert into solicitud_historico (ID_HISTORICO,ID_SOLICITUD, ID_USS, OBSERVACION, FECHA_HISTORICO) 
            	                      values ('$idSolicitud','$IdSolicitud','$login','$_POST[txtObservacion]','$fechaInicio')";                            	
            	  $resultHistorico=mysql_query($insertarHistorico); 
                 echo "<br><br>";
                  echo "<form name=\"frmSolicitudesNuevas\" method=\"post\" action=\"\">";
				  echo "<input name=\"ficha\" type=\"hidden\" value=\"$_POST[ficha]\">";
				  echo "<input name=\"txtUsuario\" type=\"hidden\" value=\"$_POST[txtUsuario]\">";
				  echo "<input name=\"txtCedula\" type=\"hidden\" value=\"$_POST[txtCedula]\">";
				  echo "<input name=\"txtExtension\" type=\"hidden\" value=\"$_POST[txtExtension]\">";
				  echo "<input name=\"selCargo\" type=\"hidden\" value=\"$_POST[selCargo]\">";
				  echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				  echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";					
				  echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
				  echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";				  
                  echo "<form name=\"frmDesperfectos\" method=\"post\" action=\"\">";	
                  echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
			      echo "<table class=\"mensajeTitulo\" align=center width=\"700\" border=\"0\">";
			      echo "<tr>";
				  echo "<td align=center>MENSAJE: NUEVA - SOLICITUD</td></tr>";
				  echo "<tr>";
				  echo "<td valign=top class=\"mensaje\" align=center>CARGO LA SOLICITUD DE EQUIPO Nº:<b>$IdSolicitud</b></td>";
				  echo "</tr><td class=\"mensaje\" align=center>¿DESEA SEGUIR CARGANDOLE SOLICITUD A: <b>$_POST[txtUsuario]?</b></td>";
				  echo "<tr><td align=\"center\"><input name=\"btnSi\" type=\"submit\" value=\"SI\"\">		
			            <INPUT name=\"btnNo\" type=\"button\" value=\"NO\" onClick=\"no()\"></td></table></form>";
            	break 1;
            	case 1:
            	echo "<br><br><br><br>";
					echo "<form name=\"frmDesperfectos\" method=\"post\" action=\"\">";
					echo "<input name=\"ficha\" type=\"hidden\" value=\"$_POST[ficha]\">";
					echo "<input name=\"txtUsuario\" type=\"hidden\" value=\"$_POST[txtUsuario]\">";
					echo "<input name=\"txtCedula\" type=\"hidden\" value=\"$_POST[txtCedula]\">";
					echo "<input name=\"txtExtension\" type=\"hidden\" value=\"$_POST[txtExtension]\">";
					echo "<input name=\"selCargo\" type=\"hidden\" value=\"$_POST[selCargo]\">";
					echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
					echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";					
					echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
					echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
					echo "<input name=\"selEquipoComponente\" type=\"hidden\" value=\"$_POST[selEquipoComponente]\">";
					echo "<input name=\"selMotivo\" type=\"hidden\" value=\"$_POST[selMotivo]\">";
					echo "<input name=\"txtObservacion\" type=\"hidden\" value=\"$_POST[txtObservacion]\">";		
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: NUEVAS - SOLICITUDES</td>
							</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>EL CAMPO ".$mensaje. " ESTÁ VACIO</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";	
					break 1;					
            default:
					echo "<br><br><br><br>";
					echo "<form name=\"frmDesperfectos\" method=\"post\" action=\"\">";
					echo "<input name=\"ficha\" type=\"hidden\" value=\"$_POST[ficha]\">";
					echo "<input name=\"txtUsuario\" type=\"hidden\" value=\"$_POST[txtUsuario]\">";
					echo "<input name=\"txtCedula\" type=\"hidden\" value=\"$_POST[txtCedula]\">";
					echo "<input name=\"txtExtension\" type=\"hidden\" value=\"$_POST[txtExtension]\">";
					echo "<input name=\"selCargo\" type=\"hidden\" value=\"$_POST[selCargo]\">";
					echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
					echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";					
					echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
					echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
					echo "<input name=\"selEquipoComponente\" type=\"hidden\" value=\"$_POST[selEquipoComponente]\">";
					echo "<input name=\"selMotivo\" type=\"hidden\" value=\"$_POST[selMotivo]\">";
					echo "<input name=\"txtObservacion\" type=\"hidden\" value=\"$_POST[txtObservacion]\">";		
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: NUEVAS - SOLICITUDES</td>
							</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>LOS CAMPOS ".$mensaje. " ESTAN VACIOS</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";				            	
            }	       	    	                      
          echo "</form>";          	           			
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
conectarMysql();
if (isset($_POST[ficha]) && !empty($_POST[ficha])) {
   $busca= "SELECT USUARIO.FICHA,USUARIO.CEDULA,CONCAT(USUARIO.NOMBRE_USUARIO,' ',USUARIO.APELLIDO_USUARIO) AS USUARIO,
                   GERENCIA.ID_GERENCIA,GERENCIA.GERENCIA,DIVISION.ID_DIVISION,DIVISION.DIVISION,USUARIO.EXTENSION,
                   CARGO.ID_CARGO,CARGO.CARGO,DEPARTAMENTO.ID_DEPARTAMENTO,DEPARTAMENTO.DEPARTAMENTO,SITIO.ID_SITIO,SITIO.SITIO
			FROM USUARIO
			INNER JOIN CARGO ON USUARIO.ID_CARGO=CARGO.ID_CARGO
			INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
			INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
			INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA
			INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
			WHERE USUARIO.FICHA = '$_POST[ficha]'";	         	       
   $rs=mysql_query($busca);
   if (mysql_num_rows($rs)==0){
       $_POST[txtUsuario]="";
       $_POST[txtCedula]="";
       $_POST[txtExtension]="";
       $_POST[selCargo]="";            	      	
       $_POST[selGerencia]="";            		     		 
       $_POST[selDivision]="";
       $_POST[selDepartamento]="";
       $_POST[selSitio]=$arreglo="";              		            		    	
   }			                    
   if ($arreglo=mysql_fetch_array($rs)){
   	   if ($_POST[seleccion]!=1){
                 $_POST[txtUsuario]=$arreglo[2];
           	     $_POST[txtCedula]=$arreglo[1];
           		 $_POST[txtExtension]=$arreglo[7];
           		 $_POST[selCargo]=$arreglo[8];            	      	
           		 $_POST[selGerencia]=$arreglo[3];            		     		 
           		 $_POST[selDivision]=$arreglo[5];
           		 $_POST[selDepartamento]=$arreglo[10];
           		 $_POST[selSitio]=$arreglo[12];              		            		 
      }	        
   }	
   $consulta="select * from solicitud_equipo where solicitud_equipo.ficha='$_POST[ficha]'";     
   $consultaValor=mysql_query($consulta);
   $numeroRow=mysql_num_rows($consultaValor);
   if ($numeroRow >0){
         echo "<br><iframe src=\"../librerias/pagDeEncabezado.php?ficha=$_POST[ficha]&gerencia=$_POST[selGerencia]&division=$_POST[selDivision]&departamento=$_POST[selDepartamento]\" name=\"frame\" marginwidth=\"0\"   
               marginheight=\"0\" scrolling=\"auto\" frameborder=\"no\"  hspace=\"0\" vspace=\"0\" align=\"center\"
	           style=\"position:relative; width:700px; height:140px; center: 0px; top: 0px;\" ALLOWTRANSPARENCY=\"true\">
	           </iframe>";                  	 	 	            	
   }      
}
$conEquipoComponente="select id_descripcion,descripcion from descripcion order by descripcion";
$equipoComponente= new campoSeleccion("selEquipoComponente","formularioCampoSeleccion","$_POST[selEquipoComponente]","onChange","",$conEquipoComponente,"--SELECCIONE--","");
$selEquipoComponente=$equipoComponente->retornar();  
$consultaMotivo="SELECT id_motivo_solicitud, Motivo_solicitud FROM Motivo_solicitud where Motivo_Solicitud.id_motivo_solicitud='MOT0000001'
	             OR Motivo_Solicitud.id_motivo_solicitud='MOT0000002' OR Motivo_Solicitud.id_motivo_solicitud='MOT0000003' ORDER BY Motivo_solicitud";
$motivo= new campoSeleccion("selMotivo","formularioCampoSeleccion","$_POST[selMotivo]","onChange","",$consultaMotivo,"--SELECCIONE--","");
$selMotivo=$motivo->retornar();
$conSitio="select id_sitio,sitio from sitio where status_activo=1 order by sitio.sitio";
$conGerencia="select id_gerencia,gerencia from gerencia where status_activo=1 order by gerencia";
$conDivision="select id_division,division from division where id_gerencia='$_POST[selGerencia]' and status_activo=1 order by division";
$conDepartamento="select id_departamento, departamento from departamento where id_division='$_POST[selDivision]' and status_activo=1 ORDER BY departamento";

$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--UBICACION--","");
$selSitio=$sitio->retornar();

$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","cambiarSeleccion()",$conGerencia,"--GERENCIA--","");
$selGerencia=$gerencia->retornar();

$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","cambiarSeleccion()",$conDivision,"--DIVISION--","");
$selDivision=$division->retornar();

$departamento= new campoSeleccion("selDepartamento","formularioCampoSeleccion","$_POST[selDepartamento]","onChange","cambiarSeleccion()",$conDepartamento,"--DEPARTAMENTO--","");
$selDepartamento=$departamento->retornar();

$conCargo="select id_cargo,cargo from cargo where status_cargo='1' order by cargo";
$cargo= new campoSeleccion("selCargo","formularioCampoSeleccion","$_POST[selCargo]","onChange","cambiarSeleccion()",$conCargo,"--CARGO--","");
$selCargo=$cargo->retornar(); 

 echo "<form name=\"frmSolicitudesNuevas\" method=\"post\" action=\"\">"; 
 echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
 echo "<input name=\"seleccion\" type=\"hidden\" value=\"0\">";
 echo "<table class=\"formularioTabla\"align=center width=\"500\" border=0>"; 
 echo "<td class=\"tituloPagina\" colspan=\"2\">SOLICITUDES</td></tr>";
 echo "<tr>";
 echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">NUEVA SOLICITUD</td></tr>"; 
 echo "<td valign=top class=\"formularioCampoTitulo\">FICHA<br> 
       <input name=\"ficha\" type=\"text\" class=\"formularioCampo\" size=\"10\" maxlength=\"\" value=\"$_POST[ficha]\" onKeyPress=\"buscarFicha()\">
       <input name=\"buscar\" type=\"button\" title=\"Buscar Ficha\" value=\"B\" onclick=\"onClick()\"><br>
       USUARIO<br><input name=\"txtUsuario\" type=\"text\" readonly=\"true\" class=\"formularioCampo\" size=\"60\" maxlength=\"\" value=\"$_POST[txtUsuario]\"><br>
       CEDULA<br><input name=\"txtCedula\" type=\"text\" readonly=\"true\" class=\"formularioCampo\" size=\"60\" maxlength=\"\" value=\"$_POST[txtCedula]\"><br>
       EXTENSION<br><input name=\"txtExtension\" type=\"text\" class=\"formularioCampo\" size=\"60\" maxlength=\"\" value=\"$_POST[txtExtension]\" onKeyPress=\"soloNumero()\"><br>
       CARGO<br>$selCargo<br></td>
       <td class=\"formularioCampoTitulo\">GERENCIA<br>$selGerencia<br>DIVISIÓN<br>$selDivision<br>DEPARTAMENTO<br>$selDepartamento<br>
       UBICACIÓN<br>$selSitio<br>EQUIPOS O COMPONENTES<br>$selEquipoComponente<br>MOTIVO SOLICITUD<br>$selMotivo</td><br>       
       <tr><td colspan=\"2\" class=\"formularioCampoTitulo\">OBSERVACION<br><textarea name=\"txtObservacion\" cols=\"77\" rows=\"3\">$_POST[txtObservacion]</textarea><br></td><br>"; 
 echo "<table align=\"center\" width=\"500\">	          
	   <td class=\"formularioTablaBotones\" align=\"center\"><input name=\"boton\" type=\"submit\" value=\" CARGAR SOLICITUD\">
  	   </td></table>";   
 echo "</table></form>";		
}
?>        