<?php
session_start();
$Acceso=array ("PRV0000001");
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
<style type="text/css">
.Estilo10 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #ffffff;
	background:#006699;
}
.Estilo70 {color:  #FF0000; 	font-size:11px; font-family: Arial, Helvetica, sans-serif;}
.Estilo71 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #000000;
}
.Estilo74 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #ffffff;
}	
</style>
<?php

require_once "../librerias/administracion.php";
require_once "../librerias/formularios.php";

if (isset($conf) && !empty($conf)) {
	if ($_POST[funcion]!=2) {
		$_POST[funcion]=1;
	}
}

 switch($_POST["funcion"]) {  
   case "1":   
     busqueda($conf);
   break 1;
   default:
    buscar_gerencia();
}


function buscar_gerencia(){ 
     conectarMysql(); 
	 echo "<form name=\"frmBuscaGerencia\" method=\"post\" action=\"\">";
     echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">" ; 
	 $cuentaConsulta="SELECT  count(id_solicitud) as total from solicitud_equipo inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia order by gerencia.id_gerencia asc";
	  
	 $cuentaConsulta1="SELECT  count(solicitud_equipo.status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where solicitud_equipo.status='STA0000001'"; 
	 $cuentaConsulta2="SELECT  count(solicitud_equipo.id_status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where solicitud_equipo.id_status='STA0000002' ";
	 $cuentaConsulta3="SELECT  count(solicitud_equipo.id_status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where solicitud_equipo.id_status='STA0000003' ";
	 $cuentaConsulta4="SELECT  count(solicitud_equipo.id_status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where solicitud_equipo.id_status='STA0000004' ";
 	 $cuentaConsulta5="SELECT  count(solicitud_equipo.id_status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where solicitud_equipo.id_status='STA0000005' ";
	 $cuentaConsulta6="SELECT  count(solicitud_equipo.id_status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where solicitud_equipo.id_status='STA0000006' ";	 
     $consulta= "select id_solicitud,gerencia,descripcion,fecha_i,des_status from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia ";		        
     $result=mysql_query($consulta);	
	 inicioTabla();
	 if ($result) {
	 	while($row1=mysql_fetch_array($result)){ 
		    $fecha=substr($row1[3],8,2).'-'.substr($row1[3],5,2).'-'.substr($row1[3],0,4);		            			 	    	
	    	equiposEncontrados($row1[0],$row1[4],$row1[2],$row1[1],$fecha);       	               
	  	}
	  }		  
	  $result=mysql_query($cuentaConsulta);	
	  $result1=mysql_query($cuentaConsulta1);
	  $result2=mysql_query($cuentaConsulta2);
	  $result3=mysql_query($cuentaConsulta3);
	  $result4=mysql_query($cuentaConsulta4); 		
	  $result5=mysql_query($cuentaConsulta5); 
	  $result6=mysql_query($cuentaConsulta6); 		
	  inicioTabla1();	
if ($result) {
	   if($row=mysql_fetch_array($result)){	      
		  if($row1=mysql_fetch_array($result1)){		    
		    if($row2=mysql_fetch_array($result2)){		      
			   if($row3=mysql_fetch_array($result3)){			     
			      if($row4=mysql_fetch_array($result4)){
                   	if($row5=mysql_fetch_array($result5)){
					 	if($row6=mysql_fetch_array($result6)){
						}
					}
			      }
			   }
		    }
		  }
		   equiposEncontrados1($row[0],$row6[0],$row2[0],$row1[0],$row3[0],$row4[0],$row5[0]);	
	   }		
}		
	 echo "</form>";	 	  	    
mysql_close();
}
function inicioTabla() {
    echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\" height=\"15\" align=\"center\">";
    echo "<TR vAlign=\"top\">";
    echo "<td width=\"800\" class=\"Estilo74\" align=\"center\" background=\"../librerias/bgimage_over.jpg\">";
    echo"<b>SOLICITUD DE GERENCIA</b></td>";
    echo "</table>";    
	echo "<table width=\"803\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">".
	"<tr class=\"Estilo10\">".
	"<th   scope=\"col\">SOLICITUD</th>".
	"<th   scope=\"col\">STATUS</th>".
	"<th   scope=\"col\">EQUIPO</th>".
	"<th   scope=\"col\">GERENCIA</th>".
	"<th   scope=\"col\">FECHA DE SOLICITUD</th>";
	echo "</tr>";
  
}

function equiposEncontrados($Solicitud,$Status,$Equipo,$Gerencia,$Fecha) {    
	echo "<tr>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\"><a href=\"secciones.php?item=208&conf=$Solicitud\">$Solicitud</a></td>";	
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Status</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Equipo</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Gerencia</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Fecha</td>";
	echo "</tr>";	
}

function inicioTabla1() {       
    echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\" height=\"15\" align=\"center\">"; 
	echo "<TR vAlign=\"top\">";  
    echo "<td width=\"800\" class=\"Estilo74\" align=\"center\" background=\"../librerias/bgimage_over.jpg\">";
    echo"<b>TOTAL DE SOLICITUD DE GERENCIA</b></td>";    
	echo "<table width=\"803\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">".
	"<tr bgcolor=\"#0000FF\" class=\"Estilo10\">".
	"<th width=\"100\"  scope=\"col\">TOTAL  SOLICITUD</th>".
	"<th width=\"100\"  scope=\"col\">SOLICITUD SIN PROCESAR</th>".
	"<th width=\"100\"  scope=\"col\">SOLICITUD RECHAZADA</th>".
	"<th width=\"100\"  scope=\"col\">SOLICITUD APROBADA</th>".
	"<th width=\"100\"  scope=\"col\">SOLICITUD EN PROCESO</th>".
	"<th width=\"100\"  scope=\"col\">SOLICITUD EJECUTADA</th>".
	"<th width=\"100\"  scope=\"col\">SOLICITUD EJECUTADA/SIN PTO RED</th>";
	echo "</tr>";

}

function equiposEncontrados1($Solicitud,$Proceso,$Aprobada,$EnProceso,$Rechazada,$Ejecutada,$Ejecutada2) {
	echo "<tr>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Solicitud</td>";	
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Proceso</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Aprobada</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$EnProceso</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Rechazada</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Ejecutada</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Ejecutada2</td>";
	echo "</tr>";	
}	


function busqueda($conf){
conectarMysql();   
    $busca= "SELECT solicitud_equipo.FICHA,concat(NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUARIO,EXTENSION,CARGO,GERENCIA,DEPARTAMENTO,DIVISION,SITIO
	        FROM solicitud_equipo inner join usuario on solicitud_equipo.ficha=usuario.ficha inner join cargo on usuario.id_cargo=cargo.id_cargo inner join ubicacion on usuario.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia inner join departamento on ubicacion.id_departamento=departamento.id_departamento inner join division on ubicacion.id_division=division.id_division inner join sitio on ubicacion.id_sitio=sitio.id_sitio  where solicitud_equipo.id_solicitud = '$conf'";		  
	conectarMysql();	         	  
	$rs=mysql_query($busca);
	inicioTabla2(); 							                    
    if ($row=mysql_fetch_array($rs)){			   								 		  			
				UsuarioEncontrado2($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7]); 		 			     	       
	}	
   echo "<CENTER>";
   echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"2\">";   
   echo "<TR vAlign=\"top\">";
   echo "<TD bgcolor=\"#ECE9D8\">";
   echo "<FONT face=\"Verdana\" size=\"1\">";
   echo "<form action=\"\" method=\"post\" name=\"formulariovolver\">";
   echo "<input name=\"Volver\" class=\"Estilo71\" align=\"center\" type=\"button\" value=\"Volver\" onClick=\"history.go(-1)\" >";
   echo "</TABLE></form>";		
   echo "</CENTER>";
 mysql_close();
}
//function que dibuja una tabla
function inicioTabla2() { 
    echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\" height=\"15\" align=\"center\">";
    echo "<TR vAlign=\"top\">";
    echo "<td width=\"800\" class=\"Estilo74\" background=\"../librerias/bgimage_over.jpg\">";
    echo"<b>SOLICITUD DE GERENCIA</b></td>";
    echo "</table>";       
	echo "<table width=\"803\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">".
	"<tr bgcolor=\"#0000FF\" class=\"Estilo10\">".
	"<th width=\"150\" scope=\"col\">FICHA</th>".	
	"<th width=\"400\" scope=\"col\">USUARIO</th>".	
	"<th width=\"150\" scope=\"col\">EXTENSION</th>".
    "<th width=\"250\" scope=\"col\">CARGO</th>".
	"<th width=\"300\" scope=\"col\">GERENCIA</th>".
	"<th width=\"300\" scope=\"col\">DIVISION</th>".
	"<th width=\"350\" scope=\"col\">DEPARTAMENTO</th>".
	"<th width=\"350\" scope=\"col\">SITIO</th>";
	echo "</tr>";
	}
	//funcion que recibe los valores que van a estar en la tabla
	function UsuarioEncontrado2($Ficha,$Nombre,$Extension,$Cargo,$Gerencia,$Division,$Departamento,$Sitio) {
	echo "<tr>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Ficha</td>";		
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Nombre</td>";	
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Extension</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Cargo</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Gerencia</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Division</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Departamento</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Sitio</td></table>";
	echo "</tr>";
	}

?>