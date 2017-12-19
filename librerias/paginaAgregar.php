<?php
//Pagina Agregar
switch ($funcion) {
	case 1:
		if (isset($_POST[txtNombre]) && empty($_POST[txtNombre])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>NOMBRE</b>";
			$i++;
			$sw=1; 
		 }
		if (isset($_POST[txtRuta]) && empty($_POST[txtRuta])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>RUTA</b>";
			$i++;
			$sw=1; 
		 }
		if (isset($_POST[selSeccion]) && $_POST[selSeccion]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>SECCION</b>";
			$i++;
			$sw=1; 
		 }
		if (isset($_POST[campo]) && count($_POST[campo])==0) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>PRIVILEGIOS</b>";
			$i++;
			$sw=1; 
		 }		 		 
	switch ($i) {
		case 0: 
			require_once "administracion.php";
			require_once "conexionsql.php";
			require_once "sitioAdmin.php";
			
			$user=new pagina("",$_POST[txtNombre],$_POST[txtRuta],$_POST[selSeccion],$_POST[campo]);
			$resultado=$user->ingresar();
			switch ($resultado) {
				
					    case 1:
							echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - NUEVA PAGINA</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR LA PAGINA</td>";
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
							echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
							echo "<input name=\"txtLogin\" type=\"hidden\" value=\"$_POST[txtLogin]\">";
							echo "<input name=\"txtNombre\" type=\"hidden\" value=\"$_POST[txtNombre]\">";
							echo "<input name=\"txtApellido\" type=\"hidden\" value=\"$_POST[txtApellido]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: ADMINCAU - NUEVA PAGINA</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO LA NUEVA PAGINA</td>";
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
					echo "<td align=center>MENSAJE: ADMINCAU - PAGINA</td>
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
					echo "<td align=center>MENSAJE: ADMINCAU - PAGINA</td>
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
		break 1;
	default:
		frmPagina();	
}
function frmPagina() {
	include "formularios.php";
	include "conexionsql.php";
	require_once("usuarioSistemaAdmin.php");	
	$conPrivilegio="select id_privilegio,privilegio from privilegio order by privilegio";	
	$conSeccion="select id_seccion_pagina,nombre_seccion from seccion_pagina order by nombre_seccion";
	$seccion= new campoSeleccion("selSeccion","formularioCampoSeleccion","$_POST[selSeccion]","","",$conSeccion,"--SELECCIONE--","");
	$selSeccion=$seccion->retornar();	
	echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	//echo "<input name=\"txtLogin\" type=\"text\" value=\"$POST[txtLogin]\">";
	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">ADMINCAU - NUEVA PAGINA</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">DATOS DE LA PAGINA</td>
  				</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">
    		NOMBRE DE LA PAGINA<br>
   			<input name=\"txtNombre\" type=\"text\" value=\"$_POST[txtNombre]\"><br>
    		RUTA<br>
   			<input name=\"txtRuta\" type=\"text\" value=\"$_POST[txtRuta]\"><br>
   			SECCION<br>
  			$selSeccion<br>
  			
   			PRIVILEGIO<br>";
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