<?php
switch ($funcion) {
	case 1:
		$sw=0;
		$mensaje="";
		if (isset($_POST[txtPuntoPendiente]) && empty($_POST[txtPuntoPendiente])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>PUNTO PENDIENTE</b>";
			$i++;
			$sw=1; 
		}
		switch ($i) {
			case 0:
			require_once("administracion.php");
			require_once("puntoPendienteAdmin.php");
			
			$tipoPendiente= new tipoPuntoPendiente();
			$tipoPendiente->setPuntoPendiente("",$_POST[txtPuntoPendiente]);
			$resultado=$tipoPendiente->ingresar();
			switch ($resultado) {
				case 0:
					echo "<form name=\"frmPuntoPendiente\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"txtGerencia\" type=\"hidden\" value=\"\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVO PUNTO PENDIENTE</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO EL NUEVO TIPO DE PUNTO PENDIENTE</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>
					<input name=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\">
					</td>";
					echo "</tr>";
					echo "</table>";						
					echo "</form>";				
					break 1;
				case 1:
					echo "<form name=\"frmPuntoPendiente\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"txtGerencia\" type=\"hidden\" value=\"$_POST[txtGerencia]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVO PUNTO PENDIENTE</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR NUEVO TIPO DE PUNTO PENDIENTE</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>
					<input name=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\">
					</td>";
					echo "</tr>";
					echo "</table>";						
					echo "</form>";				
					break 1;
				case 2:
					echo "<form name=\"frmPuntoPendiente\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"txtGerencia\" type=\"hidden\" value=\"$_POST[txtGerencia]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVA PUNTO PENDIENTE</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR TIPO DE PUNTO PENDIENTE. TIPO DE PUNTO PENDIENTE DUPLICADO</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>
					<input name=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\">
					</td>";
					echo "</tr>";
					echo "</table>";						
					echo "</form>";
					break 1;
			}
			break 1;
			
			case 1:
					echo "<form name=\"frmPuntoPendiente\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
					echo "<input name=\"txtMarca\" type=\"hidden\" value=\"$_POST[txtMarca]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVO PUNTO PENDIENTE</td>
					</tr>";	
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>EL CAMPO ".$mensaje. " ESTA VAC&Iacute;O</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
					echo "</tr>";
					echo "</table>";	
					echo "</form>";				
			break 1;
			
			default:
					echo "<form name=\"frmPuntoPendiente\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
					echo "<input name=\"txtMarca\" type=\"hidden\" value=\"$_POST[txtMarca]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVO PUNTO PENDIENTE</td>
					</tr>";	
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>LOS CAMPOS ".$mensaje. " ESTAN VAC&Iacute;OS</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
					echo "</tr>";
					echo "</table>";	
					echo "</form>";	
		}
		break 1;
	case 2:
		frmPuntoPendiente();
		break 1;
	default:
		frmPuntoPendiente();	
}

function frmPuntoPendiente() {
require_once "conexionsql.php";
require_once "formularios.php";

	echo "<form name=\"frmPuntoPendiente\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">ADMINCAU - PUNTO PENDIENTE INGRESAR</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">NUEVO PUNTO PENDIENTE</td>
  				</tr>
		<tr align center><td valign=top class=\"formularioCampoTitulo\">PUNTO PENDIENTE<br>
		<input class=\"formularioCampoTexto\" name=\"txtPuntoPendiente\" type=\"text\" value=\"$_POST[txtPuntoPendiente]\">
		<br></td></tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\"><input name=\"btnPuntoPendiente\" type=\"submit\" value=\"AGREGAR\"></td>
  				</tr>";
	echo "</table>";
	echo "</form>";	
} 
?>
