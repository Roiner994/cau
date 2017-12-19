<script>
	function cambiarSeleccion() {
		document.formularioDescripcion.funcion.value=2;
		document.formularioDescripcion.submit();
	}
</script>


<?php
//AGREGAR DESCRIPCION

require_once "formularios.php";

switch($funcion) {
		case '1':
			$sw=0;
			$mensaje="";
			if (isset($_POST[txtDescripcion]) && empty($_POST[txtDescripcion])) {
				if ($sw==1) {
					$mensaje=$mensaje."<b>,</b>";
				}
				$mensaje=$mensaje." <b>DESCRIPCION</b>";
				$i++;
				$sw=1; 
		 }
		 switch ($i) {
				case 0:
					require_once "administracion.php";
					require_once "conexionsql.php";
					require_once "DescripcionAdmin.php";
					
					$descripcion= new descripcion("",$_POST[txtDescripcion],1,$_POST[selDescripcionPropiedad],0,$_POST[SelSuministro],0);
					$resultado=$descripcion->ingresarDescripcion($_POST[chkMarca]);
					switch($resultado) {
						case 0:
		
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"txtDescripcion\" type=\"hidden\" value=\"$_POST[txtDescripcion]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - NUEVA DESCRIPCION</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO LA NUEVA DESCRIPCI&Oacute;N</td>";
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
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"txtDescripcion\" type=\"hidden\" value=\"\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - NUEVA DESCRIPCION</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR LA DESCRIPCI&Oacute;N</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>
							<input name=\"btnSalir\" type=\"button\" value=\"SALIR\" onclick=\"location.href='index2.php?item=1000'\">
							</td>";
							echo "</tr>";
							echo "</table>";						
							echo "</form>";	
							break 1;
						case 2:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"txtDescripcion\" type=\"hidden\" value=\"\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - NUEVA DESCRIPCION</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>YA EXISTE UNA DESCRIPCI&Oacute;N CON ESE NOMBRE</td>";
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
					echo "<input name=\"txtDescripcion\" type=\"hidden\" value=\"$_POST[txtDescripcion]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: INVENTARIO - NUEVA DESCRIPCION</td>
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
					echo "<input name=\"txtDescripcion\" type=\"hidden\" value=\"$_POST[txtDescripcion]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: INVENTARIO - NUEVA DESCRIPCION</td>
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
			formularioDescripcion();
			break 1;
		default:
			formularioDescripcion();
	}   			
?>
<?php			
//FORMULARIO NUEVA DESCRIPCION
function formularioDescripcion() {
require_once "conexionsql.php";
require_once "formularios.php";
$conDescripcion= "SELECT ID_DESCRIPCION,DESCRIPCION from descripcion WHERE STATUS_ACTIVO = '1' ORDER BY DESCRIPCION ASC";
$conDescripcionPropiedad="select id_descripcion_propiedad,descripcion_propiedad from descripcion_propiedad order by descripcion_propiedad";

	$descripcion= new campo("txtDescripcion","text","$clase","$_POST[txtDescripcion]","30","30");
	$txtDescripcion=$descripcion->retornar();
	

	//Campo Descripcion Propiedad
	$descripcionPropiedad= new campoSeleccion("selDescripcionPropiedad","formularioCampoSeleccion","$_POST[selDescripcionPropiedad]","onChange","cambiarSeleccion()",$conDescripcionPropiedad,"--DESCRIPCION PROPIEDAD--","");
	$selDescripcionPropiedad=$descripcionPropiedad->retornar();
	
	
	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"500\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">ADMINCAU - DESCRIPCION INGRESAR</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">NUEVA DESCRIPCION</td>
  				</tr>
  		<tr align center>
		<td valign=top class=\"formularioCampoTitulo\">DESCRIPCION<br>$txtDescripcion<br></td>
		</tr>
		<tr align center>
		<td valign=top class=\"formularioCampoTitulo\">DESCRIPCION PROPIEDAD<br>$selDescripcionPropiedad<br></td>
		</tr>						
		<tr align center>
		<td valign=top class=\"formularioCampoTitulo\">SUMINISTRO<br>
		<select name=\"SelSuministro\" class=\"formularioSeleccion\">";
			if ($suministro==0) {
				echo "<option selected value=\"0\">NO</option>";
				echo "<option value=\"1\">SI</option>";
			} else {
				echo "<option value=\"0\">NO</option>";
				echo "<option selected value=\"1\">SI</option>";
			}
			echo "</select><br></td>
		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\"><input name=\"btnDescripcion\" type=\"submit\" onClick=\"\" value=\"INGRESAR\"></td>
  				</tr>";
	echo "</table>";
	
	require_once("marcaAdmin.php");

require_once("conexionsql.php");
require_once("administracion.php");

$consulta="select id_marca,marca from marca where status_activo=1 order by marca";


conectarMysql();
$result=mysql_query($consulta);
mysql_close();

if ($result && mysql_numrows($result)>0) { 
	echo "<table align=\"center\">";
	echo "<div id=\"navcontainer\">";

	echo "<ul id=\"navlist\">";

	while ($row=mysql_fetch_array($result)) { 
		if($i==4) { 
			echo "</ul>
			<ul id=\"navlist\">";
			
		$i=0; 
		} 
		echo "<li><input name=\"chkMarca[]\" type=\"checkbox\" value=\"$row[0]\">$row[1]</li>";
	$i++;
	} 
echo "</ul>
	</div></table>";

}
echo "<table align=\"center\" width=\"500\" border=\"0\">";
 	echo "<tr>";
		echo "<td class=\"formularioTablaBotones\"><input name=\"btnDescripcion\" type=\"submit\" onClick=\"\" value=\"INGRESAR\"></td>
  		</tr>";
	echo "</table>";
	echo "</form>";	
	
    } 
?>