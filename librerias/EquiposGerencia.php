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
	color: #000000;
}	
</style> 
<?php
require_once "alineacion.php";
require_once "../librerias/administracion.php";

?>
<script>
	function BuscarEquipo() {
	
		var indiceEquipo = document.frmEquiposGerencia.selEquipo.selectedIndex;
		var valorEquipo = document.frmEquiposGerencia.selEquipo.options[indiceEquipo].value;
		
		var indiceGerencia = document.frmEquiposGerencia.selGerencia.selectedIndex;
		var valorGerencia = document.frmEquiposGerencia.selGerencia.options[indiceGerencia].value;
		
							
		var ruta="EquiposGerencia.php?"+"IdEquipo="+valorEquipo+"IdGerencia="+valorGerencias;
		if (valorEquipo!=100) {
			window.location=ruta;
		}
	}
	
</script>
<?php
switch($_POST["funcion"]) {  
   case "1":   
     buscar_gerencia($_POST[selEquipo],$_POST[selGerencia]);
   break 1;
   default:
    busca();
}
function busca(){
arribaAlinear("left");	
    echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"0\">".
    "<TD bgColor=\"#FFFFFF\">".
    "<FONT face=\"Verdana\" size=\"1\">".
    "<td class=\"Estilo71\" <b>DEMANDA DE EQUIPOS POR GERENCIAS</td></b></td>".
    "</FONT></TD></TABLE><BR>";
abajoAlinear();		  
  echo "<table border=1 align='center'>\n";
  echo "<form name=\"frmEquiposGerencia\" method=\"post\" action=\"\">";     
  echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	conectarMysql();
	$consultaEquipo = "SELECT solicitud_equipo.ID_DESCRIPCION, descripcion
	FROM solicitud_equipo INNER JOIN DESCRIPCION ON solicitud_equipo.ID_DESCRIPCION=descripcion.ID_DESCRIPCION GROUP BY ID_DESCRIPCION";
	$consultaGerencia = "SELECT id_gerencia, gerencia FROM gerencia";		
	$RsGerencia=mysql_query($consultaGerencia);	
	$RsEquipo=mysql_query($consultaEquipo);      	  
    echo"<tr>";
	echo "<TR vAlign=\"top\">
	<TD bgColor=\"#FFFFFF\" class=\"Estilo71\">
	<FONT face=\"Verdana\" size=\"1\">
	<b>EQUIPOS:</b></FONT></TD>
	<TD align=\"left\" bgColor=\"#FFFFFF\">
	<FONT face=\"Verdana\" size=\"1\">";     
	echo "<select name=\"selEquipo\"  class=\"Estilo71\">";
	echo "<option value=\"100\">-EQUIPOS-</option>";
	while ($row=mysql_fetch_array($RsEquipo)) {
		if ($row[0]==$IdEquipo) {
			echo "<option selected value=$row[0]>$row[1]</option>";	
		}
		else {
			echo "<option value=$row[0]>$row[1]</option>";
		}
	}
	echo "</select>";	
	echo"<tr>";
    echo "<TR vAlign=\"top\">
	<TD bgColor=\"#FFFFFF\" class=\"Estilo71\">
	<FONT face=\"Verdana\" size=\"1\">
	<b>GERENCIAS:</b></FONT></TD>
	<TD align=\"left\" bgColor=\"#FFFFFF\">
	<FONT face=\"Verdana\" size=\"1\">";     
	 echo "<select name=\"selGerencia\"  class=\"Estilo71\">";
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
    echo"</table>";
	echo "<table border=1 align=\"center\"><td> 
	<input name=\"btnAlmacenar\" type=\"submit\" class=\"Estilo71\" value=\"Buscar\"></td>";    
	echo "</form>";	
	echo "</body>";
	echo "</html>";	
	mysql_close();
}	
function buscar_gerencia($valor_busqueda,$valor_busqueda2){   
     conectarMysql(); 
	 $Consulta="select count(solicitud_equipo.id_descripcion) from solicitud_equipo inner join descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia where descripcion.id_descripcion='$valor_busqueda' and gerencia.id_gerencia='$valor_busqueda2'";
	 $ConsultaEquipo="SELECT descripcion.id_descripcion, concat( NOMBRE_USUARIO, ' ', APELLIDO_USUARIO ) AS USUARIO, descripcion, gerencia, id_solicitud FROM solicitud_equipo INNER JOIN usuario ON solicitud_equipo.ficha = usuario.ficha INNER JOIN descripcion ON solicitud_equipo.id_descripcion = descripcion.id_descripcion INNER JOIN ubicacion ON solicitud_equipo.id_ubicacion = ubicacion.id_ubicacion INNER JOIN gerencia ON ubicacion.id_gerencia = gerencia.id_gerencia WHERE descripcion.id_descripcion = '$valor_busqueda' AND gerencia.id_gerencia = '$valor_busqueda2'";  	 	 		 
	 $result1=mysql_query($ConsultaEquipo);			   	 	
     $result=mysql_query($Consulta);	
	 $row=mysql_fetch_array($result1);
 	 $row1=mysql_fetch_array($result);
	 if($valor_busqueda!='100' && $valor_busqueda2!='100'){
	  if ($num1=mysql_num_rows($result1) && $num=mysql_num_rows($result)){ 			 	  	  	 	 	  	      
  		   inicioTabla(); 		  	   
	       equiposEncontrados($row1[0],$row[1],$row[2],$row[3]);        	               	   
	  }
	  else{
	   echo"<table width=\"300\" border=\"1\" bordercolor=\"#CC0033\" align=\"center\" class=\"Estilo71\">
       <tr>"."<td>"."<div align=\"center\"><p><strong>No Existen Registros</strong></p>
       <form name=\"form1\" method=\"post\" action=\"\">
       </form><p><strong></strong></p></div></td></tr></table>";
	  } 
	 } 	 
	 else{
	  echo"<table width=\"300\" border=\"1\" bordercolor=\"#CC6600\" align=\"center\">
           <tr><td bgcolor=\"#ffffff\"><div align=\"center\"><p><strong>Existen Campos Vacios Seleccionelos</strong></p>
           <form name=\"form1\" method=\"post\" action=\"\"><input type=\"button\" name=\"boton\" class=\"Estilo71\" value=\"Volver\" onClick=\"history.go(-1)\">
           </form><p><strong></strong></p></div></td></tr></table>";	
	  }	    
mysql_close();
}
//buscar_gerencia( $_POST["selEquipo"],$_POST["selGerencia"]);

function inicioTabla() {
    echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\" height=\"15\" align=\"center\">
    <TR vAlign=\"top\">
    <td width=\"680\" colspan=\"6\" class=\"Estilo10\" background=\"../librerias/bgimage_over.jpg\">
    <b>DEMANDA DE EQUIPOS POR GERENCIAS</b></td></tr>
	<tr  class=\"Estilo10\">
	<th width=\"180\"  scope=\"col\">CANTIDAD DE SOLICITUDES</th>
	<th width=\"180\"  scope=\"col\">USUARIO</th>
	<th width=\"180\"  scope=\"col\">EQUIPO</th>
	<th width=\"180\"  scope=\"col\">GERENCIA</th>
	</tr>";

}

function equiposEncontrados($Equipo,$Usuario,$EquipoSol,$Gerencia) {
	echo "<tr>";	
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo74\">$Equipo</td>";	
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo74\">$Usuario</td>";	
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo74\">$EquipoSol</td>";	
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo74\">$Gerencia</td>";		
	echo "</tr></table>";
}

function inicioTabla1() {
	echo "<table width=\"100\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">".
	"<tr bgcolor=\"#0000FF\" class=\"Estilo10\">".
	"<th width=\"180\" bgcolor=\"#CC0000\" scope=\"col\">EQUIPO</th>".
	"<th width=\"180\" bgcolor=\"#CC0000\" scope=\"col\">GERENCIA</th>";
	echo "</tr>";

}

function equiposEncontrados1($Equipo1,$Gerencia) {
	echo "<tr>";	
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo74\">$Equipo1</td>";	
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo74\">$Gerencia</td>";		
	echo "</tr>";
} 	
?>