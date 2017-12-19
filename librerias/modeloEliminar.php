<?php
//VERIFICAR MODELO
require_once "formularios.php";
switch ($funcion) {

	case 1:
		
		if (isset($_POST[selModelo]) && $_POST[selModelo]==100) {
			echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			
			echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
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
					
			$i++;
		}
		break 1;
	case 2:
		formularioModeloEliminar();
		break 1;
	default:
		formularioModeloEliminar();
}
	
	switch ($i) {
				case 1:
					require_once "administracion.php";
					require_once "conexionsql.php";
					require_once "modeloAdmin.php";
					$user= new modelo("","",$_POST[selModelo],"","","",1);
					
					$resultado=$user-> modeloEliminar1();
					
					switch($resultado) {
						
						case 0:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - ELIMINAR MODELO</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE ELIMINO MODELO </td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>
							<input name=\"btnSalir\" type=\"button\" value=\"SALIR\" onclick=\"location.href='secciones.php?item=1000'\">
							</td>";
							echo "</tr>";
							echo "</table>";						
							echo "</form>";	
							break 1;
						case 1:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - ELIMINAR MODELO</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>imposible eliminar </td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>
							<input name=\"btnSalir\" type=\"button\" value=\"SALIR\" onclick=\"location.href='secciones.php?item=1000'\">
							</td>";
							echo "</tr>";
							echo "</table>";						
							echo "</form>";	
							break 1;
							
					}
					break 1;	
				
		}

?>
<?php
//FORMULARIO SELECCIONAR MODELO A ELIMINAR
function formularioModeloEliminar() {
require_once "conexionsql.php";
require_once "formularios.php";
$conModelo= "select id_modelo, concat(descripcion.descripcion,' ',marca.marca,' ',modelo.modelo) as modelo
from modelo inner join descripcion on modelo.id_descripcion=descripcion.id_descripcion
inner join marca on modelo.id_marca=marca.id_marca where modelo.status_activo='1'
order by modelo";
	//CAMPO MODELO
	$modelo= new campoSeleccion("selModelo","formularioCampoSeleccion","$_POST[selModelo]","onChange","",$conModelo,"--MODELO--","");
	$selModelo=$modelo->retornar();

echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
	

	echo "<table class=\"formularioTabla\"align=center width=\"100\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">ELIMINAR MODELO</td>
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
<tr align=center><td valign=top class=\"formularioCampoTitulo\" ><p align=center >MODELO<br>$selModelo<br></tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnModificar\" type=\"submit\" value=\"ELIMINAR\">
			</td>
  		</tr>";
echo "</table>";
echo "</form>";	
				
} 
?>