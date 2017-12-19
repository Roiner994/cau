 <script language="javascript">

	function ingresar() {
		if (document.frmSoftware.txtSoftware.value!="") {
			document.frmSoftware.funcion.value=formularioSoftware();
			document.frmSoftware.submit();
		}
	}


</script>
<?php
//verificar TIPO DE SOFTWARE
require_once "formularios.php";
switch ($funcion) {

	case 1:
		
		if (isset($_POST[selTipoSoftware]) && $_POST[selTipoSoftware]==100) {
			echo "<form name=\"frmtipoSoftware\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
		
			echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
			echo "<input name=\"selSoftware\" type=\"hidden\" value=\"$_POST[selSoftware]\">";
			echo "<input name=\"txtSoftware\" type=\"hidden\" value=\"$_POST[txtSoftware]\">";
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR SOFTWARE</td>
			</tr>";	
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>SELECCIONE UN TIPO DE SOFTWARE</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";	
			echo "</form>";	
		} else {
			formularioSoftware();		
		}
		break 1;
	case 2:
		$sw=0;
		$mensaje="";
		if (isset($_POST[txtSoftware]) && empty($_POST[txtSoftware])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>SOFTWARE</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[selTipoSoftware]) && $_POST[selTipoSoftware]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>TIPO DE SOFTWARE</b>";
			$i++;
			$sw=1;
		}
	
	switch ($i) {
				case 0:
					require_once "administracion.php";
					require_once "conexionsql.php";
					require_once "softwareAdmin.php";					
					$user= new software($_POST[selTipoSoftware],"","",$_POST[selSoftware],$_POST[txtSoftware]);
					$resultado=$user-> modificarSoftware();
					switch($resultado) {
						case 2:
							echo "<form name=\"frmtipoSoftware\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
							echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
							echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
							echo "<input name=\"selSoftware\" type=\"hidden\" value=\"$_POST[selSoftware]\">";
							echo "<input name=\"txtSoftware\" type=\"hidden\" value=\"$_POST[txtSoftware]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR TIPO DE SOFTWARE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR, TIPO DE SOFTWARE DUPLICADO</td>";
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
							echo "<form name=\"frmtipoSoftware\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
							echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
							echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
							echo "<input name=\"selSoftware\" type=\"hidden\" value=\"$_POST[selSoftware]\">";
							echo "<input name=\"txtSoftware\" type=\"hidden\" value=\"$_POST[txtSoftware]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR  SOFTWARE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE MODIFICO SOFTWARE</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>
							<input name=\"btnSalir\" type=\"button\" value=\"SALIR\" onclick=\"location.href='index2.php?item=1000'\">
							</td>";
							echo "</tr>";
							echo "</table>";						
							echo "</form>";	
							break 1;
						case 3:
							echo "<form name=\"frmtipoSoftware\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
							echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
							echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
							echo "<input name=\"selSoftware\" type=\"hidden\" value=\"$_POST[selSoftware]\">";
							echo "<input name=\"txtSoftware\" type=\"hidden\" value=\"$_POST[txtSoftware]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMMINCAU - MODIFICAR  SOFTWARE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE </td>";
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
					echo "<form name=\"frmtipoSoftware\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
					echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
					echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
					echo "<input name=\"selSoftware\" type=\"hidden\" value=\"$_POST[selSoftware]\">";
					echo "<input name=\"txtSoftware\" type=\"hidden\" value=\"$_POST[txtSoftware]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMMINCAU - MODIFICAR TIPO DE SOFTWARE</td>
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
					echo "<form name=\"frmtipoSoftware\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
					echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
					echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
					echo "<input name=\"selSoftware\" type=\"hidden\" value=\"$_POST[selSoftware]\">";
					echo "<input name=\"txtSoftware\" type=\"hidden\" value=\"$_POST[txtSoftware]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMMINCAU - MODIFICAR TIPO DE SOFTWARE</td>
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
		  formularioSoftwareEliminar();
		break 1;
	default:
		  formularioSoftwareEliminar();
}

?>



 <?php
//FORMULARIO INGRESAR SOFTWARE
function formularioSoftware() {
	require_once "formularios.php";
	require_once "conexionsql.php";
	
	//CAMPO TIPO DE SOFTWARE		
	$conTipoSoftware= "SELECT ID_TIPO_SOFTWARE,TIPO_SOFTWARE from tipo_software WHERE STATUS_ACTIVO = '1' ORDER BY tipo_software ASC";
	conectarMysql();
	$result= mysql_query($conTipoSoftware);
	$row=mysql_fetch_array($result);
	$_POST[selTipoSoftware]=$row[0];
	$tipoSoftware= new campoSeleccion("selTipoSoftware","formularioCampoSeleccion","$_POST[selTipoSoftware]","onChange","",$conTipoSoftware,"--SELECCIONE--","");
	$selTipoSoftware=$tipoSoftware->retornar();
	
	
	//CAMPO SOFTWARE
	$conSoftware= "SELECT ID_SOFTWARE,SOFTWARE from software WHERE id_software='$_POST[selSoftware]' ORDER BY software ASC";
	conectarMysql();
	$result= mysql_query($conSoftware);
	$row=mysql_fetch_array($result);
	$_POST[txtSoftware]=$row[1];
	$software= new campo("txtSoftware","text","$clase","$_POST[txtSoftware]","30","30");
	$txtSoftware=$software->retornar();
	
	
	
	echo "<form name=\"frmSoftware\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
	echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
	echo "<input name=\"selTipoSoftware\" type=\"hidden\" value=\"$_POST[selTipoSoftware]\">";
	echo "<input name=\"selSoftware\" type=\"hidden\" value=\"$_POST[selSoftware]\">";
	echo "<input name=\"txtSoftware\" type=\"hidden\" value=\"$_POST[txtSoftware]\">";
	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">ADMINCAU - MODIFICAR SOFTWARE</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">INGRESAR SOFTWARE</td>
  				</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">TIPO DE SOFTWARE<br>
			$selTipoSoftware<br>			
			SOFTWARE<br>$txtSoftware<br></td>
		</tr>";
	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"Limpiar\" type=\"submit\" value=\"GUARDAR\"></td>
  				</tr>";
			echo "<tr>";
		
	echo "</table>";
	echo "</form>";	
}
?>	 


<?php
//FORMULARIO SELECCIONAR ELIMINAR SOFTWARE
function formularioSoftwareEliminar() {
require_once "conexionsql.php";
require_once "formularios.php";
$conSoftware= "SELECT ID_SOFTWARE,SOFTWARE from software WHERE ESTATUS_ACTIVO = '1' ORDER BY software ASC";
	//Campo  tipo de software
	$software= new campoSeleccion("selSoftware","formularioCampoSeleccion","$_POST[selSoftware]","onChange","",$conSoftware,"--SELECCIONE--","");
	$selSoftware=$software->retornar();

echo "<form name=\"frmSoftware\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"selSoftware\" type=\"hidden\" value=\"$_POST[selSoftware]\">";

	echo "<table class=\"formularioTabla\"align=center width=\"100\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">MODIFICAR SOFTWARE</td>
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr><tr align=center><td valign=top class=\"formularioCampoTitulo\" ><p align=center >SOFTWARE<br>$selSoftware<br></tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"submit\" value=\"MODIFICAR\">
			</td>
  		</tr>";
echo "</table>";
echo "</form>";					
} 
?>