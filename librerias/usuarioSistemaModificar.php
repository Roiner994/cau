<?php
//Usuario del Sistema Modificar
switch ($funcion) {
	case 1:
		formularioUsuarioSistema();
		break 1;
	case 2:
		$sw=0;
		$mensaje="";
		if (isset($_POST[txtNombre]) && empty($_POST[txtNombre])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>NOMBRE</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[txtApellido]) && empty($_POST[txtApellido])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>APELLIDO</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[txtLogin])  && empty($_POST[txtLogin])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>LOGIN</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[txtPassword])  && empty($_POST[txtPassword])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>PASSWORD</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[campo]) && $_POST[campo]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>PRIVILEGIO</b>";
			$i++;
			$sw=1;
		}
		switch ($i) {
			case 0:
					require_once "administracion.php";
					require_once "usuarioSistemaAdmin.php";
					require_once "conexionsql.php";
					$usuarioSistema= new usuarioSistema($_POST[selUsuario],$_POST[txtLogin],$_POST[txtPassword],$_POST[txtNombre],$_POST[txtApellido],"",$_POST[chkPassword],1,$_POST[campo]);
					$resultado=$usuarioSistema->modificar();
					switch($resultado) {
						case 0:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - USUARIO SISTEMA</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE ACTUALIZO EL USUARIO</td>";
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
							echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - USUARIO SISTEMA</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>NO SE PUDO ACTUALIZAR EL USUARIO</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>
							<input name=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\">
							</td>";
							echo "</tr>";
							echo "</table>";						
							echo "</form>";	
							break 1;
						case 2:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - USUARIO SISTEMA</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>NO SE PUDO ACTUALIZAR EL USUARIO. REGISTRO DUPLICADO</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>
							<input name=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\">
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
					echo "<input name=\"txtLogin\" type=\"hidden\" value=\"$_POST[txtLogin]\">";
					echo "<input name=\"txtNombre\" type=\"hidden\" value=\"$_POST[txtNombre]\">";
					echo "<input name=\"txtApellido\" type=\"hidden\" value=\"$_POST[txtApellido]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - USUARIO SISTEMA</td>
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
					echo "<input name=\"txtLogin\" type=\"hidden\" value=\"$_POST[txtLogin]\">";
					echo "<input name=\"txtNombre\" type=\"hidden\" value=\"$_POST[txtNombre]\">";
					echo "<input name=\"txtApellido\" type=\"hidden\" value=\"$_POST[txtApellido]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: ADMINCAU - USUARIO SISTEMA</td>
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
		formularioBuscar();
		break 1;
	default:
		formularioBuscar();
}
function formularioBuscar() {
	require_once "formularios.php";
	require_once "conexionsql.php";
	$conBuscar="SELECT ID_USS, CONCAT(NOMBRE,', ',APELLIDO) AS NOMBRES FROM USUARIO_SISTEMA WHERE STATUS_ACTIVO='1' ORDER BY NOMBRES"; 
	$usuario= new campoSeleccion("selUsuario","formularioCampoSeleccion","$_POST[selUsuario]","","",$conBuscar,"--USUARIO--","");
	$selUsuario=$usuario->retornar();
	echo "<form name=\"frmUsuarioSistema\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">ADMINCAU - NUEVO USUARIO SISTEMA</td>
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
	 	<input name=\"btnModificar\" type=\"submit\" value=\"MODIFICAR\"></td>
		</tr>"; 	 		
	echo "</table>";
	echo "</form>";
}
function formularioUsuarioSistema() {
	require_once "formularios.php";
	require_once "conexionsql.php";
	require_once("usuarioSistemaAdmin.php");

	$conPrivilegio="SELECT ID_PRIVILEGIO,PRIVILEGIO FROM PRIVILEGIO ORDER BY PRIVILEGIO";
	$usuarioSistema= new usuarioSistema($_POST[selUsuario]);
	$resultado=$usuarioSistema->retornarUsuario();
	if ($resultado && $resultado!=1) {
		$row=mysql_fetch_array($resultado);
		$_POST[txtNombre]=$row[1];
		$_POST[txtApellido]=$row[2];
		$_POST[txtLogin]=$row[3];
		$_POST[selPrivilegio]=$row[4];
	}
	echo "<form name=\"frmUsuarioSistema\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
	echo "<input name=\"selUsuario\" type=\"hidden\" value=\"$_POST[selUsuario]\">";
	echo "<table class=\"formularioTabla\"align=center width=\"250\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">ADMINCAU - NUEVO USUARIO SISTEMA</td>
		</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">DATOS DEL USUARIO</td>
		</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">
    		NOMBRE<br><input name=\"txtNombre\" type=\"text\" value=\"$_POST[txtNombre]\"><br>
    		APELLIDOS<br><input name=\"txtApellido\" type=\"text\" value=\"$_POST[txtApellido]\"><br>
    		LOGIN<br><input name=\"txtLogin\" type=\"text\" value=\"$_POST[txtLogin]\"><br>
    		REESTABLECER CLAVE<BR><input name=\"chkPassword\" type=\"checkbox\" value=\"1\"><br>
    		PRIVILEGIOS<br>";
   	echo "</td>
		</tr>";
   	echo "<tr><td valign=top class=\"formularioCampo\">";
		$privilegio= new privilegio();
		$resultado=$privilegio->retornarPrivilegio();
		if ($resultado && $resultado!=1) {
			while ($row=mysql_fetch_array($resultado)) {
				if ($usuarioSistema->verificarPrivilegio($row[0])==1)
					echo "<input name=\"campo[]\" type=\"checkbox\" value=\"$row[0]\" checked>$row[1]<br>";
		   		else 
					echo "<input name=\"campo[]\" type=\"checkbox\" value=\"$row[0]\">$row[1]<br>";
			} 		
		}		
   	echo "</td></tr>";
  	 	echo "<tr>";
	 	echo "<td class=\"formularioTablaBotones\"><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"location.href='index2.php?item=27'\">
		<input name=\"btnAgregar\" type=\"submit\" value=\"MODIFICAR\"></td>
		</tr>"; 	 		
	echo "</table>";
	echo "</form>";


}
?>