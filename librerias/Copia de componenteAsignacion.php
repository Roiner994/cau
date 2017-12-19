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
	function buscarConfiguracion() {
		if (document.frmDespacho.txtConfiguracion.value!="") {
			document.frmDespacho.funcion.value=2;
			document.frmDespacho.submit();
		} else {
			document.frmDespacho.funcion.value=0;
			document.frmDespacho.submit();
		}
	}
	function cambiarSeleccion() {
		document.frmDespacho.funcion.value=3;
		document.frmDespacho.submit();
	}
	function regresar() {
		document.frmDespacho.funcion.value=6;
		document.frmDespacho.submit();
	}
	function buscarFicha() {
		if (document.frmDespacho.txtFicha.value!="") {
			document.frmDespacho.funcion.value=3;
			document.frmDespacho.submit();	
		}
	}
	function reemplazo() {
		if (document.frmDespacho.txtSerial.value!="" && document.frmDespacho.txtNombres.value!="") {
			document.frmDespacho.funcion.value=4;
			document.frmDespacho.submit();		
		}
	}
	function asignacion() {
		if (document.frmDespacho.txtSerial.value!="" && document.frmDespacho.txtNombres.value!="") {
			document.frmDespacho.funcion.value=8;
			document.frmDespacho.submit();	
		}	
	}
	function reemplazoSi() {
		document.frmDespacho.funcion.value=7;
		document.frmDespacho.submit();	
	}

</script>
<?php
//Asignacion de Componentes
switch($funcion) {
	case 1:
		echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
		echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
		echo "<input name=\"txtDescripcion\" type=\"hidden\" value=\"$_POST[txtDescripcion]\">";
		echo "<input name=\"txtAsignacion\" type=\"hidden\" value=\"$_POST[txtAsignacion]\">";			
		echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
		echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtFicha]\">";
		echo "<input name=\"txtNombres\" type=\"hidden\" value=\"$_POST[txtNombres]\">";
		echo "<input name=\"txtCargo\" type=\"hidden\" value=\"$_POST[txtCargo]\">";
		echo "<input name=\"txtExtension\" type=\"hidden\" value=\"$_POST[txtExtension]\">";
		echo "<input name=\"optComponentes\" type=\"hidden\" value=\"$_POST[optComponentes]\">";
		echo "<input name=\"optInventario\" type=\"hidden\" value=\"$_POST[optInventario]\">";
		echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
		echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
		echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
		echo "<input name=\"txtObservacion\" type=\"hidden\" value=\"$_POST[txtObservacion]\">";

		require_once "administracion.php";
		require_once "usuarioSistemaAdmin.php";
		require_once "componenteAdmin.php";
		
		if (isset($_POST[txtAsignacion]) && !empty($_POST[txtAsignacion])) {
			$idAsignacion=$_POST[txtAsignacion];
		} else {
			$idAsignacion="";	
		}	
		$_SESSION['idAsignacion']=$idAsignacion;
		$asignacion=new asignacion();
		$asignacion->SetParametros($idAsignacion,"",$_POST[txtFicha],$login,$_POST[txtConfiguracion],"","",$_POST[optInventario],$_POST[optComponentes],1,$_POST[txtObservacion]);
		$asignacion->setUbicacion($_POST[selSitio],$_POST[selGerencia],$_POST[selDivision],$_POST[selDepartamento]);
		$asignacion->ActualizarComponente();
		$asignacion->modificar();
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: INVENTARIO - ASIGNACION COMPONENTE</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO LA ASIGNACION #: $idAsignacion.</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"ACEPTAR\"><input name=\"txtBoton\" type=\"button\" value=\"IMPRIMIR\" onClick=\"window.open('../librerias/pdfAsignacionComponentes.php')\"></td>";
			echo "</tr>";
			echo "</table>";
			echo "</form>";
		
		
		break 1;
	case 2:
		$configuracion=$_POST[txtConfiguracion];
		componenteAsignacion($configuracion,1);
		break 1;
	case 3:
		require_once "administracion.php";
		require_once "usuarioSistemaAdmin.php";
		require_once "componenteAdmin.php";

		$acceso= new usuarioSistema("",$_SESSION['userName'],$_SESSION['userPass']);
		$login=$acceso->login();
		if (isset($_POST[txtAsignacion]) && !empty($_POST[txtAsignacion])) {
			$idAsignacion=$_POST[txtAsignacion];
		} else {
			$idAsignacion="";	
		}
		$asignacion= new asignacion();
		$asignacion->SetParametros($idAsignacion,"",$_POST[txtFicha],$login,$_POST[txtConfiguracion],"","",$_POST[optInventario],$_POST[optComponentes],1,$_POST[txtObservacion]);
		$asignacion->setUbicacion($_POST[selSitio],$_POST[selGerencia],$_POST[selDivision],$_POST[selDepartamento]);
		$resultado=$asignacion->ingresar();
		$idAsignacion=$asignacion->retornaIdAsignacion(); 
		$configuracion=$_POST[txtConfiguracion];	
		componenteAsignacion($configuracion,2,$_POST[txtFicha],$idAsignacion);
		break 1;
	case 4:
		//Reemplazo
		$configuracion=$_POST[txtConfiguracion];
		reemplazo($configuracion,$_POST[txtAsignacion]);
		break 1;
	case 5:
		require_once "administracion.php";
		require_once "usuarioSistemaAdmin.php";
		require_once "componenteAdmin.php";

		$acceso= new usuarioSistema("",$_SESSION['userName'],$_SESSION['userPass']);
		$login=$acceso->login();
		if (isset($_POST[txtAsignacion]) && !empty($_POST[txtAsignacion])) {
			$idAsignacion=$_POST[txtAsignacion];
		} else {
			$idAsignacion="";	
		}
		$asignacion= new asignacion();
		$asignacion->SetParametros($idAsignacion,"",$_POST[txtFicha],$login,$_POST[txtConfiguracion],"","",$_POST[optInventario],$_POST[optComponentes],1,$_POST[txtObservacion]);
		$asignacion->setUbicacion($_POST[selSitio],$_POST[selGerencia],$_POST[selDivision],$_POST[selDepartamento]);
		$comprobar=$asignacion->comprobarComponentesIguales();
		if ($comprobar==1) {
			echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
			echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
			echo "<input name=\"txtDescripcion\" type=\"hidden\" value=\"$_POST[txtDescripcion]\">";
			echo "<input name=\"txtAsignacion\" type=\"hidden\" value=\"$_POST[txtAsignacion]\">";			
			echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
			echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtFicha]\">";
			echo "<input name=\"txtNombres\" type=\"hidden\" value=\"$_POST[txtNombres]\">";
			echo "<input name=\"txtCargo\" type=\"hidden\" value=\"$_POST[txtCargo]\">";
			echo "<input name=\"txtExtension\" type=\"hidden\" value=\"$_POST[txtExtension]\">";
			echo "<input name=\"optComponentes\" type=\"hidden\" value=\"$_POST[optComponentes]\">";
			echo "<input name=\"optInventario\" type=\"hidden\" value=\"$_POST[optInventario]\">";
			echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
			echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
			echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
			echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
			echo "<input name=\"txtObservacion\" type=\"hidden\" value=\"$_POST[txtObservacion]\">";
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: INVENTARIO - ASIGNACION COMPONENTE</td>
			</tr>";
			echo "<tr>";
			$descripcionEntra=$asignacion->retornarDescripcionEntra();
			$descripcionSale=$asignacion->retornarDescripcionSale();
			echo "<td valign=top class=\"mensaje\" align=center>VA A REEMPLAZAR <h1>". $asignacion->retornarDescripcionEntra()."</h1> POR <h1>". $asignacion->retornarDescripcionSale()."</h1> ¿DESEA CONTINUAR?</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtSi\" type=\"button\" value=\"SI\" onclick=\"reemplazoSi()\">
			<input name=\"txtNo\" type=\"submit\" value=\"NO\"></td>";
			echo "</tr>";
			echo "</table>";			
			
		} else {
			$resultado=$asignacion->ingresar();
			$idAsignacion=$asignacion->retornaIdAsignacion();          
			$configuracion=$_POST[txtConfiguracion];
			echo "$configuracion, $_POST[txtFicha], $idAsignacion";
			componenteAsignacion($configuracion,2,$_POST[txtFicha],$idAsignacion);			
		}

		break 1;
	case 6:
		
	
		require_once "administracion.php";
		require_once "usuarioSistemaAdmin.php";
		require_once "componenteAdmin.php";

		echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
		echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
		echo "<input name=\"txtDescripcion\" type=\"hidden\" value=\"$_POST[txtDescripcion]\">";
		echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
		echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtFicha]\">";
		echo "<input name=\"txtNombres\" type=\"hidden\" value=\"$_POST[txtNombres]\">";
		echo "<input name=\"txtCargo\" type=\"hidden\" value=\"$_POST[txtCargo]\">";
		echo "<input name=\"txtExtension\" type=\"hidden\" value=\"$_POST[txtExtension]\">";
		echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
		echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		echo "<input name=\"optComponentes\" type=\"hidden\" value=\"$_POST[optComponentes]\">";
		echo "<input name=\"optInventario\" type=\"hidden\" value=\"$_POST[optInventario]\">";
		echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
		echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
		echo "<input name=\"txtObservacion\" type=\"hidden\" value=\"$_POST[txtObservacion]\">";
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: INVENTARIO - ASIGNACION COMPONENTE</td>
		</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>NO SE PUDO GUARDAR EL EQUIPO</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
		echo "</tr>";
		echo "</table>";
		$acceso= new usuarioSistema("",$_SESSION['userName'],$_SESSION['userPass']);
		$login=$acceso->login();
		if (isset($_POST[txtAsignacion]) && !empty($_POST[txtAsignacion])) {
			$idAsignacion=$_POST[txtAsignacion];
		} else {
			$idAsignacion="";	
		}
		$asignacion= new asignacion($idAsignacion,"",$_POST[txtFicha],$login,$_POST[txtConfiguracion],"","",$_POST[optInventario],$_POST[optComponentes],1,$_POST[txtObservacion]);
		$asignacion->setUbicacion($_POST[selSitio],$_POST[selGerencia],$_POST[selDivision],$_POST[selDepartamento]);
		$idAsignacion=$_POST[txtAsignacion];          
		$configuracion=$_POST[txtConfiguracion];
		echo "$configuracion, $_POST[txtFicha], $idAsignacion";
		componenteAsignacion($configuracion,2,$_POST[txtFicha],$idAsignacion);
		break 1;
	case 7:
		require_once "administracion.php";
		require_once "usuarioSistemaAdmin.php";
		require_once "componenteAdmin.php";

		$acceso= new usuarioSistema("",$_SESSION['userName'],$_SESSION['userPass']);
		
		$acceso->login();
		if (isset($_POST[txtAsignacion]) && !empty($_POST[txtAsignacion])) {
			$idAsignacion=$_POST[txtAsignacion];
		} else {
			$idAsignacion="";	
		}
		$asignacion= new asignacion();
		$_SESSION['idAsignacion']=$asignacion;
		echo "caso 7: $idAsignacion,$_POST[txtFicha],$login,$_POST[txtConfiguracion],$_POST[optInventario],$_POST[optComponentes],1,$_POST[txtObservacion]<br>
		$_POST[selSitio],$_POST[selGerencia],$_POST[selDivision],$_POST[selDepartamento]<br>";
		$asignacion->SetParametros($idAsignacion,"",$_POST[txtFicha],$login,$_POST[txtConfiguracion],"","",$_POST[optInventario],$_POST[optComponentes],1,$_POST[txtObservacion]);
		$asignacion->setUbicacion($_POST[selSitio],$_POST[selGerencia],$_POST[selDivision],$_POST[selDepartamento]);

		$resultado=$asignacion->ingresar();
		$idAsignacion=$asignacion->retornaIdAsignacion();          
		$configuracion=$_POST[txtConfiguracion];
		echo "$configuracion, $_POST[txtFicha], $idAsignacion";
		componenteAsignacion($configuracion,2,$_POST[txtFicha],$idAsignacion);			
		break 1;
	case 8:
		//Reemplazo
		$configuracion=$_POST[txtConfiguracion];
		asignacion($configuracion,$_POST[txtAsignacion]);
		break 1;
	case 9:
		require_once "administracion.php";
		require_once "usuarioSistemaAdmin.php";
		require_once "componenteAdmin.php";

		$acceso= new usuarioSistema("",$_SESSION['userName'],$_SESSION['userPass']);
		$login=$acceso->login();
		if (isset($_POST[txtAsignacion]) && !empty($_POST[txtAsignacion])) {
			$idAsignacion=$_POST[txtAsignacion];
		} else {
			$idAsignacion="";	
		}
		$asignacion= new asignacion();
		$asignacion->SetParametros($idAsignacion,"",$_POST[txtFicha],$login,$_POST[txtConfiguracion],"","",$_POST[optInventario],$_POST[optComponentes],1,$_POST[txtObservacion]);
		$asignacion->setUbicacion($_POST[selSitio],$_POST[selGerencia],$_POST[selDivision],$_POST[selDepartamento]);
			echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
			echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
			echo "<input name=\"txtDescripcion\" type=\"hidden\" value=\"$_POST[txtDescripcion]\">";
			echo "<input name=\"txtAsignacion\" type=\"hidden\" value=\"$_POST[txtAsignacion]\">";			
			echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
			echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtFicha]\">";
			echo "<input name=\"txtNombres\" type=\"hidden\" value=\"$_POST[txtNombres]\">";
			echo "<input name=\"txtCargo\" type=\"hidden\" value=\"$_POST[txtCargo]\">";
			echo "<input name=\"txtExtension\" type=\"hidden\" value=\"$_POST[txtExtension]\">";
			echo "<input name=\"optComponentes\" type=\"hidden\" value=\"$_POST[optComponentes]\">";
			echo "<input name=\"optInventario\" type=\"hidden\" value=\"$_POST[optInventario]\">";
			echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
			echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
			echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
			echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
			echo "<input name=\"txtObservacion\" type=\"hidden\" value=\"$_POST[txtObservacion]\">";
			$resultado=$asignacion->ingresar();
			$idAsignacion=$asignacion->retornaIdAsignacion();          
			$configuracion=$_POST[txtConfiguracion];
			echo "$configuracion, $_POST[txtFicha], $idAsignacion";
			componenteAsignacion($configuracion,2,$_POST[txtFicha],$idAsignacion);
			echo "</form>";
			break 1;		
	default:
		componenteAsignacion();	
}

function componenteAsignacion($configuracion="",$en="",$ficha="",$idAsignacion="") {
		require_once "equipoAdmin.php";
		require_once "usuarioAdmin.php";
		require_once "conexionsql.php";
		require_once "formularios.php";
		require_once "componenteAdmin.php";
	
		switch($en) {
			case 1:
				if (isset($configuracion) && !empty($configuracion)) {	
					$equipo= new equipo($configuracion);	
					$resultado=$equipo->retornarEquipoCampo();
					if ($resultado && $resultado!=1) {
						$row=mysql_fetch_array($resultado);
						$_SESSION['idInventario']=$row[2];
					}
					$resultado2=$equipo->retornarEquipoUbicacion();
					if ($resultado2 && $resultado2!=1) {
						$row2=mysql_fetch_array($resultado2);
						$_POST[selSitio]=$row2[8];
						$_POST[selGerencia]=$row2[2];
						$_POST[selDivision]=$row2[4];
						$_POST[selDepartamento]=$row2[6];
					}
					}

					break 1;
			case 2:
				if (isset($configuracion) && !empty($configuracion)) {	
					$_POST[txtConfiguracion]=$configuracion;
					$equipo= new equipo($configuracion);	
					$resultado=$equipo->retornarEquipoCampo();
					if ($resultado && $resultado!=1) {
						$row=mysql_fetch_array($resultado);
						$_SESSION['idInventario']=$row[2];
					}
				}
				if (isset($ficha) && !empty($ficha)) {
					$usuarioAsignacion= new usuario($ficha);
					$resultado3= $usuarioAsignacion->retornaUsuario();
					if ($resultado3 && $resultado3!=1) {
						$row3=mysql_fetch_array($resultado3);
						$_POST[txtNombres]=$row3[2];
						$_POST[txtCargo]=$row3[4];
						$_POST[txtExtension]=$row3[14];
					}	
				}
				break 1;
		}



	$conSitio="select id_sitio,sitio from sitio where status_activo=1 order by sitio";
	$conGerencia="select id_gerencia,gerencia from gerencia where status_activo=1 order by gerencia";
	$conDivision="select id_division,division from division where id_gerencia='$_POST[selGerencia]' and status_activo=1 order by division";
	$conDepartamento="select id_departamento, departamento from departamento where id_division='$_POST[selDivision]' and status_activo=1 ORDER BY departamento";

	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--UBICACION--","");
	$selSitio=$sitio->retornar();

	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","cambiarSeleccion()",$conGerencia,"--GERENCIA--","");
	$selGerencia=$gerencia->retornar();		

	$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","cambiarSeleccion()",$conDivision,"--DIVISION--","");
	$selDivision=$division->retornar();

	$departamento= new campoSeleccion("selDepartamento","formularioCampoSeleccion","$_POST[selDepartamento]","onChange","cambiarSeleccion()",$conDepartamento,"--DEPARTAMENTO--","");
	$selDepartamento=$departamento->retornar();	
	
	echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"650\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"2\">COMPONENTE - ASIGNACI&Oacute;N</td>
	</tr>";
	echo "<tr>
	<td valign=top class=\"formularioTablaTitulo\">DATOS DEL EQUIPO</td><td class=\"formularioTablaTitulo\">DATOS DEL USUARIO</td>";
	echo "</tr>";
	echo "<tr>
	<td valign=top class=\"formularioCampoTitulo\">CONFIGURACION:<br><input class=\"formularioCampoTexto\" name=\"txtConfiguracion\" type=\"text\" value=$_POST[txtConfiguracion]>
	<input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"C\" onclick=\"buscarConfiguracion()\"><br>
	DESCRIPCION<br>
	<input class=\"formularioCampoTexto\" name=\"txtDescripcion\" type=\"text\" value=\"$row[5] $row[7] $row[9]\" readonly=\"true\"><br>
	SERIAL<br>
	<input class=\"formularioCampoTexto\" name=\"txtSerial\" type=\"text\" value=\"$row[3]\" readonly=\"true\"></td>
	<td valign=top class=\"formularioCampoTitulo\">FICHA:<br><input class=\"formularioCampoTexto\" name=\"txtFicha\" type=\"text\" value=\"$_POST[txtFicha]\">
	<input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"C\" onclick=\"buscarFicha()\"><br>
	NOMBRES<br>
	<input class=\"formularioCampoTexto\" name=\"txtNombres\" type=\"text\" value=\"$_POST[txtNombres]\" readonly=\"true\"><br>
	CARGO<br>
	<input class=\"formularioCampoTexto\" name=\"txtCargo\" type=\"text\" value=\"$_POST[txtCargo]\" readonly=\"true\"><br>
	EXTENSION<br>
	<input class=\"formularioCampoTexto\" name=\"txtExtension\" type=\"text\" value=\"$_POST[txtExtension]\" readonly=\"true\"></td>";
	echo "</tr>";
	echo "<tr>
	<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DE UBICACION</td>";
	echo "</tr>";
	echo "<tr>

	<td valign=top class=\"formularioCampoTitulo\">UBICACION:<br>$selSitio<br>
	GERENCIA<br>$selGerencia<br>

	<td valign=top class=\"formularioCampoTitulo\">DIVISION<br>$selDivision<br>
	DEPARTAMENTO<br>$selDepartamento<br>";
	echo "</tr>
	</table>";

//Consulta a la base de datos
	$detalleAsignacion= new asignacion($idAsignacion);
	$detalleAsignacion->SetParametros($idAsignacion);
	$resultadoComponentesAsignados= $detalleAsignacion->retornarComponentesAsignados();
	$resultadoComponentesReemplazados=$detalleAsignacion->retornarComponentesReemplazados();


//Datos de los Componentes Asignados	
	if (isset($idAsignacion) && !empty($idAsignacion)) {
		echo "<input name=\"txtAsignacion\" type=\"hidden\" value=\"$idAsignacion\">";
		if ($resultadoComponentesAsignados && $resultadoComponentesAsignados!=1) {
			echo "<table class=\"formularioTabla\"align=center width=\"650\" border=\"0\">";	
			echo "<tr>
			<td valign=top class=\"formularioTablaTitulo\" colspan=\"4\">DATOS DE LOS COMPONENTES ASIGNADOS</td>";
			echo "</tr>";

			echo "<tr valign=top class=\"tablaTitulo\">
			<td align=\"left\" class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
			<td valign=top class=\"tablaTitulo\">MARCA</td>
			<td valign=top class=\"tablaTitulo\">MODELO</td>
			<td valign=top class=\"tablaTitulo\">SERIAL</td>
			</tr>";


			while ($row=mysql_fetch_array($resultadoComponentesAsignados)) {
				if ($i%2==0) {
					$clase="tablaFilaPar";
				} else {
					$clase="tablaFilaNone";
				}
				echo "<tr class=\"$clase\">
				<td align=\"left\">$row[4]</td>
				<td>$row[6]</td>
				<td>$row[8]</td>	
				<td>$row[9]</td>
				</tr>";
				$i++;
			}
		}	
		echo "</table>";
		$i=0;
//Datos de los Componentes Reemplazados
	
		if ($resultadoComponentesReemplazados && $resultadoComponentesReemplazados!=1) {
			echo "<br><br>";
			echo "<table class=\"formularioTabla\"align=center width=\"650\" border=\"0\">";	
			echo "<tr>
			<td valign=top class=\"formularioTablaTitulo\" colspan=\"4\">DATOS DE LOS COMPONENTES REEMPLAZADOS</td>";
			echo "</tr>";	
			echo "<tr valign=top class=\"tablaTitulo\">
			<td align=\"left\" class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
			<td valign=top class=\"tablaTitulo\">MARCA</td>
			<td valign=top class=\"tablaTitulo\">MODELO</td>
			<td valign=top class=\"tablaTitulo\">SERIAL</td>
			</tr>";	
		
			while ($row=mysql_fetch_array($resultadoComponentesReemplazados)) {
				if ($i%2==0) {
					$clase="tablaFilaPar";
				} else {
					$clase="tablaFilaNone";
				}
				echo "<tr class=\"$clase\">
				<td align=\"left\">$row[4]</td>
				<td>$row[6]</td>
				<td>$row[8]</td>
				<td>$row[9]</td>
				</tr>";
				$i++;
			}
		}	
		echo "</table>";
	}
//Observacion
	echo "<br><br>";
	echo "<table class=\"formularioTabla\"align=center width=\"650\" border=\"0\">";	
	echo "<tr>
		<td valign=top class=\"formularioTablaTitulo\">OBSERVACION</td>";
	echo "</tr>";
	echo "<tr>
		<td valign=top align=center><textarea class=\"formularioAreaTexto\" name=\"txtObservacion\" cols=\"77\" rows=\"5\">$_POST[txtObservacion]</textarea></td>";
	echo "</tr>";
	
// Botones		
	echo "<table class=\"formularioTabla\"align=center width=\"650\" border=\"0\">";
	echo "<tr align=\"center\">
	<td  class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnAsignacion\" type=\"button\" value=\"ASIGNACION\" onclick=\"asignacion()\">
	<input name=\"btnReemplazo\" type=\"button\" value=\"REEMPLAZO\" onclick=\"reemplazo()\">
	<input type=\"button\" name=\"btnPrestamo\" value=\"PRESTAMO\" onClick=\"\"></td>
	</tr>";
	echo "<tr align=\"center\">
	<td  class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnSalir\" type=\"button\" value=\"SALIR\" onclick=\"\">
	<input type=\"submit\" name=\"btnGuardar\" value=\"GUARDAR\" onClick=\"\"></td>
	</tr>";	
	echo "</table>";
	echo "</form>";
}



//Formulario que muestra los componentes despachados y los componentes del equipo
function reemplazo($configuracion="",$idAsignacion="") {
	require_once "equipoAdmin.php";
	require_once "usuarioSistemaAdmin.php";
	require_once "inventarioAdmin.php";
	require_once "conexionsql.php";	
	$acceso= new usuarioSistema("",$_SESSION['userName'],$_SESSION['userPass']);
	$login=$acceso->login();
	$despachado= new inventario("","","","","","","","","",$login);
	$resultado=$despachado->retornaDespachoAnalista();

	echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"5\">";
	echo "<input name=\"txtAsignacion\" type=\"hidden\" value=\"$idAsignacion\">
	<input name=\"txtConfiguracion\" type=\"hidden\" value=$_POST[txtConfiguracion]>
	<input name=\"txtFicha\" type=\"hidden\" value=$_POST[txtFicha]>";
	
	echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
	echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
	echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
	echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
	echo "<input name=\"txtObservacion\" type=\"hidden\" value=\"$_POST[txtObservacion]\">";
	
//Componentes Despachados
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
	echo "<tr>
	<td class=\"formularioTablaTitulo\" colspan=\"4\">COMPONENTES DESPACHADOS</td>
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
			<td align=\"left\"><input name=\"optInventario\" type=\"radio\" value=\"$row[0]\" checked>$row[4]</td>
			<td>$row[6]</td>
			<td>$row[8]</td>
			<td>$row[2]</td>
			</tr>";
			$i++;
		}
	}	
	echo "</table>";

//Componentes asociados al Equipo
	echo "<br><br><br>";
	$equipo= new equipo($configuracion);
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
	if ($resultado2 && $resultado!=1) {
		while ($row=mysql_fetch_array($resultado2)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">
			<td align=\"left\"><input name=\"optComponentes\" type=\"radio\" value=\"$row[5]\" checked>$row[0]</td>
			<td>$row[1]</td>
			<td>$row[2]</td>
			<td>$row[3]</td>
			</tr>";
			$i++;
		}
	}
	echo "<tr>
		<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"4\">
		<input name=\"btnRegresar\" type=\"button\" value=\"REGRESAR\" onclick=\"regresar()\">
		<input name=\"btnReemplazar\" type=\"submit\" value=\"REEMPLAZAR\">
		</td>
	</tr>";	
	echo "</table>";	
echo "</form>";	
}
//Asignaciones
function asignacion($configuracion="",$idAsignacion="") {
	require_once "equipoAdmin.php";
	require_once "usuarioSistemaAdmin.php";
	require_once "inventarioAdmin.php";
	require_once "conexionsql.php";	
	$acceso= new usuarioSistema("",$_SESSION['userName'],$_SESSION['userPass']);
	$login=$acceso->login();
	$despachado= new inventario("","","","","","","","","",$login);
	$resultado=$despachado->retornaDespachoAnalista();

	echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"9\">";
	echo "<input name=\"txtAsignacion\" type=\"hidden\" value=\"$idAsignacion\">
	<input name=\"txtConfiguracion\" type=\"hidden\" value=$_POST[txtConfiguracion]>
	<input name=\"txtFicha\" type=\"hidden\" value=$_POST[txtFicha]>";
	
	echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
	echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
	echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
	echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
	echo "<input name=\"txtObservacion\" type=\"hidden\" value=\"$_POST[txtObservacion]\">";
	
//Componentes Despachados
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
	echo "<tr>
	<td class=\"formularioTablaTitulo\" colspan=\"4\">COMPONENTES DESPACHADOS</td>
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
			<td align=\"left\"><input name=\"optInventario\" type=\"radio\" value=\"$row[0]\" checked>$row[4]</td>
			<td>$row[6]</td>
			<td>$row[8]</td>
			<td>$row[2]</td>
			</tr>";
			$i++;
		}
	}
	echo "</table>";	
//Componentes asociados al Equipo
	echo "<br><br><br>";
	$equipo= new equipo($configuracion);
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
	if ($resultado2 && $resultado!=1) {
		while ($row=mysql_fetch_array($resultado2)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">
			<td align=\"left\">$row[0]</td>
			<td>$row[1]</td>
			<td>$row[2]</td>
			<td>$row[3]</td>
			</tr>";
			$i++;
		}
	}
	echo "<tr>
		<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"4\">
		<input name=\"btnRegresar\" type=\"button\" value=\"REGRESAR\" onclick=\"regresar()\">
		<input name=\"btnReemplazar\" type=\"submit\" value=\"ASIGNAR\">
		</td>
	</tr>";	
	echo "</table>";	
echo "</form>";	
}
?>
