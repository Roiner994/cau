<?php
switch ($funcion) {
	case 1:
		$sw=0;
		$mensaje="";
		if (isset($_POST[selGerencia]) && $_POST[selGerencia]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>GERENCIA</b>";
			$i++;
			$sw=1;
		}
		
		if (isset($_POST[txtDivision]) && empty($_POST[txtDivision])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>DIVISION</b>";
			$i++;
			$sw=1; 
		}
		switch ($i) {
			case 0:
			require_once("administracion.php");
			$division=new division();
			$division->setDivision("",$_POST[selGerencia],$_POST[txtDivision]);
			$resultado=$division->ingresar();
			switch ($resultado) {
				case 0:
					echo "<form name=\"frmDivision\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"txtDivision\" type=\"hidden\" value=\"\">";
					echo "<input name=\"selGerencia\" type=\"hidden\" value=\"\">";

					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVA DIVISION</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO UNA NUEVA DIVISION</td>";
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
					echo "<form name=\"frmDivision\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
					echo "<input name=\"txtDivision\" type=\"hidden\" value=\"$_POST[txtDivision]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVA DIVISION</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR LA DIVISION</td>";
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
					echo "<form name=\"frmDivision\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
					echo "<input name=\"txtDivision\" type=\"hidden\" value=\"$_POST[txtDivision]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVA DIVISION</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR, DIVISION DUPLICADA</td>";
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
					echo "<form name=\"frmDivision\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
					echo "<input name=\"txtDivision\" type=\"hidden\" value=\"$_POST[txtDivision]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVA DIVISION</td>
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
					echo "<form name=\"frmDivision\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
					echo "<input name=\"txtDivision\" type=\"hidden\" value=\"$_POST[txtDivision]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVA DIVISION</td>
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
		frmDivision();
		break 1;
	default:
		frmDivision();	
}

function frmDivision() {
require_once "conexionsql.php";
require_once "formularios.php";

	$conGerencia="select id_gerencia,gerencia from gerencia where status_activo=1 order by gerencia";

	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","","",$conGerencia,"--SELECCIONE--","");
	$selGerencia=$gerencia->retornar();	

	echo "<form name=\"frmDivision\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">ADMINCAU - DIVISION INGRESAR</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">NUEVA DIVISION</td>
  				</tr>
		<tr align center><td valign=top class=\"formularioCampoTitulo\">GERENCIA<br>
		$selGerencia
		</td></tr>
		<tr align center><td valign=top class=\"formularioCampoTitulo\">DIVISION<br>
		<input class=\"formularioCampoTexto\" name=\"txtDivision\" type=\"text\" value=\"$_POST[txtDivision]\">
		<br></td></tr>";
				
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\"><input name=\"btnmarca\" type=\"submit\" value=\"AGREGAR\"></td>
  				</tr>";
	echo "</table>";
	echo "</form>";	
} 
?>