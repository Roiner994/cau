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
require_once "alineacion.php";
require_once "formularios.php";
require_once "administracion.php";
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
<?php
if (isset($conf) && !empty($conf)) {
	if ($_POST[funcion]!=2) {
		$_POST[funcion]=1;
	}
}
   
	
switch ($_POST[funcion]) {
	case "1":		    	 
	     comenzar2($conf);		
		break 1;
	case "2":
	        modifica($_POST[status]);				 		    	    
	break 1;	
	default:	
	   solicitudes(); 

}

//function comenzar(){ 
 //inicio de tabla
  echo "<table border=0 align='center'>\n";
   echo "<form name=\"frmSolicitudesAprobadas\" method=\"post\" action=\"\">";
      
	conectarMysql();
	$consultaGerencia = "SELECT id_status, des_status FROM status_solicitud where id_status=STA0000001";	
	$RsGerencia=mysql_query($consultaGerencia);		   			   	
	echo "</td>";    
    echo"</tr>";
    echo"</table>";
	echo "</form>";	
	echo "</body>";
	echo "</html>";	
	mysql_close();
//}	
function solicitudes(){
conectarMysql();
echo "<form name=\"frmSolicitudesAprobadas\" method=\"post\" action=\"\">";
$consulta="select id_solicitud,concat(NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUARIO,descripcion,gerencia,division,departamento,sitio from solicitud_equipo inner join usuario on solicitud_equipo.FICHA=usuario.FICHA inner join descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion inner join ubicacion on usuario.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia inner join division on ubicacion.id_division= division.id_division inner join departamento on ubicacion.id_departamento=departamento.id_departamento inner join sitio on ubicacion.id_sitio=sitio.id_sitio inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status where status_solicitud.id_status ='STA0000001' OR status_solicitud.id_status ='STA0000003' "; 
$result=mysql_query($consulta);
$row=mysql_fetch_array($result);
$num=mysql_num_rows($result);
if ($num >= 1) { 
inicioTabla();
$result=mysql_query($consulta);
while($row=mysql_fetch_array($result)){
  equiposEncontrados($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6]);
}
echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";   
echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\" align=\"center\">   
      <TR vAlign=\"top\"><TD bgcolor=\"#ECE9D8\"><FONT face=\"Verdana\" size=\"1\">	
	  <input name=\"imprimir\" type=\"button\" class=\"Estilo71\" value=\"Imprimir\" onClick=\"window.open('../librerias/pdfSolicitudesAprobadas.php')\">		  
	  </td></table>";
}
else{
 echo"<table width=\"300\" border=\"1\" bordercolor=\"#CC6600\"\" align=\"center\" class=\"Estilo71\">
      <tr><td><div align=\"center\"><p><strong>No Existen Registros</strong></p><p><strong></strong></p>
      </div></td></tr></table>";		
}
 echo "</table>";
 echo "</form>"; 
 mysql_close();
}
//solicitudes();

function inicioTabla() {
    echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\" height=\"15\" align=\"center\">";
    echo "<TR vAlign=\"top\">";
    echo "<td width=\"800\" class=\"Estilo74\" align=\"left\">";
    echo"<b>SOLICITUDES APROBADAS </b></td>";
    echo "</table>";
	echo "<table width=\"804\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">".
	"<tr bgcolor=\"#0000FF\" class=\"Estilo10\">".
	"<th width=\"100\"  scope=\"col\">SOLICITUD</th>".
	"<th width=\"100\"  scope=\"col\">USUARIO</th>".
	"<th width=\"150\"  scope=\"col\">EQUIPO</th>".	
	"<th width=\"200\"  scope=\"col\">GERENCIA</th>".
	"<th width=\"200\"  scope=\"col\">DIVISION</th>".
    "<th width=\"200\"  scope=\"col\">DEPARTAMENTO</th>".
	"<th width=\"200\"  scope=\"col\">SITIO</th>";	
	echo "</tr>";		
}

function equiposEncontrados($Solicitud,$Usuario,$Equipo,$Gerencia,$Division,$Departamento,$Sitio) {
	echo "<tr>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\"><a href=\"secciones.php?item=202&conf=$Solicitud\">$Solicitud</a></td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Equipo</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Usuario</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Gerencia</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Division</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Departamento</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo71\">$Sitio</td>";	
	echo "</tr>";
	echo "<input name=\"oculta2\" type=\"hidden\" value=\"$conf\">";
}
function comenzar2($conf){
//inicio de tabla
 echo "<form name=\"frmSolicitudesAprobadas\" method=\"post\" action=\"\">";
   echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
  echo "<table border=0 align='center'>\n";
  $valor_busqueda=$_POST["oculta"];      
//muestra la fecha del servidor en pantalla
  $FECHA=gmdate("d/m/Y");  
   echo "<br>";  
	echo "<center>";	
	echo "<TABLE width=\"459\"cellSpacing=\"0\" cellPadding=\"0\" border=\"0\">";    
    echo "<TR vAlign=\"top\">";   
    echo "<TD align='right'>";
    echo "<FONT face=\"Verdana\" size=\"1\">"; 	  
    echo "Fecha:$FECHA &nbsp <b>N&deg;:$conf</b></FONT></TD>";	
	echo"</table></center>";	   
    echo "<input name=\"fecha\" type=\"hidden\" value=\"$FECHA\">";
	conectarMysql();	
	$consultaStatus = "SELECT id_status, des_status FROM status_solicitud where  id_status='STA0000004' OR id_status='STA0000005'";//consulta que muestra los diferentes status que puede tener una solicitud	
	$RsStatus=mysql_query($consultaStatus);		
	$consulta="select id_solicitud,solicitud_equipo.ficha,concat(NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUARIO,descripcion,gerencia,sitio,observacion_solicitud, 
	usuario.extension from solicitud_equipo 
	inner join usuario on solicitud_equipo.FICHA=usuario.FICHA 
	inner join descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion 
	inner join ubicacion on usuario.id_ubicacion=ubicacion.id_ubicacion 
	inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia 
	inner join division on ubicacion.id_division= division.id_division 
	inner join departamento on ubicacion.id_departamento=departamento.id_departamento 
	inner join sitio on ubicacion.id_sitio=sitio.id_sitio 
	inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status 
	where solicitud_equipo.status ='STA0000001' && solicitud_equipo.id_solicitud='$conf'"; 		
	$result=mysql_query($consulta);
	$row=mysql_fetch_array($result);		
    echo "<input name=\"oculta2\" type=\"hidden\" value=\"$conf\">";
	echo "<center>";
	echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\" height=\"15\">";
    echo "<TR vAlign=\"top\">";
    echo "<td width=\"456\" class=\"Estilo74\" align=\"left\">";
    echo"<b>DATOS DE SOLICITUD</b></td>";
    echo "</table>";         	
    echo "<TABLE width=\"460\"cellSpacing=\"0\" cellPadding=\"0\" border=\"1\">"; 
	echo "<td class=\"Estilo71\"><align='left'>FICHA:<td>
	      <input class=\"Estilo71\" name=\"ficha\" size=\"60\" maxlength=\"60\" readonly=\"true\" type=\"text\" value=\"$row[1]\"><TR>";	
	echo "<td class=\"Estilo71\"><align='left'>USUARIO:<td>
	      <input class=\"Estilo71\" name=\"usuario\" size=\"60\" maxlength=\"60\" readonly=\"true\" type=\"text\" value=\"$row[2]\"><TR>";
	echo "<td class=\"Estilo71\"><align='left'>TELÉFONO:<td>
	      <input class=\"Estilo71\" name=\"telefono\" size=\"60\" maxlength=\"60\" readonly=\"true\" type=\"text\" value=\"$row[7]\"><TR>";		
	echo "<td class=\"Estilo71\"><align='left'>EQUIPO:<td>
	      <input class=\"Estilo71\" name=\"equipo\" size=\"60\" maxlength=\"60\" readonly=\"true\" type=\"text\" value=\"$row[3]\"><TR>";		  
	echo "<td class=\"Estilo71\"><align='left'>GERENCIA:<td>
	      <input class=\"Estilo71\" name=\"gerencia\" size=\"60\" maxlength=\"60\" readonly=\"true\" type=\"text\" value=\"$row[4]\"><TR>";		  
	echo "<td class=\"Estilo71\"><align='left'>SITIO:<td>
	      <input class=\"Estilo71\" name=\"sitio\" size=\"60\" maxlength=\"60\" readonly=\"true\" type=\"text\" value=\"$row[5]\"><TR>";		  	  
	echo "<td class=\"Estilo71\"><align='left'>OBSERVACION:<td>
   	      <input class=\"Estilo71\" name=\"observ\" size=\"60\" maxlength=\"60\" readonly=\"true\" type=\"text\" value=\"$row[6]\"><TR>";		  	  
    echo "<td class=\"Estilo71\"><align='left'>ESTATUS SOLICITUD:</td>"."<td>";
	echo "<select name=\"selStatus\" class=\"Estilo71\" >";
	echo "<option class=\"Estilo71\" value=\"100\">-Status-</option>";
	while ($row=mysql_fetch_array($RsStatus)) {
		if ($row[0]==$IdStatus) {
			echo "<option selected  value=$row[0]>$row[1]</option>";	
		}
		else {
			echo "<option value=$row[0]>$row[1]</option>";
		}
	}
   echo "</select>";		    
   echo"<tr>";   
   echo "<b><td class=\"Estilo71\"><align='left'>OBSERVACION ESTATUS:</b></td>"."<td>"; 	
   echo "<input class=\"Estilo71\" name=\"txtAsignacion\" type=\"text\" size=\"60\" maxlength=\"\" value=$Idasignacion>";		    				           
   echo "<input=\"status\" tipe=\"hidden\" value=\"$_POST[selStatus]\">";
   echo"</table></center>";   
   echo "<CENTER>";
   echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\">";   
   echo "<TR vAlign=\"top\">";
   echo "<TD bgcolor=\"#ECE9D8\">";
   echo "<FONT face=\"Verdana\" size=\"1\">";
   echo "<input name=\"btnAlmacenar\" class=\"Estilo71\" type=\"submit\" value=\"Actualizar\">";  
   echo "<input type=\"button\" name=\"atras\" class=\"Estilo71\" value=\"Volver\" onClick=\"history.go(-1)\">"; 
   echo "</TABLE>";		
   echo "</CENTER>";     	
    echo "</td>";    
    echo"</tr>";
    echo"</table>";
	echo "</form>";	
	echo "<input=\"status\" tipe=\"hidden\" value=\"$_POST[selStatus]\">";
	echo "</body>";
	echo "</html>";	
	mysql_close();
}
	
function modifica($valor){
 conectarMysql();
  echo "<form name=\"frmSolicitudesAprobadas\" method=\"post\" action=\"\">";
   echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
 $prueba=$_POST["selStatus"];
  $consultaModificaStatus = "update solicitud_equipo set id_status='$_POST[selStatus]', status='STA0000001'
	  ,observacion_status='$_POST[txtAsignacion]' where id_solicitud='$_POST[oculta2]'";
	 $result=mysql_query($consultaModificaStatus);	 
if ($_POST["selStatus"]!='100' && $_POST[txtAsignacion]!=''){ 
	if ($prueba=='STA0000004' OR $prueba=='STA0000005'){	 
	  $consultaModificaStatus = "update solicitud_equipo set  fecha_m='$_POST[fecha]'
	  ,observacion_status='$_POST[txtAsignacion]' where id_solicitud='$_POST[oculta2]'";
	 $result=mysql_query($consultaModificaStatus);
	 /* status='STA0000001'*/
	}
	echo "<table border=\"1\"  bordercolor=\"#CC6600\" align='center'><td>
          <b>Registro Actualizado</td></table>";   
}
else{
       echo"<table width=\"300\" border=\"1\" bordercolor=\"#CC6600\" align=\"center\" class=\"Estilo71\">".
  "<tr>"."<td>"."<div align=\"center\">".
      "<p><strong>LOS CAMPOS DEBEN ESTAR LLENOS</strong></p>".
      "<form name=\"form1\" method=\"post\" action=\"\">".
        "<input type=\"button\" name=\"boton\" class=\"Estilo71\" value=\"Volver\" onClick=\"history.go(-1)\">".
     " </form>".
     " <p>"."<strong>"."</strong>"."</p>".
    "</div>"."</td>".
  "</tr>".
"</table>";		
}     
	  echo "</form>";
   mysql_close();   
  }  

?>