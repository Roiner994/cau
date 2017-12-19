<?php
//GERENCIA MODIFICAR
?>
<script language="javascript">
	function cambiarSeleccion() {
		document.frmGerencia.funcion.value=4;
		document.frmGerencia.submit();
	}
</script>
<?php
require_once "formularios.php";
switch ($funcion) {

	case 1:
		
		if (isset($_POST[selGerencia]) && $_POST[selGerencia]==100) {
			echo "<form name=\"frmGerencia\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";

			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR GERENCIA</td>
			</tr>";	
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>SELECCIONE UNA GERENCIA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";	
			echo "</form>";	
		} else {
			formularioGerenciaModificar();	
		}
		break 1;


	case 2:
		if (isset($_POST[selGerencia]) && $_POST[selGerencia]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>GERENCIA</b>";
			$i++;
			$sw=1;
		}	
	
		switch ($i) {
				case 0:
					require_once "administracion.php";
					require_once "conexionsql.php";
					$user= new gerencia($_POST[selGerencia],$_POST[txtGerencia],1);
					$resultado=$user->modificar();
					switch($resultado) {
						case 2:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
							
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR GERENCIA</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR, GERENCIA DUPLICADA</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>
							<input name=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\">
							</td>";
							echo "</tr>";
							echo "</table>";						
							echo "</form>";	
							break 1;
						case 0:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";

							
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR GERENCIA</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE MODIFICO LA GERENCIA</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>
							<input name=\"btnSalir\" type=\"button\" value=\"SALIR\" onclick=\"location.href='index2.php?item=1000'\">
							</td>";
							echo "</tr>";
							echo "</table>";						
							echo "</form>";	
							break 1;
						case 1:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";

							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR GERENCIA</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR LA GERENCIA</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>
							<input name=\"btnSalir\" type=\"button\" value=\"SALIR\" onclick=\"location.href='index2.php?item=1000'\">
							</td>";
							echo "</tr>";
							echo "</table>";						
							echo "</form>";	
							break 1;
				}
				break 1;
			    case 1:
					echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";

					
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR GERENCIA</td>
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

					
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR GERENCIA</td>
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
			case 3:
			formularioSeleccionarGerencia();
			break 1;
			
			case 4:
			formularioGerenciaModificar(1);
			break 1;
			
			default:
			formularioSeleccionarGerencia();	
}
?>






<?php
//FORMULARIO SELECCIONAR GERENCIA
function formularioSeleccionarGerencia() {
require_once "conexionsql.php";
require_once "formularios.php";
$conGerencia= "select id_gerencia,gerencia from gerencia where status_activo=1 order by gerencia";
	//CAMPO MODELO
	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","",$conGerencia,"--GERENCIA--","");
	$selGerencia=$gerencia->retornar();

echo "<form name=\"frmGerencia\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";

	echo "<table class=\"formularioTabla\"align=center width=\"100\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">MODIFICAR GERENCIA</td>
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
<tr align=center><td valign=top class=\"formularioCampoTitulo\" ><p align=center >GERENCIA<br>$selGerencia<br></tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnModificar\" type=\"submit\" value=\"MODIFICAR\">
			</td>
  		</tr>";
echo "</table>";
echo "</form>";	
				
} 
?>





<?php
//FORMULARIO MODIFICAR MODELO
function formularioGerenciaModificar($cambiar=0) {
	require_once "formularios.php";
	require_once "conexionsql.php";
	require_once("administracion.php");
	if ($cambiar==0) {	
		$gerencia= new gerencia($_POST[selGerencia]);
		$resultado=$gerencia->buscarGerencia();
		if ($resultado && $resultado!=1) {
			$row=mysql_fetch_array($resultado);
			$_POST[txtIdGerencia]=$row[0];
			$_POST[txtGerencia]=$row[1];
		}
	}
	//CAMPO GERENCIA
	$gerencia= new campo("txtGerencia","text","formularioCampoTexto","$_POST[txtGerencia]","30","30","","");
	$txtGerencia=$gerencia->retornar();
	
	echo "<form name=\"frmGerencia\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
	echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";

	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">INVENTARIO - MODIFICAR GERENCIA</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">MODIFICAR GERENCIA</td>
  				</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">GERENCIA<br>
			$txtGerencia<br>
		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=21'\"><input name=\"Limpiar\" type=\"submit\" value=\"GUARDAR\"></td>
  				</tr>";
	echo "</table>";
	echo "</form>";	
}
?>
