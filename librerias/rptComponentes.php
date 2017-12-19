<?php
//DETALLE DE LOS COMPONENTES
?>
<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
require_once("formularios.php");
require_once("conexionsql.php");
require_once("rptAdmin.php");


    $rptComponentes = new rptComponentes($configuracion);
    $resultado=$rptComponentes->retornarInventarioComponentes();
    if ($resultado && $resultado!=1) {
	$row=mysql_fetch_array($resultado);
    }
 


		echo "<table width=\"75%\" border=\"0\" align=\"center\">
		<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"3\" align=\"center\">DETALLE DE LOS COMPONENTES</td>
			</tr>	
		<tr>
		<td valign=top class=\"formularioTablaTitulo\" colspan=\"3\"><br>USUARIOS QUE HA TENIDO EL COMPONENTE <br></td>
		</tr>	
		<tr>
		<td valign=top class=\"formularioCampoTitulo\"><b>USUARIO</b></td>				
		<td valign=top class=\"formularioCampoTitulo\"><b>FICHA</b></td>		
		<td valign=top class=\"formularioCampoTitulo\"><b>EXTENSION</b></td>		
		</tr>
		<tr>		
		</tr>
        <td valign=top class=\"formularioTablaTitulo\" colspan=\"3\"><br>SITIOS EN DONDE HA ESTADO EL COMPONENTE<br></td>
		</tr>
		<tr>
		<td valign=top class=\"formularioCampoTitulo\"><b>EDIFICIO</b></td>
		<td valign=top class=\"formularioCampoTitulo\"><b>DIVISION</b></td>
		<td valign=top class=\"formularioCampoTitulo\"><b>GERENCIA</b></td>
		</tr>
		<tr>				
		</tr>		 
		<td valign=top class=\"formularioTablaTitulo\" colspan=\"3\"><br>CONFIGURACIONES EN LAS CUALES HA ESTADO ASOCIADO EL COMPONENTE <br></td>
		</tr>
		<tr>
		<td valign=top class=\"formularioCampoTitulo\"><b>CONFIGURACION</b></td>			
		</tr>
		<tr>					
		</tr>			
		</tr>";
		echo "</table>";
				

		
?>