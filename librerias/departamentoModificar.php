<?php
//DEPARTAMENTO MODIFICAR
?>
<script language="javascript">
	function cambiarSeleccion() {
		document.frmDepartamento.funcion.value=4;
		document.frmDepartamento.submit();
	}
</script>
<?php
require_once "formularios.php";
switch ($funcion) {

	case 1:
		
		if (isset($_POST[selDepartamento]) && $_POST[selDepartamento]==100) {
			echo "<form name=\"frmDepartamento\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";

			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR DEPARTAMENTO</td>
			</tr>";	
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>SELECCIONE UNA DEPARTAMENTO</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";	
			echo "</form>";	
		} else {
			formularioDepartamentoModificar();	
		}
		break 1;


	case 2:
		if (isset($_POST[selDepartamento]) && $_POST[selDepartamento]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>DEPARTAMENTO</b>";
			$i++;
			$sw=1;
		}	
	
		switch ($i) {
				case 0:
					require_once "administracion.php";
					require_once "conexionsql.php";
					$user= new departamento($_POST[selDepartamento],$_POST[selDivision],$_POST[txtDepartamento],1);
					$resultado=$user->modificar();
					switch($resultado) {
						case 2:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
							
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR DEPARTAMENTO</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR, DEPARTAMENTO DUPLICADA</td>";
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
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR DEPARTAMENTO</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE MODIFICO LA DEPARTAMENTO</td>";
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
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR DEPARTAMENTO</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR LA DEPARTAMENTO</td>";
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
					echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR DEPARTAMENTO</td>
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
					echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR DEPARTAMENTO</td>
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
			formularioSeleccionarDepartamento();
			break 1;
			
			case 4:
			formularioDepartamentoModificar(1);
			break 1;
			
			default:
			formularioSeleccionarDepartamento();	
}
?>






<?php
//FORMULARIO SELECCIONAR DEPARTAMENTO
function formularioSeleccionarDepartamento() {
require_once "conexionsql.php";
require_once "formularios.php";
$conDepartamento= "select id_departamento,departamento from departamento where id_departamento<>id_division and status_activo=1 order by departamento";
	//CAMPO MODELO
	$departamento= new campoSeleccion("selDepartamento","formularioCampoSeleccion","$_POST[selDepartamento]","onChange","",$conDepartamento,"--DEPARTAMENTO--","");
	$selDepartamento=$departamento->retornar();

echo "<form name=\"frmDepartamento\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";

	echo "<table class=\"formularioTabla\"align=center width=\"100\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">MODIFICAR DEPARTAMENTO</td>
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
<tr align=center><td valign=top class=\"formularioCampoTitulo\" ><p align=center >DEPARTAMENTO<br>$selDepartamento<br></tr>";
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
function formularioDepartamentoModificar($cambiar=0) {
	require_once "formularios.php";
	require_once "conexionsql.php";
	require_once("administracion.php");
	if ($cambiar==0) {	
		$departamento= new departamento($_POST[selDepartamento]);
		$resultado=$departamento->buscarDepartamento();
		if ($resultado && $resultado!=1) {
			$row=mysql_fetch_array($resultado);
			$_POST[txtIdDepartamento]=$row[0];
			$_POST[selDivision]=$row[1];
			$_POST[txtDepartamento]=$row[2];
		}
	}

	$conDivision="SELECT ID_DIVISION, DIVISION FROM division where id_gerencia<>id_division and status_activo=1 ORDER BY DIVISION";
	//Campo de la Division		
	$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","cambiarSeleccion()",$conDivision,"--DIVISION--","");
	$selDivision=$division->retornar();
		
	//CAMPO DEPARTAMENTO
	$departamento= new campo("txtDepartamento","text","formularioCampoTexto","$_POST[txtDepartamento]","","","","");
	$txtDepartamento=$departamento->retornar();
	
	echo "<form name=\"frmDepartamento\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
	echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";

	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">INVENTARIO - MODIFICAR DEPARTAMENTO</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">MODIFICAR DEPARTAMENTO</td>
  				</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">DIVISION
			$selDivision<br>		
    		DEPARTAMENTO<br>
			$txtDepartamento<br>
		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=21'\"><input name=\"Limpiar\" type=\"submit\" value=\"GUARDAR\"></td>
  				</tr>";
	echo "</table>";
	echo "</form>";	
}
?>