<?php
//Privilegios de los Usuarios
switch($funcion) {
	case 1:
		if (isset($_POST[txtPrivilegio]) && empty($_POST[txtPrivilegio])) {
			echo "<p align=center>ESCRIBA EL NOMBRE DEL PRIVILEGIO</p>";
			echo "<p align=center><input name=\"btn\" type=\"button\" value=\"REGRESAR\" onClick=history.go(-1)></p>";
		} else {
			include "administracion.php";
			include "usuarioSistemaAdmin.php";
			include "conexionsql.php";
			$privilegio= new privilegio("",$_POST[txtPrivilegio]);
			$resultado=$privilegio->ingresar();
			switch($resultado) {
				case 0:
					echo "SE GUARDO EL REGISTRO EXITOSAMENTE";
					echo "<form name=\"frmProveedor\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"btnAgregar\" type=\"submit\" value=\"ACEPTAR\">";
					echo "</form>";
					break 1;
				case 1:
					echo "NO SE PUDO GUARDAR EL REGISTRO";
					echo "<form name=\"frmProveedor\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"btnAgregar\" type=\"submit\" value=\"ACEPTAR\">";
					echo "</form>";
					break 1;
				case 2:
					echo "NO SE PUDO GUARDAR EL REGISTRO.<br>REGISTRO DUPLICADO";
					echo "<form name=\"frmProveedor\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"btnAgregar\" type=\"submit\" value=\"ACEPTAR\">";
					echo "</form>";
			}
		}
		break 1;
	case 2:
		frmPrivilegio();
		break 1;
	default:
		frmPrivilegio();
}


function frmPrivilegio() {
	include "../librerias/formularios.php";
	echo "<form name=\"frmProveedor\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
		echo "PRIVILEGIO";
		echo "<br>";
		$privilegio= new campo("txtPrivilegio","text","$clase","$_POST[txtPrivilegio]","20","20","","");
		$txtPrivilegio=$privilegio->retornar();
		echo $txtPrivilegio;
		echo "<br>";
		echo "<input name=\"btnEliminar\" type=\"reset\" value=\"LIMPIAR\">";
		echo "<input name=\"btnAgregar\" type=\"submit\" value=\"AGREGAR\">";
	echo "</form>";
}

?>