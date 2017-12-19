<?php
session_start();
$Acceso=array ("PRV0000001");
switch ($_SESSION['authUser']) {
	case '0':
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
		</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>SITIO RESTRINGIDO. NO PUEDE ENTRAR AL SISTEMA</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
		echo "</tr>";
		echo "</table>";
		exit();
		break 1;
	case '1':
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
		</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>SISTEMA DEL CENTRO DE ATENCI&Oacute;N A USUARIO. SISTRIO RESTRINGIDO</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
		echo "</tr>";
		echo "</table>";
		exit();
		break 1;
	default:
	require_once  "../librerias/usuarioSistemaAdmin.php";
	require_once "../librerias/conexionsql.php";
	$acceso= new usuarioSistema("",$_SESSION['userName'],$_SESSION['userPass']);
	$resultado= $acceso->validar();
	switch ($resultado) {
		case 1:
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>CLAVE INCORRECTA. NO PUEDE ENTRAR A LA P&Aacute;GINA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";
			exit();
			break 1;
		case 2:
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";
			exit();
			break 1;
		default:
			foreach($Acceso as $valor) {
				if ($_SESSION['authUser']!=$valor) {
					$sw=1;
				} else {
					$sw=0;
					break 1;
				}
			}
			if ($sw==1) {
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>DISCULPE,USTED NO TIENE SUFUCIENTE PRIVILEGIO PARA ENTRAR A ESTE SITIO</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";
				exit();
			}
	}
}
?>
<script language="javascript">
	function buscarConfiguracionNueva() {
		if (document.frmAsignacion.txtConfiguracionNueva.value!="") {
			document.frmAsignacion.funcion.value=2;
			document.frmAsignacion.submit();
		}
	}
	function buscarConfiguracionAnterior() {
		if (document.frmAsignacion.txtConfiguracionAnterior.value!="") {
			document.frmAsignacion.funcion.value=2;
			document.frmAsignacion.submit();
		}
	}
	function tipoAsignacion() {
	var form = document.forms[0]
	for (var i = 0; i < form.optAsignacion.length; i++) {
		if (form.optAsignacion[i].checked) {
			break
		}
	}
	}
		
	function cambiarSeleccion() {
		document.frmAsignacion.funcion.value=3;
		document.frmAsignacion.submit();
	}
	function regresar() {
		document.frmAsignacion.funcion.value=6;
		document.frmAsignacion.submit();
	}
	function buscarFicha() {
		if (document.frmAsignacion.txtFicha.value!="") {
			document.frmAsignacion.funcion.value=2;
			document.frmAsignacion.submit();	
		}
	}
	function reemplazo() {
		if (document.frmAsignacion.txtSerial.value!="" && document.frmAsignacion.txtNombres.value!="") {
			document.frmAsignacion.funcion.value=4;
			document.frmAsignacion.submit();		
		}
	}
	function asignacion() {
		if (document.frmAsignacion.txtSerial.value!="" && document.frmAsignacion.txtNombres.value!="") {
			document.frmAsignacion.funcion.value=8;
			document.frmAsignacion.submit();	
		}	
	}
	function reemplazoSi() {
		document.frmAsignacion.funcion.value=7;
		document.frmAsignacion.submit();	
	}

	function ChequearTodosNuevos(chkbox){
		for (var i=0;i < document. forms[0].elements.length;i++){
			var elemento = document.forms[0].elements[i];
			if (elemento.type == "checkbox" && elemento.name=="chkComponentesNuevos[]"){
				elemento.checked = chkbox.checked
			}
		}
	}
	function ChequearTodosAnteriores(chkbox){
		for (var i=0;i < document. forms[0].elements.length;i++){
			var elemento = document.forms[0].elements[i];
			if (elemento.type == "checkbox" && elemento.name=="chkComponentesAnteriores[]"){
				elemento.checked = chkbox.checked
			}
		}
	}
	function vaciar() {
		if (document.frmAsignacion.txtConfiguracionAnterior.value=="") {
			document.frmAsignacion.funcion.value=2;
			document.frmAsignacion.submit();	
		}
	}


</script>
<?php
//Asignacion de Equipos
switch ($funcion) {
	case 1:
		if (isset($_POST[txtNombres]) && empty($_POST[txtNombres])) {
			$_POST[txtFicha]="";		
		}
		if (isset($_POST[txtDescripcion]) && empty ($_POST[txtDescripcion])) {
			$_POST[txtConfiguracion]="";	
		}
		if (isset($_POST[txtFicha]) && empty($_POST[txtFicha])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>FICHA</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[txtConfiguracionNueva]) && empty($_POST[txtConfiguracionNueva])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>CONFIGURACION</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[selSitio]) && $_POST[selSitio]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>SITIO</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[selGerencia]) && $_POST[selGerencia]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>GERENCIA</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[selDivision]) && $_POST[selDivision]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>DIVISION</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[selDepartamento]) && $_POST[selDepartamento]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>DEPARTAMENTO</b>";
			$i++;
			$sw=1;
		}

		if (isset($_POST[selAnalista]) && $_POST[selAnalista]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>ANALISTA</b>";
			$i++;
			$sw=1;
		}
		switch($i) {
			case 0:
		require_once "usuarioSistemaAdmin.php";
		require_once "conexionsql.php";
		require_once "administracion.php";
		require_once "usuarioAdmin.php";
		require_once "equipoAdmin.php";		
		if (isset($_POST[txtFicha]) && !empty($_POST[txtFicha])) {
			$usuarioAsignacion= new usuario($_POST[txtFicha]);
			$resultado3= $usuarioAsignacion->retornaUsuario();
			if ($resultado3 && $resultado3==1) {
				echo "<form name=\"frmAsignacion\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - ASIGNACION DE COMPONENTES</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>LA FICHA NO EXISTE</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";	
				break 1;
			}
		}
	
		echo "<br>echo FICHA: $_POST[txtFicha]<br>";
		echo "<br>componentes Nuevos<br>";
		$listaNuevos=$_POST[chkComponentesNuevos];
			$tmp;
			for ($i=0;$i<count($listaNuevos);$i++) {
				$tmp=$tmp."'".$listaNuevos[$i]."',";
			}
			$total=strlen($tmp);
			$tmp=substr($tmp,0,strlen($tmp)-1);
			echo $tmp;
		echo "<br>componentes Reemplazados<br>";
		$listaComponentes=$_POST[chkComponentesAnteriores];
			$tmp2;
			for ($i=0;$i<count($listaComponentes);$i++) {
				$tmp2=$tmp2."'".$listaComponentes[$i]."',";
			}
			$total=strlen($tmp2);
			$tmp2=substr($tmp2,0,strlen($tmp2)-1);
			echo $tmp2;		
		echo "<br>componentes Despachados<br>";
		$listaDespachados=$_POST[chkInventario];
			$tmp3;
			for ($i=0;$i<count($listaDespachados);$i++) {
				$tmp3=$tmp3."'".$listaDespachados[$i]."',";
			}
			$total=strlen($tmp3);
			$tmp3=substr($tmp3,0,strlen($tmp3)-1);
			echo $tmp3;				
				if (isset($_POST[txtFicha]) && !empty($_POST[txtFicha])) {
					$usuarioAsignacion= new usuario($_POST[txtFicha]);
					$resultado3= $usuarioAsignacion->retornaUsuario();
					if ($resultado3 && $resultado3==1) {
						echo "<form name=\"frmAsignacion\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO - ASIGNACION DE COMPONENTES</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>LA FICHA NO EXISTE</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";	
						break 1;
					}
				}
				$equipo= new equipo($_POST[txtConfiguracionNueva]);	
				$resultado=$equipo->retornarEquipoCampo();
			 	if ($resultado && $resultado==1) {
						echo "<form name=\"frmAsignacion\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO - ASIGNACION DE COMPONENTES</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>LA CONFIGURACION NO EXISTE</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";	
						break 1;
			 	}
					if (empty($_POST[chkComponentesNuevos])) {
						echo "<form name=\"frmAsignacion\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO - ASIGNACION DE COMPONENTES</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>NO SELECCION&Oacute; NIGUN COMPONENTE PARA ASIGNAR</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";	
						break 1;						
					}
					if (empty($_POST[chkComponentes]) && $_POST[optAsignacion]==2) {
						echo "<form name=\"frmAsignacion\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO - ASIGNACION DE COMPONENTES</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>NO SELECCION&Oacute; NIGUN COMPONENTE A SER REEMPLAZADO</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";	
						break 1;						
					}
				echo "<br>formulario Configuracion Nueva: $_POST[txtConfiguracionNueva]<br>";
				$acceso= new usuarioSistema("",$_SESSION['userName'],$_SESSION['userPass']);
				$login=$acceso->login();
				$asignacion= new asignacion("",$_POST[chkInventario],$_POST[chkComponentes],"",$_POST[txtObservacion],$login,"",$_POST[selGerencia],$_POST[selDivision],$_POST[selDepartamento],$_POST[selSitio],$_POST[txtConfiguracionNueva],$_POST[txtFicha],$_POST[selAnalista],"",$_POST[optAsignacion],$_POST[txtComponente],$_POST[txtConfiguracionAnterior]);
				$resultado=$asignacion->ingresar();
				switch ($resultado) {
					case 0:
						echo "<form name=\"frmAsignacion\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO - ASIGNACION DE COMPONENTES</td>
						</tr>";
						$asign=$asignacion->retornarAsignacion();
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO LA ASIGNACION NUMERO <b>$asign</b></td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";	
						break 1;
					default:
						echo "<form name=\"frmAsignacion\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO - ASIGNACION DE COMPONENTES</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>NO SE PUDO GUARDAR LA ASIGNACI&Oacute;N</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";							
				}
				break 1;
			case 1:
				echo "<form name=\"frmAsignacion\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - NUEVO EQUIPO</td>
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
				echo "<form name=\"frmAsignacion\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - NUEVO EQUIPO</td>
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
		frmAsignacion($_POST[txtConfiguracionNueva]);
		break 1;
	case 3:
		frmAsignacion($_POST[txtConfiguracionNueva]);
		break 1;
	default:
		frmAsignacion($_POST[txtConfiguracionNueva]);	
}
function frmAsignacion($configuracionNueva="") {

	require_once "equipoAdmin.php";
	require_once "usuarioAdmin.php";
	require_once "conexionsql.php";
	require_once "formularios.php";
	require_once "inventarioAdmin.php";
	if (isset($_POST[txtFicha]) && !empty($_POST[txtFicha])) {
		$usuarioAsignacion= new usuario($_POST[txtFicha]);
		$resultado3= $usuarioAsignacion->retornaUsuario();
		if ($resultado3 && $resultado3!=1) {
			$row3=mysql_fetch_array($resultado3);
			$_POST[txtNombres]=$row3[2];
			$_POST[txtCargo]=$row3[4];
			$_POST[txtExtension]=$row3[14];
		}	
	}

	$conSitio="select id_sitio,sitio from sitio where status_activo=1 order by sitio";
	$conGerencia="select id_gerencia,gerencia from gerencia where status_activo=1 order by gerencia";
	$conDivision="select id_division,division from division where id_gerencia='$_POST[selGerencia]' and status_activo=1 order by division";
	$conDepartamento="select id_departamento, departamento from departamento where id_division='$_POST[selDivision]' and status_activo=1 ORDER BY departamento";
	$conAnalista="select usuario_sistema.id_uss,concat(usuario_sistema.nombre,' ',usuario_sistema.apellido) as nombres from usuario_sistema order by nombres";
	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--UBICACION--","");
	$selSitio=$sitio->retornar();

	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","cambiarSeleccion()",$conGerencia,"--GERENCIA--","");
	$selGerencia=$gerencia->retornar();		

	$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","cambiarSeleccion()",$conDivision,"--DIVISION--","");
	$selDivision=$division->retornar();

	$departamento= new campoSeleccion("selDepartamento","formularioCampoSeleccion","$_POST[selDepartamento]","onChange","cambiarSeleccion()",$conDepartamento,"--DEPARTAMENTO--","");
	$selDepartamento=$departamento->retornar();	

	//Campo Analista	
	$analista= new campoSeleccion("selAnalista","formularioCampoSeleccion","$_POST[selAnalista]","onChange","cambiarSeleccion()",$conAnalista,"--SELECCIONE--","");
	$selAnalista=$analista->retornar();

	echo "<form name=\"frmAsignacion\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"650\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"2\">EQUIPOS - ASIGNACI&Oacute;N</td>
	</tr>";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"2\">";
	switch($_POST[optAsignacion]) {
		case 1:
			echo "<input name=\"optAsignacio&acute;n\" type=\"radio\" value=\"1\" checked onclick=\"tipoAsignacion()\">Asignacion
			<input name=\"optAsignacion\" type=\"radio\" value=\"2\" onclick=\"tipoAsignacion()\">Reemplazo
			<input name=\"optAsignacion\" type=\"radio\" value=\"3\" onclick=\"tipoAsignacion()\">Pr&eacute;stamo";
			break 1;
		case 2:
			echo "<input name=\"optAsignacion\" type=\"radio\" value=\"1\" onclick=\"tipoAsignacion()\">Asignacion
			<input name=\"optAsignacion\" type=\"radio\" value=\"2\" checked onclick=\"tipoAsignacion()\">Reemplazo
			<input name=\"optAsignacion\" type=\"radio\" value=\"3\" onclick=\"tipoAsignacion()\">Pr&eacute;stamo";
			break 1;
		case 3:
			echo "<input name=\"optAsignacion\" type=\"radio\" value=\"1\" onclick=\"tipoAsignacion()\">Asignacion
			<input name=\"optAsignacion\" type=\"radio\" value=\"2\" onclick=\"tipoAsignacion()\">Reemplazo
			<input name=\"optAsignacion\" type=\"radio\" value=\"3\" checked onclick=\"tipoAsignacion()\">Pr&eacute;stamo";
		break 1;	
		default:
			echo "<input name=\"optAsignacion\" type=\"radio\" value=\"1\" checked onclick=\"tipoAsignacion()\">Asignacion
			<input name=\"optAsignacion\" type=\"radio\" value=\"2\" onclick=\"tipoAsignacion()\">Reemplazo
			<input name=\"optAsignacion\" type=\"radio\" value=\"3\" onclick=\"tipoAsignacion()\">Pr&eacute;stamo";
	}
	echo "</td>
  	</tr>";
	echo "<tr>
	<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL USUARIO</td>";
	echo "</tr>";
	echo "<tr>
	<td valign=top class=\"formularioCampoTitulo\">FICHA:<br><input class=\"formularioCampoTexto\" name=\"txtFicha\" type=\"text\" value=\"$_POST[txtFicha]\" onKeyPress=\"if (event.keyCode==13) buscarFicha();\">
	<input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"C\" onclick=\"buscarFicha()\"><br>
	NOMBRES<br>
	<input class=\"formularioCampoTexto\" name=\"txtNombres\" type=\"text\" value=\"$_POST[txtNombres]\" readonly=\"true\"></td>
	<td valign=top class=\"formularioCampoTitulo\">CARGO<br>
	<input class=\"formularioCampoTexto\" name=\"txtCargo\" type=\"text\" value=\"$_POST[txtCargo]\" readonly=\"true\"><br>
	EXTENSION<br>
	<input class=\"formularioCampoTexto\" name=\"txtExtension\" type=\"text\" value=\"$_POST[txtExtension]\"></td>";
	echo "</tr>";
	echo "<tr>
	<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DE UBICACION</td>";
	echo "</tr>";
	echo "<tr>

	<td valign=top class=\"formularioCampoTitulo\">UBICACION:<br>$selSitio<br>
	GERENCIA<br>$selGerencia<br>

	<td valign=top class=\"formularioCampoTitulo\">DIVISION<br>$selDivision<br>
	DEPARTAMENTO<br>$selDepartamento<br>";
	echo "</tr>";
	echo "</table>";
	echo "<br><br>";
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
	echo "<tr>
	<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">CONFIGURACION NUEVA:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"formularioCampoTexto\" name=\"txtConfiguracionNueva\" type=\"text\" value=\"$_POST[txtConfiguracionNueva]\" onKeyPress=\"if (event.keyCode==13) buscarConfiguracionNueva();\">
	<input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"C\" onclick=\"buscarConfiguracionNueva()\"></td>";
	echo "</tr>";
	echo "</table>";
	$equipo= new equipo($configuracion);	
	$resultado=$equipo->retornarEquipoCampo();
	//Componentes asociados al Equipo
	
	$equipo= new equipo($_POST[txtConfiguracionNueva]);
	$resultado=$equipo->retornarEquipoCampo();
	$resultado2=$equipo->retornarComponenteAsociados();
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
	echo "<tr valign=top class=\"tablaTitulo\">
	<td align=\"left\" class=\"tablaTitulo\"><input type=\"checkbox\" name=\"chkComponentesNuevos[]\" value=\"\" align=\"left\"onClick=\"ChequearTodosNuevos(this);\">DESCRIPCI&Oacute;N</td>
	<td valign=top class=\"tablaTitulo\">MARCA</td>
	<td valign=top class=\"tablaTitulo\">MODELO</td>
	<td valign=top class=\"tablaTitulo\">SERIAL</td>
	</tr>";	
	$clase="tablaFilaPar";
	if ($resultado && $resultado!=1) {
		$i++;
		$row=mysql_fetch_array($resultado);
			echo "<tr class=\"$clase\">
			<td align=\"left\">$row[5]</td>
			<td>$row[7]</td>
			<td>$row[9]</td>
			<td>$row[3]</td>
			</tr>";			
	}
	if ($resultado2 && $resultado2!=1) {
		while ($row2=mysql_fetch_array($resultado2)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">
			<td align=\"left\"><input name=\"chkComponentesNuevos[]\" type=\"checkbox\" value=\"$row2[5]\">$row2[0]</td>
			<td>$row2[1]</td>
			<td>$row2[2]</td>
			<td>$row2[3]</td>
			</tr>";
			$i++;
		}
	}
	echo "</table>";	

	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
	echo "<tr>";

	echo "</tr>";
	echo "<tr>
	<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">CONFIGURACION ANTERIOR:&nbsp;
	<input class=\"formularioCampoTexto\" name=\"txtConfiguracionAnterior\" type=\"text\" value=\"$_POST[txtConfiguracionAnterior]\" onChange=\"vaciar()\" onKeyPress=\"if (event.keyCode==13) buscarConfiguracionAnterior();\">
	<input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"C\" onclick=\"buscarConfiguracionAnterior()\"></td>";
	echo "</tr>";
	//Componentes asociados al Equipo
	$equipo= new equipo($_POST[txtConfiguracionAnterior]);
	$resultado=$equipo->retornarEquipoCampo();
	$resultado2=$equipo->retornarComponenteAsociados();
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
	echo "<tr valign=top class=\"tablaTitulo\">
	<td align=\"left\" class=\"tablaTitulo\"><input name=\"chkComponentesReemplazados[]\" type=\"checkbox\" value=\"\" onclick=\"ChequearTodosAnteriores(this);\">DESCRIPCI&Oacute;N</td>
	<td valign=top class=\"tablaTitulo\">MARCA</td>
	<td valign=top class=\"tablaTitulo\">MODELO</td>
	<td valign=top class=\"tablaTitulo\">SERIAL</td>
	</tr>";	
	$clase="tablaFilaPar";
	if ($resultado && $resultado!=1) {
		$i++;
		$row=mysql_fetch_array($resultado);
			echo "<tr class=\"$clase\">
			<td align=\"left\">$row[5]</td>
			<td>$row[7]</td>
			<td>$row[9]</td>
			<td>$row[3]</td>
			</tr>";			
	}
	if ($resultado2 && $resultado!=1) {
		while ($row2=mysql_fetch_array($resultado2)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">
			<td align=\"left\"><input name=\"chkComponentesAnteriores[]\" type=\"checkbox\" value=\"$row2[5]\">$row2[0]</td>
			<td>$row2[1]</td>
			<td>$row2[2]</td>
			<td>$row2[3]</td>
			</tr>";
			$i++;
		}
	}

	echo "</table>";
//Observacion
	echo "<br><br>";
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";	
	echo "<tr>
	<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL ANALISTA</td>";
	echo "</tr>";
	echo "<tr>
	<td valign=top class=\"formularioTabla\" colspan=\"2\">$selAnalista</td>";
	echo "</tr>";

	echo "<tr>
		<td valign=top class=\"formularioTablaTitulo\">OBSERVACION</td>";
	echo "</tr>";
	echo "</table>";
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";	
	echo "<tr>
		<td valign=top align=center><textarea class=\"formularioAreaTexto\" name=\"txtObservacion\" cols=\"77\" rows=\"5\">$_POST[txtObservacion]</textarea></td>";
	echo "</tr>";
	echo "</table>";
// Botones		
	echo "<table class=\"formularioTabla\"align=center width=\"650\" border=\"0\">";
	echo "<tr align=\"center\">
	<td  class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnSalir\" type=\"button\" value=\"SALIR\" onclick=\"\"><input name=\"btnAsignacion\" type=\"submit\" value=\"ASIGNACION\">
	</td>
	</tr>";
	echo "</table>";
	echo "</form>";
}
?>