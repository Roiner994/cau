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
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"ACEPTAR\"></td>";
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
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"ACEPTAR\"></td>";
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
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"ACEPTAR\"></td>";
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
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"ACEPTAR\"></td>";
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
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"ACEPTAR\"></td>";
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

/*function imprimirPagina() {
//window.open("reporteFechas.php"); 
//window.close("reporteFechas.php")  
  var ventimp = window.open('reporteSolicitudesEjecutadas.php');  
  //ventimp.document.write( ficha.innerHTML );
  //ventimp.document.close();
  //ventimp.print( );
  //ventimp.close();
  ventimp.print();
  ventimp.close(); 
//parent.location.href="reporteFechas.php"

}*/		
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
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
<?php   		   
function rangoFecha(){
echo "<form name=\"f1\" method=\"post\" action=\"\">";
echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
echo "<table class=\"formularioTabla\"align=center width=\"580\" border=\"0\">";
	echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">SOLICITUDES</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">SOLICITUDES EJECUTADAS</td>
			
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>";  			
/*echo "<SCRIPT LANGUAGE=\"JavaScript\">
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
</form>";*/
$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10","","");
$txtFechaInicio=$fechaInicio->retornar();		
$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
$txtFechaFinal=$fechaFinal->retornar();		
echo "<tr align=center></tr></tr>  
<td valign=top class=\"formularioCampoTitulo\" >
FECHA INICIAL:$txtFechaInicio<a href=\"javascript:show_calendar('f1.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\"></a><br>
FECHA FINAL:&nbsp;&nbsp;&nbsp;$txtFechaFinal<a href=\"javascript:show_calendar('f1.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\"></a><br></td>";
echo "<tr>";
echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnBuscar\" title=\"Buscar solicitudes ejecutadas en la base de datos\" type=\"submit\" value=\"BUSCAR\">	 
     <input name=\"Limpiar\" title=\"Cancelar solicitud ejecutada\" type=\"button\" value=\"CANCELAR\" onclick=\"fuera()\"></td>";

}




function validarFecha(){	
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
$FechaI="$_POST[year]-$_POST[month]-$_POST[day]";	
$FechaF="$_POST[year1]-$_POST[month1]-$_POST[day1]";	
	 echo "<form name=\"f1\" method=\"post\" action=\"\">";
	 echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";		
	 if ($anno2 > $anno1){	    
	 	$fechaI=substr($_POST[txtFechaInicio],6,4)."-". substr($_POST[txtFechaInicio],3,2)."-". substr($_POST[txtFechaInicio],0,2);
		$fechaF=substr($_POST[txtFechaFinal],6,4)."-". substr($_POST[txtFechaFinal],3,2)."-". substr($_POST[txtFechaFinal],0,2);			 			
	    $consulta="select id_solicitud,concat(NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUARIO,fecha_i,descripcion,gerencia,sitio from solicitud_equipo 
		           inner join usuario on solicitud_equipo.FICHA=usuario.FICHA inner join descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion 
		           inner join ubicacion on usuario.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia inner 
		           join division on ubicacion.id_division= division.id_division inner join departamento on ubicacion.id_departamento=departamento.id_departamento 
		           inner join sitio on ubicacion.id_sitio=sitio.id_sitio inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status 
		           where (fecha_i >= '$fechaI' and fecha_i <= '$fechaF') and (status_solicitud.id_status ='STA0000004' OR status_solicitud.id_status ='STA0000005')";		     			
  		conectarMysql();   
		$result=mysql_query($consulta);			           
           $num=mysql_num_rows($result);	          
			  if ($num < 1){
			  	 echo"<table width=\"400\" bordercolor=\"#CC6600\" align=\"center\" class=\"Estilo71\">
                      <tr><td><div align=\"center\"><p><strong>No se Tiene Registros en Este Rango de Fecha...</strong></p><p><strong></strong></p>
                      </div></td></tr></table>";						  				  
			  }				  
			  else{	
			  rangoFecha();			   		  			  
			  echo "<table width=\"803\" align=\"center\">";			  
		      echo "<tr>";
			  echo "<td class=\"formularioTablaTitulo\" colspan=\"6\">SOLICITUDES EJECUTADAS</td></tr>";
	          echo "<tr>";			  
				"<tr class=\"Estilo10\">".
				"<th class=\"Estilo10\" scope=\"col\">SOLICITUD</th>".
				"<th class=\"Estilo10\" scope=\"col\">USUARIO</th>".
				"<th class=\"Estilo10\" scope=\"col\">FECHA SOLICITUD</th>".
				"<th class=\"Estilo10\" scope=\"col\">EQUIPO</th>".	
				"<th class=\"Estilo10\" scope=\"col\">GERENCIA</th>".	
				"<th class=\"Estilo10\" scope=\"col\">SITIO</th>";	
				echo "</tr>";		
			    $result=mysql_query($consulta);
	           while($row=mysql_fetch_array($result)) {				    
	           	if ($i%2==0) {
				 $clase="tablaFilaPar";
				} else {
				 $clase="tablaFilaNone";
				}	          
				$i++; 	
	           	$fechaSus=substr($row[2],8,2)."-". substr($row[2],5,2)."-". substr($row[2],0,4);
	           	echo"<tr class=\"$clase\">
				<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$row[0]</a></td>
				<td  width=\"200\"align=\"center\" valign=\"middle\" class=\"Estilo71\">$row[1]</td>
				<td  width=\"100\"align=\"center\" valign=\"middle\" class=\"Estilo71\">$fechaSus</td>
				<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$row[3]</td>
				<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$row[4]</td>		
				<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$row[5]</td>	
				</tr>
				<input name=\"oculta2\" type=\"hidden\" value=\"$conf\">
		        <tr>";			  			     
	     }
	     echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\" align=\"center\"><TR vAlign=\"top\"> 
         	   <TD bgcolor=\"#ECE9D8\"><FONT face=\"Verdana\" size=\"1\">	
               <input name=\"imprimir\" type=\"button\" class=\"Estilo71\" value=\"Imprimir\" onClick=\"window.open('../librerias/pdfSolicitudesEjecutadas.php')\">";		  		            
			   echo "</td></table>";			  
			  
	  }		
  echo "</form>";        
}				
}
?>
