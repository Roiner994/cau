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
 require_once "alineacion.php";
 require_once "libreriaScript2.php"; 
 require_once "../librerias/formularios.php";
 ?>

 <?
  switch ($_POST["funcion"]) {
	case "0":		
	validar2();	   	
	break 1;
	case "1":
		 if(!empty($_POST['campo'])) { 
    	 $aLista=$_POST['campo'];
		 $valores="'".implode(',',$aLista)."'";
		 $valores=str_replace(',','\',\'',$valores);
		 //echo $valores;		
		 $_SESSION[valores]=$valores;		
		 conectarMysql();
		 $conSolicitud="select id_solicitud,descripcion,concat(NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUARIO,extension,gerencia,departamento,sitio from solicitud_equipo inner join usuario on solicitud_equipo.ficha=usuario.ficha inner join descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion inner join ubicacion on usuario.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia inner join division on ubicacion.id_division= division.id_division inner join departamento on ubicacion.id_departamento=departamento.id_departamento inner join sitio on ubicacion.id_sitio=sitio.id_sitio inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status WHERE id_solicitud IN ($valores) ORDER BY sitio DESC";
		 $result=mysql_query($conSolicitud);   	     
		 //$_SESSION[conSolicitud]=$conSolicitud;
		 inicioTabla();				         		 
		 while ($row=mysql_fetch_array($result)) {				 		 
		 equiposEncontrados($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6]);			 		
		 }		
		 //$_SESSION[conSolicitud]=$conSolicitud;
		  echo "<table border=\"1\" align=\"center\"><td>
		  <input name=\"imprimir\" type=\"button\" class=\"Estilo71\" value=\"Imprimir\" onClick=\"window.open('../librerias/pdfAprobadasPorInstalar.php')\">		  
		  <input type=\"reset\" value=\"Cancelar\" class=\"Estilo71\" onClick=\" history.go(-1)\"></td></table>";		  		  
		 mysql_close();
		}
		else {
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
		      </tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>SELECCIONE POR LO MENOS UN CAMPO</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\" onClick=\" history.go(-1)\"></td>";
		echo "</tr>";
		echo "</table>";
		}	    	 	  
	break 1;	
	default:	
	   fecha(); 
}
 function fecha(){
 echo "<form name=\"f1\" method=\"post\" action=\"\">";
 arribaAlinear("left");	
    echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"0\">".
    "<TD bgColor=\"#FFFFFF\">".
    "<FONT face=\"Verdana\" size=\"1\">".
    "<td class=\"Estilo71\" <b>SOLICITUDES APROBADAS POR INSTALAR</td></b></td>".
    "</FONT></TD></TABLE>";
 abajoAlinear();		          
	echo "<br>";		
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
<option value=\"09\">Septiembre</option>
<option value=\"10\">Octubre</option>
<option value=\"11\">Noviembre</option>
<option value=\"12\">Diciembre</option>
</select>

<select name=\"year\" class=\"Estilo71\" onChange=\"populate(this.form,this.form.month.selectedIndex);\" size=\"1\">
<option>2004</option><option  selected>2005</option><option>2006</option><option>2007</option>
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
<option>2004</option><option  selected>2005</option><option>2006</option><option>2007</option>
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
	
function validar2(){
	$FechaI="$_POST[year]-$_POST[month]-$_POST[day]";	
	$FechaF="$_POST[year1]-$_POST[month1]-$_POST[day1]";	
	$_SESSION[fechaI]="$_POST[day]-$_POST[month]-$_POST[year]";
	$_SESSION[fechaF]="$_POST[day1]-$_POST[month1]-$_POST[year1]";
	 echo "<form name=\"frmMarca\" method=\"post\" action=\"\">";
	 echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";		
	 if ($_POST[year] <= $_POST[year1]){
	    if ($_POST[year1] > $_POST[year] && $_POST[day]!='' && $_POST[day1]!=''){
		      $consulta="select id_solicitud,solicitud_equipo.ficha,concat(NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUARIO,descripcion,gerencia,division,departamento,sitio,fecha_i from solicitud_equipo inner join usuario on solicitud_equipo.FICHA=usuario.FICHA inner join descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion inner join ubicacion on usuario.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia inner join division on ubicacion.id_division= division.id_division inner join departamento on ubicacion.id_departamento=departamento.id_departamento inner join sitio on ubicacion.id_sitio=sitio.id_sitio inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status where fecha_i>='$FechaI' and fecha_i<='$FechaF' and  status_solicitud.id_status ='STA0000003'  order by sitio desc";
		      conectarMysql();
	          $result=mysql_query($consulta);
			  $num=mysql_num_rows($result);	          
			  if ($num < 1){
			   echo"<table width=\"400\" border=\"1\" bordercolor=\"#CC6600\" align=\"center\" class=\"Estilo71\">
                    <tr><td><div align=\"center\"><p><strong>No se Tiene Registros en Este Rango de Fecha...</strong></p><p><strong></strong></p>
                    </div></td></tr></table>";				 
	          }	
			  else{
			  /*echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\" height=\"15\" align=\"center\" >";
              echo "<TR vAlign=\"top\">";
              echo "<td width=\"800\" class=\"Estilo74\" align=\"center\" background=\"bgimage_over.jpg\">";
              echo"<b>SOLICITUDES POR INSTALAR</b></td>";   	   	 	*/
              inicioTabla();             
	          while($row=mysql_fetch_array($result)) {	          	          
		      echo "<tr>";
 			  echo "<td class=\"Estilo71\"><input name=\"campo[]\" type=\"checkbox\" value=\"$row[0]\">$row[0]</td>
			  <td class=\"Estilo71\" align=\"center\">$row[3]</td>			  
			  <td class=\"Estilo71\" align=\"center\">$row[2]</td>
			  <td class=\"Estilo71\" align=\"center\">$row[1]</td>			  
			  <td class=\"Estilo71\" align=\"center\">$row[4]</td>		   	 	 			  
 			  <td class=\"Estilo71\" align=\"center\">$row[5]</td>		   	 			   	 	
 			  <td class=\"Estilo71\" align=\"center\">$row[6]</td>";		   	 	
			  //echo "</table>";
			  }
			  echo"<CENTER>";                 
			  echo "<table border=\"1\"><td>
			  <input name=\"btn\" type=\"submit\" class=\"Estilo71\" value=\"ACEPTAR\"></td></table>";
			  }			  
	     }
		else  if ($_POST[month] <= $_POST[month1]){             
               if ($_POST[day]!='' && $_POST[day1]!=''){      		
	            if ($_POST[day] <= $_POST[day1] || $_POST[day] >= $_POST[day1]){
                 $consulta="select id_solicitud,solicitud_equipo.ficha,concat(NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUARIO,descripcion,gerencia,division,departamento,sitio,fecha_i from solicitud_equipo inner join usuario on solicitud_equipo.FICHA=usuario.FICHA inner join descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion inner join ubicacion on usuario.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia inner join division on ubicacion.id_division= division.id_division inner join departamento on ubicacion.id_departamento=departamento.id_departamento inner join sitio on ubicacion.id_sitio=sitio.id_sitio inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status where fecha_i>='$FechaI' and fecha_i<='$FechaF' and  status_solicitud.id_status ='STA0000003'  order by sitio desc";				        	         			     				 
				 conectarMysql();
			     $result=mysql_query($consulta);	
			     $num=mysql_num_rows($result);
	            if ($num < 1){
				 echo"<table width=\"400\" border=\"1\" bordercolor=\"#CC6600\" align=\"center\" class=\"Estilo71\">
                      <tr><td><div align=\"center\"><p><strong>No se Tiene Registros en Este Rango de Fecha...</strong></p><p><strong></strong></p>
                      </div></td></tr></table>";						  				  
	            }
				else{	   	   	 
				echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\" height=\"15\" align=\"center\">";
                echo "<TR vAlign=\"top\">";
                echo "<td width=\"800\" colspan=\"6\" class=\"Estilo74\" align=\"center\">";
                echo"<b>SOLICITUDES POR INSTALAR</b></td></tr>";			 
			   inicioTabla1();
	           while($row=mysql_fetch_array($result)) {				    
			   $fecha=substr($row[8],8,2).'-'.substr($row[8],5,2).'-'.substr($row[8],0,4); 	  	   
			   echo "<tr>";             		      			  
			   echo "<td class=\"Estilo71\"><input name=\"campo[]\" type=\"checkbox\" value=\"$row[0]\">$row[0]</td>
			   <td class=\"Estilo71\" align=\"center\">$row[1]</td>
			   <td width=\"250\" class=\"Estilo71\" align=\"center\">$row[2]</td>
			   <td width=\"200\" class=\"Estilo71\" align=\"center\">$row[3]</td>
			   <td width=\"200\" class=\"Estilo71\" align=\"center\">$row[4]</td>
			   <td width=\"200\" class=\"Estilo71\" align=\"center\">$row[5]</td>
			   <td width=\"200\" class=\"Estilo71\" align=\"center\">$row[6]</td>
			   <td width=\"180\" class=\"Estilo71\" align=\"center\">$row[7]</td>
			   <td width=\"120\" class=\"Estilo71\" align=\"center\">$fecha</td>";		   	 
			   echo "</tr>";
			   }			 			  
			   echo "<CENTER>   
               <TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\">   
               <TR vAlign=\"top\">
		       <TD bgcolor=\"#ECE9D8\"><FONT face=\"Verdana\" size=\"1\"></td>
			   <td><input name=\"btn\" type=\"submit\" class=\"Estilo71\" value=\"ACEPTAR\"></td></table>";
			   }
			   }  		      			  
		       else{
			   arribaAlinear("center");
			   echo"<table width=\"300\" border=\"1\" bordercolor=\"#6699ff\" align=\"center\">".
               "<tr>"."<td bgcolor=\"#ffffff\">"."<div align=\"center\">".
               "<p><strong>Existen Campos Vacios Seleccionelos</strong></p>".              
               "<input type=\"button\" name=\"boton\" class=\"Estilo71\" value=\"Volver\" onClick=\"history.go(-1)\">".              
               " <p>"."<strong>"."</strong>"."</p>".
               "</div>"."</td>"."</tr>".
               "</table>";
			   abajoAlinear();
			  }		  			  			  
	    } 		
		else {
		 arribaAlinear("center");
		 echo"<table width=\"300\" border=\"1\" bordercolor=\"#CC6600\" align=\"center\">".
         "<tr>"."<td bgcolor=\"#ffffff\">"."<div align=\"center\">".
         "<p><strong>Existen Campos Vacios Seleccionelos</strong></p>".
         "<input type=\"button\" name=\"boton\" class=\"Estilo71\" value=\"Volver\" onClick=\"history.go(-1)\">".
         " <p>"."<strong>"."</strong>"."</p>".
         "</div>"."</td>"."</tr>".
         "</table>";
		 abajoAlinear();}			 

	}
	else{
	arribaAlinear("center");
	echo"<table width=\"300\" border=\"1\" bordercolor=\"#CC6600\" align=\"center\">".
         "<tr>"."<td bgcolor=\"#ffffff\">"."<div align=\"center\">".
         "<p><strong>Existen Campos Vacios Seleccionelos</strong></p>".
         "<input type=\"button\" name=\"boton\" class=\"Estilo71\" value=\"Volver\" onClick=\"history.go(-1)\">".
         " <p>"."<strong>"."</strong>"."</p>".
         "</div>"."</td>"."</tr>".
         "</table>";
	abajoAlinear();}		
    }
	   
	else{
	arribaAlinear("center");
	echo"<table width=\"300\" border=\"1\" bordercolor=\"#CC6600\" align=\"center\">".
         "<tr>"."<td bgcolor=\"#ffffff\">"."<div align=\"center\">".
         "<p><strong>Existen Campos Vacios Seleccionelos</strong></p>".
         "<input type=\"button\" name=\"boton\" class=\"Estilo71\" value=\"Volver\" onClick=\"history.go(-1)\">".
         " <p>"."<strong>"."</strong>"."</p>".
         "</div>"."</td>"."</tr>".
         "</table>";
	abajoAlinear();
	}	
  echo "</form>";	       	     
}				
function inicioTabla() {	
    echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\" height=\"15\" align=\"center\">";
    echo "<TR vAlign=\"top\">";
    echo "<td width=\"800\" class=\"Estilo74\" align=\"center\">";
    echo"<b>SOLICITUDES POR INSTALAR</b></td>";
	echo "<table width=\"803\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">".
	"<tr class=\"Estilo10\">".
	"<th width=\"\"  scope=\"col\">SOLICITUD</th>".
	"<th width=\"\"  scope=\"col\">EQUIPO</th>".	
	"<th width=\"\"  scope=\"col\">USUARIO</th>".	
	"<th width=\"\"  scope=\"col\">FICHA</th>".	
    "<th width=\"\"  scope=\"col\">GERENCIA</th>".
	"<th width=\"\"  scope=\"col\">DEPARTAMENTO</th>".	
	"<th width=\"\"  scope=\"col\">EDIFICIO</th>";	
	echo "</tr>";		
}

function equiposEncontrados($Solicitud,$Equipo,$Usuario,$Extension,$Gerencia,$Departamento,$Sitio) {
	echo "<tr>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Solicitud</a></td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Equipo</td>";	;
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Usuario</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Extension</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Gerencia</td>";	
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Departamento</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Sitio</td>";	
	echo "</tr>";
	echo "<input name=\"oculta2\" type=\"hidden\" value=\"$conf\">";		
}

function inicioTabla1() {	
echo "<table width=\"803\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">".
	"<tr class=\"Estilo10\">".
	"<tr class=\"Estilo10\">".
	"<th width=\"\">SOLICITUD</th>".
	"<th width=\"\">FICHA</th>".
	"<th width=\"\">USUARIO</th>".
	"<th width=\"\">EQUIPO</th>".
	"<th width=\"\">GERENCIA</th>".
	"<th width=\"\">DIVISION</th>".
	"<th width=\"\">DEPARTAMENTO</th>".
    "<th width=\"\">EDIFICIO</th>".
	"<th width=\"\">FECHA</th>";
	echo "</tr>";		
}		
?>