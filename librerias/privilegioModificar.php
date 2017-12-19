<?php
//Privilegios Modificar
switch($_POST[funcion]) {
	case 1:
		if (isset($_POST[selPrivilegio]) && $_POST[selPrivilegio]=='100') {
			echo "<p align=center>SELECCION UN PRIVILEGIO</p>";
			echo "<p align=center><input name=\"btn\" type=\"button\" value=\"REGRESAR\" onClick=history.go(-1)></p>";
		} else {
			mostrar();
		}
		break 1;
	case 2:
		include "administracion.php";
		include "usuarioSistemaAdmin.php";
		include "conexionsql.php";
		$privilegio= new privilegio($_POST[txtIdPrivilegio],$_POST[txtPrivilegio]);
		$resultado=$privilegio->modificar();
		switch($resultado) {
			case 0:
				echo "SE MODIFICÓ EL REGISTRO EXITOSAMENTE";
				echo "<form name=\"frmProveedor\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
				echo "<input name=\"btnAgregar\" type=\"submit\" value=\"ACEPTAR\">";
				echo "</form>";
				break 1;
			case 1:
				echo "NO SE PUDO MODIFICAR EL REGISTRO";
				echo "<form name=\"frmProveedor\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
				echo "<input name=\"btnAgregar\" type=\"submit\" value=\"ACEPTAR\">";
				echo "</form>";
				break 1;
			case 2:
				echo "NO SE PUDO MODIFICAR EL REGISTRO.<br>REGISTRO DUPLICADO";
				echo "<form name=\"frmProveedor\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
				echo "<input name=\"btnAgregar\" type=\"submit\" value=\"ACEPTAR\">";
				echo "</form>";
				break 1;
		}
		break 1;
	case 3:
		formularioModificar();
		break 1;
	default:
		formularioModificar();
}

function formularioModificar() {
	include "administracion.php";
	include "formularios.php";
	include "../librerias/conexionsql.php";
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
	echo "<input name=\"btn\" type=\"submit\" value=\"MODIFICAR\">";
	echo "</form>";
}
function mostrar() {
	include "formularios.php";
	include "../librerias/conexionsql.php";
	$conBuscar="SELECT ID_PRIVILEGIO,PRIVILEGIO FROM PRIVILEGIO WHERE ID_PRIVILEGIO='$_POST[selPrivilegio]'";
	conectarMysql();
	$result=mysql_query($conBuscar);
	$row=mysql_fetch_array($result);
	mysql_close();
	$_POST[txtPrivilegio]=$row[1];
	echo "<form name=\"frmPrivilegio\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
	echo "<input name=\"txtIdPrivilegio\" type=\"hidden\" value=\"$_POST[selPrivilegio]\">";
	
	echo "PRIVILEGIO";
	echo "<br>";
	$privilegio= new campo("txtPrivilegio","text","$clase","$_POST[txtPrivilegio]","20","20","","");
	$txtPrivilegio=$privilegio->retornar();
	echo $txtPrivilegio;
	echo "<br>";
	echo "<input name=\"btnEliminar\" type=\"reset\" value=\"REESTABLECER\">";
	echo "<input name=\"btnAgregar\" type=\"submit\" value=\"MODIFICAR\">";
	echo "</form>";
}
?>