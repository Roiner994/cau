<?php
//Reporte de un Inventario
?>
<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
require_once("formularios.php");
require_once("conexionsql.php");
require_once("rptAdmin.php");

    



		echo "<table width=\"75%\" border=\"0\" align=\"center\">
		<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"3\" align=\"center\">DETALLE DEL INVENTARIO</td>
			</tr>
		<tr>
		<td valign=top class=\"formularioTablaTitulo\" colspan=\"3\"><br>COMPONENTES ASOCIADOS AL EQUIPO</td>
		</tr>		
		<tr>
		<td valign=top class=\"formularioCampoTitulo\"><b>DESCRIPCION</b></td>
		<td valign=top class=\"formularioCampoTitulo\"><b>FECHA_ASOCIACION</b></td>		
		</tr>		
		<tr>
		<td valign=top class=\"formularioCampo\">$row[8]</td>		
		<td valign=top class=\"formularioCampo\">$row[19]</td>
		</tr>
		<tr>
		<td valign=top class=\"formularioTablaTitulo\" colspan=\"3\"><br>USUARIOS QUE HA TENIDO EL EQUIPO <br></td>
		</tr>	
		<tr>
		<td valign=top class=\"formularioCampoTitulo\"><b>USUARIO</b></td>				
		<td valign=top class=\"formularioCampoTitulo\"><b>FICHA</b></td>		
		<td valign=top class=\"formularioCampoTitulo\"><b>EXTENSION</b></td>		
		</tr>
		<tr>
		<td valign=top class=\"formularioCampo\">$row[0]</td>		
		<td valign=top class=\"formularioCampo\">$row[2]</td>		
		<td valign=top class=\"formularioCampo\">$row[4]</td>
		</tr>
        <td valign=top class=\"formularioTablaTitulo\" colspan=\"3\"><br>SITIOS EN DONDE HA ESTADO EL EQUIPO<br></td>
		</tr>
		<tr>
		<td valign=top class=\"formularioCampoTitulo\"><b>EDIFICIO</b></td>
		<td valign=top class=\"formularioCampoTitulo\"><b>DIVISION</b></td>
		<td valign=top class=\"formularioCampoTitulo\"><b>GERENCIA</b></td>
		</tr>
		<tr>
		<td valign=top class=\"formularioCampo\">$row[31]</td>		
		<td valign=top class=\"formularioCampo\">$row[2]</td>
		<td valign=top class=\"formularioCampo\">$row[4]</td>
		</tr>		 
		<td valign=top class=\"formularioTablaTitulo\" colspan=\"3\"><br>NÚMERO DE MANTENIMIENTOS REALIZADOS AL EQUIPO <br></td>
		</tr>
		<tr>
		<td valign=top class=\"formularioCampoTitulo\"><b>CANTIDAD</b></td>		
		</tr>
		<tr>
		<td valign=top class=\"formularioCampo\">$row[3]</td>			
		</tr>		
			
		</tr>";
		echo "</table>";


?>