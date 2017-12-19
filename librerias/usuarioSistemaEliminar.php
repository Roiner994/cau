<?php
//Usuario del Sistema Eliminar
//echo "USUARIO SISTEMA - ELIMINAR";
//echo $_POST[funcion];
switch ($_POST[funcion]) {
	case 1:
		mostrar();
		break 1;
	case 2:
		include_once("administracion.php");
		include_once("conexionsql.php");
		require_once "formularios.php";
		$usuarioSistema= new usuarioSistema($_POST[txtIdUss],"","","","","","",0);
		$resultado=$usuarioSistema->eliminar();
		switch($resultado) {
			case 0:
				echo "<form name=\"Eliminar\" method=\"post\" action=\"\">
	            	<div style=\"padding-left:0px; padding-top:0px;\" align=\"center\" >
					ADMINCAU - ELIMINAR USUARIO SISTEMA";
	            echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
	            echo "<br>"; echo "<br>";
	            echo "<table class=\"mensajeTitulo\" align=center width=\"300\" border=\"0\">";
	            echo "<tr><td valign=top class=\"mensaje\" align=center>SE ELIMINÓ EL REGISTRO EXITOSAMENTE</td></tr>";
				echo "<tr><td valign=top class=\"mensaje\" align=center><input name=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</div></form>";
				break 1;
			case 1:
				echo "<form name=\"Eliminar\" method=\"post\" action=\"\">
	            	<div style=\"padding-left:0px; padding-top:0px;\" align=\"center\" >
					ADMINCAU - ELIMINAR USUARIO SISTEMA";
	            echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
	            echo "<br>"; echo "<br>";
	            echo "<table class=\"mensajeTitulo\" align=center width=\"300\" border=\"0\">";
	            echo "<tr><td valign=top class=\"mensaje\" align=center>NO SE PUDO ELIMINAR EL REGISTRO</td></tr>";
				echo "<tr><td valign=top class=\"mensaje\" align=center><input name=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</div></form>";
				break 1;
		}
		break 1;
	default:
		formularioBuscar();
}

function formularioBuscar() {
	include_once("formularios.php");
	include_once("conexionsql.php");
	
	
	$conBuscar="SELECT ID_USS, CONCAT(NOMBRE,', ',APELLIDO) AS NOMBRES FROM USUARIO_SISTEMA WHERE STATUS_ACTIVO='1' ORDER BY NOMBRES"; 
	$usuario= new campoSeleccion("selUsuario","formularioCampoSeleccion","$_POST[selUsuario]","","",$conBuscar,"--USUARIO--","");
	$selUsuario=$usuario->retornar();
	
	echo "<form name=\"Eliminar\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"300\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">ADMINCAU - ELIMINAR USUARIO SISTEMA</td>
		</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">DATOS DEL USUARIO</td>
		</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">
    		SELECCIONE UN USUARIO<br>$selUsuario</td>
		</tr>";
  	 	echo "<tr>";
	 	echo "<td class=\"formularioTablaBotones\">
	 	<input name=\"btnAgregar\" type=\"submit\" value=\"ELIMINAR\"></td>
		</tr>"; 	 		
	echo "</table>";
	echo "</form>";
}

function mostrar() {
	include_once("formularios.php");
	include_once("conexionsql.php");
	conectarMysql();
	$conBuscar="SELECT ID_USS, NOMBRE, APELLIDO,LOGIN FROM USUARIO_SISTEMA WHERE ID_USS='$_POST[selUsuario]'";
	if ($result=mysql_query($conBuscar)) {
			$row=mysql_fetch_array($result);
			echo "<form name=\"Eliminar\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
			echo "<table class=\"formularioTabla\"align=center width=\"300\" border=\"0\">";
			echo "<tr><td class=\"tituloPagina\" colspan=\"2\">ADMINCAU - ELIMINAR USUARIO SISTEMA</td></tr>";
			echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">DATOS DEL USUARIO A ELIMINAR</td>";
			echo "</tr>";
			echo "<tr><td><br>";
			echo "<p align=center class=\"formularioCampoTitulo\"><b>NOMBRE:</b> $row[1]"." "."$row[2]</p>";			
			echo "<p align=center class=\"formularioCampoTitulo\"><b>LOGIN:</b> $row[3]</p>";
			echo "<p align=center ><b>¿DESEA CONTINUAR?</b></p>";
			echo "<input name=\"txtIdUss\" type=\"hidden\" value=\"$row[0]\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
			echo "<p align=center><input name=\"btnSi\" type=\"submit\" value=\" SI \">";
			echo "<input name=\"btnNo\" type=\"button\" value=\"NO\" onClick=\"history.go(-3)\"></p>";
			echo "</td></tr>";
			echo "</table>";
			echo "</form>";
	} else {
		echo "NO SE PUDO MOSTRAR LA CONSULTA<br>";
	}
}
?>