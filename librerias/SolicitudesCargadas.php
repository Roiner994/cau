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
	background:#CC6600;
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
	background:#CC6600;
}	
</style>
<?php
require_once "formularios.php";
require_once "administracion.php";
require_once "alineacion.php";
?>
<script>
 //funcion que guarda los valores seleccionados o escritos
	function BuscarMarca() {	
		
		
		var indiceStatus=document.frmSolicitudesAprobadas.selStatus.selectedIndex;
		var valorStatus=document.frmSolicitudesAprobadas.selStatus.options[indiceStatus].value;
						
		var valorAsignacion=document.frmSolicitudesAprobadas.txtAsignacion.value;
					
		var ruta="SolicitudesAprobadas.php?"+"IdAsignacion="+valorAsignacion+"&IdStatus="+valorStatus;
		if (valorAsignacion!=100) {
			window.location=ruta;
		}
	}
	//funcion que valida que todos los campos esten llenos para poder cargar la solicitud
	function ValidarCampos() {
			
				
		var indiceStatus=document.frmSolicitudes.selStatus.selectedIndex;
		var valorStatus=document.frmSolicitudes.selStatus.options[indiceStatus].value;

		var val=0;
		
		if (document.frmSolicitudes.txtAsignacion.value=="") {
			val=1;
		}
		
		if (valorStatus=='100') {
			val=1;
		}
		if (val==1) {
			window.alert("EXISTE UN CAMPO VACIO");
		}
		else {
			document.frmSolicitudes.submit();
		}
	}	
</script>

<?PHP
  switch ($_POST["funcion"]) {
	case "0":
	validarFecha();			   	
	break 1;	
	default:	
	  rangoFecha();
}
?>

<?php  		   
function inicioTabla2() { 
    echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\" height=\"15\" align=\"center\">";
    echo "<TR vAlign=\"top\">";
    echo "<td width=\"800\" class=\"Estilo74\" align=\"left\">";
    echo"<b>SOLICITUDES CARGADAS</b></td></table>";     
	echo "<table width=\"803\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">".
	"<tr  class=\"Estilo10\"><th>SOLICITUD</th><th>STATUS</th><th>EQUIPO</th><th>FICHA</th>
	<th>NOMBRE</th><th>EXTENSION</th><th>GERENCIA</th><th>SITIO</th><th>OBSERVACION</th>";	
	echo "</tr>";		
}

function rangoFecha(){
echo "<form name=\"f1\" method=\"post\" action=\"\">";
arribaAlinear("left");	
echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"0\">".
"<TD bgColor=\"#FFFFFF\">".
"<FONT face=\"Verdana\" size=\"1\">".
"<td class=\"Estilo71\" <b>SOLICITUDES CARGADAS</td></b></td>".
"</FONT></TD></TABLE>";
abajoAlinear();		     
echo "<SCRIPT LANGUAGE=\"JavaScript\">
function populate(objForm,selectIndex) {
timeA = new Date(objForm.year.options[objForm.year.selectedIndex].text, objForm.month.options[objForm.month.selectedIndex].value,1);
timeDifference = timeA - 86400000;
timeB = new Date(timeDifference);
var daysInMonth = timeB.getDate();
for (var i = 0; i < objForm.day.length; i++) {
objForm.day.options[0] = null;
}
for (var i = 0; i < daysInMonth; i++) {
objForm.day.options[i] = new Option(i+1);
}
document.f1.day.options[0].selected = true;
}
function getYears() {
var years = new Array(1997,1998,1999,2000,2001,2002, 2003, 2004, 2005, 2006)
for (var i = 0; i < document.f1.year.length; i++) {
document.f1.year.options[0] = null;
}
timeC = new Date();
currYear = timeC.getFullYear();
for (var i = 0; i < years.length; i++) {
document.f1.year.options[i] = new Option(years[i]);
}
document.f1.year.options[2].selected=true;
}
window.onLoad = getYears;


function populate1(objForm,selectIndex) {
timeA = new Date(objForm.year1.options[objForm.year1.selectedIndex].text, objForm.month1.options[objForm.month1.selectedIndex].value,1);
timeDifference = timeA - 86400000;
timeB = new Date(timeDifference);
var daysInMonth = timeB.getDate();
for (var i = 0; i < objForm.day1.length; i++) {
objForm.day1.options[0] = null;
}
for (var i = 0; i < daysInMonth; i++) {
objForm.day1.options[i] = new Option(i+1);
}
document.f1.day1.options[0].selected = true;
}
function getYears1() {
var years = new Array(1997,1998,1999,2000,2001,2002, 2003, 2004, 2005, 2006)
for (var i = 0; i < document.f1.year1.length; i++) {
document.f1.year1.options[0] = null;
}
timeC = new Date();
currYear = timeC.getFullYear();
for (var i = 0; i < years.length; i++) {
document.f1.year1.options[i] = new Option(years[i]);
}
document.f1.year1.options[2].selected=true;
}
window.onLoad = getYears1;
</script>";
echo "</head>";

echo "<center>
<table border=\"1\">
<TR vAlign=\"top\">
<TD bgColor=\"#FFFFFF\" class=\"Estilo71\">
<form name=\"f1\">
<table border=\"1\">
<TR vAlign=\"top\">
<TD bgColor=\"#FFFFFF\" class=\"Estilo71\">
<FONT face=\"Verdana\" size=\"1\">
<b>FECHA-INICIAL:</b></FONT></TD>
<TD align=\"left\" bgColor=\"#FFFFFF\">
<FONT face=\"Verdana\" size=\"1\">
<td align=\"center\">
<select name=\"day\" class=\"Estilo71\">
<option>  </option>
<option>  </option>
<option>  </option>
<option>  </option>
<option>  </option>
<option>  </option>
<option>  </option>
</select>

<select name=\"month\" class=\"Estilo71\" onChange=\"populate(this.form,this.selectedIndex);\">
<option value=\"01\">Enero</option>
<option value=\"02\">Febrero</option>
<option value=\"03\">Marzo</option>
<option value=\"04\">Abril</option>
<option value=\"05\">Mayo</option>
<option value=\"06\">Junio</option>
<option value=\"07\">Julio</option>
<option value=\"08\">Agosto</option>
<option value=09>Septiembre</option>
<option value=\"10\">Octubre</option>
<option value=\"11\">Noviembre</option>
<option value=\"12\">Diciembre</option>
</select>

<select name=\"year\" class=\"Estilo71\" onChange=\"populate(this.form,this.form.month.selectedIndex);\" size=\"1\">
<option selected>2005</option><option>2006</option><option>2007</option>
<option>2008</option><option>2009</option><option>2010</option>
<option>2011</option><option>2012</option><option>2013</option>
<option>2014</option></option><option>2015</option>
</select><FONT face=\"Verdana\" size=\"1\"><td class=\"Estilo71\" <b>FORMATO: DD/MM/AAAA</td></b></td>
</FONT>
</tr>
</center>
<center>
<TR vAlign=\"top\">
<TD bgColor=\"#FFFFFF\" class=\"Estilo71\">
<FONT face=\"Verdana\" size=\"1\">
<b>FECHA-FINAL:</b></FONT></TD>
<TD align=\"left\" bgColor=\"#FFFFFF\">
<FONT face=\"Verdana\" size=\"1\">
<td align=\"center\">
<select name=\"day1\" class=\"Estilo71\">
<option>  </option>
<option>  </option>
<option>  </option>
<option>  </option>
<option>  </option>
<option>  </option>
<option>  </option>
</select>

<select name=\"month1\" class=\"Estilo71\" onChange=\"populate1(this.form,this.selectedIndex);\">
<option value=\"01\">Enero</option>
<option value=\"02\">Febrero</option>
<option value=\"03\">Marzo</option>
<option value=\"04\">Abril</option>
<option value=\"05\">Mayo</option>
<option value=\"06\">Junio</option>
<option value=\"07\">Julio</option>
<option value=\"08\">Agosto</option>
<option value=09>Septiembre</option>
<option value=\"10\">Octubre</option>
<option value=\"11\">Noviembre</option>
<option value=\"12\">Diciembre</option>
</select>
<select name=\"year1\" class=\"Estilo71\" onChange=\"populate1(this.form,this.form.month.selectedIndex);\" size=\"1\">
<option selected>2005</option><option>2006</option><option>2007</option>
<option>2008</option><option>2009</option><option>2010</option>
<option>2011</option><option>2012</option><option>2013</option>
<option>2014</option></option><option>2015</option>
</select><FONT face=\"Verdana\" size=\"1\"><td class=\"Estilo71\"<b>FORMATO: DD/MM/AAAA</td></b></td>
</FONT>
</td>
</tr>
</table>
</td><center>
<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\">    
<TR vAlign=\"top\">
<TD bgColor=\"#FFFFFF\" class=\"Estilo71\">
<FONT face=\"Verdana\" size=\"1\">
<input name=\"funcion\" type=\"hidden\" value=\"0\">
<input name=\"btnAlmacenar\" type=\"submit\" class=\"Estilo71\" value=\"Buscar\"></tr>
</CENTER></TABLE>
</form>";
}

function validarFecha(){
	conectarMysql();	
	$FechaI="$_POST[year]-$_POST[month]-$_POST[day]";	
	$FechaF="$_POST[year1]-$_POST[month1]-$_POST[day1]";	
	$_SESSION[fechaI]="$_POST[year]-$_POST[month]-$_POST[day]";
	$_SESSION[fechaF]="$_POST[year1]-$_POST[month1]-$_POST[day1]";
	 echo "<form name=\"SolicitudesCargadas\" method=\"post\" action=\"\">";	           	 		
	 echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";		
	 if ($_POST[year] <= $_POST[year1]){
	    if ($_POST[year1] > $_POST[year] && $_POST[day]!='' && $_POST[day1]!=''){
		$consulta="select id_solicitud,des_status,descripcion,solicitud_equipo.ficha,concat(NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUARIO,extension,gerencia,sitio,observacion_solicitud 
		from solicitud_equipo inner join usuario on solicitud_equipo.ficha=usuario.ficha inner join descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion 
		inner join ubicacion on usuario.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia inner join departamento on ubicacion.id_departamento=departamento.id_departamento 
		inner join sitio on ubicacion.id_sitio=sitio.id_sitio inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status 
		where  fecha_i  between '$FechaI' and '$FechaF' AND (status_solicitud.id_status ='STA0000001' OR status_solicitud.id_status ='STA0000002' OR status_solicitud.id_status ='STA0000003' OR status_solicitud.id_status ='STA0000004' OR status_solicitud.id_status ='STA0000005' OR status_solicitud.id_status ='STA0000006') order by solicitud_equipo.id_solicitud asc";		     
	    $result=mysql_query($consulta);			           
           $num=mysql_num_rows($result);	          
			  if ($num < 1){
			  echo"<table width=\"400\" border=\"1\" bordercolor=\"#CC6600\" align=\"center\" class=\"Estilo71\">
                   <tr><td><div align=\"center\"><p><strong>No se Tiene Registros en Este Rango de Fecha..</strong></p><p><strong></strong></p>
                   </div></td></tr></table>";						  				  	
	          }	
			  else{
			  	inicioTabla2() ;			  			     	   	 	
	           while($row=mysql_fetch_array($result)) {			            			 
			    equiposEncontrados($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8]);
			   } 
			   $_SESSION[consulta]=$consulta;
			   echo "<table border=\"1\" align=\"center\"><td>
  		             <input name=\"imprimir\" type=\"button\" class=\"Estilo71\" value=\"Imprimir\" onClick=\"window.open('../librerias/pdfSolicitudesCargadas.php')\">
		             <input type=\"reset\" value=\"Cancelar\" class=\"Estilo71\" onClick=\" history.go(-1)\"></td></table>";		 		  			     
		      echo "<tr>";			  
			  }			  
	     }
		else  if ($_POST[month] <= $_POST[month1]){             
               if ($_POST[day]!='' && $_POST[day1]!=''){      		
	            if ($_POST[day] <= $_POST[day1] || $_POST[day] >= $_POST[day1]){
                $consulta="select id_solicitud,des_status,descripcion,solicitud_equipo.ficha,concat(NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUARIO,extension,gerencia,sitio,observacion_solicitud from solicitud_equipo 
				           inner join usuario on solicitud_equipo.ficha=usuario.ficha inner join descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion 
						   inner join ubicacion on usuario.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia 
						   inner join departamento on ubicacion.id_departamento=departamento.id_departamento inner join sitio on ubicacion.id_sitio=sitio.id_sitio inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status where  (fecha_i >= '$FechaI' and fecha_i <= '$FechaF')and (status_solicitud.id_status ='STA0000001' OR status_solicitud.id_status ='STA0000002' OR status_solicitud.id_status ='STA0000003' OR status_solicitud.id_status ='STA0000004' OR status_solicitud.id_status ='STA0000005' OR status_solicitud.id_status ='STA0000006') order by gerencia asc";
			     conectarMysql();
			     $result=mysql_query($consulta);	
			     $num=mysql_num_rows($result);
	             if ($num < 1){
			      echo"<table width=\"400\" border=\"1\" bordercolor=\"#CC6600\" align=\"center\" class=\"Estilo71\">
                       <tr><td><div align=\"center\"><p><strong>No se Tiene Registros en Este Rango de Fecha..</strong></p><p><strong></strong></p>
                       </div></td></tr></table>";						  				  	
	             }
				 else{
					inicioTabla2(); 					 			  	   	 
	                while($row=mysql_fetch_array($result)) {				   			 
			        equiposEncontrados($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8]);  			   			         	
					}
        			$_SESSION[consulta]=$consulta;
					echo "<table border=\"1\" align=\"center\"><td>
  		                  <input name=\"imprimir\" type=\"button\" class=\"Estilo71\" value=\"Imprimir\" onClick=\"window.open('../librerias/pdfSolicitudesCargadas.php')\">
		                  <input type=\"reset\" value=\"Cancelar\" class=\"Estilo71\" onClick=\" history.go(-1)\"></td></table>";		 		  			  					
				 }		
			   echo "<tr>";             		      			  
			   echo "</td></table>";	  			   		      	
			  }  		      			  
		      else{
			  echo"<table width=\"400\" border=\"1\" bordercolor=\"#CC6600\" align=\"center\" class=\"Estilo71\">
                   <tr><td><div align=\"center\"><p><strong>Error en el Rango de Fechas...</strong></p><p><strong></strong></p>
                   </div></td></tr></table>";						  				  	
			  }		  			  			  
	    } 		
		else {
		  echo"<table width=\"400\" border=\"1\" bordercolor=\"#CC6600\" align=\"center\" class=\"Estilo71\">
               <tr><td><div align=\"center\"><p><strong>Error en el Rango de Fechas...</strong></p><p><strong></strong></p>
               </div></td></tr></table>";						  				  	 
        }
	}
	else{
	      echo"<table width=\"400\" border=\"1\" bordercolor=\"#CC6600\" align=\"center\" class=\"Estilo71\">
               <tr><td><div align=\"center\"><p><strong>Error en el Rango de Fechas...</strong></p><p><strong></strong></p>
               </div></td></tr></table>";						  				  	
	}		
    }
	   
	else{
     	  echo"<table width=\"400\" border=\"1\" bordercolor=\"#CC6600\" align=\"center\" class=\"Estilo71\">
               <tr><td><div align=\"center\"><p><strong>Error en el Rango de Fechas...</strong></p><p><strong></strong></p>
               </div></td></tr></table>";						  				  	
	}	
  echo "</form>";  
}				

function equiposEncontrados($Solicitud,$Status,$Equipo,$Ficha,$Nombre,$Extension,$Gerencia,$Sitio,$Observacion) {
	echo "<tr>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Solicitud</a></td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Status</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Equipo</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Ficha</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Nombre</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Extension</td>";	
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Gerencia</td>";	
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Sitio</td>";	
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Observacion</td>";	
	echo "</tr>";
	echo "<input name=\"oculta2\" type=\"hidden\" value=\"$conf\">";
}
?>
