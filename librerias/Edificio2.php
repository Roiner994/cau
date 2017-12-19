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
require_once"alineacion.php";
require_once"administracion.php";
echo "<html>";
echo "<head>";
echo "<title>Gerencia</title>";
?>
<script>
	function BuscarSitio() {
	
		var indiceSitio = document.frmEdificio2.selSitio.selectedIndex;
		var valorSitio = document.frmEdificio2.selSitio.options[indiceSitio].value;
		
							
		var ruta="Edificio.php?"+"IdSitio="+valorSitio;
		if (valorSitio!=100) {
			window.location=ruta;
		}
	}
	function ValidarCampos() {
			
		var indiceSitio = document.frmEdificio2.selSitio.selectedIndex;
		var valorSitio = document.frmEdificio2.selSitio.options[indiceSitio].value;
		
		
		var MENSAJE="EL CAMPO ";
		var val=0;
		
		
		if (valorSitio=='100') {
			val=1;
		}
		
		if (val==1) {
			window.alert("SELECCIONE UN CAMPO");
		}
		else {
			document.frmEdificio2.submit();
		}
	}		
/*function imprimirPagina() {
//window.open("reporteFechas.php"); 
//window.close("reporteFechas.php")  
  var ventimp = window.open('reporteEdificios.php');  
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
switch($_POST["funcion"]) {  
   case "1":
     buscar_edificio( $_POST["selSitio"]);					
   break 1;  
   
   default:
    edificio();
}

function edificio(){
 //inicio de tabla
   arribaAlinear("left");	
   echo "<TABLE  border=\"0\">".    
   "<td class=\"Estilo71\" <b>SOLICITUD POR EDIFICIO</td></b></td>".
   "</TABLE>";
   abajoAlinear();		
   echo "<form name=\"f1\" method=\"post\" action=\"\">";        
   echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	conectarMysql();
	$consultaSitio = "SELECT id_sitio, sitio FROM sitio order by sitio asc";	
	$RsSitio=mysql_query($consultaSitio);     	  
	echo "<center>";
	echo "<TABLE border=\"1\">";    
    echo "<TR vAlign=\"top\">";  
    echo "<TD class=\"Estilo71\" >";
    echo "<FONT face=\"Verdana\" size=\"1\">";
    echo "<b>EDIFICIOS:</b></FONT></TD>";
    echo "<TD align=\"left\" bgColor=\"#FFFFFF\">";
    echo "<FONT face=\"Verdana\" size=\"1\">";
	 echo "<select name=\"selSitio\"  class=\"Estilo71\" >";
	 echo "<option value=\"100\">-TODOS-</option>";
	while ($row=mysql_fetch_array($RsSitio)) {
		if ($row[0]==$IdSitio) {
			echo "<option selected value=$row[0]>$row[1]</option>";	
		}
		else {
			echo "<option value=$row[0]>$row[1]</option>";
		}
	}
	echo "</CENTER>";	           	
echo "<center>
<TR vAlign=\"top\">
<TD bgColor=\"#FFFFFF\" class=\"Estilo71\">
<FONT face=\"Verdana\" size=\"1\">
<b>FECHA-INICIAL:</b></FONT>
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
</select><FONT face=\"Verdana\" size=\"1\"><td class=\"Estilo71\" <b>FORMATO: DD/MM/AAAA</b></td><tr>
</center>
<TD bgColor=\"#FFFFFF\" class=\"Estilo71\">
<FONT face=\"Verdana\" size=\"1\">
<b>FECHA-FINAL:</b></FONT></TD>
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
<option value=\"09\">Septiembre</option>
<option value=\"10\">Octubre</option>
<option value=\"11\">Noviembre</option>
<option value=\"12\">Diciembre</option>
</select>
<select name=\"year1\" class=\"Estilo71\" onChange=\"populate1(this.form,this.form.month.selectedIndex);\" size=\"1\">
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
	
function buscar_edificio($valor_busqueda){     
     $FechaI="$_POST[year]-$_POST[month]-$_POST[day]";	
     $FechaF="$_POST[year1]-$_POST[month1]-$_POST[day1]";
	 $sitio="$_POST[selSitio]";		 	
  	 $_SESSION[fechaI]=$FechaI;
	 $_SESSION[fechaF]=$FechaF;
	 $_SESSION[sitio]=$sitio; 	 
     conectarMysql(); 
	 if ($_POST[year] <= $_POST[year1] && $_POST[month] <= $_POST[month1] && $_POST[day] <= $_POST[day1] && $_POST[day]!='' && $_POST[day1]!=''){		      
	  if($_POST[selSitio]!='100'){	  
	  $consulta="SELECT sitio,id_solicitud,des_status,fecha_i,solicitud_equipo.ficha,concat(NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUARIO,extension,descripcion from usuario inner join solicitud_equipo on usuario.ficha=solicitud_equipo.ficha inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join  descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion inner join ubicacion on usuario.id_ubicacion=ubicacion.id_ubicacion inner join sitio on ubicacion.id_sitio=sitio.id_sitio where (sitio.id_sitio LIKE '%$_POST[selSitio]') AND (solicitud_equipo.fecha_i >= '$FechaI') AND (solicitud_equipo.fecha_i <= '$FechaF')";       
	  $result=mysql_query($consulta);	 	 
	  $row=mysql_fetch_array($result);	 	
	    $num=mysql_num_rows($result);	
		if ($num < 1){
		 echo"<table width=\"300\" border=\"1\" bordercolor=\"#CC6600\"\" align=\"center\" class=\"Estilo71\">
              <tr><td><div align=\"center\"><p><strong>No se Tiene Registros en Este Rango de Fecha...</strong></p><p><strong></strong></p>
              </div></td></tr></table>";			 
	     }	
	    else{
		  echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\" height=\"15\" align=\"center\">";
          echo "<TR vAlign=\"top\">";
          echo "<td width=\"680\" class=\"Estilo74\" align=\"left\">";
          echo"<b>SOLICITUD POR EDIFICIO ($row[0])</b></td>";        	    			 
	      echo "</table>";	 	 	 	     		  	 	 	      
	      inicioTabla();    
		  $result=mysql_query($consulta);			       
		  while($row=mysql_fetch_array($result)){	
		  $fecha=substr($row[3],8,2).'-'.substr($row[3],5,2).'-'.substr($row[3],0,4);	  		  
	      equiposEncontrados($row[1],$row[7],$fecha,$row[4],$row[5],$row[6],$row[2],$row[0]);       	               
	      }		      
	      $_SESSION['consulta']=$consulta;
		  echo "<table border=\"1\" align=\"center\"><td>
		  <input name=\"imprimir\" type=\"submit\" class=\"Estilo71\" value=\"Imprimir\" onClick=\"window.open('../librerias/pdfEdificios.php')\">
		  <input type=\"reset\" value=\"Cancelar\" class=\"Estilo71\" onClick=\" history.go(-1)\"></td></table>";	
	     }
		 	  		  		 
	  }
	  else if($_POST[selSitio]=='100'){
	       $_POST[selSitio]='';	       
	       //$consulta="SELECT sitio,id_solicitud,des_status,fecha_i,solicitud_equipo.ficha,concat(NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUARIO,extension,descripcion from usuario inner join solicitud_equipo on usuario.ficha=solicitud_equipo.ficha inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join  descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion inner join ubicacion on usuario.id_ubicacion=ubicacion.id_ubicacion inner join sitio on ubicacion.id_sitio=sitio.id_sitio where (solicitud_equipo.fecha_i >= '$FechaI') AND (solicitud_equipo.fecha_i <= '$FechaF')";       
           $consulta="SELECT sitio,id_solicitud,des_status,fecha_i,solicitud_equipo.ficha,concat(NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUARIO,extension,descripcion from usuario inner join solicitud_equipo on usuario.ficha=solicitud_equipo.ficha inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join  descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion inner join ubicacion on usuario.id_ubicacion=ubicacion.id_ubicacion inner join sitio on ubicacion.id_sitio=sitio.id_sitio where sitio.id_sitio LIKE '%$_POST[selSitio]' AND solicitud_equipo.fecha_i >= '$FechaI' AND solicitud_equipo.fecha_i <= '$FechaF'";		   
	       $result=mysql_query($consulta); $row1=mysql_fetch_array($result);	
		   $num=mysql_num_rows($result);	
		   if ($num < 1){
		     echo"<table width=\"400\" border=\"1\" bordercolor=\"#CC6600\" align=\"center\">
                  <tr>"."<td bgcolor=\"#ffffff\">"."<div align=\"center\"><p><strong>No se Tiene Registros en Este Rango de Fecha...</strong></p>              
                  <input type=\"button\" name=\"boton\" class=\"Estilo71\" value=\"Volver\" onClick=\"history.go(-1)\">              
                  <p><strong></strong></p>
                  </div></td></tr></table>";
	       }	
	       else{
		   echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\" height=\"15\" align=\"center\">";
           echo "<TR vAlign=\"top\">";
           echo "<td width=\"795\" class=\"Estilo74\" align=\"left\">";
           echo"<b>SOLICITUD POR EDIFICIO (-TODOS-)</b></td>";        	    			 
	       echo "</table>";	 	 	 	     		  	 	 	      
	       inicioTabla();    
		   $result=mysql_query($consulta);			       
		   while($row1=mysql_fetch_array($result)){		   		  		  
		   $fecha=substr($row1[3],8,2).'-'.substr($row1[3],5,2).'-'.substr($row1[3],0,4);
	       equiposEncontrados($row1[1],$row1[7],$fecha,$row1[4],$row1[5],$row1[6],$row1[2],$row1[0]);       	               		   
	       }	       
	       $_SESSION['consulta']=$consulta;
   	      echo "<table border=\"1\" align=\"center\"><td>
		  <input name=\"imprimir\" type=\"submit\" class=\"Estilo71\" value=\"Imprimir\" onClick=\"window.open('../librerias/pdfEdificios.php')\">
		  <input type=\"reset\" value=\"Cancelar\" class=\"Estilo71\" onClick=\" history.go(-1)\"></td></table>";			
	       }
		  		 
	  }//{echo "<table border=\"0\" align=\"center\" <b> Error en el Rango de Fechas</b></table>";}
	 } 
	 else{
	 echo"<table width=\"300\" border=\"1\" bordercolor=\"#CC6600\" align=\"center\">".
         "<tr>"."<td bgcolor=\"#ffffff\">"."<div align=\"center\">".
         "<p><strong>Error en el Rango de Fechas</strong></p>".              
         "<input type=\"button\" name=\"boton\" class=\"Estilo71\" value=\"Volver\" onClick=\"history.go(-1)\">".              
         " <p>"."<strong>"."</strong>"."</p>".
         "</div>"."</td>"."</tr>".
         "</table>";
	 }  
	  mysql_close();
}


function inicioTabla() {
	echo "<table width=\"800\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">".
	"<tr  class=\"Estilo10\">".
	"<th  scope=\"col\">SOLICITUD</th>".
	"<th  scope=\"col\">EQUIPO</th>".
	"<th  scope=\"col\">FECHA</th>".
	"<th  scope=\"col\">FICHA</th>".
	"<th  scope=\"col\">NOMBRE</th>".	
	"<th  scope=\"col\">EXTENSION</th>".
	"<th  scope=\"col\">ESTATUS</th>".
	"<th  scope=\"col\">EDIFICIO</th>";
	echo "</tr>";

}

function equiposEncontrados($Solicitud,$Equipo,$Fecha,$Status,$Ficha,$Nombre,$Extension,$Sitio) {
	echo "<tr>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Solicitud</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Equipo</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Fecha</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Status</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Ficha</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Nombre</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Extension</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Sitio</td>";
	echo "</tr>";
}
?>