<?php
//DIVISION MODIFICAR
?>
<script language="javascript">
	function cambiarSeleccion() {
		document.frmDivision.funcion.value=4;
		document.frmDivision.submit();
	}
</script>
<?php
require_once "formularios.php";
switch ($funcion) {

	case 1:
		
		if (isset($_POST[selDivision]) && $_POST[selDivision]==100) {
			echo "<form name=\"frmDivision\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";

			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR DIVISION</td>
			</tr>";	
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>SELECCIONE UNA DIVISION</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";	
			echo "</form>";	
		} else {
			formularioDivisionModificar();	
		}
		break 1;


	case 2:
		if (isset($_POST[selDivision]) && $_POST[selDivision]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>DIVISION</b>";
			$i++;
			$sw=1;
		}	
	
		switch ($i) {
				case 0:
					require_once "administracion.php";
					require_once "conexionsql.php";
					$user= new division($_POST[selDivision],$_POST[selGerencia],$_POST[txtDivision],1);
					$resultado=$user->modificar();
					switch($resultado) {
						case 2:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
							
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR DIVISION</td>
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
						case 0:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";

							
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR DIVISION</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE MODIFICO LA DIVISION</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>
							<input name=\"btnSalir\" type=\"button\" value=\"SALIR\" onclick=\"location.href='index2?item=1000'\">
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
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR DIVISION</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR LA DIVISION</td>";
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
					echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR DIVISION</td>
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
					echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR DIVISION</td>
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
			formularioSeleccionarDivision();
			break 1;
			
			case 4:
			formularioDivisionModificar(1);
			break 1;
			
			default:
			formularioSeleccionarDivision();	
}
?>






<?php
//FORMULARIO SELECCIONAR DIVISION
function formularioSeleccionarDivision() {
require_once "conexionsql.php";
require_once "formularios.php";
$conDivision= "select id_division,division from division where id_division<>id_gerencia and status_activo=1 order by division";
	//CAMPO MODELO
	$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","",$conDivision,"--DIVISION--","");
	$selDivision=$division->retornar();

echo "<form name=\"frmDivision\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";

	echo "<table class=\"formularioTabla\"align=center width=\"100\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">MODIFICAR DIVISION</td>
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
<tr align=center><td valign=top class=\"formularioCampoTitulo\" ><p align=center >DIVISION<br>$selDivision<br></tr>";
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
function formularioDivisionModificar($cambiar=0) {
	require_once "formularios.php";
	require_once "conexionsql.php";
	require_once("administracion.php");
	if ($cambiar==0) {	
		$division= new division($_POST[selDivision]);
		$resultado=$division->buscarDivision();
		if ($resultado && $resultado!=1) {
			$row=mysql_fetch_array($resultado);
			$_POST[txtIdDivision]=$row[0];
			$_POST[selGerencia]=$row[1];
			$_POST[txtDivision]=$row[2];
		}
	}

	$conGerencia="SELECT ID_GERENCIA, GERENCIA FROM gerencia where status_activo=1 ORDER BY GERENCIA";
	//Campo de la Gerencia		
	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","cambiarSeleccion()",$conGerencia,"--GERENCIA--","");
	$selGerencia=$gerencia->retornar();
		
	//CAMPO DIVISION
	$division= new campo("txtDivision","text","formularioCampoTexto","$_POST[txtDivision]","","","","");
	$txtDivision=$division->retornar();
	
	echo "<form name=\"frmDivision\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
	echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";

	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">INVENTARIO - MODIFICAR DIVISION</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">MODIFICAR DIVISION</td>
  				</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">GERENCIA
			$selGerencia<br>		
    		DIVISION<br>
			$txtDivision<br>
		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=21'\"><input name=\"Limpiar\" type=\"submit\" value=\"GUARDAR\"></td>
  				</tr>";
	echo "</table>";
	echo "</form>";	
}
?>