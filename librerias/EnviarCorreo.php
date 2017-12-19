<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
	require_once("seguridad.php");
	require_once("inventarioAdmin.php");
	require_once("usuarioAdmin.php");
	require_once("administracion.php");
	require_once ("formularios.php");
?>

<script language="javascript">

	function quitarNotificacion() {
		document.frmNotificacion.funcion.value=3;
		document.frmNotificacion.submit();
	}	
	function asociar() {
		document.frmNotificacion.funcion.value=4;
		document.frmNotificacion.submit();			
	}
	function enviarNotificacion() {
			document.frmNotificacion.funcion.value=1;
			document.frmNotificacion.submit();			
	}		
	function mostrarTextoRed() {
			document.frmNotificacion.funcion.value=2;
			document.frmNotificacion.submit();			
	}	

</script>

<?php

switch ($funcion) {
	case 1:
		if (isset($_POST[Notificacion]) && empty($_POST[Notificacion])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>LISTA DE NOTIFICACION</b>";
			$i++;
			$sw=1;
		}	
		if ((isset($_POST[chkRed])) && ($_POST[chkRed]==1) &&(empty($_POST[txtRed]))) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>PUNTO DE RED</b>";
			$i++;
			$sw=1;
		}
		switch ($i) {
			case 0:
				$tmp="'".$_POST[Notificacion]."'";
				$tmp=str_replace("',","'",$tmp);
				$tmp=str_replace(",","','",$tmp);	
				$login=$_SESSION["login"];
				$usuario= new usuario();
				$usuario->setUsuario($tmp);
				switch ($resultado) {
					case 0:
						//*****************************************************************************************************************************
						//*****************************************************************************************************************************
						$equipo= new equipo();
						$equipo->setEquipo($configuracion,'',0,$_POST[chkRed],0,0,$_POST[txtRed]);
						$resultado=$equipo->buscarEquipo();
						$sitio=$equipo->retornarUltimaUbicacion('un');
						$gerencia=$equipo->retornarUltimaUbicacion('gn');
						$division=$equipo->retornarUltimaUbicacion('sn');
						$equipo->setInventarioUbicacion('','',$_POST[txtObservacion]);
						$equipo->actualizarEspecifico();
						$equipo->actualizarRed();
						$equipo->actualizarTextoRed();
						$resultadoUsuariosANotificar=$usuario->mostrarRemitentes($tmp);
						if ($resultadoUsuariosANotificar && $resultadoUsuariosANotificar!=1){ 
							while ($row=mysql_fetch_array($resultadoUsuariosANotificar)){
								ini_set("SMTP","150.0.5.9");
								if ($_POST[chkRed]==1)
									$mensaje = "
											<html>
												<head>
													<title>PRUEBA-CAU</title>
													<style type=\"text/css\">
														#cuadro{
															margin-top : 10px;
															margin-left : 10px;
															margin-right : 10px;
														}				
														.let {
															font-family: Verdana;
															font-size: 10pt;
															color: #000000;
															text-align:justify;
														}
														.let2 {
															font-family: Verdana;
															font-size: 10pt;
															color: #000000;
															text-align:center;
														}
														.imgder {
															BORDER-RIGHT: #ccc 2px solid; PADDING-RIGHT: 1px; BORDER-TOP: #ccc 2px solid; PADDING-LEFT: 1px; FLOAT: right; PADDING-BOTTOM: 1px; MARGIN-LEFT: 6px; BORDER-LEFT: #ccc 2px solid; PADDING-TOP: 1px; BORDER-BOTTOM: #ccc 2px solid; BACKGROUND-COLOR: #8ed0e0
														}
														A:link {
															COLOR: #0000ff;
															TEXT-DECORATION: underline;
															font-family: Verdana, Arial, Helvetica, sans-serif;
															font-size: 10pt;
															font-style: normal;
														}
														A:visited {
															COLOR: #551a8b;
															TEXT-DECORATION: none;
															font-family: Verdana, Arial, Helvetica, sans-serif;
															font-size: 10pt;
														}
														A:active {
															COLOR: #c64934;
															TEXT-DECORATION: underline;
															font-family: Verdana, Arial, Helvetica, sans-serif;
															font-size: 10pt;
														}
														A:hover {
															FONT-WEIGHT: bold; COLOR: #c64934; TEXT-DECORATION: none
														}
													</style>
												</head>
												<body>
													<table width=\"600\" border=\"0\" align=\"center\">
														<tr>
															<p align=\"center\"><strong>Centro de Atenci&oacute;n a Usuarios </strong></p>
															<td width=\"700\" valign=\"top\" bgcolor=\"#D7EBFF\" class=\"let\" colspan=\"2\">
																<div id=\"cuadro\">
																	<p>Se informa que el Equipo <strong>$configuracion</strong> se instalo en el <strong>$sitio</strong>, <strong>$gerencia</strong>, <strong>$division</strong> al Usuario <strong>$nombre</strong>, Ficha <strong>$ficha</strong>, Extension <strong>$extension</strong></p> 											
																	<p>Queda pendiente la conexion de red debido a: <strong>$_POST[txtRed]</strong></p>
																	<p>Se solicita sea actualizado este equipo en el <strong>Active Directory</strong></p>
																</div>															
															</td>
														</tr>
													</table>
												</body>
											</html>";
								else
									$mensaje = "
											<html>
												<head>
													<title>PRUEBA-CAU</title>
													<style type=\"text/css\">
														#cuadro{
															margin-top : 10px;
															margin-left : 10px;
															margin-right : 10px;
														}				
														.let {
															font-family: Verdana;
															font-size: 10pt;
															color: #000000;
															text-align:justify;
														}
														.let2 {
															font-family: Verdana;
															font-size: 10pt;
															color: #000000;
															text-align:center;
														}
														.imgder {
															BORDER-RIGHT: #ccc 2px solid; PADDING-RIGHT: 1px; BORDER-TOP: #ccc 2px solid; PADDING-LEFT: 1px; FLOAT: right; PADDING-BOTTOM: 1px; MARGIN-LEFT: 6px; BORDER-LEFT: #ccc 2px solid; PADDING-TOP: 1px; BORDER-BOTTOM: #ccc 2px solid; BACKGROUND-COLOR: #8ed0e0
														}
														A:link {
															COLOR: #0000ff;
															TEXT-DECORATION: underline;
															font-family: Verdana, Arial, Helvetica, sans-serif;
															font-size: 10pt;
															font-style: normal;
														}
														A:visited {
															COLOR: #551a8b;
															TEXT-DECORATION: none;
															font-family: Verdana, Arial, Helvetica, sans-serif;
															font-size: 10pt;
														}
														A:active {
															COLOR: #c64934;
															TEXT-DECORATION: underline;
															font-family: Verdana, Arial, Helvetica, sans-serif;
															font-size: 10pt;
														}
														A:hover {
															FONT-WEIGHT: bold; COLOR: #c64934; TEXT-DECORATION: none
														}
													</style>
												</head>
												<body>
													<table width=\"600\" border=\"0\" align=\"center\">
														<tr>
															<p align=\"center\"><strong>Centro de Atenci&oacute;n a Usuarios </strong></p>
															<td width=\"700\" valign=\"top\" bgcolor=\"#D7EBFF\" class=\"let\" colspan=\"2\">
																<div id=\"cuadro\">
																	<p>Se informa que el Equipo <strong>$configuracion</strong> se instalo en el <strong>$sitio</strong>, <strong>$gerencia</strong>, <strong>$division</strong> al Usuario <strong>$nombre</strong>, Ficha <strong>$ficha</strong>, Extension <strong>$extension</strong></p> 											
																	<p>Actualizar en el <strong>Active Directory</strong></p>
																</div>															
															</td>
														</tr>
													</table>
												</body>
											</html>";
											
								// Para enviar correo HTML 
								$cabeceras  = "MIME-Version: 1.0\r\n";
								$cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";
								// cabeceras adicionales 
								$cabeceras .= "From: prueba.CAU@venalum.com.ve\r\n";
								$envio = mail("$row[9]","Asignacion de Equipo","$mensaje","$cabeceras");
							}
							echo "<form name=\"frmNotificacion\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"Notificacion\" type=\"hidden\" value=\"$_POST[Notificacion]\">";
							echo "<input name=\"txtObservacion\" type=\"hidden\" value=\"$_POST[txtObservacion]\">";
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>NOTIFICACION:  - ASIGNACION DE EQUIPOS</td>
								</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>NOTIFICACIONES ENVIADAS</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\" onclick=\"location.href='index2.php?item=622'\"></td>";
							echo "</tr>";
							echo "</table>";
							echo "</form>";	
						}
					break 1;
				}
				break 1;
			case 1:
				echo "<form name=\"frmNotificacion\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<input name=\"Notificacion\" type=\"hidden\" value=\"$_POST[Notificacion]\">";
				echo "<input name=\"txtObservacion\" type=\"hidden\" value=\"$_POST[txtObservacion]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - DESPACHO DE EQUIPOS</td>
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
				echo "<form name=\"frmNotificacion\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<input name=\"Notificacion\" type=\"hidden\" value=\"$_POST[Notificacion]\">";
				echo "<input name=\"txtObservacion\" type=\"hidden\" value=\"$_POST[txtObservacion]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - DESPACHO DE EQUIPOS</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>LOS CAMPOS ".$mensaje. " ESTAN VAC&Iacute;OS</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";	
				break 1;			
		}
		break 1;
	case 2:
		$tmp="'".$_POST[Notificacion]."'";
		$tmp=str_replace("',","'",$tmp);
		$tmp=str_replace(",","','",$tmp);	
		frmNotificacion($tmp);	
		break 1;
	case 3:
		unset($_POST[Notificacion]);
		frmNotificacion($tmp);		
		break 1;
	case 4:
		if (!empty($_POST[selUsuarioSistema]))
			$_POST[Notificacion]=$_POST[Notificacion].",".$_POST[selUsuarioSistema];
			$tmp="'".$_POST[Notificacion]."'";
			$tmp=str_replace("',","'",$tmp);
			$tmp=str_replace(",","','",$tmp);
		frmNotificacion($tmp);
		break 1;
	default:
		frmNotificacion();
}

function frmNotificacion($elementos="",$quitar="") {
	require_once("inventarioAdmin.php");
	require_once("usuarioAdmin.php");
	require_once("administracion.php");
	require_once ("formularios.php");

		$conUss="Select usuario.FICHA, concat(usuario.NOMBRE_USUARIO,' ', usuario.APELLIDO_USUARIO) From usuario
	 		Inner Join departamento ON usuario.ID_DEPARTAMENTO = departamento.ID_DEPARTAMENTO
	 		Inner Join division ON departamento.ID_DIVISION = division.ID_DIVISION
	 		Inner Join gerencia ON division.ID_GERENCIA = gerencia.ID_GERENCIA
	 		Where ((gerencia.GERENCIA = 'GCIA. SISTEMAS Y ORGANIZACIÓN') and (usuario.EMAIL <> '')) Order By usuario.NOMBRE_USUARIO Asc";

	$usuarioSistema= new campoSeleccion("selUsuarioSistema","formularioCampoSeleccion","$_POST[selUsuarioSistema]","onChange","asociar()",$conUss,"--SELECCIONE--","");
	$selUsuarioSistema=$usuarioSistema->retornar();

	echo "<form name=\"frmNotificacion\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";		
	echo "<input name=\"Notificacion\" type=\"hidden\" value=\"$_POST[Notificacion]\">";
	echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"2\">NOTIFICACION DE ASIGNACION DE EQUIPOS</td>
	</tr>";
	echo "<tr>
			<td class=\"formularioTablaTitulo\" colspan=\"4\">LISTA DE DESTINATARIOS</td>
		</tr>";
	$usuario=new usuario();
	$resultadoUsuariosANotificar=$usuario->mostrarRemitentes($elementos);
	if ($resultadoUsuariosANotificar && $resultadoUsuariosANotificar!=1) {
		echo "<tr valign=top class=\"tablaTitulo\">
			<td align=\"left\" class=\"tablaTitulo\">FICHA</td>
			<td valign=top class=\"tablaTitulo\">NOMBRE</td>
			<td valign=top class=\"tablaTitulo\">EMAIL</td>
			</tr>";
		$i=0;
			while ($row=mysql_fetch_array($resultadoUsuariosANotificar)) {
				if ($i%2==0) {
					$clase="tablaFilaPar";
				} else {
					$clase="tablaFilaNone";
				}
				$correo=strtoupper($row[9]);
				echo "<tr class=\"$clase\">
					<td align=\"left\">$row[0]</td>
					<td>$row[2] $row[3]</td>
					<td>$correo</td>
				</tr>";
				$i++;
			}
		echo "<tr>
			<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"5\">";
				echo "<a class=\"botonEnlace\" href=\"#\" onClick=\"quitarNotificacion()\">LIMPIAR</a>
			</td>
		</tr>";				
	   } else {
		echo "<tr class=\"$clase\">
					<td align=\"center\" colspan=\"5\">LISTA NO DISPONIBLE</td>";
		echo "</tr>";
	}
	echo "</table>";
	echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
	echo "<tr>";
	echo "<td valign=top class=\"formularioTablaTitulo\" colspan=\"5\">ENVIAR NOTIFICACION A</td>
		</tr>";
	echo "<tr>";
	echo "<td valign=top class=\"formularioCampoTitulo\">PERSONAL<br>$selUsuarioSistema</td>
	</tr>";
	echo "<td valign=top class=\"formularioCampoTitulo\">¿CONECTADO A RED?<br>";
				if ($_POST[chkRed]==1){
					echo "<input name=\"chkRed\" type=\"checkbox\" value=\"1\" onclick=\"mostrarTextoRed()\" checked>NO<br>";
					echo "<textarea name=\"txtRed\" cols=\"35\" rows=\"1\">$_POST[txtRed]</textarea><br>";
					}else 
					echo "<input name=\"chkRed\" type=\"checkbox\" value=\"1\" onclick=\"mostrarTextoRed()\">NO";
	echo "</td>";
	echo "<tr>";
	echo "<td valign=top class=\"formularioCampoTitulo\" colspan=\"5\">OBSERVACION<br>
	<textarea class=\"formularioAreaTextoPlanilla\" name=\"txtObservacion\" cols=\"500\" rows=\"2\">$_POST[txtObservacion]</textarea></td>
	</tr>";
	echo "<tr>
	<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"5\">
	<input name=\"btnNotificar\" type=\"button\" value=\"ENVIAR\" onclick=\"enviarNotificacion()\">
	</tr>";	
	echo "</table>";
	echo "</form>";
}
?>