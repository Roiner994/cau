<?php

switch($funcion) {
	case 1:
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
		if (isset($_POST[txtLogin]) && empty($_POST[txtLogin])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>LOGIN</b>";
			$i++;
			$sw=1; 
		 }	
		if (isset($_POST[campo]) && empty($_POST[campo])) {
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
			require_once "conexionsql.php";
			require_once "usuarioSistemaAdmin.php";
			
			$user=new usuarioSistema("",$_POST[txtLogin],"",$_POST[txtNombre],$_POST[txtApellido],"",1,1,$_POST[campo]);
			$resultado=$user->ingresar();
			switch ($resultado) {
				
					    case 0:
					    	unset($_POST);
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"txtLogin\" type=\"hidden\" value=\"$_POST[txtLogin]\">";
							echo "<input name=\"txtNombre\" type=\"hidden\" value=\"$_POST[txtNombre]\">";
							echo "<input name=\"txtApellido\" type=\"hidden\" value=\"$_POST[txtApellido]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - NUEVO USUARIO SISTEMA</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO EL NUEVO USUARIO</td>";
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
							echo "<input name=\"txtLogin\" type=\"hidden\" value=\"$_POST[txtLogin]\">";
							echo "<input name=\"txtNombre\" type=\"hidden\" value=\"$_POST[txtNombre]\">";
							echo "<input name=\"txtApellido\" type=\"hidden\" value=\"$_POST[txtApellido]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - NUEVO USUARIO SISTEMA</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR EL USUARIO</td>";
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
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"txtLogin\" type=\"hidden\" value=\"$_POST[txtLogin]\">";
							echo "<input name=\"txtNombre\" type=\"hidden\" value=\"$_POST[txtNombre]\">";
							echo "<input name=\"txtApellido\" type=\"hidden\" value=\"$_POST[txtApellido]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - NUEVO USUARIO SISTEMA</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR EL USUARIO, LOGIN DUPLICADO</td>";
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
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVO USUARIO SISTEMA</td>
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
					echo "<td align=center>MENSAJE: ADMINCAU - NUEVO USUARIO SISTEMA</td>
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
	frmUsuarioSistema();
	break 1; 
	default:
	frmUsuarioSistema();	
	
}


function frmUsuarioSistema() {
	require_once("formularios.php");
	require_once("conexionsql.php");
	require_once("usuarioSistemaAdmin.php");
	
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
    		NOMBRE<br><input name=\"txtNombre\" type=\"text\" value=\"$_POST[txtNombre]\"><br>
    		APELLIDOS<br><input name=\"txtApellido\" type=\"text\" value=\"$_POST[txtApellido]\"><br>
    		LOGIN<br><input name=\"txtLogin\" type=\"text\" value=\"$_POST[txtLogin]\"><br>
    		PRIVILEGIOS<br>";
			$privilegio= new privilegio();
			$resultado=$privilegio->retornarPrivilegio();
   			if ($resultado && $resultado!=1) {
				while ($row=mysql_fetch_array($resultado)) {
			   		echo "<input name=\"campo[]\" type=\"checkbox\" value=\"$row[0]\">$row[1]<br>";
				} 		
   			}		
   			
   	echo "</td>
		</tr>";
  	 	echo "<tr>";
	 	echo "<td class=\"formularioTablaBotones\"><input name=\"btnLimpiar\" type=\"reset\" value=\"LIMPIAR\">
		<input name=\"btnAgregar\" type=\"submit\" value=\"AGREGAR\"></td>
		</tr>"; 	 		
	echo "</table>";
	echo "</form>";
}

?>