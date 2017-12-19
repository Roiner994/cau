<HTML>
<?php
//Prueba de CheckBox
include "librerias/formato.php";
echo "</head>";
 //TITULO DE LA PAGINA ACTUAL
 estilos();
 $titulo="REPORTE";
 inicio($titulo);
 //TITULO DEL ENCABEZADO
 $encabezado="REPORTE DE EQUIPOS";
 encabezado($encabezado); 
 
 
switch ($_POST[funcion]) {
	case 1:
		if(!empty($_POST['campo'])) { 
    	 $aLista=$_POST['campo'];
		 $valores="'".implode(',',$aLista)."'";
		 $valores=str_replace(',','\',\'',$valores);
		 include "../librerias/conexionsql.php";
		 conectarMysql();
		 $conSolicitud="select id_solicitud,descripcion,nombre_usuario,apellido_usuario,extension,gerencia,departamento,sitio from solicitud_equipo inner join usuario on solicitud_equipo.ficha=usuario.ficha inner join descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia inner join division on ubicacion.id_division= division.id_division inner join departamento on ubicacion.id_departamento=departamento.id_departamento inner join sitio on ubicacion.id_sitio=sitio.id_sitio inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status WHERE id_solicitud IN ($valores) ORDER BY sitio DESC";
		 $result=mysql_query($conSolicitud);				         
		 inicioTabla();
		while ($row=mysql_fetch_array($result)) {		
		 equiposEncontrados($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7]);			 
		
		 }
		 mysql_close();
		}
		break 1;
	default:
		mostrar();
}
function mostrar() {
	
	
	include "../librerias/conexionsql.php";
	$conBuscar="select id_solicitud,descripcion,gerencia,division,departamento,sitio,fecha_i from solicitud_equipo inner join descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia inner join division on ubicacion.id_division= division.id_division inner join departamento on ubicacion.id_departamento=departamento.id_departamento inner join sitio on ubicacion.id_sitio=sitio.id_sitio inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status where fecha_i='$_POST[selFecha]' and fecha_i='$_POST[selFecha1]' and status_solicitud.id_status ='STA0000001' OR status_solicitud.id_status ='STA0000003'  order by sitio desc";
	echo "<form name=\"frmMarca\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	conectarMysql();
	$result=mysql_query($conBuscar);
	
	while($row=mysql_fetch_array($result)) {
	//echo"<br>"; 
		  echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">";
			echo "<input name=\"campo[]\" type=\"checkbox\" value=\"$row[0]\">$row[0]&nbsp; &nbsp;&nbsp;&nbsp;$row[1]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $row[2]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $row[3] $row[4] $row[5]<br>.<br>";
		
	}
	echo "<p align=center><input name=\"btn\" type=\"submit\" value=\"ACEPTAR\"></p>";
	echo "</form>";
}

function inicioTabla() {
	echo "<table width=\"800\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">".
	"<tr bgcolor=\"#0000FF\" class=\"Estilo10\">".
	"<th width=\"100\" bgcolor=\"#CC0000\" scope=\"col\">SOLICITUD</th>".
	"<th width=\"150\" bgcolor=\"#CC0000\" scope=\"col\">EQUIPO</th>".
	"<th width=\"500\" bgcolor=\"#CC0000\" scope=\"col\">NOMBRE</th>".
	"<th width=\"200\" bgcolor=\"#CC0000\" scope=\"col\">APELLIDO</th>".
	"<th width=\"200\" bgcolor=\"#CC0000\" scope=\"col\">EXTENSION</th>".
    "<th width=\"200\" bgcolor=\"#CC0000\" scope=\"col\">GERENCIA</th>".
	 "<th width=\"200\" bgcolor=\"#CC0000\" scope=\"col\">DEPARTAMENTO</th>".
	"<th width=\"200\" bgcolor=\"#CC0000\" scope=\"col\">SITIO</th>";	
	echo "</tr>";		
}

function equiposEncontrados($Solicitud,$Equipo,$Nombre,$Apellido,$Extension,$Gerencia,$Departamento,$Sitio) {
	echo "<tr>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo14\">$Solicitud</a></td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo14\">$Equipo</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo14\">$Nombre</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo14\">$Apellido</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo14\">$Extension</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo14\">$Gerencia</td>";	
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo14\">$Departamento</td>";
	echo "<td align=\"center\" valign=\"middle\" class=\"Estilo14\">$Sitio</td>";	
	echo "</tr>";
	echo "<input name=\"oculta2\" type=\"hidden\" value=\"$conf\">";
}
?>