<script language="javascript">
	function cambiarSeleccion() {
		document.frmModelo.funcion.value=4;
		document.frmModelo.submit();
	}
</script>
<?php
require_once "formularios.php";
switch ($funcion) {

	case 1:
		
		if (isset($_POST[selModelo]) && $_POST[selModelo]==100) {
			echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
			echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
			echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
			echo "<input name=\"txtModelo\" type=\"hidden\" value=\"$_POST[txtModelo]\">";
			echo "<input name=\"txtTipo\" type=\"hidden\" value=\"$_POST[txtTipo]\">";
			echo "<input name=\"txtUnidad\" type=\"hidden\" value=\"$_POST[txtUnidad]\">";
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR MODELO</td>
			</tr>";	
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>SELECCIONE UN MODELO</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";	
			echo "</form>";	
		} else {
			formularioModeloModificar();	
		}
		break 1;


	case 2:
		if (isset($_POST[selDescripcion]) && $_POST[selDescripcion]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>DESCRIPCION</b>";
			$i++;
			$sw=1;
		}	
		if (isset($_POST[selMarca]) && $_POST[selMarca]==100){
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>MARCA</b>";
			$i++;
			$sw=1;
		}	
		if (isset($_POST[txtModelo]) && empty($_POST[txtModelo])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>MODELO</b>";
			$i++;
			$sw=1;
		}	
		
			
		
		switch ($i) {
				case 0:
					require_once "administracion.php";
					require_once "conexionsql.php";
					require_once "modeloAdmin.php";
					$user= new modelo($_POST[selDescripcion],$_POST[selMarca],$_POST[selModelo],$_POST[txtModelo],$_POST[txtTipo],$_POST[txtUnidad],1);
					$resultado=$user->modificarModelo();
					switch($resultado) {
						case 2:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
							echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
							echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
							echo "<input name=\"txtModelo\" type=\"hidden\" value=\"$_POST[txtModelo]\">";
							echo "<input name=\"txtTipo\" type=\"hidden\" value=\"$_POST[txtTipo]\">";
							echo "<input name=\"txtUnidad\" type=\"hidden\" value=\"$_POST[txtUnidad]\">";
							
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR MODELO</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR, MODELO DUPLICADO</td>";
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
							echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
							echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
							echo "<input name=\"txtModelo\" type=\"hidden\" value=\"$_POST[txtModelo]\">";
							echo "<input name=\"txtTipo\" type=\"hidden\" value=\"$_POST[txtTipo]\">";
							echo "<input name=\"txtUnidad\" type=\"hidden\" value=\"$_POST[txtUnidad]\">";
							
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR MODELO</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE MODIFICO MODELO</td>";
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
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
							echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
							echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
							echo "<input name=\"txtModelo\" type=\"hidden\" value=\"$_POST[txtModelo]\">";
							echo "<input name=\"txtTipo\" type=\"hidden\" value=\"$_POST[txtTipo]\">";
							echo "<input name=\"txtUnidad\" type=\"hidden\" value=\"$_POST[txtUnidad]\">";
							
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - MODIFICAR MODELO</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR EN BASE DE DATOS</td>";
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
					echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
					echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
					echo "<input name=\"txtModelo\" type=\"hidden\" value=\"$_POST[txtModelo]\">";
					echo "<input name=\"txtTipo\" type=\"hidden\" value=\"$_POST[txtTipo]\">";
					echo "<input name=\"txtUnidad\" type=\"hidden\" value=\"$_POST[txtUnidad]\">";
					
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR MODELO</td>
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
					echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
					echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
					echo "<input name=\"txtModelo\" type=\"hidden\" value=\"$_POST[txtModelo]\">";
					echo "<input name=\"txtTipo\" type=\"hidden\" value=\"$_POST[txtTipo]\">";
					echo "<input name=\"txtUnidad\" type=\"hidden\" value=\"$_POST[txtUnidad]\">";
					
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR MODELO</td>
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
			formularioSeleccionarModelo();
			break 1;
			
			case 4:
			formularioModeloModificar(1);
			break 1;
			
			default:
			formularioSeleccionarModelo();	
}
?>






<?php
//FORMULARIO SELECCIONAR MODELO
function formularioSeleccionarModelo() {
require_once "conexionsql.php";
require_once "formularios.php";
$conModelo= "select id_modelo, concat(descripcion.descripcion,' ',marca.marca,' ',modelo.modelo,' ',cap_vel,' ',unidad) as modelo
from modelo inner join descripcion on modelo.id_descripcion=descripcion.id_descripcion
inner join marca on modelo.id_marca=marca.id_marca where modelo.status_activo='1'
order by modelo";
	//CAMPO MODELO
	$modelo= new campoSeleccion("selModelo","formularioCampoSeleccion","$_POST[selModelo]","onChange","",$conModelo,"--MODELO--","");
	$selModelo=$modelo->retornar();

echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";

	echo "<table class=\"formularioTabla\"align=center width=\"100\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">MODIFICAR MODELO</td>
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
<tr align=center><td valign=top class=\"formularioCampoTitulo\" ><p align=center >MODELO<br>$selModelo<br></tr>";
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
function formularioModeloModificar($cambiar=0) {
	require_once "formularios.php";
	require_once "conexionsql.php";
	require_once("modeloAdmin.php");
	if ($cambiar==0) {	
		$componente= new modelo("","",$_POST[selModelo]);
		$resultado=$componente->buscarModelo();
		if ($resultado && $resultado!=1) {
			$row=mysql_fetch_array($resultado);
			$_POST[selDescripcion]=$row[6];
			$_POST[selMarca]=$row[4];
			$_POST[txtModelo]=$row[1];
			$_POST[txtTipo]=$row[2];
			$_POST[txtUnidad]=$row[3];	
		}
	}
	//CAMPO DESCRIPCION
	$conDescripcion= "SELECT ID_DESCRIPCION,DESCRIPCION from descripcion WHERE STATUS_ACTIVO = '1' ORDER BY DESCRIPCION ASC";
	$descripcion= new campoSeleccion("selDescripcion","formularioCampoTexto","$_POST[selDescripcion]","onChange","cambiarSeleccion()","$conDescripcion","--DESCRIPCION--","");
	$selDescripcion=$descripcion->retornar();
	
	//CAMPO MARCA
	$conMarca= "SELECT descripcion_marca.ID_MARCA, MARCA FROM descripcion_marca INNER JOIN marca ON descripcion_marca.ID_MARCA=marca.ID_MARCA
	WHERE descripcion_marca.ID_DESCRIPCION ='$_POST[selDescripcion]' ORDER BY MARCA";
	$marca= new campoSeleccion("selMarca","formularioCampoSeleccion","$_POST[selMarca]","onChange","",$conMarca,"--MARCA--","");
	$selMarca=$marca->retornar();

	$modelo= new campo("txtModelo","text","formularioCampoTexto","$_POST[txtModelo]","30","30","","");
	$txtModelo=$modelo->retornar();
	
	//CAMPO TIPO
	$tipo= new campo("txtTipo","text","formularioCampoTexto","$_POST[txtTipo]","30","30","","");
	$txtTipo=$tipo->retornar();
	
	//CAMPO UNIDAD
	$unidad= new campo("txtUnidad","text","formularioCampoTexto","$_POST[txtUnidad]","30","30","","");
	$txtUnidad=$unidad->retornar();
	
	echo "<form name=\"frmModelo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
	echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
	

	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">INVENTARIO - MODIFICAR MODELO</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">MODIFICAR MODELO</td>
  				</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">DESCRIPCION<br>
			$selDescripcion<br>
			MARCA<br>$selMarca<br>
			MODELO<br>$txtModelo<br>
			TIPO<br>$txtTipo<br>
			UNIDAD<br>$txtUnidad<br></td>
		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=21'\"><input name=\"Limpiar\" type=\"submit\" value=\"GUARDAR\"></td>
  				</tr>";
	echo "</table>";
	echo "</form>";	
}
?>