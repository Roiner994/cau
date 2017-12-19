<?php
//SITIO MODIFICAR
?>
<script language="javascript">
	function cambiarSeleccion() {
		document.frmSitio.funcion.value=4;
		document.frmSitio.submit();
	}
</script>
<?php
require_once "formularios.php";
switch ($funcion) {

	case 1:
		
		if (isset($_POST[selSitio]) && $_POST[selSitio]==100) {
			echo "<form name=\"frmSitio\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";

			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR SITIO</td>
			</tr>";	
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>SELECCIONE UN SITIO</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";	
			echo "</form>";	
		} else {
			formularioSitioModificar();	
		}
		break 1;


	case 2:
		if (isset($_POST[selSitio]) && $_POST[selSitio]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>SITIO</b>";
			$i++;
			$sw=1;
		}	
	
		switch ($i) {
				case 0:
					require_once "administracion.php";
					require_once "conexionsql.php";
					$user= new sitio($_POST[selSitio],$_POST[txtSitio],1);
					$resultado=$user->modificar();
					switch($resultado) {
						case 2:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
							
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR SITIO</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR, SITIO DUPLICADO</td>";
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
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR SITIO</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE MODIFICO EL SITIO</td>";
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
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR SITIO</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR EL SITIO</td>";
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
					echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR SITIO</td>
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
					echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR SITIO</td>
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
			formularioSeleccionarSitio();
			break 1;
			
			case 4:
			formularioSitioModificar(1);
			break 1;
			
			default:
			formularioSeleccionarSitio();	
}
?>






<?php
//FORMULARIO SELECCIONAR SITIO
function formularioSeleccionarSitio() {
require_once "conexionsql.php";
require_once "formularios.php";
$conSitio= "select id_sitio,sitio from sitio where status_activo=1 order by sitio";
	//CAMPO MODELO
	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","onChange","",$conSitio,"--SITIO--","");
	$selSitio=$sitio->retornar();

echo "<form name=\"frmSitio\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";

	echo "<table class=\"formularioTabla\"align=center width=\"100\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">MODIFICAR SITIO</td>
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
<tr align=center><td valign=top class=\"formularioCampoTitulo\" ><p align=center >SITIO<br>$selSitio<br></tr>";
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
function formularioSitioModificar($cambiar=0) {
	require_once "formularios.php";
	require_once "conexionsql.php";
	require_once("administracion.php");
	if ($cambiar==0) {	
		$sitio= new sitio($_POST[selSitio]);
		$resultado=$sitio->buscarSitio();
		if ($resultado && $resultado!=1) {
			$row=mysql_fetch_array($resultado);
			$_POST[txtIdSitio]=$row[0];
			$_POST[txtSitio]=$row[1];
		}
	}
	//CAMPO SITIO
	$sitio= new campo("txtSitio","text","formularioCampoTexto","$_POST[txtSitio]","","","","");
	$txtSitio=$sitio->retornar();
	
	echo "<form name=\"frmSitio\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
	echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";

	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">INVENTARIO - MODIFICAR SITIO</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">MODIFICAR SITIO</td>
  				</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">SITIO<br>
			$txtSitio<br>
		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=21'\"><input name=\"Limpiar\" type=\"submit\" value=\"GUARDAR\"></td>
  				</tr>";
	echo "</table>";
	echo "</form>";	
}
?>
