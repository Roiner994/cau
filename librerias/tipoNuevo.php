<?php
$funcion=$_POST['funcion'];
switch ($funcion) {
	case 1:
		$sw=0;
		$mensaje="";
		if (isset($_POST[txtTipo]) && empty($_POST[txtTipo])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>TIPO</b>";
			$i++;
			$sw=1; 
		}
		switch ($i) {
			case 0:
			require_once("administracion.php");
			$sitio=new tipo();
			$sitio->setTipo("",$_POST[txtTipo]);
			$resultado=$sitio->ingresar();
			switch ($resultado) {
				case 0:
					echo "<form name=\"frmSitio\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"txtTipo\" type=\"hidden\" value=\"\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVO TIPO</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO UN NUEVO TIPO</td>";
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
					echo "<form name=\"frmSitio\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"txtTipo\" type=\"hidden\" value=\"$_POST[txtTipo]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVO TIPO</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR EL TIPO</td>";
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
					echo "<form name=\"frmSitio\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"txtTipo\" type=\"hidden\" value=\"$_POST[txtTipo]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVO TIPO</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR, TIPO DUPLICADO</td>";
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
					echo "<form name=\"frmSitio\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVO TIPO</td>
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
					echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
					echo "<input name=\"txtMarca\" type=\"hidden\" value=\"$_POST[txtMarca]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVO SITIO</td>
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
		frmSitio();
		break 1;
	default:
		frmSitio();	
}

function frmSitio() {
require_once "conexionsql.php";
require_once "formularios.php";

	echo "<form name=\"frmSitio\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">ADMINCAU - TIPO INGRESAR</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">NUEVO TIPO</td>
  				</tr>
		<tr align center><td valign=top class=\"formularioCampoTitulo\">TIPO<br>
		<input class=\"formularioCampoTexto\" name=\"txtTipo\" type=\"text\" value=\"$_POST[txtTipo]\">
		<br></td></tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\"><input name=\"btnmarca\" type=\"submit\" value=\"AGREGAR\"></td>
  				</tr>";
	echo "</table>";
	echo "</form>";	
} 
?>
