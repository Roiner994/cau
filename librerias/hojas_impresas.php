<?php
require_once("seguridad.php");
?>
<html>
<head>
<title>CANTIDAD DE HOJAS IMPRESAS</title>
<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
</head>
<body>


<?php

switch ($funcion) {
	case 1:
		require_once("inventarioAdmin.php");
		require_once("mantenimientoAdmin.php");
		
		$login=$_SESSION["login"];
		$equipo= new equipo();
		$equipo->setEquipo($_GET[configuracion]);
		$equipo->setInventarioPropiedad("",$login);
		$mantenimiento= new mantenimiento();
		$mantenimiento->setDatosMantenimiento("",$_GET[configuracion]);
		$resultado2=$mantenimiento->retornaUltimoMantenimiento();
		$resultado=$equipo->ingresarHojas($_POST[txtCantidad]);
		$row=mysql_fetch_array($resultado2);
		$equipo->ActualizarHojasMantenimiento($_POST[txtCantidad],$row[0]);
		
		switch ($resultado) {
			case 0:
				
				echo "<br><br><br><br>";
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";				
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: IMPRESORA - HOJAS IMPRESAS</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO LA CANTIDAD DE HOJAS</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>
				<input name=\"btnAceptar\" type=\"button\" value=\"ACEPTAR\" onclick=\"window.close()\">
				</td>";
				echo "</tr>";
				echo "</table>";						
				echo "</form>";	
				break 1;
			case 1:
				
				echo "<br><br><br><br>";
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";				
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: IMPRESORA - HOJAS IMPRESAS</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>NO SE GUARDO LA CANTIDAD DE HOJAS</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>
				<input name=\"btnAceptar\" type=\"button\" value=\"CANCELAR\" onclick=\"window.close()\">
				</td>";
				echo "</tr>";
				echo "</table>";						
				echo "</form>";					
				break 1;
			case 2:
				
				echo "<br><br><br><br>";
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";				
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: IMPRESORA - HOJAS IMPRESAS</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>EL CAMPO CANTIDAD EST&Aacute; VAC&IacuteO</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>
				<input name=\"btnAceptar\" type=\"submit\" value=\"CANCELAR\">
				</td>";
				echo "</tr>";
				echo "</table>";						
				echo "</form>";					
				break 1;				
		}
		
		
		
		break 1;
	case 2:
		break 1;
	default:
		frmImpresora();
}

function frmImpresora() {
	require_once("administracion.php");
	require_once("inventarioAdmin.php");
	$equipo= new equipo();
	$equipo->setEquipo($_GET[configuracion]);
	$resultado=$equipo->buscarEquipo();
	if ($resultado!=1) {
		$row=mysql_fetch_array($resultado);
	}
		echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
		
			echo "<table class=\"formularioTabla\"align=center width=\"20%\" border=\"0\" align=\"center\">";
			echo "<tr>";
			echo "<td class=\"tituloPagina\" >CANTIDAD DE HOJAS</td>
	  		</tr>";
	
			
			echo "<tr>";
				echo "<td class=\"formularioTablaTitulo\" >DATOS DEL COMPONENTE</td>
	  				</tr>
	    		<td valign=top class=\"formularioCampoTitulo\">CONFIGURACION<br>
				<b class=\"campo\">$row[0]</b><br>
				DESCRIPCION<br><b class=\"campo\">$row[5]</b><br>
				MARCA / MODELO<br><b class=\"campo\">$row[7] $row[9]</b><br>
				SERIAL<br><b class=\"campo\">$row[3]</b><br>";
			echo "</tr>";
			echo "<tr>";
				echo "<td valign=top class=\"formularioTablaTitulo\">EQUIPO ASOCIADO EN CAMPO</td>
	  				</tr>";
	  		echo "<tr>
				<td class=\"formularioCampoTitulo\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ESCRIBA EL NÚMERO DE HOJAS<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"formularioCampoTexto\" name=\"txtCantidad\" type=\"text\" value=\"$_POST[txtCantidad]\" onKeypress=\"if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;\">";
			echo "</tr>";
	  		echo "<tr>
				<td align=\"center\"><input name \"btnAceptar\" value=\"ACEPTAR\" type=\"submit\">";
			echo "</tr>";
	  		echo "</table>";
		echo "</form>";
}

?>
</body>
</html>
