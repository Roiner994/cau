<?php
//Formulario Eliminar Privilegio

switch($_POST[funcion]) {
	case 1:
		mensajeEliminar();
		break 1;
	case 2:
		include "administracion.php";
		include "usuarioSistemaAdmin.php";
		include "conexionsql.php";
		$privilegio= new privilegio($_POST[txtIdPrivilegio],"");
		$resultado=$privilegio->eliminar();
		switch($resultado) {
			case 0:
				echo "SE ELIMINÓ EL REGISTRO EXITOSAMENTE";
				echo "<form name=\"frmProveedor\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
				echo "<input name=\"btnAgregar\" type=\"submit\" value=\"ACEPTAR\">";
				echo "</form>";
				break 1;
			case 1:
				echo "NO SE PUDO ELIMINAR EL REGISTRO";
				echo "<form name=\"frmProveedor\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
				echo "<input name=\"btnAgregar\" type=\"submit\" value=\"ACEPTAR\">";
				echo "</form>";
				break 1;
		}
		break 1;
	case 3:
		formularioEliminar();
		break 1;
	default:
		formularioEliminar();
}
function formularioEliminar() {
	include "administracion.php";
	include "formularios.php";
	include "conexionsql.php";
	echo "MODIFICAR DEPARTAMENTO";
	$conPrivilegio="SELECT ID_PRIVILEGIO,PRIVILEGIO FROM PRIVILEGIO ORDER BY PRIVILEGIO";
	$prv= new campoSeleccion("selPrivilegio","$clase","$idPrivilegio","onChange","",$conPrivilegio,"--PRIVILEGIO--","");
	echo "<form name=\"frmPrivilegio\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "PRIVILEGIO";
	$privilegio=$prv->retornar();
	echo "<br>";
	echo $privilegio;
	echo "<br>";
	echo "<input name=\"btn\" type=\"submit\" value=\"ELIMINAR\">";
	echo "</form>";
}
function mensajeEliminar() {
	$conBuscar="SELECT ID_PRIVILEGIO, PRIVILEGIO FROM PRIVILEGIO WHERE ID_PRIVILEGIO='$_POST[selPrivilegio]'";
	include "administracion.php";
	include "formularios.php";
	include "conexionsql.php";
	conectarMysql();
	$result=mysql_query($conBuscar);
	$row=mysql_fetch_array($result);
	mysql_close();
	echo "VA A ELIMINAR EL <b>PRIVILEGIO:</b> $row[1]<br>";
	echo "¿DESEA CONTINUAR?<br>";

	echo "<form name=\"frmPrivilegio\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
	echo "<input name=\"txtIdPrivilegio\" type=\"hidden\" value=\"$_POST[selPrivilegio]\">";
	echo "<p align=center><input name=\"btnSi\" type=\"submit\" value=\" SI \">";
	echo "<input name=\"btnNo\" type=\"button\" value=\"NO\" onClick=\"history.go(-3)\"></p>";
	echo "</form>";

}
?>