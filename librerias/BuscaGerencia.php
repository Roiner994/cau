<?php
session_cache_limiter ( 'private' );	
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
	color: #FFFFFF;
	background:#CC6600;
}
.Estilo11 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #000000;
	background:#ffffff;
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
<?PHP
include "alineacion.php";
//include "conexionsql.php";
include "administracion.php";
include "formularios.php";
echo "<html>";
echo "<head>";
?>
<script>
	function BuscarGerencia() {
	
		var indiceGerencia = document.frmBuscaGerencia.selGerencia.selectedIndex;
		var valorGerencia = document.frmBuscaGerencia.selGerencia.options[indiceGerencia].value;
		
							
		var ruta="BuscaGerencia.php?"+"IdGerencia="+valorGerencia;
		if (valorGerencia!=100) {
			window.location=ruta;
		}
	}
	function ValidarCampos() {
			
		var indiceGerencia = document.frmBuscaGerencia.selGerencia.selectedIndex;
		var valorGerencia = document.frmBuscaGerencia.selGerencia.options[indiceGerencia].value;
		
		
		var MENSAJE="EL CAMPO ";
		var val=0;
		
		
		if (valorGerencia=='100') {
			val=1;
		}
		
		if (val==1) {
			window.alert("SELECCIONE UN CAMPO");
		}
		else {
			document.frmBuscaGerencia.submit();
		}
	}	
</script>
<?PHP
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
?>

<?PHP

if (isset($conf) && !empty($conf)) {
	if ($_POST[funcion]!=2) {
		$_POST[funcion]=2;
	}
}
 switch($_POST["funcion"]) {  
   case "1": 
   buscar_gerencia($_POST["selGerencia"]);				 
   break 1;  
   case "2":
     busqueda($conf);
   break 1;
   default:
    busca();
} 

 function busca(){      
	conectarMysql();
	$consultaGerencia = "SELECT id_gerencia, gerencia FROM gerencia ORDER BY gerencia ASC";	
	$RsGerencia=mysql_query($consultaGerencia);	    
	arribaAlinear("left");	
    echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"0\">".
    "<TD bgColor=\"#FFFFFF\">".
    "<FONT face=\"Verdana\" size=\"1\">".
    "<td class=\"Estilo71\" <b>SOLICITUDES POR GERENCIA</td></b></td>".
    "</FONT></TD>";
    abajoAlinear();	
	echo "<form name=\"f1\" method=\"post\" action=\"\">";	
   	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">" ;
	echo"<tr>";
	echo "<CENTER>";
	echo "<TABLE  border=\"1\">";    
	echo "<TR vAlign=\"top\">";
    echo "<TD bgColor=\"#FFFFFF\" class=\"Estilo71\" >";
    echo "<FONT face=\"Verdana\" size=\"1\">";
    echo "<b>GERENCIAS:</b></FONT></TD>";
    echo "<TD align=\"left\" bgColor=\"#FFFFFF\">";
    echo "<FONT face=\"Verdana\" size=\"1\">"; 	
	echo "<select name=\"selGerencia\"  class=\"Estilo11\" >";
	echo "<option value=\"100\">-TODAS-</option>";	
	while ($row=mysql_fetch_array($RsGerencia)) {
		if ($row[0]==$IdGerencia) {
			echo "<option selected value=$row[0]>$row[1]</option>";	
		}
		else {
			echo "<option value=$row[0]>$row[1]</option>";
		}
	}
echo "</select>";	
echo "</CENTER>";	           	
echo "<center>
<TR vAlign=\"top\">
<TD bgColor=\"#FFFFFF\" class=\"Estilo71\">
<FONT face=\"Verdana\" size=\"1\">
<b>FECHA-INICIAL:</b></FONT>
<td align=\"center\" class=\"Estilo11\">
<select name=\"day\" class=\"Estilo11\">
<option>  </option>
<option>  </option>
<option>  </option>
<option>  </option>
<option>  </option>
<option>  </option>
<option>  </option>
</select>

<select name=\"month\" class=\"Estilo11\" onChange=\"populate(this.form,this.selectedIndex);\">
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

<select name=\"year\" class=\"Estilo11\" onChange=\"populate(this.form,this.form.month.selectedIndex);\" size=\"1\">
<option selected>2005</option><option>2006</option><option>2007</option>
<option>2008</option><option>2009</option><option>2010</option>
<option>2011</option><option>2012</option><option>2013</option>
<option>2014</option></option><option>2015</option>
</select><FONT face=\"Verdana\" size=\"1\"><td class=\"Estilo11\" <b>FORMATO: DD/MM/AAAA</b></td><tr>
</center>
<TD bgColor=\"#FFFFFF\" class=\"Estilo71\">
<FONT face=\"Verdana\" size=\"1\">
<b>FECHA-FINAL:</b></FONT></TD>
<td align=\"center\">
<select name=\"day1\" class=\"Estilo11\">
<option>  </option>
<option>  </option>
<option>  </option>
<option>  </option>
<option>  </option>
<option>  </option>
<option>  </option>
</select>

<select name=\"month1\" class=\"Estilo11\" onChange=\"populate1(this.form,this.selectedIndex);\">
<option value=\"01\">Enero</option>
<option value=\"02\">Febrero</option>
<option value=\"03\">Marzo</option>
<option value=\"04\">Abril</option>
<option value=\"05\">Mayo</option>
<option value=\"06\">Junio</option>
<option value=\"07\">Julio</option>
<option value=\"08\">Agosto</option>
<option value=\"09\">Septiembre</option>
<option value=\"10\">Octubre</option>
<option value=\"11\">Noviembre</option>
<option value=\"12\">Diciembre</option>
</select>
<select name=\"year1\" class=\"Estilo11\" onChange=\"populate1(this.form,this.form.month.selectedIndex);\" size=\"1\">
<option selected>2005</option><option>2006</option><option>2007</option>
<option>2008</option><option>2009</option><option>2010</option>
<option>2011</option><option>2012</option><option>2013</option>
<option>2014</option></option><option>2015</option>
</select><FONT face=\"Verdana\" size=\"1\"><td class=\"Estilo71\"<b>FORMATO: DD/MM/AAAA</b></td>
</table>";

echo"<center><TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\">    
<TR vAlign=\"top\">
<TD bgColor=\"#FFFFFF\" class=\"Estilo71\">
<FONT face=\"Verdana\" size=\"1\">
<input name=\"btnAlmacenar\" type=\"submit\" class=\"Estilo71\" value=\"Buscar\"></tr>
</CENTER>
</form>";	
}
	
function buscar_gerencia($valor_busqueda){
$FechaI="$_POST[year]-$_POST[month]-$_POST[day]";
$FechaF="$_POST[year1]-$_POST[month1]-$_POST[day1]";	
     conectarMysql(); 
	 echo "<form name=\"frmBuscaGerencia\" method=\"post\" action=\"\">";
     echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">" ; 
	 $cuentaConsulta="SELECT  count(id_solicitud) as total from solicitud_equipo inner join ubicacion on usuario.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where (gerencia.id_gerencia LIKE '%$_POST[selGerencia]') AND (fecha_i >= '$FechaI') AND (fecha_i <= '$FechaF')";	 	 
	 $consulta="select id_solicitud,gerencia,descripcion,fecha_i,des_status,concat(NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUARIO from solicitud_equipo inner join usuario on  solicitud_equipo.ficha=usuario.ficha inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where (gerencia.id_gerencia LIKE '%$_POST[selGerencia]') AND (fecha_i >= '$FechaI') AND (fecha_i <= '$FechaF') ORDER BY gerencia asc";		             	 	 		  
	 $result=mysql_query($consulta);    
	 $row1=mysql_fetch_array($result);
	 if ($_POST[year] <= $_POST[year1] && $_POST[month] <= $_POST[month1] && $_POST[day] <= $_POST[day1] && $_POST[day]!='' && $_POST[day1]!=''){		              	 
	   if($_POST[selGerencia]!='100') {	   
	     $num=mysql_num_rows($result);
	     if ($num < 1){
		 echo"<table width=\"350\" border=\"1\" bordercolor=\"#CC6600\" align=\"center\">".
         "<tr>"."<td bgcolor=\"#ffffff\">"."<div align=\"center\">".
         "<p><strong>No se Tiene Registros en Este Rango de Fecha...</strong></p>".    
         " <p>"."<strong>"."</strong>"."</p>".
         "</div>"."</td>".
         "</tr>".
         "</table>";
	     }
		else{ 			   	   	    
	     echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\" height=\"15\" align=\"center\">";
         echo "<TR vAlign=\"top\">";
         echo "<td width=\"796\" class=\"Estilo74\" align=\"left\">";
         echo"SOLICITUDES POR GERENCIAS <b>($row1[1])</b></td>";        	    			 
	     echo "</table>";	   	  
	   inicioTabla(); 	
	   $result=mysql_query($consulta);    
	   while($row1=mysql_fetch_array($result)){	  
	     equiposEncontrados($row1[0],$row1[4],$row1[2],$row1[5],$row1[3]);       	               
	   }
	   //$cuentaConsulta1="SELECT  solicitud_equipo.id_status,count(*) from solicitud_equipo inner join status_solicitud on solicitud_equipo.status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where (gerencia.id_gerencia LIKE '%') AND (fecha_i >= '2005-10-01') AND (fecha_i <= '2005-11-30') group by solicitud_equipo.id_status";
	   $cuentaConsulta1="SELECT  count(solicitud_equipo.id_status) as total1 from solicitud_equipo inner join status_solicitud on solicitud_equipo.status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where (solicitud_equipo.status='STA0000001') AND (gerencia.id_gerencia LIKE '%$_POST[selGerencia]') AND (fecha_i >= '$FechaI') AND (fecha_i <= '$FechaF')"; 
	   $cuentaConsulta2="SELECT  count(solicitud_equipo.id_status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where (solicitud_equipo.id_status='STA0000002') AND (gerencia.id_gerencia LIKE '%$_POST[selGerencia]')  AND (fecha_i >= '$FechaI') AND (fecha_i <= '$FechaF')";
	   $cuentaConsulta3="SELECT  count(solicitud_equipo.id_status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where (solicitud_equipo.id_status='STA0000003') AND (gerencia.id_gerencia LIKE '%$_POST[selGerencia]')  AND (fecha_i >= '$FechaI') AND (fecha_i <= '$FechaF')";
	   $cuentaConsulta4="SELECT  count(solicitud_equipo.id_status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where (solicitud_equipo.id_status='STA0000004') AND (gerencia.id_gerencia LIKE '%$_POST[selGerencia]')  AND (fecha_i >= '$FechaI') AND (fecha_i <= '$FechaF')";
 	   $cuentaConsulta5="SELECT  count(solicitud_equipo.id_status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where (solicitud_equipo.id_status='STA0000005') AND (gerencia.id_gerencia LIKE '%$_POST[selGerencia]')  AND (fecha_i >= '$FechaI') AND (fecha_i <= '$FechaF')";
	   $cuentaConsulta6="SELECT  count(solicitud_equipo.id_status)as total6 from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where (solicitud_equipo.id_status='STA0000006') AND (gerencia.id_gerencia LIKE '%$_POST[selGerencia]')  AND (fecha_i >= '$FechaI') AND (fecha_i <= '$FechaF')";	        
	   $result=mysql_query($cuentaConsulta);	
	   $result1=mysql_query($cuentaConsulta1);	  
	   $result2=mysql_query($cuentaConsulta2);
	   $result3=mysql_query($cuentaConsulta3);
	   $result4=mysql_query($cuentaConsulta4); 		
	   $result5=mysql_query($cuentaConsulta5); 
	   $result6=mysql_query($cuentaConsulta6);	 	
	   inicioTabla1();	
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
	}
	else if($_POST[selGerencia]=='100' && $_POST[day] !='' && $_POST[day1] !=''){	
	 $_POST[selGerencia]='';   	  
     conectarMysql(); 	
     $consulta1="select id_solicitud,gerencia,descripcion,fecha_i,des_status,concat(NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUARIO from solicitud_equipo 
	 inner join usuario on  solicitud_equipo.ficha=usuario.ficha inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status 
	 inner join ubicacion on usuario.id_ubicacion=ubicacion.id_ubicacion inner join descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion 
	 inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where (gerencia.id_gerencia LIKE '%$_POST[selGerencia]') AND (fecha_i >= '$FechaI') AND (fecha_i <= '$FechaF') ORDER BY gerencia asc";		             	 	 		  	 
	 $cuentaConsulta="SELECT  count(id_solicitud) as total from solicitud_equipo inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where (fecha_i >= '$FechaI') AND (fecha_i <= '$FechaF') ";    	  
	 $cuentaConsulta1="SELECT  count(solicitud_equipo.status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where (solicitud_equipo.status='STA0000001') AND (fecha_i >= '$FechaI') AND (fecha_i <= '$FechaF')"; 
	 $cuentaConsulta2="SELECT  count(solicitud_equipo.id_status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where (solicitud_equipo.id_status='STA0000002') AND (fecha_i >= '$FechaI') AND (fecha_i <= '$FechaF')";
	 $cuentaConsulta3="SELECT  count(solicitud_equipo.id_status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where (solicitud_equipo.id_status='STA0000003') AND (fecha_i >= '$FechaI') AND (fecha_i <= '$FechaF')";
	 $cuentaConsulta4="SELECT  count(solicitud_equipo.id_status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where (solicitud_equipo.id_status='STA0000004') AND (fecha_i >= '$FechaI') AND (fecha_i <= '$FechaF')";
 	 $cuentaConsulta5="SELECT  count(solicitud_equipo.id_status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where (solicitud_equipo.id_status='STA0000005') AND (fecha_i >= '$FechaI') AND (fecha_i <= '$FechaF')";
	 $cuentaConsulta6="SELECT  count(solicitud_equipo.id_status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where (solicitud_equipo.id_status='STA0000006') AND (fecha_i >= '$FechaI') AND (fecha_i <= '$FechaF')";	  	 
	 $result1=mysql_query($consulta1);	 
	 $num=mysql_num_rows($result1);
	     if ($num < 1){
		 echo"<table width=\"350\" border=\"1\" bordercolor=\"#CC6600\" align=\"center\">".
         "<tr>"."<td bgcolor=\"#ffffff\">"."<div align=\"center\">".
         "<p><strong>No se Tiene Registros en Este Rango de Fecha...</strong></p>".    
         " <p>"."<strong>"."</strong>"."</p>".
         "</div>"."</td>".
         "</tr>".
         "</table>";
	     }
		else{ 
		 echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\" height=\"15\" align=\"center\">";
           echo "<TR vAlign=\"top\">";
           echo "<td width=\"796\" class=\"Estilo74\" align=\"left\">";
           echo"<b>SOLICITUD POR GERENCIAS (-TODAS-)</b></td>";        	    			 
	       echo "</table>";	 		   	    			
	    inicioTabla2();
		$result1=mysql_query($consulta1); 
	    while($row1=mysql_fetch_array($result1)){
	    equiposEncontrados($row1[0],$row1[4],$row1[2],$row1[5],$row1[1]);       	               
	    }		  
	    $result=mysql_query($cuentaConsulta);	
	    $result1=mysql_query($cuentaConsulta1);
	    $result2=mysql_query($cuentaConsulta2);
	    $result3=mysql_query($cuentaConsulta3);
	    $result4=mysql_query($cuentaConsulta4); 		
	    $result5=mysql_query($cuentaConsulta5); 
	    $result6=mysql_query($cuentaConsulta6); 		
	    inicioTabla1();	
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
	 }	  					   
	else{
	echo"<table width=\"300\" border=\"1\" bordercolor=\"#CC6600\" align=\"center\">".
    "<tr>"."<td bgcolor=\"#ffffff\">"."<div align=\"center\">".
    "<p><strong>Existen Campos Vacios Seleccionelos</strong></p>".
    "<form name=\"form1\" method=\"post\" action=\"\">".
    "<input type=\"button\" name=\"boton\" class=\"Estilo71\" value=\"Volver\" onClick=\"history.go(-1)\">".
    " </form>".
    " <p>"."<strong>"."</strong>"."</p>".
    "</div>"."</td>".
    "</tr>".
    "</table>";
    }
 
}
	else  if ($_POST[day]!='' && $_POST[day1]!=''){echo "<center><b>Error en el Rango De Fechas</b>";}
	     else{
	     echo"<table width=\"300\" border=\"1\" bordercolor=\"#CC6600\" align=\"center\">".
         "<tr>"."<td bgcolor=\"#ffffff\">"."<div align=\"center\">".
         "<p><strong>Existen Campos Vacios Seleccionelos</strong></p>".
         "<form name=\"form1\" method=\"post\" action=\"\">".
         "<input type=\"button\" name=\"boton\" class=\"Estilo71\" value=\"Volver\" onClick=\"history.go(-1)\">".
         " </form>".
         " <p>"."<strong>"."</strong>"."</p>".
         "</div>"."</td>".
         "</tr>".
         "</table>";}
echo "</form>";	 	  	    
mysql_close();
}


function inicioTabla() {	
	echo "<table width=\"800\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">".
	"<tr class=\"Estilo10\">".
	"<th width=\"100\"  scope=\"col\">SOLICITUD</th>".
	"<th width=\"100\"  scope=\"col\">STATUS</th>".
	"<th width=\"100\"  scope=\"col\">EQUIPO</th>".
	"<th width=\"100\"  scope=\"col\">USUARIO</th>".
	"<th width=\"100\"  scope=\"col\">FECHA</th>";
	echo "</tr>";
  
}
function inicioTabla2() {	
	echo "<table width=\"800\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">".
	"<tr class=\"Estilo10\">".
	"<th width=\"100\"  scope=\"col\">SOLICITUD</th>".
	"<th width=\"100\"  scope=\"col\">STATUS</th>".
	"<th width=\"100\"  scope=\"col\">EQUIPO</th>".
	"<th width=\"100\"  scope=\"col\">USUARIO</th>".
	"<th width=\"100\"  scope=\"col\">GERENCIA</th>";
	echo "</tr>";
  
}
function equiposEncontrados($Solicitud,$Status,$Equipo,$Usuario,$Gerencia) {
	echo "<tr>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\"><a href=\"secciones.php?item=204&conf=$Solicitud\">$Solicitud</a></td>";	
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Status</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Equipo</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Usuario</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Gerencia</td>";
	echo "</tr>";
}
function inicioTabla1() {
	echo "<table width=\"800\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">".
	"<tr class=\"Estilo10\">".
	"<th width=\"100\" bgcolor=\"#99CC99\">TOTAL  SOLICITUD</th>".
	"<th width=\"100\" scope=\"col\">SOLICITUD SIN PROCESAR</th>".
	"<th width=\"100\" scope=\"col\">SOLICITUD RECHAZADA</th>".
	"<th width=\"100\" bgcolor=\"#99CC99\">SOLICITUD APROBADA</th>".
	"<th width=\"100\" scope=\"col\">SOLICITUD EN PROCESO</th>".
	"<th width=\"100\" scope=\"col\">SOLICITUD EJECUTADA</th>".
	"<th width=\"100\" scope=\"col\">SOLICITUD EJECUTADA/SIN PTO RED</th>";
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
	         FROM solicitud_equipo inner join usuario on  solicitud_equipo.ficha=usuario.ficha inner join cargo on usuario.id_cargo=cargo.id_cargo inner join ubicacion on usuario.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia inner join departamento on ubicacion.id_departamento=departamento.id_departamento		inner join division on ubicacion.id_division=division.id_division inner join sitio on ubicacion.id_sitio=sitio.id_sitio  where solicitud_equipo.id_solicitud = '$conf'";	
 
   // $consulta="select  solicitud_equipo.id_solicitud,descripcion.descripcion,des_status,observacion_status,motivo_solicitud,observacion_solicitud from solicitud_equipo  inner join motivo_solicitud on solicitud_equipo.id_motivo_solicitud=motivo_solicitud.id_motivo_solicitud inner join descripcion on solicitud_equipo.id_descripcion =descripcion.id_descripcion  inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status where solicitud_equipo.ficha='$valor_busqueda'";				
	
	conectarMysql(); 
         	  
	$rs=mysql_query($busca);		
	inicioTabla3();				                    
    if ($row=mysql_fetch_array($rs)){			   								 		  			
				UsuarioEncontrado2($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7]); 		 			     	       
	}	
   echo "<CENTER>";   
   echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"2\">";   
   echo "<TR vAlign=\"top\">";
   echo "<TD bgcolor=\"#ECE9D8\">";
   echo "<FONT face=\"Verdana\" size=\"1\">";
   echo "<form action=\"\" method=\"post\" name=\"formulariovolver\">";
   echo "<input name=\"Volver\" type=\"button\" class=\"Estilo71\" value=\"Volver\" onClick=\"history.go(-1)\" >";   
   echo "</TABLE></form>";
   echo "</center>";
		
 mysql_close();
}	

function inicioTabla3() { 
    echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\" height=\"15\" align=\"center\">";
    echo "<TR vAlign=\"top\">";
    echo "<td width=\"796\" class=\"Estilo74\" align=\"left\">";
    echo"<b>SOLICITUD DE GERENCIA</b></td>";
    echo "</table>";       
	echo "<table width=\"800\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">".
	"<tr bgcolor=\"#0000FF\" class=\"Estilo10\">".
	"<th width=\"180\" scope=\"col\">FICHA</th>".	
	"<th width=\"180\" scope=\"col\">USUARIO</th>".	
	"<th width=\"180\" scope=\"col\">EXTENSION</th>".
    "<th width=\"180\" scope=\"col\">CARGO</th>".
	"<th width=\"180\" scope=\"col\">GERENCIA</th>".
	"<th width=\"700\" scope=\"col\">DIVISION</th>".
	"<th width=\"350\" scope=\"col\">DEPARTAMENTO</th>".
	"<th width=\"350\" scope=\"col\">SITIO</th>";
	echo "</tr>";
}

function UsuarioEncontrado2($Ficha,$Nombre,$Extension,$Cargo,$Gerencia,$Division,$Departamento,$Sitio) {	
	echo "<td align=\"center\" valign=\"middle\"class=\"Estilo71\">$Ficha</td>		
	<td align=\"center\" valign=\"middle\"class=\"Estilo71\">$Nombre</td>	
	<td align=\"center\" valign=\"middle\"class=\"Estilo71\">$Extension</td>
	<td align=\"center\" valign=\"middle\"class=\"Estilo71\">$Cargo</td>
	<td align=\"center\" valign=\"middle\"class=\"Estilo71\">$Gerencia</td>
	<td align=\"center\" valign=\"middle\"class=\"Estilo71\">$Division</td>
	<td align=\"center\" valign=\"middle\"class=\"Estilo71\">$Departamento</td>
	<td align=\"center\" valign=\"middle\"class=\"Estilo71\">$Sitio</td>
	</tr></td>";
	
}
?>