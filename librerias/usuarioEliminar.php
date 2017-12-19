<?php
//Modulo de Eliminar un Usuario
//Formulario para eliminar un Usuario en el Sistema
require_once "administracion.php";
require_once "UsuarioAdmin.php";
require_once "conexionsql.php";
require_once "formularios.php";
if (isset($ficha) && !empty($ficha)) {
	if ($_POST[funcion]!=3) {
		$_POST[funcion]=2;
	}
}
	switch ($_POST[funcion]) {
		case 1:
			mostrarResultado($_POST[txtBuscar]);
			break 1;
		case 2:
			formularioEliminar($ficha);
			break 1;
		case 3:
			$user= new usuario($_POST[txtFicha],"","","","","","","","","","","");
			$resultado=$user->desactivar();
			switch($resultado) {
				case 1:
					echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVO USUARIO</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE ELIMINAR EL REGISTRO DEL SISTEMA</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>
					<input name=\"btnAceptar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php?item=1000'\">
					</td>";
					echo "</tr>";
					echo "</table>";						
					echo "</form>";	
					break 1;
				case 0:
					echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVO USUARIO</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>SE ELIMINÓ EL REGISTRO DEL SISTEMA</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>
					<input name=\"btnAceptar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php?item=1000'\">
					</td>";
					echo "</tr>";
					echo "</table>";						
					echo "</form>";	
					break 1;
			}
			break 1;
	default:
		formularioBuscar();
	}
function formularioBuscar() {
	$buscar= new campo("txtBuscar","text","$clase","$_POST[txtBuscar]","30","30");
	$txtBuscar=$buscar->retornar();
	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">ADMINCAU - USUARIO ELIMINAR</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">BUSCAR USUARIO</td>
  				</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">FICHA, CEDULA, NOMBRES<br>
			$txtBuscar<br>
		</td>
		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\"><input name=\"btnBuscar\" type=\"submit\" onClick=\"\" value=\"BUSCAR\"></td>
  				</tr>";
	echo "</table>";
	echo "</form>";	
}
	function mostrarResultado($txtBuscar) {
		$buscar=new usuario($txtBuscar,$txtBuscar,$txtBuscar,$txtBuscar);
		$resultado=$buscar->buscarUsuario();
		if ($resultado>0) {
		echo "<table width=\"500\" border=\"0\">
		  <tr>
		  <td valign=top class=\"tablaTitulo\"><b>FICHA</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>CEDULA</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>NOMBRES</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>APELLIDOS</b></td>
		  </tr>";
		while($row=mysql_fetch_array($resultado)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">
				<td><a class=enlace href=\"index2.php?item=25&ficha=$row[0]\">$row[0]</a></td>
				<td>$row[1]</td>
				<td>$row[2]</td>
				<td>$row[3]</td>
				</tr>";
		$i++;
		}
		echo "</table>";
		} else {
			
		}
	} 
function formularioEliminar($ficha) {
		$conBuscar="SELECT FICHA, NOMBRE_USUARIO, APELLIDO_USUARIO FROM USUARIO WHERE FICHA='$ficha'";
		conectarMysql();
		$resultado=mysql_query($conBuscar);
		$row=mysql_fetch_array($resultado);
		echo "<br><br><br><br>";
		echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
		echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$ficha\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: ADMINCAU - ELIMINAR USUARIO</td>
		</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>VA A ELIMINAR AL USUARIO:</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=left><b>FICHA:</b> $row[0].<br>
		<b>NOMBRES:</b> $row[1].<br>
		<b>APELLIDOS:</b> $row[2].<br></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>¿DESEA CONTINUAR?</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnSi\" type=\"submit\" value=\" SI \">
		<input name=\"btnNo\" type=\"button\" value=\"NO\" onclick=\"location.href='index2.php?item=1000'\"></td>";
		echo "</tr>";
		echo "</table>";
	echo "</form>";
}
?>