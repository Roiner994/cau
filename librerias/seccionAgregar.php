<?php
//AgregarSeccion
switch ($funcion) {
	case 1:
		$sw=0;
		$mensaje="";
		if (isset($_POST[txtSeccion]) && empty($_POST[txtSeccion])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>SECCION</b>";
			$i++;
			$sw=1; 
	 	}
	 	switch ($i) {
	 		case 0:
	 		require_once("sitioAdmin.php");	
	 		$seccion=new seccion("",$_POST[txtSeccion]);
	 		$resultado=$seccion->ingresar();
	 		switch ($resultado) {
	 			case 0:
					echo "<form name=\"frmSeccion\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
					echo "<input name=\"txtSeccion\" type=\"hidden\" value=\"\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVA SECCION</td>
					</tr>";	
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO LA SECCION</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
					echo "</tr>";
					echo "</table>";	
					echo "</form>";
					break 1;
	 			case 1:
					echo "<form name=\"frmSeccion\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
					echo "<input name=\"txtSeccion\" type=\"hidden\" value=\"$_POST[txtSeccion]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVA SECCION</td>
					</tr>";	
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>NO SE GUARDO LA SECCION</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
					echo "</tr>";
					echo "</table>";	
					echo "</form>";	
	 				break 1;	
	 			case 2:
					echo "<form name=\"frmSeccion\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
					echo "<input name=\"txtSeccion\" type=\"hidden\" value=\"$_POST[txtSeccion]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVA SECCION</td>
					</tr>";	
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR. SECCION DUPLICADA</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
					echo "</tr>";
					echo "</table>";	
					echo "</form>";	
	 				break 1;
	 		} 
	 			break 1;
	 		case 1:
					echo "<form name=\"frmSeccion\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
					echo "<input name=\"txtSeccion\" type=\"hidden\" value=\"$_POST[txtSeccion]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVA SECCION</td>
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
				echo "<form name=\"frmSeccion\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
				echo "<input name=\"txtSeccion\" type=\"hidden\" value=\"$_POST[txtSeccion]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: ADMINCAU - NUEVA SECCION</td>
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
	default:
		frmSeccion();
}
function frmSeccion() {
require_once "formularios.php";
	$seccion= new campo("txtSeccion","text","formularioCampoTexto","$_POST[txtSeccion]","100","100");
	$txtSeccion=$seccion->retornar();	
	echo "<form name=\"frmSeccion\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">SECCI&Oacute;N DE P&Aacute;GINA</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">NUEVA SECCION</td>
  				</tr>
		<tr align center><td valign=top class=\"formularioCampoTitulo\">SECCION<br>$txtSeccion<br></td></tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\"><input name=\"btnSeccion\" type=\"submit\" onClick=\"\" value=\"INGRESAR\"></td>
  				</tr>";
	echo "</table>";
	echo "</form>";		
}
?>