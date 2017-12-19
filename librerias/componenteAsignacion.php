<?php
session_cache_limiter ( 'private' );
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
<script>

function tipoAsignacion() {
	var form = document.forms[0]
	for (var i = 0; i < form.optAsignacion.length; i++) {
		if (form.optAsignacion[i].checked) {
			break
		}
	}
	document.frmAsignacion.funcion.value=0;
	document.frmAsignacion.submit();
	}
	function buscarConfiguracion() {
		if (document.frmAsignacion.txtConfiguracion.value!="") {
			document.frmAsignacion.funcion.value=0;
			document.frmAsignacion.submit();
		} else {
			document.frmAsignacion.funcion.value=0;
			document.frmAsignacion.submit();
		}
	}
	function buscarFicha() {
		if (document.frmAsignacion.txtFicha.value!="") {
			document.frmAsignacion.funcion.value=2;
			document.frmAsignacion.submit();	
		}
	}
	function cambiarSeleccion() {
		document.frmAsignacion.funcion.value=2;
		document.frmAsignacion.submit();
	}
	
</script>
<?php
//Asignacion de Componentes
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
		if (isset($_POST[txtConfiguracion]) && empty($_POST[txtConfiguracion])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>CONFIGURACION</b>";
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
				require_once("componenteAdmin.php");
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
				$equipo= new equipo($_POST[txtConfiguracion]);	
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
					if (empty($_POST[chkInventario])) {
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
				
				$acceso= new usuarioSistema("",$_SESSION['userName'],$_SESSION['userPass']);
				$login=$acceso->login();
				$asignacion= new asignacion("",$_POST[chkInventario],$_POST[chkComponentes],"",$_POST[txtObservacion],$login,"",$_POST[selGerencia],$_POST[selDivision],$_POST[selDepartamento],$_POST[selSitio],$_POST[txtConfiguracion],$_POST[txtFicha],$_POST[selAnalista],"",$_POST[optAsignacion]);
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
		frmAsignacion(1);
		break 1;
	default:
		frmAsignacion();
		break 1;	
}
function frmAsignacion($cambiarSeleccion=0) {
	require_once "formularios.php";
	require_once "conexionsql.php";
	require_once "equipoAdmin.php";
	require_once "usuarioSistemaAdmin.php";
	require_once "usuarioAdmin.php";	
	require_once "inventarioAdmin.php";	
	$equipo= new equipo($_POST[txtConfiguracion]);	
	$resultado=$equipo->retornarEquipoCampo();
 	if ($resultado && $resultado!=1) {
		$row=mysql_fetch_array($resultado);
		$_SESSION['idInventario']=$row[2];
		$_POST[txtDescripcion]=$row[7];
		$_POST[txtMarca]=$row[9];
		$_POST[txtSerial]=$row[3];
	} else {
		$_POST[txtDescripcion]="";
		$_POST[txtMarca]="";
		$_POST[txtSerial]="";
	}
	if ($cambiarSeleccion==0) {
		$resultado2=$equipo->retornarEquipoUbicacion();
		if ($resultado2 && $resultado2!=1) {
			$row2=mysql_fetch_array($resultado2);
			$_POST[selSitio]=$row2[8];
			$_POST[selGerencia]=$row2[2];
			$_POST[selDivision]=$row2[4];
			$_POST[selDepartamento]=$row2[6];
		}
		else {
			$_POST[selSitio]="";
			$_POST[selGerencia]="";
			$_POST[selDivision]="";
			$_POST[selDepartamento]="";
		}
	}
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
	
	
	$conSitio="SELECT ID_SITIO,SITIO FROM sitio ORDER BY SITIO";
	$conGerencia="SELECT ID_GERENCIA, GERENCIA FROM gerencia ORDER BY GERENCIA";
	$conDivision="SELECT ID_DIVISION, DIVISION FROM division WHERE ID_GERENCIA='$_POST[selGerencia]' ORDER BY DIVISION";
	$conDepartamento="SELECT ID_DEPARTAMENTO,DEPARTAMENTO FROM departamento WHERE ID_DIVISION='$_POST[selDivision]' ORDER BY DEPARTAMENTO";
	$conAnalista="select distinct despacho.id_uss,concat(usuario_sistema.nombre,' ',usuario_sistema.apellido) as nombres
	from despacho inner join usuario_sistema on despacho.id_uss=usuario_sistema.id_uss where status=0 order by nombres";
	//Datos de la Ubicacion

	//Campo del Sitio
	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--SITIO--","");
	$selSitio=$sitio->retornar();
	
	//Campo de la Gerencia		
	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","cambiarSeleccion()",$conGerencia,"--GERENCIA--","");
	$selGerencia=$gerencia->retornar();
	
	//Campo de la Division
	$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","cambiarSeleccion()",$conDivision,"--DIVISION--","");
	$selDivision=$division->retornar();
	//Campo Departamento	
	$departamento= new campoSeleccion("selDepartamento","formularioCampoSeleccion","$_POST[selDepartamento]","","",$conDepartamento,"--DEPARTAMENTO--","");
	$selDepartamento=$departamento->retornar();
	//Campo Analista	
	$analista= new campoSeleccion("selAnalista","formularioCampoSeleccion","$_POST[selAnalista]","onChange","cambiarSeleccion()",$conAnalista,"--SELECCIONE--","");
	$selAnalista=$analista->retornar();
	
	echo "<form name=\"frmAsignacion\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"2\">ASIGNACION DE COMPONENTES</td>
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
	echo "<tr>";
		echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL USUARIO</td>
		</tr>";
	echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\">FICHA:<br><input class=\"formularioCampoTexto\" name=\"txtFicha\" type=\"text\" value=\"$_POST[txtFicha]\" onKeyPress=\"if (event.keyCode==13) buscarFicha();\">
	<input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"C\" onclick=\"buscarFicha()\"><br>
		<td valign=top class=\"formularioCampoTitulo\">NOMBRES:<br><input class=\"formularioCampoTexto\" name=\"txtNombres\" type=\"text\" value=\"$_POST[txtNombres]\" readonly=\"true\"><br></td>
		</tr>";
	echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\">CARGO:<br><input class=\"formularioCampoTexto\" name=\"txtCargo\" type=\"text\" value=\"$_POST[txtCargo]\" readonly=\"true\"><br>
		<td valign=top class=\"formularioCampoTitulo\">EXTENSION:<br><input class=\"formularioCampoTexto\" name=\"txtExtension\" type=\"text\" value=\"$_POST[txtExtension]\"><br></td>
		</tr>";
	echo "<tr>";
		echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL EQUIPO</td>
		</tr>";
	echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\">CONFIGURACION:<br><input class=\"formularioCampoTexto\" name=\"txtConfiguracion\" type=\"text\" value=\"$_POST[txtConfiguracion]\" onKeyPress=\"if (event.keyCode==13) buscarConfiguracion();\">
		<input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"C\" onclick=\"buscarConfiguracion()\" ><br>
		<td valign=top class=\"formularioCampoTitulo\">DESCRIPCION:<br><input class=\"formularioCampoTexto\" name=\"txtDescripcion\" type=\"text\" value=$_POST[txtDescripcion]>
		<br></td>

		</tr>";
	echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\">MARCA/MODELO:<br><input class=\"formularioCampoTexto\" name=\"txtMarca\" type=\"text\" value=$_POST[txtMarca]>
		<br>
		<td valign=top class=\"formularioCampoTitulo\">SERIAL:<br><input class=\"formularioCampoTexto\" name=\"txtSerial\" type=\"text\" value=$_POST[txtSerial]>
		<br></td>
		</tr>";
	echo "<tr>";
		echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DE UBICACION</td>
		</tr>";
	echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\">UBICACION:<br>$selSitio<br>
		<td valign=top class=\"formularioCampoTitulo\">GERENCIA:<br>$selGerencia<br></td>
		</tr>";
	echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\">DIVISION:<br>$selDivision<br>
		<td valign=top class=\"formularioCampoTitulo\">DEPARTAMENTO:<br>$selDepartamento<br></td>
		</tr>";
	echo "</table>";
	
//Componentes asociados al Equipo
	echo "<br>";
	$resultado2=$equipo->retornarComponenteAsociados();
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
	echo "<tr>
	<td class=\"formularioTablaTitulo\" colspan=\"4\">COMPONENTES DEL EQUIPO</td>
	</tr>";	
	echo "<tr valign=top class=\"tablaTitulo\">
	<td align=\"left\" class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
	<td valign=top class=\"tablaTitulo\">MARCA</td>
	<td valign=top class=\"tablaTitulo\">MODELO</td>
	<td valign=top class=\"tablaTitulo\">SERIAL</td>
	</tr>";	
	if ($resultado2 && $resultado2!=1) {
		while ($row=mysql_fetch_array($resultado2)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">
			<td align=\"left\">";
			if ($_POST[optAsignacion]==2) {
				echo "<input name=\"chkComponentes[]\" type=\"checkbox\" value=\"$row[5]\">";
			}
			echo "$row[0]</td>
			<td>$row[1]</td>
			<td>$row[2]</td>
			<td>$row[3]</td>
			</tr>";
			$i++;
		}
	}
	echo "</table>";

//Componentes Despachados
	echo "<br>";
	$despachado= new inventario("","","","","","","","","",$_POST[selAnalista]);
	$resultado=$despachado->retornaDespachoAnalista();
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
	echo "<tr>
	<td class=\"formularioTablaTitulo\" colspan=\"4\">COMPONENTES DESPACHADOS - $selAnalista</td>
	</tr>";	
	echo "<tr valign=top class=\"tablaTitulo\">
	<td align=\"left\" class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
	<td valign=top class=\"tablaTitulo\">MARCA</td>
	<td valign=top class=\"tablaTitulo\">MODELO</td>
	<td valign=top class=\"tablaTitulo\">SERIAL</td>
	</tr>";	
	if ($resultado && $resultado!=1) {
		while ($row=mysql_fetch_array($resultado)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">
			<td align=\"left\"><input name=\"chkInventario[]\" type=\"checkbox\" value=\"$row[0]\">$row[4]</td>
			<td>$row[6]</td>
			<td>$row[8]</td>
			<td>$row[2]</td>
			</tr>";
			$i++;
		}
	}
	echo "</table>";	
	
	echo "<br>";
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
	echo "<tr>
		<td valign=top class=\"formularioTablaTitulo\">OBSERVACION</td>";
	echo "</tr>";
	echo "<tr>
		<td valign=top align=center><textarea class=\"formularioAreaTexto\" name=\"txtObservacion\" cols=\"77\" rows=\"5\">$_POST[txtObservacion]</textarea></td>";
	echo "</tr>";
	echo "<tr>
		<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"4\">
		<input name=\"btnRegresar\" type=\"button\" value=\"REGRESAR\" onclick=\"regresar()\">
		<input name=\"btnReemplazar\" type=\"submit\" value=\"GUARDAR\">
		</td>
	</tr>";	
	echo "</form>";
}
?>