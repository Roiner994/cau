<?php

switch ($funcion) {
	case 1:
		require_once("conexionsql.php");
		require_once("requerimientoAdmin.php");
		$requerimiento= new requerimientoHardware();
		$requerimiento->setRequerimientoHardware($_GET[idRequerimiento]);
		$resultado=$requerimiento->eliminarRequerimiento();
		switch ($resultado) {
			case 0:
				
				echo "<br><br><br><br>";
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: REQUERIMIENTO - ELIMINAR REQUERIMIENTO DE SOLICITUDES</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>SE ELIMIN&Oacute; EL REQUERIMIENTO $_GET[idRequerimiento]</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>
				<input name=\"btnAceptar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php?item=201'\"></td>";
				echo "</tr>";
				echo "</table>";						
				echo "</form>";
				
				break 1;
			case 1:
				
				echo "<br><br><br><br>";
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: REQUERIMIENTO - ELIMINAR REQUERIMIENTO DE SOLICITUDES</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE ELIMINAR EL REQUERIMIENTO $_GET[idRequerimiento]</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>
				<input name=\"btnAceptar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php?item=201'\"></td>";
				echo "</tr>";
				echo "</table>";						
				echo "</form>";
				
				break 1;
		}
		break 1;
	case 2:
		break 1;
	default:
		frmEliminar();		
}

function frmEliminar() {
//Requerimiento Eliminar;
				echo "<br><br><br><br>";
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: REQUERIMIENTO - ELIMINAR REQUERIMIENTO DE SOLICITUDES</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>¿DESEA ELIMINAR EL REQUERIMIENTO $_GET[idRequerimiento]?</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>
				<input name=\"btnSi\" type=\"button\" value=\"SI\" onclick=\"location.href='index2.php?item=204&funcion=1&idRequerimiento=$_GET[idRequerimiento]'\">
				<input name=\"btnNo\" type=\"button\" value=\"NO\" onclick=\"location.href='index2.php?item=202&idRequerimiento=$_GET[idRequerimiento]'\"></td>";
				echo "</tr>";
				echo "</table>";						
				echo "</form>";
}
?>